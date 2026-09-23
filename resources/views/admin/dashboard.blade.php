@extends('layouts.admin')

@section('title', 'Dasbor Utama')
@section('page-title', 'Dasbor Ikhtisar')

@section('content')
<div class="space-y-8">
    {{-- Role Welcome Banner --}}
    <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-r from-primary-950/70 via-surface-900 to-surface-900 p-6 sm:p-8 backdrop-blur-xl shadow-xl">
        <div class="absolute right-0 top-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-primary-500/10 blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full border border-primary-500/30 bg-primary-500/15 px-3 py-1 text-xs font-semibold text-primary-400 mb-2">
                    @switch(auth()->user()->role)
                        @case('super_admin') 👑 Hak Akses: Super Administrator @break
                        @case('admin_brantas') 🎯 Hak Akses: Bidang Pemberantasan @break
                        @case('admin_rehab') 🏥 Hak Akses: Bidang Rehabilitasi @break
                        @case('admin_cegah') 🛡️ Hak Akses: Bidang Pencegahan & Dayamas @break
                    @endswitch
                </span>
                <h2 class="text-2xl font-bold text-white">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-sm text-surface-400 mt-1 max-w-2xl">
                    @switch(auth()->user()->role)
                        @case('super_admin')
                            Anda memiliki akses penuh untuk memantau pemetaan zona kerawanan, verifikasi seluruh data konten edukasi, dan tata kelola akun admin bidang.
                            @break
                        @case('admin_brantas')
                            Fokus dasbor Anda adalah memperbarui data wilayah, status zona kerawanan (Merah, Kuning, Hijau), serta total kasus narkotika se-Sulawesi Tengah.
                            @break
                        @case('admin_rehab')
                            Fokus dasbor Anda adalah menyusun serta memperbarui artikel, panduan layanan rehabilitasi medis, dan informasi pemulihan korban penyalahgunaan.
                            @break
                        @case('admin_cegah')
                            Fokus dasbor Anda adalah memperkaya katalog edukasi, kamus istilah bahaya narkoba, dan materi pencegahan dini bagi masyarakat.
                            @break
                    @endswitch
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @if(auth()->user()->isSuperAdmin() || auth()->user()->role === 'admin_brantas')
                    <a href="{{ route('admin.zona.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-500 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Tambah Zona
                    </a>
                @endif
                <a href="{{ route('admin.edukasi.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-xs font-bold text-surface-200 hover:bg-white/10 hover:text-white transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tulis Materi
                </a>
            </div>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Zona --}}
        <div class="rounded-2xl border border-white/5 bg-surface-900/60 p-5 backdrop-blur-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-surface-400">Total Zona Terdata</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-500/10 text-primary-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-white">{{ $totalZona }}</p>
            <div class="mt-3 flex items-center gap-3 text-xs">
                <span class="text-danger-400 font-medium">🔴 {{ $zonaMerah }} Merah</span>
                <span class="text-warning-400 font-medium">🟡 {{ $zonaKuning }} Kuning</span>
                <span class="text-accent-400 font-medium">🟢 {{ $zonaHijau }} Hijau</span>
            </div>
        </div>

        {{-- Total Kasus --}}
        <div class="rounded-2xl border border-white/5 bg-surface-900/60 p-5 backdrop-blur-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-surface-400">Total Akumulasi Kasus</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-danger-500/10 text-danger-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-white">{{ number_format($totalKasus) }}</p>
            <p class="mt-3 text-xs text-surface-500">Tercatat di seluruh wilayah Sulteng</p>
        </div>

        {{-- Total Edukasi --}}
        <div class="rounded-2xl border border-white/5 bg-surface-900/60 p-5 backdrop-blur-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-surface-400">Materi Edukasi Aktif</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-accent-500/10 text-accent-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-white">{{ $totalEdukasi }}</p>
            <p class="mt-3 text-xs text-surface-500">Artikel, kamus, & siaran media</p>
        </div>

        {{-- Petugas Terdaftar --}}
        <div class="rounded-2xl border border-white/5 bg-surface-900/60 p-5 backdrop-blur-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-surface-400">Total Akun Petugas</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-warning-500/10 text-warning-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-white">{{ $totalUsers }}</p>
            <p class="mt-3 text-xs text-surface-500">Terdistribusi ke 3 bidang admin</p>
        </div>
    </div>

    {{-- Role Specific Content Grids --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Section 1: Zona Kerawanan (Tampil untuk Super Admin & Admin Pemberantasan) --}}
        @if(isset($zonasTerbaru))
            <div class="rounded-3xl border border-white/5 bg-surface-900/60 p-6 backdrop-blur-xl">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-white">Status Zona Terkini</h3>
                        <p class="text-xs text-surface-400">Daftar wilayah kerawanan narkotika</p>
                    </div>
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->role === 'admin_brantas')
                        <a href="{{ route('admin.zona.index') }}" class="text-xs font-semibold text-primary-400 hover:text-primary-300">
                            Kelola Semua &rarr;
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs uppercase text-surface-500 border-b border-white/5">
                            <tr>
                                <th class="pb-3 font-semibold">Wilayah</th>
                                <th class="pb-3 font-semibold">Status</th>
                                <th class="pb-3 font-semibold text-right">Kasus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($zonasTerbaru as $z)
                                <tr>
                                    <td class="py-3 font-medium text-white">{{ $z->nama_wilayah }}</td>
                                    <td class="py-3">
                                        @if($z->status_zona === 'merah')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-danger-500/15 border border-danger-500/30 px-2 py-0.5 text-[11px] font-semibold text-danger-400">🔴 Bahaya</span>
                                        @elseif($z->status_zona === 'kuning')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-warning-500/15 border border-warning-500/30 px-2 py-0.5 text-[11px] font-semibold text-warning-400">🟡 Waspada</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-accent-500/15 border border-accent-500/30 px-2 py-0.5 text-[11px] font-semibold text-accent-400">🟢 Aman</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right font-semibold text-surface-300">{{ $z->jumlah_kasus }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-xs text-surface-500">Belum ada data zona.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Section 2: Konten Edukasi Saya / Edukasi Terbaru --}}
        @if(isset($edukasiSaya))
            <div class="rounded-3xl border border-white/5 bg-surface-900/60 p-6 backdrop-blur-xl">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-white">Materi Edukasi Saya</h3>
                        <p class="text-xs text-surface-400">Konten yang Anda publikasikan</p>
                    </div>
                    <a href="{{ route('admin.edukasi.index') }}" class="text-xs font-semibold text-primary-400 hover:text-primary-300">
                        Kelola Semua &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($edukasiSaya as $item)
                        <div class="flex items-center justify-between p-3.5 rounded-xl border border-white/5 bg-white/5 hover:bg-white/10 transition">
                            <div class="min-w-0 flex-1 mr-3">
                                <h4 class="text-sm font-semibold text-white truncate">{{ $item->judul }}</h4>
                                <span class="text-xs text-surface-400">{{ ucfirst($item->kategori) }} • {{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('admin.edukasi.edit', $item->id) }}" class="text-xs font-semibold text-primary-400 hover:text-primary-300 shrink-0">Edit</a>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs text-surface-500">
                            Anda belum menerbitkan materi edukasi.
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Section 3: Edukasi Terbaru untuk Super Admin & Admin Cegah --}}
        @if(isset($edukasiTerbaru))
            <div class="rounded-3xl border border-white/5 bg-surface-900/60 p-6 backdrop-blur-xl">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-white">Materi Edukasi Terbaru</h3>
                        <p class="text-xs text-surface-400">Terbitan terkini dari seluruh bidang</p>
                    </div>
                    <a href="{{ route('admin.edukasi.index') }}" class="text-xs font-semibold text-primary-400 hover:text-primary-300">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($edukasiTerbaru as $item)
                        <div class="flex items-center justify-between p-3.5 rounded-xl border border-white/5 bg-white/5">
                            <div class="min-w-0 flex-1 mr-3">
                                <h4 class="text-sm font-semibold text-white truncate">{{ $item->judul }}</h4>
                                <span class="text-xs text-surface-400">Oleh: {{ $item->penulis->name ?? 'Admin' }} ({{ $item->kategori }})</span>
                            </div>
                            <span class="text-xs text-surface-500 shrink-0">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs text-surface-500">
                            Belum ada materi edukasi.
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Section 4: Daftar Pengguna untuk Super Admin --}}
        @if(isset($users))
            <div class="rounded-3xl border border-white/5 bg-surface-900/60 p-6 backdrop-blur-xl">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-white">Petugas Terdaftar</h3>
                        <p class="text-xs text-surface-400">Akun pengelola sistem informasi BNNP</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($users as $u)
                        <div class="flex items-center justify-between p-3.5 rounded-xl border border-white/5 bg-white/5">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-500/20 text-xs font-bold text-primary-400">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-white truncate">{{ $u->name }}</p>
                                    <p class="text-xs text-surface-500 truncate">{{ $u->email }}</p>
                                </div>
                            </div>
                            <span class="rounded-lg bg-surface-800 px-2.5 py-1 text-[11px] font-semibold text-surface-300">
                                {{ $u->role }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
