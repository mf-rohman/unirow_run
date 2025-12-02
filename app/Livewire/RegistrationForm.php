<?php

namespace App\Livewire;

use App\Mail\RegistrationConfirmMail;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

class RegistrationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
    return $form
        ->schema([
            Wizard::make([
                
                // --- STEP 1: INFORMASI EVENT (Hanya Teks & Gambar) ---
                Wizard\Step::make('Info')
                    ->label('Welcome') // Ubah label jadi Welcome/Info
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\Placeholder::make('event_info')
                            ->label('')
                            ->content(new HtmlString('
                                <div class="text-center space-y-6">
                                    <div>
                                        <h2 class="text-3xl font-extrabold text-blue-900">Fun Run Dies Natalis Unirow 2025</h2>
                                        <p class="text-gray-500 mt-2 text-lg">Rayakan semangat kebersamaan dengan berlari bersama!</p>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                            <div class="text-2xl mb-2">📅</div>
                                            <div class="font-bold text-blue-900">Minggu, 20 Agt 2025</div>
                                            <div class="text-xs text-blue-600">06:00 WIB - Selesai</div>
                                        </div>
                                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                            <div class="text-2xl mb-2">📍</div>
                                            <div class="font-bold text-blue-900">Kampus Unirow</div>
                                            <div class="text-xs text-blue-600">Start & Finish Point</div>
                                        </div>
                                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                            <div class="text-2xl mb-2">🎁</div>
                                            <div class="font-bold text-blue-900">Total Hadiah</div>
                                            <div class="text-xs text-blue-600">Puluhan Juta Rupiah</div>
                                        </div>
                                    </div>

                                    <div class="bg-white border-l-4 border-blue-500 text-left p-4 shadow-sm rounded-r-lg">
                                        <p class="text-gray-600 italic">
                                            "Ajang lari paling bergengsi di Tuban kembali hadir! Siapkan fisikmu untuk rute 5K yang menyenangkan atau tantang dirimu di rute 10K. Dapatkan Jersey Eksklusif, Medali Finisher, dan kesempatan memenangkan Doorprize menarik."
                                        </p>
                                    </div>

                                    <div class="pt-4">
                                        <p class="text-sm font-semibold text-blue-600 animate-pulse">
                                            Klik tombol "Lanjut" di bawah untuk mendaftar 👇
                                        </p>
                                    </div>
                                </div>
                            ')),
                    ]),

                // --- STEP 2: GENDER (Tetap) ---
                Wizard\Step::make('Gender')
                    ->label('Gender')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Forms\Components\Placeholder::make('label_gender')
                            ->content(new HtmlString('<h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Apa Jenis Kelamin Anda?</h2>'))
                            ->label(''),

                        Forms\Components\Radio::make('jenis_kl')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->descriptions([
                                'Laki-laki' => '👨',
                                'Perempuan' => '👩',
                            ])
                            ->view('forms.components.radio-card')
                            ->required(),
                    ]),

                // --- STEP 3: IDENTITAS (Tetap) ---
                Wizard\Step::make('Identity')
                    ->label('Data Diri')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Nama Lengkap')->required(),
                                Forms\Components\TextInput::make('nik')->label('NIK')->numeric()->length(16)->required()
                                    ->unique(table: 'participants', column: 'nik') 
                                    ->validationMessages([
                                        'unique' => 'Mohon maaf, NIK ini sudah terdaftar sebelumnya.',
                                        'digits' => 'NIK harus berjumlah 16 digit.',
                                        'numeric' => 'NIK harus berupa angka.',
                                    ]),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->placeholder('email@anda.com')
                                    ->hint('⚠️ Pastikan email aktif untuk verifikasi!')
                                    ->hintColor('danger'),
                                Forms\Components\TextInput::make('phone')->tel()->label('WhatsApp')->required(),
                                Forms\Components\TextInput::make('usia')->numeric()->suffix('Tahun')->required(),
                                Forms\Components\Textarea::make('alamat')
                                    ->label('Alamat Lengkap')
                                    ->rows(2)
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->extraAttributes([
                                'class' => 'p-6 rounded-xl shadow-lg border border-gray-200 
                                            bg-white dark:bg-gray-800 
                                            text-gray-900 dark:text-gray-100'
                            ]),
                    ]),

                // --- STEP 4: RACE PACK & KATEGORI (Kategori Pindah Sini) ---
                Wizard\Step::make('Kit')
                    ->label('Race Pack')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        
                        // // 1. PILIH KATEGORI LARI (Pindahan dari Step 1)
                        // Forms\Components\Placeholder::make('label_cat')
                        //     ->content(new HtmlString('<h3 class="text-lg font-bold text-gray-700 mb-2">Pilih Kategori Lari</h3>'))
                        //     ->label(''),

                        // Forms\Components\Radio::make('category_dummy') // Ganti dengan nama field database asli jika ada
                        //     ->label('Kategori')
                        //     ->options([
                        //         '5K' => 'Fun Run 5K',
                        //         '10K' => 'Race 10K',
                        //     ])
                        //     ->descriptions([
                        //         '5K' => '🏃‍♂️ Jarak Pendek', 
                        //         '10K' => '🔥 Jarak Jauh', 
                        //     ])
                        //     ->view('forms.components.radio-card')
                        //     ->required(),

                        // // Separator visual
                        // Forms\Components\Placeholder::make('sep')->content(new HtmlString('<hr class="my-6 border-gray-200">')),

                        // 2. PILIH UKURAN JERSEY
                        Forms\Components\Placeholder::make('label_jersey')
                            ->content(new HtmlString('<h3 class="text-lg font-bold text-gray-700 mb-2">Pilih Ukuran Jersey</h3>'))
                            ->label(''),

                        Forms\Components\Radio::make('jersey_size')
                            ->label('Ukuran Jersey')
                            ->options([
                                'S' => 'Size S', 'M' => 'Size M', 'L' => 'Size L', 
                                'XL' => 'Size XL', 'XXL' => 'Size XXL',
                            ])
                            ->descriptions([
                                'S' => '👕', 'M' => '👕', 'L' => '👕', 'XL' => '👕', 'XXL' => '👕',
                            ])
                            ->view('forms.components.radio-card')
                            ->required(),

                        // 3. UPLOAD BUKTI BAYAR
                        Forms\Components\Section::make('Pembayaran')
                            ->schema([
                                Forms\Components\FileUpload::make('payment_proof')
                                    ->label('Upload Bukti Transfer')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public')
                                    ->directory('payments')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->extraAttributes(['class' => 'bg-white mt-6 rounded-xl border border-gray-200']),
                    ]),

            ])
            ->nextAction(fn (Forms\Components\Actions\Action $action) => $action->label('Lanjut ➡️'))
            ->previousAction(fn (Forms\Components\Actions\Action $action) => $action->label('⬅️ Kembali'))
            ->submitAction(new HtmlString('<button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-full shadow-lg text-lg transition transform hover:scale-105 mt-6">🚀 KIRIM PENDAFTARAN</button>'))
            ->startOnStep(1)
        ])
        ->statePath('data');
    }

    public function create()
    {
        // Simpan Data
        $participant = Participant::create($this->form->getState());
    
        // KIRIM EMAIL KONFIRMASI
        try {
            Mail::to($participant->email)->send(new RegistrationConfirmMail($participant));
        } catch (\Exception $e) {
            // Abaikan error email jika internet lemot, data tetap tersimpan
        }
    
        $this->form->fill();
        $this->dispatch('open-success-modal');
    }
    
    public function render(): View
    {
        return view('livewire.registration-form');
    }
}