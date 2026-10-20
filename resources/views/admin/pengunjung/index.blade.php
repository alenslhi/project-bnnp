@extends('layouts.admin')

@section('title', 'Riwayat Pengunjung')
@section('page-title', 'Riwayat Pengunjung')

@section('content')

{{-- ═══ BREADCRUMB ═══ --}}
<div class="flex items-center gap-2 text-xs text-surface-500 dark:text-surface-400 mb-2">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Dashboard</a>
    <span>/</span>
    <span class="font-semibold text-surface-900 dark:text-white">Riwayat Pengunjung</span>
</div>

{{-- ═══ HEADER & TOMBOL AKSI ═══ --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h2 class="text-2xl sm:text-3xl font-black text-surface-900 dark:text-white tracking-tight">
            Riwayat Pengunjung
        </h2>
        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">
            Pantau statistik dan riwayat kunjungan website Anda.
        </p>
    </div>

    {{-- Tombol Reset Semua Data (Merah Sesuai Gambar) --}}
    <form id="form-reset-pengunjung" action="{{ route('admin.pengunjung.reset') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button"
                onclick="confirmResetPengunjung()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-danger-600 hover:bg-danger-700 text-white font-bold text-sm shadow-xs transition hover:shadow-md cursor-pointer active:scale-95">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
            </svg>
            <span>Reset Semua Data</span>
        </button>
    </form>
</div>

{{-- ═══ 4 KARTU STATISTIK (Sesuai Desain Gambar) ═══ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    {{-- Card 1: Total Pengunjung --}}
    <div class="rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900 p-5 shadow-xs flex items-center gap-4 transition hover:shadow-md">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-[11px] font-bold uppercase tracking-wider text-surface-400 dark:text-surface-400">
                TOTAL PENGUNJUNG
            </span>
            <p class="text-2xl sm:text-3xl font-black text-surface-900 dark:text-white tracking-tight mt-0.5">
                {{ number_format($totalPengunjung, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Card 2: Hari Ini --}}
    <div class="rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900 p-5 shadow-xs flex items-center gap-4 transition hover:shadow-md">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-[11px] font-bold uppercase tracking-wider text-surface-400 dark:text-surface-400">
                HARI INI
            </span>
            <p class="text-2xl sm:text-3xl font-black text-surface-900 dark:text-white tracking-tight mt-0.5">
                {{ number_format($pengunjungHariIni, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Card 3: Minggu Ini --}}
    <div class="rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900 p-5 shadow-xs flex items-center gap-4 transition hover:shadow-md">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
        </div>
        <div>
            <span class="block text-[11px] font-bold uppercase tracking-wider text-surface-400 dark:text-surface-400">
                MINGGU INI
            </span>
            <p class="text-2xl sm:text-3xl font-black text-surface-900 dark:text-white tracking-tight mt-0.5">
                {{ number_format($pengunjungMingguIni, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Card 4: Bulan Ini --}}
    <div class="rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900 p-5 shadow-xs flex items-center gap-4 transition hover:shadow-md">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
        </div>
        <div>
            <span class="block text-[11px] font-bold uppercase tracking-wider text-surface-400 dark:text-surface-400">
                BULAN INI
            </span>
            <p class="text-2xl sm:text-3xl font-black text-surface-900 dark:text-white tracking-tight mt-0.5">
                {{ number_format($pengunjungBulanIni, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>

{{-- ═══ TABEL DAFTAR LOG PENGUNJUNG TERBARU ═══ --}}
<div class="bg-white dark:bg-surface-900 border border-surface-200 dark:border-white/10 rounded-2xl overflow-hidden shadow-xs">
    <div class="px-6 py-5 border-b border-surface-200 dark:border-white/5 flex items-center justify-between">
        <h3 class="text-base sm:text-lg font-bold text-surface-900 dark:text-white">
            Daftar Log Pengunjung Terbaru
        </h3>
        <span class="text-xs text-surface-500 dark:text-surface-400">
            Total tercatat: <strong>{{ number_format($logs->total(), 0, ',', '.') }}</strong>
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-surface-600 dark:text-surface-300">
            <thead class="bg-surface-100/75 dark:bg-surface-800/50 text-[11px] uppercase tracking-wider text-surface-500 dark:text-surface-400 border-b border-surface-200 dark:border-white/5 font-bold">
                <tr>
                    <th scope="col" class="px-6 py-4">Waktu Akses</th>
                    <th scope="col" class="px-6 py-4">Alamat IP</th>
                    <th scope="col" class="px-6 py-4">URL yang Dikunjungi</th>
                    <th scope="col" class="px-6 py-4">Browser / Perangkat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-200 dark:divide-white/5 text-xs sm:text-sm">
                @forelse($logs as $log)
                    <tr class="hover:bg-surface-50/70 dark:hover:bg-white/[0.02] transition-colors">
                        {{-- Waktu Akses --}}
                        <td class="px-6 py-4 whitespace-nowrap text-surface-700 dark:text-surface-300 font-medium">
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </td>

                        {{-- Alamat IP --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block rounded-lg bg-surface-100 dark:bg-surface-800 px-2.5 py-1 font-mono text-xs font-semibold text-surface-800 dark:text-surface-200 border border-surface-200/60 dark:border-surface-700/60">
                                {{ $log->ip_address }}
                            </span>
                        </td>

                        {{-- URL yang Dikunjungi --}}
                        <td class="px-6 py-4 max-w-xs truncate">
                            <a href="{{ $log->url ?? url('/') }}"
                               target="_blank"
                               class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 hover:underline font-medium break-all">
                                {{ $log->url ?: url('/') }}
                            </a>
                        </td>

                        {{-- Browser / Perangkat --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-1.5" title="{{ $log->user_agent }}">
                                <span class="font-semibold text-surface-800 dark:text-surface-200">{{ $log->browser }}</span>
                                <span class="text-surface-400">•</span>
                                <span class="text-surface-500 dark:text-surface-400">{{ $log->platform }}</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-surface-400 dark:text-surface-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-10 w-10 text-surface-300 dark:text-surface-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                                <p class="text-sm font-semibold text-surface-600 dark:text-surface-400">Belum ada riwayat kunjungan tercatat</p>
                                <p class="text-xs text-surface-400 mt-1">Pengunjung yang mengakses website akan otomatis tercatat di sini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-surface-200 dark:border-white/5 bg-surface-50/50 dark:bg-transparent">
            {{ $logs->links() }}
        </div>
    @endif
</div>

{{-- ═══ JAVASCRIPT KONFIRMASI RESET ═══ --}}
<script>
    function confirmResetPengunjung() {
        if (confirm('PERINGATAN!\n\nApakah Anda yakin ingin mereset seluruh data riwayat pengunjung?\nSemua log dan hitungan pengunjung akan dikembalikan ke 0 dan tindakan ini tidak dapat dibatalkan.')) {
            document.getElementById('form-reset-pengunjung').submit();
        }
    }
</script>

@endsection
