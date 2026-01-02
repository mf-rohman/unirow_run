<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\ParticipantResource\RelationManagers;
use App\Mail\PaymentSuccessMail;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\HtmlString;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('phone')->required(),
                Forms\Components\Select::make('jersey_size')
                    ->options([
                        'XS' => 'XS', 'S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', '2XL' => '2XL', '3XL' => '3XL', '4XL' => '4XL', '5XL' => '5XL',
                    ])->required(),
                Forms\Components\FileUpload::make('payment_proof')
                    ->image()
                    ->directory('payments')
                    ->columnSpanFull(),

                    Forms\Components\Toggle::make('is_verified')
                    ->label('Lunas?')
                    ->onColor('success')
                    ->offColor('danger')
                    
                    // 1. WAJIB ADA: Agar kode jalan langsung saat diklik (tanpa tekan save dulu)
                    ->live() 
                    
                    ->afterStateUpdated(function ($state, ?\Illuminate\Database\Eloquent\Model $record, \Filament\Forms\Set $set) {
                        
                        if ($state && $record && empty($record->bib_number)) {
                
                            $lastParticipant = \App\Models\Participant::whereNotNull('bib_number')
                                ->orderByRaw('LENGTH(bib_number) DESC')
                                ->orderBy('bib_number', 'desc')
                                ->first();
                            
                            $nextNumber = 1;
                
                            if ($lastParticipant) {
                                $cleanNumber = preg_replace('/[^0-9]/', '',  $lastParticipant->bib_number);
                                $nextNumber = (int) $cleanNumber + 1;
                            }
                            
                            $bib = 'RUN-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                            
                            // Update Database Langsung
                            $record->update(['bib_number' => $bib]);
                
                            // Opsional: Update tampilan field BIB di form agar admin melihatnya berubah
                            // Asumsi nama field form bib-nya adalah 'bib_number'
                            $set('bib_number', $bib);
                
                            // Kirim Email
                            try {
                                \Illuminate\Support\Facades\Mail::to($record->email)->send(new \App\Mail\PaymentSuccessMail($record));
                                
                                // Beri notifikasi kecil bahwa email terkirim
                                \Filament\Notifications\Notification::make()
                                    ->title('Verifikasi Berhasil & Email Terkirim')
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {}
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bib_number')
                    ->label('No. BIB')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('name')->searchable()->label('Nama'),
                Tables\Columns\TextColumn::make('nik')->label('NIK')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jenis_kl')->label('L/P'),
                Tables\Columns\TextColumn::make('usia')->suffix(' Thn')->toggleable(isToggledHiddenByDefault:true),
                Tables\Columns\TextColumn::make('phone')->label('WA')->copyable(),
                Tables\Columns\TextColumn::make('jersey_size')->label('Size'),
                Tables\Columns\IconColumn::make('is_verified')
                    ->label('Status Bayar')
                    ->boolean() 
                    ->trueIcon('heroicon-s-check-circle') 
                    ->falseIcon('heroicon-o-x-circle')    
                    ->trueColor('success') 
                    ->falseColor('danger') 
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Tgl Daftar')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_verified')->label('Status Verifikasi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('lihat_bukti')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => Storage::url($record->payment_proof))
                    ->openUrlInNewTab(),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                Tables\Actions\BulkAction::make('verify_selected')
                    ->label('Verifikasi Pembayaran')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(function (\Illuminate\Database\Eloquent\Collection $records) {

                        $lastParticipant = \App\Models\Participant::whereNotNull('bib_number')
                            ->orderByRaw('LENGTH(bib_number) DESC')
                            ->orderBy('bib_number', 'desc')
                            ->first();

                        $currentMaxNumber = 0;
                        if ($lastParticipant) {
                            $cleanNumber = preg_replace('/[^0-9]/', '', $lastParticipant->bib_number);
                            $currentMaxNumber = (int) $cleanNumber;
                        }
    
                        foreach ($records as $record) {
                            // Hanya proses yang belum diverifikasi atau belum punya BIB
                            if (!$record->is_verified || empty($record->bib_number)) {
                                
                                // Naikkan counter (+1)
                                $currentMaxNumber++; 
                                
                                // Format BIB
                                $bib = 'RUN-' . str_pad($currentMaxNumber, 4, '0', STR_PAD_LEFT);
                                
                                $record->update([
                                    'is_verified' => true,
                                    'bib_number' => $bib
                                ]);
                
                                // Kirim Email
                                try {
                                    Mail::to($record->email)->send(new PaymentSuccessMail($record));
                                } catch (\Exception $e) {}
                            }
                        }
                    
                        \Filament\Notifications\Notification::make()
                            ->title('Verifikasi Berhasil')
                            ->body($records->count() . ' peserta telah diverifikasi & dikirim email.')
                            ->success()
                            ->send();
                    
                        return redirect()->route('filament.admin.resources.participants.index');
                    })
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}
