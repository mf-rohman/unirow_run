<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light"> <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fun Run Dies Natalis Unirow 2025</title>
    
    @filamentStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #172554; /* Deep Blue Background */
            color: #1e293b;
        }

        /* --- PERBAIKAN UTAMA: MEMAKSA WARNA HITAM PADA INPUT --- */
        
        /* 1. Target Input, Select, Textarea */
        input, select, textarea, .fi-input, .fi-select-input {
            color: #000000 !important; /* Teks Hitam Pekat */
            background-color: #f3f4f6 !important; /* Background Abu Muda */
            border: 1px solid #d1d5db !important; /* Border Abu */
            -webkit-text-fill-color: #000000 !important; /* Fix untuk Safari/Chrome */
        }

        /* 2. Target Label (Judul Input) */
        label, .fi-fo-field-wrp-label, span.fi-fo-field-wrp-label {
            color: #1f2937 !important; /* Abu Gelap */
        }

        /* 3. Target Placeholder (Teks bayangan 'Masukkan nama...') */
        ::placeholder {
            color: #9ca3af !important; /* Abu-abu medium */
            opacity: 1 !important;
        }

        /* 4. Fix dropdown icon agar terlihat */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
            background-position: right 0.5rem center !important;
            background-repeat: no-repeat !important;
            background-size: 1.5em 1.5em !important;
        }

        /* 5. Styling Wizard Step (Supaya teks step di atas tidak putih hilang) */
        .fi-fo-wizard-header-step-label {
            color: #e2e8f0 !important; /* Putih agak abu utk teks header */
        }
        .fi-fo-wizard-header-step-icon {
            border-color: #3b82f6 !important;
            color: #3b82f6 !important;
        }

        /* Style tambahan untuk tombol submit */
        button[type="submit"] {
            background-color: #22c55e !important; /* Hijau */
            color: white !important;
        }

        /* --- CUSTOM WIZARD BUTTONS --- */

        /* 1. Styling area tombol di bawah */
        .fi-fo-wizard-footer-actions {
            gap: 1rem; /* Jarak antar tombol */
        }

        /* 2. Tombol NEXT (Lanjut) - Kita ubah jadi Biru Besar */
        .fi-btn-color-primary {
            background-color: #3b82f6 !important; /* Biru */
            color: white !important;
            border-radius: 9999px !important; /* Bulat */
            padding: 0.75rem 2rem !important; /* Besar */
            font-weight: bold !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* 3. Tombol PREVIOUS (Kembali) - Kita ubah jadi Abu Terang Besar */
        .fi-btn-color-gray {
            background-color: #e5e7eb !important; /* Abu terang */
            color: #1f2937 !important; /* Teks Hitam */
            border-radius: 9999px !important;
            padding: 0.75rem 2rem !important;
            font-weight: bold !important;
            border: none !important;
        }

        /* Efek Hover */
        .fi-btn-color-primary:hover { transform: scale(1.05); transition: 0.2s; }
        .fi-btn-color-gray:hover { background-color: #d1d5db !important; }

        /* Sembunyikan Label teks kecil default jika ada */
        .fi-btn-label { font-size: 1rem !important; }

        .fi-fo-wizard-header-step-button[aria-current="step"] .fi-fo-wizard-header-step-icon-ctn {
        background-color: #fbbf24 !important; /* Lingkaran jadi Kuning */
        border-color: #fbbf24 !important;
        box-shadow: 0 0 20px rgba(251, 191, 36, 0.6); /* Efek Glowing/Bercahaya */
        transform: scale(1.1); /* Sedikit membesar */
        transition: all 0.3s ease;
    }

        /* Ubah warna ICON di dalam lingkaran active jadi gelap (biar terbaca) */
        .fi-fo-wizard-header-step-button[aria-current="step"] .fi-fo-wizard-header-step-icon {
            color: #0f172a !important; /* Biru gelap hampir hitam */
        }

        /* Ubah warna TEKS LABEL active jadi Kuning */
        .fi-fo-wizard-header-step-button[aria-current="step"] .fi-fo-wizard-header-step-label {
            color: #fbbf24 !important; 
            font-weight: bold !important;
            text-shadow: 0 0 10px rgba(251, 191, 36, 0.3);
        }

        /* ----------------------------------------- */

        /* 2. KONDISI COMPLETED (Form sudah diisi/dilewati) 
           Warna: HIJAU (Success)
        */
        /* Filament biasanya memberi class 'bg-primary-600' pada index > 0. 
           Kita override manual berdasarkan logic CSS sibling atau class bawaan jika ada.
           Tapi cara paling aman membedakan 'Completed' vs 'Pending' tanpa JS tambahan 
           adalah melihat apakah dia punya background primary tapi TIDAK active.
        */

        /* Target lingkaran yang border-nya primary tapi tidak active */
        .fi-fo-wizard-header-step-icon-ctn.bg-primary-600 {
            background-color: #22c55e !important; /* Hijau */
            border-color: #22c55e !important;
        }

        /* Target Icon Checkmark (SVG) pada step completed */
        .fi-fo-wizard-header-step-icon-ctn.bg-primary-600 svg {
            color: white !important;
        }

        /* ----------------------------------------- */

        /* 3. KONDISI PENDING (Belum sampai sana) 
           Warna: ABU-ABU REDUP (Default)
        */
        .fi-fo-wizard-header-step-button:not([aria-current="step"]) .fi-fo-wizard-header-step-icon-ctn {
            /* Biarkan default transparan/border abu */
            opacity: 0.6;
        }

        .fi-fo-wizard-header-step-button:not([aria-current="step"]) .fi-fo-wizard-header-step-label {
            color: #94a3b8 !important; /* Slate 400 */
        }

        input:focus,
        select:focus,
        textarea:focus,
        .fi-input:focus,         /* Class khusus Filament input text */
        .fi-select-input:focus,  /* Class khusus Filament select */
        .fi-fo-textarea:focus    /* Class khusus Filament textarea */
        {
            /* 1. Ubah warna border jadi Biru */
            border-color: #3b82f6 !important; /* Tailwind blue-500 */

            /* 2. Hilangkan outline default browser (garis jelek bawaan chrome/firefox) */
            outline: 2px solid transparent !important;
            outline-offset: 2px !important;

            /* 3. Ciptakan efek cahaya (Glow Ring) menggunakan box-shadow */
            /* Format: offset-x | offset-y | blur-radius | spread-radius | color */
            /* Kita pakai spread 3px dengan warna biru transparan (opacity 0.3) */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3) !important;

            /* Tambahkan transisi halus agar efeknya tidak kaget */
            transition: all 0.15s ease-in-out !important;
        }

        @keyframes float {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }

        .animate-blob {
            animation: float 10s infinite; /* Gerakan lambat 10 detik */
        }

        /* Utilitas delay agar bola tidak bergerak barengan */
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        /* Pattern titik-titik halus (Noise) agar tidak terlalu flat */
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col items-center justify-center p-4">
    <div class="fixed inset-0 -z-10 bg-[#0f172a] overflow-hidden">
        
        <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-4xl bg-blue-900/20 blur-[100px] rounded-full mix-blend-screen"></div>

        <svg class="absolute top-10 left-10 w-24 h-24 text-blue-500/20 animate-blob" 
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
        </svg>

        <svg class="absolute bottom-20 right-10 w-32 h-32 text-yellow-500/10 animate-blob animation-delay-2000" 
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 00-.584.859 6.753 6.753 0 006.138 5.6 6.73 6.73 0 002.743 1.346A6.707 6.707 0 019.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 00-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 00.75-.75 2.25 2.25 0 00-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 01-1.112-3.173 6.73 6.73 0 002.743-1.347 6.753 6.753 0 006.139-5.6.75.75 0 00-.585-.858 47.767 47.767 0 00-3.07-.543V2.62a.75.75 0 00-.658-.744 49.22 49.22 0 00-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 00-.657.744zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 013.16 5.337a45.6 45.6 0 012.006-.343v.256zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 01-2.863 3.207 6.72 6.72 0 00.857-3.294z" clip-rule="evenodd" />
        </svg>

        <svg class="absolute bottom-10 left-10 w-20 h-20 text-green-500/20 animate-blob animation-delay-4000" 
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
        </svg>

        <svg class="absolute top-20 right-20 w-16 h-16 text-cyan-400/30 animate-blob" 
             style="animation-delay: 1s;"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 01.359.852L12.981 9.75h5.527a.75.75 0 01.625 1.162l-6.615 11.04a.75.75 0 01-1.332-.783l2.25-9.169H7.662a.75.75 0 01-.663-1.125l6.75-9.006a.75.75 0 01.866-.274z" clip-rule="evenodd" />
        </svg>

    </div>

    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-white tracking-wider">UNIROW<span class="text-blue-400">RUN</span></h1>
        <p class="text-blue-200 text-sm">Dies Natalis 2025 Registration</p>
    </div>

    <div class="w-full max-w-3xl">
        {{ $slot }}
    </div>

    <div class="mt-8 text-center text-slate-500 text-xs">
        &copy; 2025 Panitia Dies Natalis Unirow Tuban
    </div>

    @filamentScripts

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-success-modal', (event) => {
                Swal.fire({
                    title: 'Pendaftaran Berhasil!',
                    text: 'Terima kasih! Data Anda telah kami terima. Admin kami akan segera memverifikasi bukti pembayaran Anda.',
                    icon: 'success',
                    iconColor: '#22c55e', // Warna Hijau Sukses
                    background: '#1e293b', // Background Biru Gelap biar matching
                    color: '#ffffff', // Teks Putih
                    confirmButtonText: 'Siap, Lanjut Latihan! 🏃',
                    confirmButtonColor: '#3b82f6', // Tombol Biru
                    allowOutsideClick: false,
                    backdrop: `
                        rgba(0,0,123,0.4)
                        url("https://media.tenor.com/images/a746a6f6c7676451525a476837861935/tenor.gif")
                        left top
                        no-repeat
                    `
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Refresh halaman setelah klik OK agar form benar-benar bersih
                        window.location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>