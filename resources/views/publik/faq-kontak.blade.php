@extends('layouts.publik')

@section('title', 'FAQ & Kontak Darurat')

@section('content')

    {{-- Header --}}
    <section class="mx-auto max-w-7xl px-4 pt-10 pb-12 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-block text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-2">Pusat Bantuan & Pengaduan</span>
            <h1 class="text-3xl sm:text-4xl font-black text-surface-900 dark:text-white mb-4">FAQ & Kontak Darurat</h1>
            <p class="text-surface-600 dark:text-surface-400 leading-relaxed text-sm sm:text-base">
                Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan BNNP Sulawesi Tengah, prosedur rehabilitasi, dan hubungi kami jika Anda membutuhkan bantuan darurat atau ingin melapor.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Bagian FAQ (Kiri, 2 Kolom) --}}
            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-2xl font-bold text-surface-900 dark:text-white mb-6">Pertanyaan Umum (FAQ)</h2>

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
                <h2 class="text-2xl font-bold text-surface-900 dark:text-white mb-6">Kontak Darurat</h2>
                
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
                                <div class="p-2.5 bg-emerald-50 dark:bg-green-500/10 text-emerald-600 dark:text-green-400 rounded-xl">
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

@endsection

@push('scripts')
    {{-- Alpine.js for Accordion --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
