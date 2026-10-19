@extends('layouts.admin')

@section('title', 'Kelola Materi Edukasi')
@section('page-title', 'Kelola Materi Edukasi P4GN')

@section('content')
<div class="space-y-6">
    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-surface-900 dark:text-white">Daftar Materi & Publikasi</h2>
            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">
                Kelola dan terbitkan materi artikel, kamus bahaya narkoba, serta siaran media informasi BNNP Sulteng.
            </p>
        </div>

        <a href="{{ route('admin.edukasi.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-500 transition shrink-0">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tulis Materi Baru
        </a>
    </div>

    {{-- Table Card --}}
    <div class="rounded-3xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/60 backdrop-blur-xl overflow-hidden shadow-sm dark:shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-surface-50 dark:bg-surface-950/50 text-xs uppercase tracking-wider text-surface-500 dark:text-surface-400 border-b border-surface-200 dark:border-white/5">
                    <tr>
                        <th class="py-4 px-6 font-semibold">Judul Materi</th>
                        <th class="py-4 px-6 font-semibold">Kategori</th>
                        <th class="py-4 px-6 font-semibold">Penulis</th>
                        <th class="py-4 px-6 font-semibold">Tanggal</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-100 dark:divide-white/5">
                    @forelse($edukasis as $item)
                        <tr class="hover:bg-primary-50/50 dark:hover:bg-white/[0.02] transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    @if($item->gambar)
                                        <div class="h-10 w-14 rounded-lg overflow-hidden bg-surface-100 dark:bg-surface-800 shrink-0 border border-surface-200 dark:border-white/10">
                                            <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="h-full w-full object-cover">
                                        </div>
                                    @else
                                        <div class="h-10 w-14 rounded-lg bg-surface-100 dark:bg-white/5 flex items-center justify-center text-surface-400 shrink-0 border border-surface-200 dark:border-white/5">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('edukasi.show', $item->id) }}" target="_blank"
                                           class="font-bold text-surface-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition block line-clamp-1">
                                            {{ $item->judul }}
                                        </a>
                                        <span class="text-xs text-surface-400 line-clamp-1 mt-0.5">
                                            {{ Str::limit(strip_tags($item->konten), 70) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($item->kategori === 'artikel')
                                    <span class="inline-flex items-center rounded-lg border border-primary-200 dark:border-primary-500/30 bg-primary-50 dark:bg-primary-500/10 px-2.5 py-1 text-xs font-semibold text-primary-700 dark:text-primary-400">
                                        Artikel
                                    </span>
                                @elseif($item->kategori === 'kamus')
                                    <span class="inline-flex items-center rounded-lg border border-warning-200 dark:border-warning-500/30 bg-warning-50 dark:bg-warning-500/10 px-2.5 py-1 text-xs font-semibold text-warning-600 dark:text-warning-400">
                                        Kamus Narkoba
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-lg border border-accent-200 dark:border-accent-500/30 bg-accent-50 dark:bg-accent-500/10 px-2.5 py-1 text-xs font-semibold text-accent-600 dark:text-accent-400">
                                        Rilis Media
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-surface-600 dark:text-surface-300">
                                {{ $item->penulis->name ?? 'Admin BNNP' }}
                            </td>
                            <td class="py-4 px-6 text-xs text-surface-400 whitespace-nowrap">
                                {{ $item->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    {{-- Edit & Hapus (Super admin dan Admin) --}}
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                        <a href="{{ route('admin.edukasi.edit', $item->id) }}"
                                           class="p-2 rounded-lg bg-surface-100 dark:bg-white/5 text-surface-500 dark:text-surface-300 hover:text-primary-600 dark:hover:text-white hover:bg-primary-50 dark:hover:bg-white/10 transition"
                                           title="Edit Materi">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.edukasi.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 rounded-lg bg-danger-50 dark:bg-danger-500/10 text-danger-500 dark:text-danger-400 hover:bg-danger-100 dark:hover:bg-danger-500/20 transition"
                                                    title="Hapus Materi">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-surface-400 dark:text-surface-500 text-sm">
                                Belum ada materi edukasi yang dipublikasikan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($edukasis->hasPages())
            <div class="p-4 border-t border-surface-200 dark:border-white/5">
                {{ $edukasis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
