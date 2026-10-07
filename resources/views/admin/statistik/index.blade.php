@extends('layouts.admin')

@section('title', 'Kelola Statistik Kasus')
@section('page-title', 'Kelola Data Statistik Kasus (Dari CSV)')

@section('content')
<div class="space-y-6">

    {{-- Form Upload --}}
    <div class="bg-surface-900 border border-white/5 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/5 bg-surface-900/50">
            <h2 class="text-lg font-bold text-white">Upload Dataset Baru</h2>
            <p class="text-sm text-surface-400 mt-1">Unggah file CSV berisi data statistik kasus. Anda bisa mengunduh template CSV <a href="{{ asset('excel_templates/template_data_kasus.csv') }}" class="text-primary-400 hover:underline" download>di sini</a>.</p>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.statistik.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="nama_dataset" class="block text-sm font-medium text-surface-200">Nama Dataset <span class="text-danger-400">*</span></label>
                        <input type="text" name="nama_dataset" id="nama_dataset" placeholder="Misal: Data Pengguna Narkoba 2024" required
                            class="block w-full rounded-xl border border-white/10 bg-surface-800 px-4 py-2.5 text-sm text-white focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    
                    <div class="space-y-1.5">
                        <label for="tahun" class="block text-sm font-medium text-surface-200">Tahun <span class="text-danger-400">*</span></label>
                        <input type="number" name="tahun" id="tahun" placeholder="2024" value="{{ date('Y') }}" required
                            class="block w-full rounded-xl border border-white/10 bg-surface-800 px-4 py-2.5 text-sm text-white focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="file_csv" class="block text-sm font-medium text-surface-200">File CSV <span class="text-danger-400">*</span></label>
                    <input type="file" name="file_csv" id="file_csv" accept=".csv, .txt" required
                        class="block w-full rounded-xl border border-white/10 bg-surface-800 px-4 py-2 text-sm text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500 file:text-white hover:file:bg-primary-600 focus:outline-none cursor-pointer">
                    <p class="text-xs text-surface-500 mt-1">Hanya mendukung format .csv</p>
                </div>

                <div class="pt-4 border-t border-white/5">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-primary-600 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 hover:bg-primary-500 hover:shadow-primary-500/30 transition">
                        Upload & Proses Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Dataset --}}
    <div class="bg-surface-900 border border-white/5 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/5 bg-surface-900/50">
            <h2 class="text-lg font-bold text-white">Daftar Dataset Terunggah</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-surface-300">
                <thead class="bg-surface-800/50 text-xs uppercase text-surface-400 border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Dataset</th>
                        <th class="px-6 py-4 font-semibold">Tahun</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($datasets as $dataset)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4 font-medium text-white">{{ $dataset->nama_dataset }}</td>
                        <td class="px-6 py-4">{{ $dataset->tahun }}</td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.statistik.destroy', urlencode($dataset->nama_dataset)) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh data pada dataset ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-danger-400 bg-danger-500/10 hover:bg-danger-500/20 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-surface-400">Belum ada dataset yang diunggah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
