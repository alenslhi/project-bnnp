@extends('layouts.publik')

@section('title', 'Dashboard Statistik Informasi BNN')

@push('styles')
<style>
    /* Custom styles for ApexCharts in dark mode */
    .apexcharts-tooltip {
        background: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5) !important;
    }
    .apexcharts-tooltip-title {
        background: #0f172a !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        font-family: inherit !important;
        font-weight: 600 !important;
    }
    .apexcharts-text tspan {
        font-family: 'Inter', sans-serif !important;
    }
</style>
@endpush

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-white sm:text-4xl">
            Dashboard Statistik <span class="text-primary-500">SIRENA</span>
        </h1>
        <p class="mt-3 text-lg text-surface-400 max-w-2xl mx-auto">
            Informasi agregat sebaran pasien, penggunaan narkotika, dan demografi terkait upaya rehabilitasi BNN. Data ini disajikan untuk memberikan wawasan publik yang transparan dan informatif.
        </p>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Chart 1: Penggunaan Narkotika (Bar) --}}
        <div class="col-span-1 lg:col-span-2 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Penggunaan Narkotika
            </h3>
            <div id="chart-penggunaan" class="h-80"></div>
        </div>

        {{-- Chart 2: Usia Anak & Dewasa (Pie) --}}
        <div class="col-span-1 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4">Usia Anak dan Dewasa</h3>
            <div id="chart-usia" class="flex justify-center h-80"></div>
        </div>

        {{-- Chart 3: Motif Penggunaan (Bar) --}}
        <div class="col-span-1 lg:col-span-2 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4">Motif Penggunaan Narkotika</h3>
            <div id="chart-motif" class="h-80"></div>
        </div>

        {{-- Chart 4: Pendidikan (Pie) --}}
        <div class="col-span-1 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4">Pendidikan Pasien</h3>
            <div id="chart-pendidikan" class="flex justify-center h-80"></div>
        </div>

        {{-- Row 3: 3 Pie Charts --}}
        <div class="col-span-1 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4">Jenis Kelamin</h3>
            <div id="chart-gender" class="flex justify-center h-64"></div>
        </div>

        <div class="col-span-1 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4">Sumber Pasien</h3>
            <div id="chart-sumber" class="flex justify-center h-64"></div>
        </div>

        <div class="col-span-1 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4">Sumber Biaya</h3>
            <div id="chart-biaya" class="flex justify-center h-64"></div>
        </div>

        {{-- Chart 5: Lama Penggunaan (Bar) --}}
        <div class="col-span-1 lg:col-span-3 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4">Lama Penggunaan Narkotika</h3>
            <div id="chart-lama" class="h-72"></div>
        </div>

        {{-- Chart 6: Pekerjaan (Bar Vertical/Horizontal) --}}
        <div class="col-span-1 lg:col-span-3 bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl">
            <h3 class="text-lg font-semibold text-white mb-4">Pekerjaan Pasien</h3>
            <div id="chart-pekerjaan" class="h-[500px]"></div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        const commonOptions = {
            chart: {
                foreColor: '#94a3b8', // text-slate-400
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            tooltip: {
                theme: 'dark'
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.1)',
                strokeDashArray: 4,
            }
        };

        const pieColors = ['#e11d48', '#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ec4899', '#0ea5e9'];
        const barColor = '#ef4444'; // red-500

        // 1. Penggunaan Narkotika (Bar)
        new ApexCharts(document.querySelector("#chart-penggunaan"), {
            ...commonOptions,
            series: [{ name: 'Jumlah Pasien', data: [5, 0, 0, 0, 0, 0, 44, 0, 3, 0, 1, 7, 0, 0] }],
            chart: { type: 'bar', height: 320, ...commonOptions.chart },
            plotOptions: { bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'top' } } },
            colors: [barColor],
            xaxis: {
                categories: ['Alkohol', 'Heroin', 'Metadon / Subutex', 'Opiat lain', 'Barbiturat', 'Sedatif', 'Amfetamin Type Stimulants', 'MDMA', 'Kanabis', 'Halusinogen', 'Solvent/Inhalasia', 'NPS', 'Kokain', 'Lainnya'],
            }
        }).render();

        // 2. Usia (Pie)
        new ApexCharts(document.querySelector("#chart-usia"), {
            ...commonOptions,
            series: [29, 45],
            labels: ['Anak (dibawah 19 tahun)', 'Dewasa'],
            chart: { type: 'pie', height: 320, ...commonOptions.chart },
            colors: ['#e11d48', '#4c1d95'], // red-600, violet-900
            legend: { position: 'bottom' }
        }).render();

        // 3. Motif (Bar)
        new ApexCharts(document.querySelector("#chart-motif"), {
            ...commonOptions,
            series: [{ name: 'Jumlah', data: [40, 33, 22, 14, 11, 1, 5, 2, 5, 4, 5, 0] }],
            chart: { type: 'bar', height: 320, ...commonOptions.chart },
            plotOptions: { bar: { horizontal: true, borderRadius: 4 } },
            colors: [barColor],
            xaxis: {
                categories: ['Ajakan/bujukan teman', 'Ingin mencoba/penasaran', 'Tinggal di lingkungan pengguna', 'Konflik keluarga', 'Bersenang-senang', 'Stress belajar/kerja', 'Penambah stamina', 'Keluarga penyalahguna', 'Perceraian/patah hati', 'Diberikan cuma-cuma', 'Bermain game', 'Berduka']
            }
        }).render();

        // 4. Pendidikan (Pie)
        new ApexCharts(document.querySelector("#chart-pendidikan"), {
            ...commonOptions,
            series: [2, 6, 27, 31, 0, 0, 0, 7, 1, 0],
            labels: ['Tidak Sekolah', 'Tamat SD', 'Tamat SLTP', 'Tamat SLTA', 'Lulusan D1', 'Lulusan D2', 'Lulusan D3', 'Lulusan S1', 'Lulusan S2', 'Lulusan S3'],
            chart: { type: 'pie', height: 320, ...commonOptions.chart },
            colors: pieColors,
            legend: { position: 'bottom' }
        }).render();

        // 5. Gender (Pie)
        new ApexCharts(document.querySelector("#chart-gender"), {
            ...commonOptions,
            series: [72, 2],
            labels: ['Laki-laki', 'Perempuan'],
            chart: { type: 'pie', height: 260, ...commonOptions.chart },
            colors: ['#e11d48', '#4c1d95'],
            legend: { position: 'bottom' }
        }).render();

        // 6. Sumber Pasien (Pie)
        new ApexCharts(document.querySelector("#chart-sumber"), {
            ...commonOptions,
            series: [73, 0, 0, 0, 0, 0, 1, 0, 0],
            labels: ['Sukarela', 'Proses Hukum', 'Vonis Hakim', 'Warga Binaan', 'Intervensi Masy.', 'Rujukan TAT', 'Rujukan', 'Penjangkauan', 'Razia'],
            chart: { type: 'pie', height: 260, ...commonOptions.chart },
            colors: pieColors,
            legend: { position: 'bottom' }
        }).render();

        // 7. Sumber Biaya (Pie)
        new ApexCharts(document.querySelector("#chart-biaya"), {
            ...commonOptions,
            series: [74, 0],
            labels: ['APBN', 'PNBP'],
            chart: { type: 'pie', height: 260, ...commonOptions.chart },
            colors: ['#e11d48', '#4c1d95'],
            legend: { position: 'bottom' }
        }).render();

        // 8. Lama Penggunaan (Bar)
        new ApexCharts(document.querySelector("#chart-lama"), {
            ...commonOptions,
            series: [{ name: 'Jumlah', data: [20, 15, 42, 16] }],
            chart: { type: 'bar', height: 280, ...commonOptions.chart },
            plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '50%' } },
            colors: [barColor],
            xaxis: { categories: ['0 - 6 bulan', '7 - 12 bulan', '12 - 60 bulan', 'Diatas 60 bulan'] }
        }).render();

        // 9. Pekerjaan (Bar)
        new ApexCharts(document.querySelector("#chart-pekerjaan"), {
            ...commonOptions,
            series: [{ name: 'Jumlah', data: [10, 1, 32, 0, 3, 1, 0, 0, 5, 0, 0, 0, 1, 0, 6, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1] }],
            chart: { type: 'bar', height: 500, ...commonOptions.chart },
            plotOptions: { bar: { horizontal: true, borderRadius: 2 } },
            colors: [barColor],
            xaxis: {
                categories: ['Belum/Tidak Bekerja', 'Mengurus Rumah Tangga', 'Pelajar/Mahasiswa', 'Pensiunan', 'PNS', 'TNI', 'Kepolisian RI', 'Perdagangan', 'Petani/Pekebun', 'Peternak', 'Nelayan/Perikanan', 'Industri', 'Konstruksi', 'Transportasi', 'Karyawan Swasta', 'Karyawan BUMN', 'Karyawan BUMD', 'Karyawan Honorer', 'Buruh Harian Lepas', 'Buruh Tani', 'Buruh Nelayan', 'Buruh Peternakan', 'PRT', 'Tukang Cukur', 'Tukang Listrik', 'Tukang Batu', 'Tukang Kayu', 'Tukang Sol', 'Tukang Las', 'Tukang Jahit', 'Penata Rambut', 'Penata Rias', 'Penata Busana', 'Mekanik', 'Wiraswasta', 'Anggota Lembaga', 'Artis', 'Atlit', 'Chef', 'Manajer', 'Tata Usaha', 'Operator', 'Pekerja Pengolahan', 'Teknisi', 'Asisten Ahli', 'Lainnya']
            },
            grid: {
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: false } }
            }
        }).render();
    });
</script>
@endsection
