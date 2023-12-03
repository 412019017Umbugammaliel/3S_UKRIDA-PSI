@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - Hasil Psikotes')

@section('contents')
    <section class="content">
        <div class="card card-solid">
            <div class="card-body">
                <h3 class="text-center mb-4 font-weight-bold text-warning">Hasil Psikotes</h3>

                @php
                    $datasets = [];
                    $labels = [];
                @endphp

                @foreach ($categories as $category)
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            {{ $category->name_category }}
                        </div>
                        <div class="card-body">
                            @php
                                $categoryPoint = $categoryPoints->where('id_category', $category->id_category)->first();
                                $classifications = $category->classifications;
                            @endphp

                            @if ($categoryPoint)
                                <p>Total Points: {{ $categoryPoint->total_points }}</p>
                                <p>Classifications:</p>
                                <ul>
                                    @foreach ($classifications as $classification)
                                        <li>{{ $classification->title }} - {{ $classification->description }}</li>
                                    @endforeach
                                </ul>

                                @php
                                    // Tambahkan dataset untuk setiap kategori
                                    $datasets[] = $categoryPoint->total_points;
                                    array_unshift($labels, $category->name_category);
                                @endphp
                            @else
                                <p>{{ __('No data available yet') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Tambahkan bagian untuk menampilkan grafik perbandingan -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        Perbandingan Hasil Psikotes
                    </div>
                    <div class="card-body">
                        <canvas id="comparisonChart" width="400" height="200"></canvas>
                        <script>
                            var ctxComparison = document.getElementById('comparisonChart').getContext('2d');
                            var backgroundColors = ['rgba(201, 88, 169, 0.8)', 'rgba(255, 0, 0, 0.8)', 'rgba(28, 209, 208, 0.8)', 'rgba(255, 255, 0, 0.8)', 'rgba(27, 217, 178, 0.8)', 'rgba(165, 194, 216, 0.8)'];
                        
                            var comparisonChart = new Chart(ctxComparison, {
                                type: 'bar',
                                data: {
                                    labels: @json($labels),
                                    datasets: [{
                                        backgroundColor: backgroundColors,
                                        data: @json($datasets)
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: {
                                            stacked: true
                                        },
                                        y: {
                                            stacked: true,
                                            beginAtZero: true
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            position: 'top'
                                        }
                                    },
                                    animation: {
                                        duration: 1500,
                                        easing: 'easeInOutQuart'
                                    },
                                    shadowOffsetX: 2,
                                    shadowOffsetY: 2,
                                    shadowBlur: 5,
                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                }
                            });
                        </script>
                        
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('userlogin') }}" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </section>
@endsection
