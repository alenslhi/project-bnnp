@extends('layouts.publik')

@section('title', 'FAQ & Kontak Darurat')

@section('content')

    {{-- Header --}}
    <section class="mx-auto max-w-7xl px-4 pt-10 pb-12 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-block text-xs font-semibold text-primary-400 uppercase tracking-widest mb-2">Pusat Bantuan</span>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">FAQ & Kontak Darurat</h1>
            <p class="text-surface-400 leading-relaxed">
                Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan BNNP Sulawesi Tengah, prosedur rehabilitasi, dan hubungi kami jika Anda membutuhkan bantuan darurat.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Bagian FAQ (Kiri, 2 Kolom) --}}
            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-2xl font-bold text-white mb-6">Pertanyaan Umum (FAQ)</h2>

                {{-- Accordion Item 1 --}}
                <div class="rounded-2xl border border-white/5 bg-surface-900/50 p-1" x-data="{ open: false }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-white">Bagaimana prosedur pendaftaran rehabilitasi mandiri?</span>
                        <svg class="h-5 w-5 text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-300 leading-relaxed pt-2 border-t border-white/5">
                            Keluarga atau pasien dapat datang langsung ke klinik rehabilitasi BNNP terdekat dengan membawa fotokopi KTP dan KK. Pendaftaran rehabilitasi yang dilaporkan secara mandiri **tidak akan diproses hukum** (bebas pidana) sesuai undang-undang yang berlaku.
                        </div>
                    </div>
                </div>

                {{-- Accordion Item 2 --}}
                <div class="rounded-2xl border border-white/5 bg-surface-900/50 p-1" x-data="{ open: false }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-white">Apakah layanan rehabilitasi dipungut biaya?</span>
                        <svg class="h-5 w-5 text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-300 leading-relaxed pt-2 border-t border-white/5">
                            Layanan rehabilitasi di fasilitas BNN **100% GRATIS** tanpa dipungut biaya apapun. Negara menanggung biaya pemulihan bagi pecandu yang memiliki niat untuk sembuh.
                        </div>
                    </div>
                </div>

                {{-- Accordion Item 3 --}}
                <div class="rounded-2xl border border-white/5 bg-surface-900/50 p-1" x-data="{ open: false }">
                    <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left">
                        <span class="font-semibold text-white">Bagaimana cara melaporkan aktivitas peredaran narkoba secara anonim?</span>
                        <svg class="h-5 w-5 text-surface-400 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-5 pb-5 text-sm text-surface-300 leading-relaxed pt-2 border-t border-white/5">
                            Anda dapat melapor melalui Call Center BNN di nomor <strong>106</strong> atau mengirimkan SMS ke <strong>081221675675</strong>. Identitas pelapor akan dirahasiakan dan dilindungi sepenuhnya oleh undang-undang perlindungan saksi.
                        </div>
                    </div>
                </div>

            </div>

            {{-- Bagian Kontak Darurat (Kanan, 1 Kolom) --}}
            <div>
                <h2 class="text-2xl font-bold text-white mb-6">Kontak Darurat</h2>
                
                <div class="rounded-2xl bg-gradient-to-b from-primary-600/20 to-primary-900/10 border border-primary-500/20 p-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-primary-500/10">
                        <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-500/20 text-primary-400">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-primary-400">Call Center Nasional</p>
                                <p class="text-2xl font-bold text-white tracking-wider">106</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="rounded-xl bg-surface-950/50 border border-white/5 p-4 flex items-center gap-4">
                                <div class="p-2 bg-green-500/10 text-green-400 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-surface-400">WhatsApp Pengaduan</p>
                                    <p class="font-semibold text-white">+62 812-3456-7890</p>
                                </div>
                            </div>
                            
                            <div class="rounded-xl bg-surface-950/50 border border-white/5 p-4 flex items-center gap-4">
                                <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-surface-400">Email Resmi</p>
                                    <p class="font-semibold text-white">info@bnnp-sulteng.go.id</p>
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
