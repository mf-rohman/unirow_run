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
                                        <h2 class="text-3xl font-extrabold text-blue-900">Unirow Run Dies Natalis 2025</h2>
                                        <p class="text-gray-500 mt-2 text-lg">Rayakan semangat kebersamaan dengan berlari bersama!</p>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                            <div class="text-2xl mb-2">📅</div>
                                            <div class="font-bold text-blue-900">Minggu, 18 Jan 2026</div>
                                            <div class="text-xs text-blue-600">06:00 WIB - Selesai</div>
                                        </div>
                                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                            <div class="text-2xl mb-2">📍</div>
                                            <div class="font-bold text-blue-900">Kampus Unirow</div>
                                            <div class="text-xs text-blue-600">Start & Finish Point</div>
                                        </div>
                                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                            <div class="text-2xl mb-2">🎁</div>
                                            <div class="font-bold text-blue-900">Hadiah</div>
                                            <div class="text-xs text-blue-600">Banyak Hadiah Menarik</div>
                                        </div>
                                    </div>

                                    <div class="bg-white border-l-4 border-blue-500 text-left p-4 shadow-sm rounded-r-lg">
                                        <p class="text-gray-600 italic">
                                            "Ajang lari paling bergengsi di Tuban kembali hadir! Siapkan fisikmu untuk rute 5K yang menyenangkan. Dapatkan Jersey Eksklusif, Medali Finisher, dan kesempatan memenangkan Doorprize menarik."
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
                                Forms\Components\TextInput::make('nik')
                                    ->label('NIK')
                                    ->numeric()
                                    ->length(16)
                                    ->required()
                                    ->unique(table: 'participants', column: 'nik') 
                                    ->validationMessages([
                                        'unique' => 'Mohon maaf, NIK ini sudah terdaftar sebelumnya.',
                                        'digits' => 'NIK harus berjumlah 16 digit.',
                                        'numeric' => 'NIK harus berupa angka.',
                                    ])
                                    ->helperText(new \Illuminate\Support\HtmlString('<span class="text-yellow-400 font-bold text-xs">⚠️ Pastikan nik sesuai KTP !</span>')),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->placeholder('email@anda.com')
                                    ->helperText(new \Illuminate\Support\HtmlString('<span class="text-yellow-400 font-bold text-xs">⚠️ Pastikan email aktif untuk verifikasi!</span>')),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->label('WhatsApp')
                                    ->required()
                                    ->placeholder('08xxxxxxxxxx'),
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
                        
                        // // 1. PILIH KATEGORI
                        // Forms\Components\Placeholder::make('label_cat')
                        //     ->content(new HtmlString('<h3 class="text-lg font-bold text-gray-700 mb-2">Pilih Kategori Lari</h3>'))
                        //     ->label(''),

                        // Forms\Components\Radio::make('category_dummy')
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

                        // Forms\Components\Placeholder::make('sep')->content(new HtmlString('<hr class="my-6 border-gray-200">')),

                        // 2. PANDUAN UKURAN (SIZE CHART HTML)
                        // Kita buat tabel visual agar mirip gambar referensi
                        Forms\Components\Placeholder::make('size_chart_info')
                            ->label('')
                            ->content(new HtmlString('
                                <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-4">
                                    <h4 class="font-bold text-orange-800 mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        Panduan Ukuran (Size Chart)
                                    </h4>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-center border-collapse">
                                            <thead>
                                                <tr class="text-orange-900 bg-orange-100">
                                                    <th class="p-2 rounded-l-lg">Size</th>
                                                    <th class="p-2">Lebar (cm)</th>
                                                    <th class="p-2 rounded-r-lg">Panjang (cm)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600">
                                                <tr class="border-b border-orange-100"><td class="p-1 font-bold">XS</td><td>48</td><td>66</td></tr>
                                                <tr class="border-b border-orange-100"><td class="p-1 font-bold">S</td><td>50</td><td>68</td></tr>
                                                <tr class="border-b border-orange-100"><td class="p-1 font-bold">M</td><td>52</td><td>70</td></tr>
                                                <tr class="border-b border-orange-100"><td class="p-1 font-bold">L</td><td>54</td><td>72</td></tr>
                                                <tr class="border-b border-orange-100"><td class="p-1 font-bold">XL</td><td>57</td><td>74</td></tr>
                                                <tr><td class="p-1 font-bold">2XL</td><td>60</td><td>76</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-xs text-orange-600 mt-2">*Lebar dada x Panjang baju dalam centimeter</p>
                                </div>
                            ')),

                        Forms\Components\Radio::make('jersey_size')
                            ->label('Pilih Ukuran Jersey')
                            ->options([
                                'XS' => 'Size XS',
                                'S' => 'Size S',
                                'M' => 'Size M',
                                'L' => 'Size L',
                                'XL' => 'Size XL',
                                '2XL' => 'Size 2XL',
                            ])
                            ->descriptions([
                                'XS' => '48 x 66 cm',
                                'S' => '50 x 68 cm',
                                'M' => '52 x 70 cm',
                                'L' => '54 x 72 cm',
                                'XL' => '57 x 74 cm',
                                '2XL' => '60 x 76 cm',
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
            ->submitAction(new HtmlString('
                <button type="submit" 
                    wire:loading.attr="disabled" 
                    wire:loading.class="opacity-75 cursor-wait"
                    wire:target="create"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-full shadow-lg text-lg transition transform hover:scale-105 mt-6 flex items-center justify-center relative overflow-hidden">
                    
                    <span wire:loading.remove wire:target="create" class="flex items-center gap-2">
                        🚀 KIRIM PENDAFTARAN
                    </span>

                    <span wire:loading wire:target="create" class="flex items-center gap-2">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        SEDANG MEMPROSES...
                    </span>
                </button>
            '))
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