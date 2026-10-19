@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-surface-900 dark:text-white tracking-tight">Daftar Pengguna</h2>
        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Kelola akses akun admin untuk sistem BNNP Sulteng.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border {{ ($adminCount ?? 0) >= 1 ? 'border-primary-300 dark:border-primary-500/30 bg-primary-50 dark:bg-primary-500/10 text-primary-700 dark:text-primary-400' : 'border-emerald-300 dark:border-emerald-500/30 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' }} text-xs font-semibold">
            <span class="w-2 h-2 rounded-full {{ ($adminCount ?? 0) >= 1 ? 'bg-primary-500' : 'bg-emerald-500' }}"></span>
            Kuota Akun Admin: {{ $adminCount ?? 0 }}/1 {{ ($adminCount ?? 0) >= 1 ? '(Terisi)' : '(Tersedia)' }}
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary-600 hover:bg-primary-500 text-white text-sm font-medium rounded-xl transition-all shadow-lg shadow-primary-500/25">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah User
        </a>
    </div>
</div>

<div class="bg-white dark:bg-surface-900 border border-surface-200 dark:border-white/5 rounded-2xl overflow-hidden shadow-sm dark:shadow-none">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-surface-600 dark:text-surface-300">
            <thead class="bg-surface-50 dark:bg-surface-800/50 text-xs uppercase text-surface-500 dark:text-surface-400">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Nama & Email</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Role</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Tgl Terdaftar</th>
                    <th scope="col" class="px-6 py-4 text-right font-medium tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-100 dark:divide-white/5">
                @forelse($users as $user)
                    <tr class="hover:bg-primary-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-surface-900 dark:text-white">{{ $user->name }}</div>
                            <div class="text-xs text-surface-400">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @switch($user->role)
                                @case('super_admin')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/20">Super Admin</span>
                                    @break
                                @case('admin')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary-50 dark:bg-primary-500/10 text-primary-700 dark:text-primary-400 border border-primary-200 dark:border-primary-500/20">Admin</span>
                                    @break
                                @default
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-surface-100 dark:bg-surface-500/10 text-surface-600 dark:text-surface-400 border border-surface-200 dark:border-surface-500/20">{{ $user->role_label }}</span>
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition" title="Edit">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                </a>
                                
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-surface-400 hover:text-danger-500 dark:hover:text-danger-400 transition" title="Hapus">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-surface-400 dark:text-surface-500">
                            Belum ada data user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-surface-200 dark:border-white/5">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
