@php
    $bulanList = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
    $activeMonth = $currentMonth ?? (int) date('n');
    $activeYear = $currentYear ?? (int) date('Y');
    $years = $availableYears ?? [$activeYear];
    $totalAllTime = $totalPengunjung ?? 0;
    $totalFilteredInitial = $pengunjungBulanIni ?? 0;
@endphp

{{-- ═══ MODAL STATISTIK PENGUNJUNG (Tema Biru Resmi SKENA BNNP) ═══ --}}
<div id="visitor-modal-backdrop"
     class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 bg-black/60 backdrop-blur-xs transition-opacity duration-300 opacity-0"
     role="dialog"
     aria-modal="true"
     aria-labelledby="visitor-modal-title">

    <div id="visitor-modal-card"
         class="relative w-full max-w-md bg-white dark:bg-surface-900 rounded-[28px] sm:rounded-[32px] shadow-2xl overflow-hidden border border-surface-200/60 dark:border-white/10 transform transition-all duration-300 scale-95 opacity-0">

        {{-- ── HEADER MODAL (Biru Navy Pemerintah Resmi BNNP) ── --}}
        <div class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-950 px-6 pt-7 pb-6 text-center text-white select-none">
            {{-- Tombol Tutup (X) --}}
            <button type="button"
                    onclick="closeVisitorModal()"
                    class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 active:scale-95 text-white/90 hover:text-white flex items-center justify-center transition-all cursor-pointer"
                    aria-label="Tutup Statistik">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Icon Bar Chart Berlingkar --}}
            <div class="w-14 h-14 rounded-full bg-white/15 border border-white/25 flex items-center justify-center mx-auto mb-3 shadow-inner">
                <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
            </div>

            {{-- Judul & Subjudul --}}
            <h3 id="visitor-modal-title" class="text-xl sm:text-2xl font-black text-white tracking-tight">
                Statistik Pengunjung
            </h3>
            <p class="text-xs sm:text-[13px] text-primary-200 font-normal mt-1 leading-snug">
                Rincian data akses website SKENA BNNP Sulteng
            </p>
        </div>

        {{-- ── BODY MODAL ── --}}
        <div class="p-6 sm:p-7 space-y-5 bg-white dark:bg-surface-900">
            {{-- Label Filter --}}
            <div class="text-center">
                <span class="text-[11px] font-bold uppercase tracking-widest text-surface-400 dark:text-surface-500">
                    FILTER WAKTU AKSES
                </span>
            </div>

            {{-- 3 Filter Dropdown (Hari, Bulan, Tahun) --}}
            <div class="grid grid-cols-3 gap-2 sm:gap-3">
                {{-- Hari --}}
                <div>
                    <label for="visitor-filter-day" class="block text-[11px] font-semibold text-surface-500 dark:text-surface-400 mb-1">
                        Hari
                    </label>
                    <div class="relative">
                        <select id="visitor-filter-day"
                                onchange="fetchVisitorFilteredStats()"
                                class="w-full appearance-none rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-xs sm:text-sm font-semibold text-surface-800 dark:text-surface-100 py-2.5 px-3 pr-8 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-600 dark:focus:border-primary-400 transition cursor-pointer">
                            <option value="Semua" selected>Semua</option>
                            @for($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}">{{ str_pad($d, 2, '0', STR_PAD_LEFT) }}</option>
                            @endfor
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-surface-400">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Bulan --}}
                <div>
                    <label for="visitor-filter-month" class="block text-[11px] font-semibold text-surface-500 dark:text-surface-400 mb-1">
                        Bulan
                    </label>
                    <div class="relative">
                        <select id="visitor-filter-month"
                                onchange="fetchVisitorFilteredStats()"
                                class="w-full appearance-none rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-xs sm:text-sm font-semibold text-surface-800 dark:text-surface-100 py-2.5 px-3 pr-8 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-600 dark:focus:border-primary-400 transition cursor-pointer">
                            <option value="Semua">Semua</option>
                            @foreach($bulanList as $num => $name)
                                <option value="{{ $num }}" {{ $num === $activeMonth ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-surface-400">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Tahun --}}
                <div>
                    <label for="visitor-filter-year" class="block text-[11px] font-semibold text-surface-500 dark:text-surface-400 mb-1">
                        Tahun
                    </label>
                    <div class="relative">
                        <select id="visitor-filter-year"
                                onchange="fetchVisitorFilteredStats()"
                                class="w-full appearance-none rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-xs sm:text-sm font-semibold text-surface-800 dark:text-surface-100 py-2.5 px-3 pr-8 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-600 dark:focus:border-primary-400 transition cursor-pointer">
                            <option value="Semua">Semua</option>
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ $yr === $activeYear ? 'selected' : '' }}>
                                    {{ $yr }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-surface-400">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── KARTU HASIL TOTAL KUNJUNGAN ── --}}
            <div class="relative rounded-2xl border border-surface-200/80 dark:border-white/10 bg-primary-50/40 dark:bg-primary-950/20 p-5 text-center transition-all">
                <span class="block text-xs sm:text-sm font-semibold text-surface-600 dark:text-surface-300">
                    Total Kunjungan
                </span>
                <div class="relative flex items-center justify-center my-1.5 min-h-[56px]">
                    <span id="visitor-modal-filtered-count"
                          class="text-4xl sm:text-5xl font-black text-primary-700 dark:text-primary-400 tracking-tight transition-all duration-200">
                        {{ number_format($totalFilteredInitial, 0, ',', '.') }}
                    </span>
                    {{-- Mini spinner saat loading --}}
                    <div id="visitor-modal-spinner" class="absolute hidden">
                        <svg class="animate-spin h-7 w-7 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- ── ROW FOOTER MODAL (Total Sepanjang Waktu) ── --}}
            <div class="border-t border-surface-200/70 dark:border-white/10 pt-4 flex items-center justify-between">
                <span class="text-xs sm:text-sm font-bold text-surface-700 dark:text-surface-300">
                    Total Sepanjang Waktu
                </span>
                <span id="visitor-modal-total-count" class="text-base sm:text-lg font-black text-surface-900 dark:text-white">
                    {{ number_format($totalAllTime, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ═══ JAVASCRIPT LOGIC MODAL & REALTIME FILTER ═══ --}}
<script>
    function openVisitorModal() {
        const backdrop = document.getElementById('visitor-modal-backdrop');
        const card = document.getElementById('visitor-modal-card');
        if (!backdrop || !card) return;

        backdrop.classList.remove('hidden');
        backdrop.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        // Trigger animasi masuk
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        });

        // Ambil data terbaru saat modal dibuka
        fetchVisitorFilteredStats();
    }

    function closeVisitorModal() {
        const backdrop = document.getElementById('visitor-modal-backdrop');
        const card = document.getElementById('visitor-modal-card');
        if (!backdrop || !card) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            backdrop.classList.add('hidden');
            backdrop.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }, 250);
    }

    // Tutup saat backdrop diklik
    document.getElementById('visitor-modal-backdrop')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeVisitorModal();
        }
    });

    // Tutup dengan tombol Esc
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const backdrop = document.getElementById('visitor-modal-backdrop');
            if (backdrop && !backdrop.classList.contains('hidden')) {
                closeVisitorModal();
            }
        }
    });

    // Fetch data filter AJAX secara real-time
    let visitorAbortController = null;

    function fetchVisitorFilteredStats() {
        const daySelect   = document.getElementById('visitor-filter-day');
        const monthSelect = document.getElementById('visitor-filter-month');
        const yearSelect  = document.getElementById('visitor-filter-year');
        const countEl     = document.getElementById('visitor-modal-filtered-count');
        const spinnerEl   = document.getElementById('visitor-modal-spinner');
        const totalEl     = document.getElementById('visitor-modal-total-count');

        if (!daySelect || !monthSelect || !yearSelect || !countEl) return;

        const day   = daySelect.value;
        const month = monthSelect.value;
        const year  = yearSelect.value;

        // Cancel previous request if any
        if (visitorAbortController) {
            visitorAbortController.abort();
        }
        visitorAbortController = new AbortController();

        // Tampilkan spinner / redupkan angka
        countEl.classList.add('opacity-30');
        if (spinnerEl) spinnerEl.classList.remove('hidden');

        const url = `/api/pengunjung/statistik?hari=${encodeURIComponent(day)}&bulan=${encodeURIComponent(month)}&tahun=${encodeURIComponent(year)}`;

        fetch(url, { signal: visitorAbortController.signal })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    countEl.textContent = data.total_filter_formatted;
                    if (totalEl) {
                        totalEl.textContent = data.total_sepanjang_waktu_formatted;
                    }

                    // Sinkronkan juga angka pada widget bubble di halaman
                    const mainTotalEl = document.getElementById('visitor-total-main');
                    const mainTodayEl = document.getElementById('visitor-today-main');
                    if (mainTotalEl) mainTotalEl.textContent = data.total_sepanjang_waktu_formatted;
                    if (mainTodayEl) mainTodayEl.textContent = data.total_hari_ini_formatted;
                }
            })
            .catch(err => {
                if (err.name !== 'AbortError') {
                    console.error('Gagal memuat statistik pengunjung:', err);
                }
            })
            .finally(() => {
                countEl.classList.remove('opacity-30');
                if (spinnerEl) spinnerEl.classList.add('hidden');
            });
    }
</script>
