@extends('layouts.dashboard')

@section('header_title', 'Dashboard Statistik')

@section('content')
    <div class="space-y-6">

        <!-- Filter Header -->
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm border border-gray-100">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Ringkasan Aktivitas</h2>
                <p class="text-sm text-gray-500">Pantau pergerakan pengunjung dan interaksi modul</p>
            </div>
            <div>
                <select onchange="window.location.href='?period=' + this.value"
                    class="rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] text-sm cursor-pointer">
                    <option value="7_days" {{ request('period') == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </div>
        </div>

        <!-- Card Angka Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Pengunjung Hari Ini -->
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-[#800000] p-6">
                <div class="text-sm font-medium text-gray-500 truncate">Pengunjung Hari Ini</div>
                <div class="mt-2 flex items-baseline">
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($summary['visitors_today']) }}</div>
                    <div class="ml-2 text-sm text-green-600 font-medium">Orang</div>
                </div>
            </div>

            <!-- Total Pengunjung Bulan Ini -->
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-gray-700 p-6">
                <div class="text-sm font-medium text-gray-500 truncate">Pengunjung Bulan Ini</div>
                <div class="mt-2 flex items-baseline">
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($summary['visitors_month']) }}</div>
                    <div class="ml-2 text-sm text-gray-500 font-medium">Orang</div>
                </div>
            </div>

            <!-- Modul Dilihat -->
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-600 p-6">
                <div class="text-sm font-medium text-gray-500 truncate">Modul Dilihat (Hari Ini)</div>
                <div class="mt-2 flex items-baseline">
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($summary['views_today']) }}</div>
                    <div class="ml-2 text-sm text-blue-600 font-medium">Kali</div>
                </div>
            </div>

            <!-- Modul Diunduh -->
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-green-600 p-6">
                <div class="text-sm font-medium text-gray-500 truncate">Modul Diunduh (Hari Ini)</div>
                <div class="mt-2 flex items-baseline">
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($summary['downloads_today']) }}
                    </div>
                    <div class="ml-2 text-sm text-green-600 font-medium">File</div>
                </div>
            </div>
        </div>

        <!-- Area Grafik -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Lalu Lintas & Interaksi Modul</h3>
            <div class="relative h-96 w-full">
                <!-- Canvas untuk Chart.js -->
                <canvas id="statistikChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Panggil Chart.js lewat CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Inisialisasi Grafik -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('statistikChart').getContext('2d');

            // Ambil data dari PHP Controller
            const labels = @json($chartData['labels']);
            const dataVisitors = @json($chartData['visitors']);
            const dataViews = @json($chartData['views']);
            const dataDownloads = @json($chartData['downloads']);

            new Chart(ctx, {
                type: 'line', // Grafik garis kombinasi dengan bar
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pengunjung (Orang)',
                            data: dataVisitors,
                            borderColor: '#800000', // Merah Marun
                            backgroundColor: 'rgba(128, 0, 0, 0.1)',
                            borderWidth: 2,
                            tension: 0.4, // Membuat garis melengkung (smooth)
                            fill: true,
                            type: 'line'
                        },
                        {
                            label: 'Modul Dilihat (Kali)',
                            data: dataViews,
                            backgroundColor: '#2563eb', // Biru
                            borderRadius: 4,
                            type: 'bar' // Dibuat bentuk batang agar beda dengan pengunjung
                        },
                        {
                            label: 'Modul Diunduh (File)',
                            data: dataDownloads,
                            backgroundColor: '#16a34a', // Hijau
                            borderRadius: 4,
                            type: 'bar'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y;
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
