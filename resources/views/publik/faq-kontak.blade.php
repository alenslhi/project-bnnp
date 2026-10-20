@extends('layouts.publik')

@section('title', 'FAQ & Kontak Darurat')

@section('content')

    {{-- Header --}}
    <section class="mx-auto max-w-7xl px-4 pt-10 pb-12 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-block text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-2">Pusat Bantuan & Layanan SKENA</span>
            <h1 class="text-3xl sm:text-4xl font-black text-surface-900 dark:text-white mb-4">FAQ & Kontak Darurat</h1>
            <p class="text-surface-600 dark:text-surface-400 leading-relaxed text-sm sm:text-base">
                Temukan jawaban seputar sistem SKENA (Sistem Informasi Kumpulan Edukasi Narkotika), layanan BNNP Sulawesi Tengah, prosedur rehabilitasi, dan kontak darurat pengaduan.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Bagian FAQ (Kiri, 2 Kolom) --}}
            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-2xl font-bold text-surface-900 dark:text-white mb-6">Pertanyaan Umum (FAQ)</h2>

                {{-- Accordion Item SKENA --}}
                <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/50 p-1 shadow-xs" x-data="{ open: true }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-surface-900 dark:text-white">Apa itu sistem SKENA BNNP Sulteng?</span>
                        <svg class="h-5 w-5 text-surface-500 dark:text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-600 dark:text-surface-300 leading-relaxed pt-2 border-t border-surface-100 dark:border-white/5">
                            <strong class="text-primary-700 dark:text-primary-400">SKENA</strong> adalah singkatan dari <strong>Sistem Informasi Kumpulan Edukasi Narkotika</strong>. Ini merupakan platform digital resmi BNNP Sulawesi Tengah yang mengintegrasikan pusat literasi edukasi pencegahan narkoba, peta zonasi kerawanan, modul rehabilitasi, dan kanal pelaporan masyarakat dalam mewujudkan Sulawesi Tengah Bersinar (Bersih Narkoba).
                        </div>
                    </div>
                </div>

                {{-- Accordion Item 0 (P4GN) --}}
                <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/50 p-1 shadow-xs" x-data="{ open: false }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-surface-900 dark:text-white">Apa itu P4GN dan apa tujuannya?</span>
                        <svg class="h-5 w-5 text-surface-500 dark:text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-600 dark:text-surface-300 leading-relaxed pt-2 border-t border-surface-100 dark:border-white/5">
                            <strong class="text-primary-700 dark:text-primary-400">P4GN</strong> adalah singkatan dari <strong>Pencegahan, Pemberantasan, Penyalahgunaan, dan Peredaran Gelap Narkotika</strong>. Ini merupakan gerakan dan rencana aksi nasional terpadu yang dipimpin oleh Badan Narkotika Nasional (BNN) untuk melindungi masyarakat dari bahaya penyalahgunaan zat adiktif dan memutus mata rantai peredaran narkoba demi mewujudkan Indonesia Bersinar (Bersih Narkoba).
                        </div>
                    </div>
                </div>

                {{-- Accordion Item 1 --}}
                <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/50 p-1 shadow-xs" x-data="{ open: false }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-surface-900 dark:text-white">Bagaimana prosedur pendaftaran rehabilitasi mandiri?</span>
                        <svg class="h-5 w-5 text-surface-500 dark:text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-600 dark:text-surface-300 leading-relaxed pt-2 border-t border-surface-100 dark:border-white/5">
                            Keluarga atau pasien dapat datang langsung ke klinik rehabilitasi BNNP terdekat dengan membawa fotokopi KTP dan KK. Pendaftaran rehabilitasi yang dilaporkan secara mandiri <strong class="text-primary-700 dark:text-primary-300">tidak akan diproses hukum (bebas pidana)</strong> sesuai amanat Undang-Undang Narkotika No. 35 Tahun 2009.
                        </div>
                    </div>
                </div>

                {{-- Accordion Item 2 --}}
                <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/50 p-1 shadow-xs" x-data="{ open: false }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-surface-900 dark:text-white">Apakah layanan rehabilitasi dipungut biaya?</span>
                        <svg class="h-5 w-5 text-surface-500 dark:text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-600 dark:text-surface-300 leading-relaxed pt-2 border-t border-surface-100 dark:border-white/5">
                            Layanan rehabilitasi di fasilitas BNN <strong class="text-emerald-600 dark:text-emerald-400">100% GRATIS</strong> tanpa dipungut biaya apapun. Negara menanggung penuh pembiayaan pemulihan bagi penyalah guna narkotika yang memiliki tekad untuk sembuh.
                        </div>
                    </div>
                </div>

                {{-- Accordion Item 3 --}}
                <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/50 p-1 shadow-xs" x-data="{ open: false }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-surface-900 dark:text-white">Bagaimana cara melaporkan aktivitas peredaran narkoba secara anonim?</span>
                        <svg class="h-5 w-5 text-surface-500 dark:text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-600 dark:text-surface-300 leading-relaxed pt-2 border-t border-surface-100 dark:border-white/5">
                            Anda dapat melapor melalui Call Center BNN di nomor <strong class="text-primary-700 dark:text-primary-400">184</strong> atau menghubungi hotline BNNP Sulteng di <strong class="text-primary-700 dark:text-primary-400">08114511344</strong>. Identitas pelapor dijamin kerahasiaannya dan dilindungi oleh undang-undang perlindungan saksi.
                        </div>
                    </div>
                </div>

                {{-- Accordion Item 4 --}}
                <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/50 p-1 shadow-xs" x-data="{ open: false }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-surface-900 dark:text-white">Apa arti warna zona (Merah, Kuning, Hijau) pada peta?</span>
                        <svg class="h-5 w-5 text-surface-500 dark:text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-600 dark:text-surface-300 leading-relaxed pt-2 border-t border-surface-100 dark:border-white/5">
                            <ul class="space-y-1.5 list-disc list-inside">
                                <li><strong class="text-danger-600 dark:text-red-400">Zona Merah (Bahaya / Rawan Tinggi):</strong> Wilayah dengan tingkat kasus tinggi dan potensi peredaran aktif yang memerlukan intervensi terpadu.</li>
                                <li><strong class="text-amber-600 dark:text-amber-400">Zona Kuning (Waspada / Rawan Sedang):</strong> Wilayah dengan indikasi peredaran sedang yang membutuhkan pengawasan ketat.</li>
                                <li><strong class="text-emerald-600 dark:text-emerald-400">Zona Hijau (Aman / Rawan Rendah):</strong> Wilayah kondusif dengan jumlah kasus minimal atau nihil yang dipertahankan melalui program desa bersinar.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Bagian Kontak Darurat (Kanan, 1 Kolom) --}}
            <div>
                <div class="flex items-center gap-2 mb-6">
                    <h2 class="text-2xl font-bold text-surface-900 dark:text-white inline-flex items-center select-none">
                        {{-- Tombol Rahasia Tepat di kata Kontak --}}
                        <button type="button" 
                                onclick="triggerEasterEgg()"
                                class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors cursor-pointer text-left focus:outline-none"
                                title="✨ Ada rahasia di sini...">
                            Kontak
                        </button>
                        <span class="ml-1.5">Darurat</span>
                    </h2>
                    
                    {{-- Titik Tombol Rahasia Tersembunyi (Hidden easter egg dot) tepat di samping Kontak Darurat --}}
                    <button type="button" 
                            onclick="triggerEasterEgg()"
                            class="relative inline-flex items-center justify-center w-6 h-6 -ml-0.5 rounded-full text-transparent hover:text-amber-500 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 cursor-pointer focus:outline-none transition-all duration-300 group"
                            title="🤫 Ssstt... tombol rahasia!">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent group-hover:bg-amber-500 dark:group-hover:bg-amber-400 transition-colors"></span>
                        <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 absolute transition-opacity duration-300 text-amber-500 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </button>
                </div>
                
                <div class="rounded-3xl bg-gradient-to-b from-primary-50 to-primary-100/50 dark:from-primary-600/20 dark:to-primary-900/10 border border-primary-200 dark:border-primary-500/20 p-6 relative overflow-hidden shadow-sm">
                    <div class="absolute -right-10 -top-10 text-primary-500/10 pointer-events-none">
                        <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-600 text-white shadow-md shadow-primary-600/30">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-primary-700 dark:text-primary-300">Call Center Nasional BNN</p>
                                <p class="text-3xl font-black text-primary-900 dark:text-white tracking-wider">184</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="rounded-2xl bg-white dark:bg-surface-950/70 border border-primary-200/70 dark:border-white/5 p-4 flex items-center gap-4 shadow-xs">
                                <div class="p-2.5 bg-emerald-50 dark:bg-green-500/10 text-emerald-600 dark:green-400 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold uppercase text-surface-500 dark:text-surface-400">Hotline BNNP Sulteng</p>
                                    <p class="font-bold text-surface-900 dark:text-white text-sm">08114511344</p>
                                </div>
                            </div>
                            
                            <div class="rounded-2xl bg-white dark:bg-surface-950/70 border border-primary-200/70 dark:border-white/5 p-4 flex items-center gap-4 shadow-xs">
                                <div class="p-2.5 bg-primary-50 dark:bg-blue-500/10 text-primary-600 dark:text-blue-400 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold uppercase text-surface-500 dark:text-surface-400">Email Resmi Layanan</p>
                                    <p class="font-bold text-surface-900 dark:text-white text-sm">bnnpsulteng@gmail.com</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Easter Egg Modal --}}
    <div id="easter-egg-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-md transition-all duration-300">
        <div class="relative w-full max-w-sm rounded-3xl bg-white dark:bg-surface-900 border border-surface-200 dark:border-white/10 p-6 text-center shadow-2xl transform scale-95 transition-transform duration-300" id="easter-egg-card">
            {{-- Close Button --}}
            <button type="button" onclick="closeEasterEgg()" class="absolute top-4 right-4 p-2 rounded-full text-surface-400 hover:text-surface-700 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/10 transition" title="Tutup">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Meme / Sketch Image --}}
            <div class="overflow-hidden rounded-2xl bg-surface-50 dark:bg-surface-950 p-2 mb-4 border border-surface-200 dark:border-white/5">
                <img src="{{ asset('images/easter-egg.png') }}" alt="Easter Egg BLEHHH!" class="w-full h-auto rounded-xl mx-auto drop-shadow-md hover:scale-105 transition-transform duration-300">
            </div>

            <h3 class="text-2xl font-black text-surface-900 dark:text-white mb-1">BLEEEHHH! 😜</h3>
            <p class="text-xs text-surface-500 dark:text-surface-400 mb-5 leading-relaxed">
                Wah, jeli banget matanya! Kamu berhasil nemuin tombol rahasia di <span class="font-bold text-primary-600 dark:text-primary-400">Kontak Darurat</span>! Tetap semangat dan jauhi narkoba yaa~ ✨
            </p>

            <button type="button" onclick="closeEasterEgg()" class="w-full py-2.5 px-4 rounded-xl bg-primary-600 hover:bg-primary-500 text-white font-bold text-xs shadow-lg shadow-primary-600/30 transition">
                Tutup Rahasia ✨
            </button>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Alpine.js for Accordion --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Canvas Confetti for celebratory Easter Egg --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <script>
        function playEasterEggSound() {
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                const ctx = new AudioContext();
                
                // Playful musical chime: C5 -> E5 -> G5 -> C6
                const notes = [523.25, 659.25, 783.99, 1046.50];
                notes.forEach((freq, index) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, ctx.currentTime + index * 0.07);
                    
                    gain.gain.setValueAtTime(0.18, ctx.currentTime + index * 0.07);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + index * 0.07 + 0.22);
                    
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    
                    osc.start(ctx.currentTime + index * 0.07);
                    osc.stop(ctx.currentTime + index * 0.07 + 0.22);
                });
            } catch(e) {}
        }

        function triggerEasterEgg() {
            const modal = document.getElementById('easter-egg-modal');
            const card = document.getElementById('easter-egg-card');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    card.classList.remove('scale-95');
                    card.classList.add('scale-100');
                }, 10);
                playEasterEggSound();

                if (typeof confetti === 'function') {
                    confetti({
                        particleCount: 80,
                        spread: 70,
                        origin: { y: 0.6 }
                    });
                }
            }
        }

        function closeEasterEgg() {
            const modal = document.getElementById('easter-egg-modal');
            const card = document.getElementById('easter-egg-card');
            if (modal) {
                card.classList.remove('scale-100');
                card.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 150);
            }
        }

        document.getElementById('easter-egg-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeEasterEgg();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeEasterEgg();
        });
    </script>
@endpush
