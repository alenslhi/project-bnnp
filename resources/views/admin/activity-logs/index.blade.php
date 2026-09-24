@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white tracking-tight">Log Aktivitas Sistem</h2>
    <p class="text-sm text-surface-400 mt-1">Riwayat tindakan yang dilakukan oleh admin di dalam sistem.</p>
</div>

<div class="bg-surface-900 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-surface-300">
            <thead class="bg-surface-800/50 text-xs uppercase text-surface-400">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Waktu</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">User</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Aksi</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($logs as $log)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-surface-400 text-xs">
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($log->user)
                                <div class="font-medium text-white">{{ $log->user->name }}</div>
                                <div class="text-[10px] text-surface-400 uppercase tracking-widest">{{ $log->user->role }}</div>
                            @else
                                <span class="text-surface-500 italic">User Dihapus</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                            @if(str_contains($log->action, 'CREATE')) bg-green-500/10 text-green-400 border-green-500/20
                            @elseif(str_contains($log->action, 'UPDATE')) bg-blue-500/10 text-blue-400 border-blue-500/20
                            @elseif(str_contains($log->action, 'DELETE')) bg-red-500/10 text-red-400 border-red-500/20
                            @else bg-surface-500/10 text-surface-400 border-surface-500/20
                            @endif
                            ">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-surface-200">
                            {{ $log->description }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-surface-500">
                            Belum ada log aktivitas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-white/5">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
