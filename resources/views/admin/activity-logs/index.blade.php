@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-surface-900 dark:text-white tracking-tight">Log Aktivitas Sistem</h2>
    <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Riwayat tindakan audit dan operasional yang dilakukan oleh admin di dalam sistem.</p>
</div>

<div class="bg-white dark:bg-surface-900 border border-surface-200 dark:border-white/10 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-surface-600 dark:text-surface-300">
            <thead class="bg-surface-100/75 dark:bg-surface-800/50 text-xs uppercase text-surface-600 dark:text-surface-400 border-b border-surface-200 dark:border-white/5">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Waktu</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">User</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Aksi</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-200 dark:divide-white/5">
                @forelse($logs as $log)
                    <tr class="hover:bg-surface-50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-surface-500 dark:text-surface-400 text-xs">
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($log->user)
                                <div class="font-medium text-surface-900 dark:text-white">{{ $log->user->name }}</div>
                                <div class="text-[10px] text-surface-500 dark:text-surface-400 uppercase tracking-widest font-semibold">{{ $log->user->role }}</div>
                            @else
                                <span class="text-surface-400 italic">User Dihapus</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border
                            @if(str_contains($log->action, 'CREATE')) bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20
                            @elseif(str_contains($log->action, 'UPDATE')) bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20
                            @elseif(str_contains($log->action, 'DELETE')) bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20
                            @else bg-surface-100 dark:bg-surface-500/10 text-surface-700 dark:text-surface-400 border-surface-200 dark:border-surface-500/20
                            @endif
                            ">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-surface-800 dark:text-surface-200">
                            {{ $log->description }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-surface-500">
                            Belum ada log aktivitas tercatat.
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
@endsection
