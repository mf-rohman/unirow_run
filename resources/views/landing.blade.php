<x-layouts.app>
    @php
        // Pengaturan Waktu (WIB)
        $now = now('Asia/Jakarta');
        $deadlineTahap1 = \Carbon\Carbon::create(2026, 1, 4, 11, 0, 0, 'Asia/Jakarta');
        $bukaTahap2 = \Carbon\Carbon::create(2026, 1, 4, 12, 0, 0, 'Asia/Jakarta');

        // Penentuan Status
        //$sedangTutup = ($now->greaterThanOrEqualTo($deadlineTahap1) && $now->lessThan($bukaTahap2));
		$sedangTutup = $now->greaterThanOrEqualTo($deadlineTahap1);
        $tampilkanCountdownTahap1 = $now->lessThan($deadlineTahap1);
    @endphp

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 md:space-y-20 pb-20">

        <div class="text-center space-y-6 pt-8 md:pt-16" data-aos="zoom-in">
            <div class="inline-block px-4 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs md:text-sm font-semibold tracking-widest uppercase">
                Dies Natalis Ke-19 Unirow Tuban
            </div>

            <h1 class="text-4xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-blue-200 to-blue-400 leading-tight">
                UNIROW RUN 2025
            </h1>

            <p class="text-base md:text-xl text-blue-200 max-w-2xl mx-auto opacity-80">
                Siapkan fisikmu, rasakan euforianya! Lari bareng komunitas, menangkan hadiahnya.
            </p>

            @if($tampilkanCountdownTahap1)
            <div id="countdown-wrapper" class="max-w-xl mx-auto pt-4" data-aos="fade-up">
                <p class="text-blue-300 text-xs md:text-sm mb-3 uppercase tracking-widest font-bold">Pendaftaran ditutup dalam:</p>
                <div class="flex justify-center gap-2 md:gap-4 text-white">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 min-w-[70px] md:min-w-[90px]">
                        <span id="hours" class="block text-2xl md:text-4xl font-black">00</span>
                        <span class="text-[10px] md:text-xs uppercase opacity-60">Jam</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 min-w-[70px] md:min-w-[90px]">
                        <span id="minutes" class="block text-2xl md:text-4xl font-black">00</span>
                        <span class="text-[10px] md:text-xs uppercase opacity-60">Menit</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 min-w-[70px] md:min-w-[90px]">
                        <span id="seconds" class="block text-2xl md:text-4xl font-black text-orange-400">00</span>
                        <span class="text-[10px] md:text-xs uppercase opacity-60">Detik</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="pt-8">
                @if($sedangTutup)
                    <div class="inline-flex flex-col items-center" data-aos="fade-up">
                        <div class="px-8 py-4 text-lg font-bold text-gray-400 bg-white/10 border border-white/20 rounded-full cursor-not-allowed">
                            🚫 Pendaftaran Sudah Ditutup
                        </div>
                        <p class="text-red-400 text-sm mt-4 animate-pulse font-medium italic">Nantikan informasi berikutnya dari kami!</p>
                    </div>
                @else
                    <a href="{{ route('register') }}" wire:navigate class="relative inline-flex group items-center justify-center px-8 py-4 text-lg font-bold text-white transition-all duration-200 bg-blue-600 rounded-full hover:bg-blue-500 shadow-xl shadow-blue-500/30 w-full sm:w-auto">
                        Daftar Sekarang 🚀
                        <span class="absolute top-0 right-0 w-4 h-4 -mt-1 -mr-1 bg-white rounded-full opacity-30 animate-ping"></span>
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 md:p-8 rounded-3xl" data-aos="fade-right">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-2xl shadow-lg">🗺️</div>
                    <div>
                        <h3 class="text-2xl font-bold text-white leading-tight">Rute Lari 5K</h3>
                        <p class="text-blue-200 text-sm">Start & Finish: Kampus Unirow</p>
                    </div>
                </div>
                <div class="space-y-6 relative">
                    <div class="absolute left-6 top-2 bottom-2 w-0.5 bg-blue-500/30"></div>
                    <div class="relative flex items-center gap-6">
                        <div class="w-12 flex justify-center z-10"><div class="w-4 h-4 rounded-full bg-green-500 border-4 border-gray-900 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div></div>
                        <div class="flex-1 bg-white/5 p-3 rounded-xl border border-white/5 text-white font-bold text-sm md:text-base">START: Kampus Unirow</div>
                    </div>
                    <div class="relative flex items-center gap-6 pl-12 text-gray-300 text-sm md:text-base">
                        Jl. Manunggal Lor → Gedung Dinsos → Jl. WR Supratman
                    </div>
                    <div class="relative flex items-center gap-6 pl-12 text-gray-300 text-sm md:text-base">
                        SMAN 1 Tuban → Pertigaan JT ke kiri
                    </div>
                    <div class="relative flex items-center gap-6">
                        <div class="w-12 flex justify-center z-10"><div class="w-4 h-4 rounded-full bg-red-600 border-4 border-gray-900 animate-bounce"></div></div>
                        <div class="flex-1 bg-gradient-to-r from-red-600/20 to-transparent p-3 rounded-xl border-l-4 border-red-500 text-white font-bold text-sm md:text-base">FINISH: Kampus Unirow</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 md:p-8 rounded-3xl flex flex-col justify-center" data-aos="fade-left">
                <h3 class="text-2xl font-bold text-white text-center mb-8">Penyelenggara</h3>
                <div class="space-y-4">
                    <div class="bg-black/20 p-4 rounded-2xl border border-white/5 flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center font-bold text-white">TR</div>
                        <div><h4 class="text-white font-bold">Tuban Runners</h4><p class="text-gray-400 text-xs text-nowrap">Official Running Community</p></div>
                    </div>
                    <div class="bg-black/20 p-4 rounded-2xl border border-white/5 flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center font-bold text-white text-nowrap">HM</div>
                        <div><h4 class="text-white font-bold">COMMUNICATION RUN</h4><p class="text-gray-400 text-xs"></p></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative bg-gradient-to-br from-indigo-900/50 to-blue-900/50 rounded-3xl p-8 md:p-12 border border-blue-500/20 text-center" data-aos="fade-up">
            <h2 class="text-3xl md:text-5xl font-black text-white mb-10 tracking-tight">🎁 GRAND DOORPRIZE</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white/5 p-6 rounded-2xl border border-white/10 hover:border-yellow-500/50 transition">
                    <div class="text-5xl mb-4">🛵</div>
                    <div class="text-white font-bold text-xl">MOTOR LISTRIK</div>
                </div>
                <div class="bg-white/5 p-6 rounded-2xl border border-white/10 hover:border-blue-400/50 transition">
                    <div class="text-5xl mb-4">🚲</div>
                    <div class="text-white font-bold text-xl">SEPEDA LISTRIK</div>
                </div>
                <div class="bg-white/5 p-6 rounded-2xl border border-white/10 hover:border-green-400/50 transition">
                    <div class="text-5xl mb-4">🚵</div>
                    <div class="text-white font-bold text-xl">SEPEDA GUNUNG</div>
                </div>
            </div>
        </div>

        <div data-aos="fade-up">
            <h2 class="text-2xl font-bold text-white text-center mb-8">Fasilitas Peserta</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $items = [
                        ['👕', 'Jersey Exclusive'], ['🏅', 'Medali Finisher'],
                        ['🔢', 'BIB Number'], ['🎒', 'Race Pack'],
                        ['💧', 'Water Station'], ['🍌', 'Refreshment'],
                        ['🚑', 'Medical Support'], ['📸', 'Documentation']
                    ];
                @endphp
                @foreach($items as $item)
                <div class="bg-white/5 p-4 rounded-xl border border-white/5 text-center hover:bg-white/10 transition">
                    <div class="text-3xl mb-1">{{ $item[0] }}</div>
                    <div class="text-gray-300 text-xs font-semibold uppercase">{{ $item[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    @if($tampilkanCountdownTahap1)
    <script>
        const target = new Date("December 27, 2025 12:00:00").getTime();
        const timer = setInterval(function() {
            const now = new Date().getTime();
            const diff = target - now;

            if (diff <= 0) {
                clearInterval(timer);
                window.location.reload(); // Hanya reload sekali saat tgl 27 jam 12 tercapai
                return;
            }

            const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById("hours").innerText = h.toString().padStart(2, '0');
            document.getElementById("minutes").innerText = m.toString().padStart(2, '0');
            document.getElementById("seconds").innerText = s.toString().padStart(2, '0');
        }, 1000);
    </script>
    @endif
</x-layouts.app>