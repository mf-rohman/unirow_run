<x-layouts.app>
    <div class="flex items-center justify-center min-h-[50vh]">
        
        <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-8 rounded-3xl shadow-2xl max-w-md w-full text-center relative overflow-hidden group">
            
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-32 bg-green-500/30 rounded-full blur-3xl -z-10"></div>

            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center shadow-lg shadow-green-500/40 animate-bounce-slow">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-white mb-2">Verifikasi Berhasil!</h1>
            
            <p class="text-blue-100 mb-6 text-sm leading-relaxed">
                Halo <strong>{{ $participant->name }}</strong>,<br>
                Email Anda telah berhasil dikonfirmasi. Data pendaftaran Anda sekarang sudah lengkap dan tersimpan aman di sistem kami.
            </p>

            <div class="bg-blue-900/40 border border-blue-500/30 rounded-xl p-4 mb-8 text-left flex items-start gap-3">
                <div class="text-xl">📧</div>
                <div>
                    <h3 class="text-white font-bold text-sm">Cek Inbox Berkala</h3>
                    <p class="text-xs text-blue-200 mt-1">
                        Tiket dan Nomor Dada (BIB) akan dikirim ke email ini setelah Admin memverifikasi bukti pembayaran Anda.
                    </p>
                </div>
            </div>

            <a href="/" class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-bold text-blue-900 bg-white rounded-xl hover:bg-blue-50 transition transform hover:scale-105 shadow-lg">
                Kembali ke Halaman Utama
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>

        </div>
    </div>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5%); }
            50% { transform: translateY(5%); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }
    </style>
</x-layouts.app>