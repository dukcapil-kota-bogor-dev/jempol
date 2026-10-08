<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <div class="mb-2 bg-gradient-to-r from-indigo-600 to-blue-500 rounded-3xl p-8 shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-white text-2xl md:text-3xl font-extrabold mb-2">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-indigo-100 text-sm md:text-base opacity-90 max-w-xl">
                        Berikut adalah ringkasan data pemohon dan statistik terkini untuk hari ini.
                    </p>
                </div>
                <div class="absolute -right-10 -top-10 h-40 w-40 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute right-20 -bottom-10 h-32 w-32 bg-indigo-400/20 rounded-full blur-2xl"></div>
            </div>

            {{-- ================= SECTION 1: PEMOHON ================= --}}
            <div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-4">Data Pemohon</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-users animate-pulse"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Pemohon</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">{{ $pemohons->count() }}</h3>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-hourglass-half animate-[spin_5s_linear_infinite]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pending</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">{{ $pemohons->where('status_progress', 'proses')->count() }}</h3>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-check-double animate-pulse"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Selesai</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">{{ $pemohons->where('status_progress', 'selesai')->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg shadow-sm">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-800">Distribusi Kategori</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">Berdasarkan Kondisi Pemohon</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                        <div class="lg:col-span-8 relative" style="height: 150px;">
                            <canvas id="categoryChartPemohon"></canvas>
                        </div>

                        <div class="lg:col-span-4 grid grid-cols-2 lg:grid-cols-1 gap-1.5">
                            @php
                                $colorsPemohon = [
                                    'Lansia' => 'bg-blue-500',
                                    'Sakit' => 'bg-red-500',
                                    'ODGJ' => 'bg-amber-500',
                                    'Disabilitas' => 'bg-emerald-500',
                                    'Lainnya' => 'bg-slate-400',
                                ];
                            @endphp

                            @foreach($chartData as $label => $count)
                            <div class="flex items-center justify-between p-1.5 px-3 rounded-lg bg-gray-50 border border-gray-100 hover:bg-indigo-50 transition-all group">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $colorsPemohon[$label] ?? 'bg-gray-400' }}"></span>
                                    <span class="text-[11px] font-bold text-gray-600 group-hover:text-indigo-600">{{ $label }}</span>
                                </div>
                                <span class="text-sm font-black text-gray-800">{{ $count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            {{-- ================= SECTION 2: GOES TO SCHOOL ================= --}}
            <div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-4">Data Goes to School</h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

                    {{-- Jumlah Goes to School --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-users animate-pulse"></i>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Jumlah Goes to School</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">{{ $goestoschool->count() }}</h3>
                        </div>
                    </div>


                    {{-- Pending --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-hourglass-half animate-[spin_5s_linear_infinite]"></i>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pending</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">
                                {{ $goestoschool->where('status_progress', 'proses')->count() }}
                            </h3>
                        </div>
                    </div>


                    {{-- Selesai --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-check-double animate-pulse"></i>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Selesai</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">
                                {{ $goestoschool->where('status_progress', 'selesai')->count() }}
                            </h3>
                        </div>
                    </div>


                    {{-- Aktivasi IKD --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-id-card animate-pulse"></i>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Aktivasi IKD</p>

                            {{-- DIUBAH DARI status_ikd MENJADI aktivasi_ikd --}}
                            <h3 class="text-3xl font-extrabold text-gray-800">
                                {{ $goestoschool->sum('aktivasi_ikd') }}
                            </h3>
                        </div>
                    </div>
                </div>


                {{-- Diagram Goes to School --}}
                @php
                    $chartDataGoesToSchool = $chartDataGoesToSchool ?? [];

                    // Aktivasi IKD dihitung dari kolom aktivasi_ikd
                    $chartDataGoesToSchool['Aktivasi IKD'] = $goestoschool->sum('aktivasi_ikd');
                @endphp

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg shadow-sm">
                            <i class="fas fa-chart-bar"></i>
                        </div>

                        <div>
                            <h3 class="text-lg font-extrabold text-gray-800">Distribusi Kategori</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">
                                Berdasarkan Hasil Goes to School
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                        <div class="lg:col-span-8 relative" style="height: 150px;">
                            <canvas id="categoryChartGts"></canvas>
                        </div>

                        <div class="lg:col-span-4 grid grid-cols-2 lg:grid-cols-1 gap-1.5">

                            @php
                                $colorsGts = [
                                    'Terekam' => 'bg-blue-500',
                                    'Terekam Gagal' => 'bg-red-500',
                                    'Kurang Dari 16 Tahun' => 'bg-amber-500',
                                    'Sudah Punya' => 'bg-emerald-500',
                                    'Tidak Hadir' => 'bg-slate-400',
                                    'Aktivasi IKD' => 'bg-purple-500',
                                ];
                            @endphp

                            @foreach($chartDataGoesToSchool as $label => $count)
                                <div class="flex items-center justify-between p-1.5 px-3 rounded-lg bg-gray-50 border border-gray-100 hover:bg-indigo-50 transition-all group">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $colorsGts[$label] ?? 'bg-gray-400' }}"></span>
                                        <span class="text-[11px] font-bold text-gray-600 group-hover:text-indigo-600">
                                            {{ $label }}
                                        </span>
                                    </div>

                                    <span class="text-sm font-black text-gray-800">
                                        {{ $count }}
                                    </span>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>


            {{-- ================= SECTION 3: LSM ================= --}}
            <div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-4">Data LSM</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-users animate-pulse"></i>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total LSM</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">{{ $lsm->count() }}</h3>
                        </div>
                    </div>


                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-hourglass-half animate-[spin_5s_linear_infinite]"></i>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pending</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">
                                {{ $lsm->where('status', 'pending')->count() }}
                            </h3>
                        </div>
                    </div>


                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 transition-transform hover:scale-105 duration-300">
                        <div class="h-14 w-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                            <i class="fas fa-check-double animate-pulse"></i>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Selesai</p>
                            <h3 class="text-3xl font-extrabold text-gray-800">
                                {{ $lsm->where('status', 'selesai')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>


                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg shadow-sm">
                            <i class="fas fa-chart-bar"></i>
                        </div>

                        <div>
                            <h3 class="text-lg font-extrabold text-gray-800">Distribusi Kategori</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">
                                Berdasarkan Kondisi LSM
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">

                        <div class="lg:col-span-8 relative" style="height: 150px;">
                            <canvas id="categoryChartLsm"></canvas>
                        </div>

                        <div class="lg:col-span-4 grid grid-cols-2 lg:grid-cols-1 gap-1.5">

                            @php
                                $colorsLsm = [
                                    'Terekam' => 'bg-blue-500',
                                    'Gagal Terekam' => 'bg-red-500',
                                    'Sudah Memiliki KTP' => 'bg-amber-500',
                                    'Tidak Hadir' => 'bg-emerald-500',
                                ];
                            @endphp

                            @foreach($chartDataLSM as $label => $count)
                                <div class="flex items-center justify-between p-1.5 px-3 rounded-lg bg-gray-50 border border-gray-100 hover:bg-indigo-50 transition-all group">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $colorsLsm[$label] ?? 'bg-gray-400' }}"></span>
                                        <span class="text-[11px] font-bold text-gray-600 group-hover:text-indigo-600">
                                            {{ $label }}
                                        </span>
                                    </div>

                                    <span class="text-sm font-black text-gray-800">
                                        {{ $count }}
                                    </span>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function buildBarChart(canvasId, data) {
                const canvas = document.getElementById(canvasId);

                if (!canvas) {
                    return;
                }

                const ctx = canvas.getContext('2d');

                new Chart(ctx, {
                    type: 'bar',

                    data: {
                        labels: Object.keys(data),

                        datasets: [{
                            label: 'Jiwa',
                            data: Object.values(data),

                            backgroundColor: [
                                '#3b82f6',
                                '#ef4444',
                                '#f59e0b',
                                '#10b981',
                                '#94a3b8',
                                '#a855f7'
                            ],

                            borderRadius: 6,
                            barThickness: 30
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: false
                            },

                            tooltip: {
                                padding: 8,
                                bodyFont: {
                                    size: 11
                                }
                            }
                        },

                        scales: {
                            y: {
                                beginAtZero: true,

                                grid: {
                                    color: '#f8fafc',
                                    drawBorder: false
                                },

                                ticks: {
                                    stepSize: 1,
                                    color: '#cbd5e1',

                                    font: {
                                        size: 10,
                                        weight: '600'
                                    }
                                }
                            },

                            x: {
                                grid: {
                                    display: false
                                },

                                ticks: {
                                    color: '#64748b',

                                    font: {
                                        size: 9,
                                        weight: 'bold'
                                    },

                                    maxRotation: 0,
                                    minRotation: 0,
                                    autoSkip: false,
                                    align: 'center'
                                }
                            }
                        }
                    }
                });
            }


            buildBarChart(
                'categoryChartPemohon',
                {!! json_encode($chartData) !!}
            );


            buildBarChart(
                'categoryChartGts',
                {!! json_encode($chartDataGoesToSchool) !!}
            );


            buildBarChart(
                'categoryChartLsm',
                {!! json_encode($chartDataLSM) !!}
            );

        });
    </script>

</x-app-layout>