@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - Detail History')

@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail History</h3>
                        </div>
                        <div class="card-body">
                            <p>Total Points: {{ $categoryPoints->sum('final_point') }}</p>

                            <!-- Tampilkan grafik perbandingan (jika diperlukan) -->
                            <div class="card">
                                <div class="card-header bg-warning text-dark">
                                    Perbandingan Hasil Psikotes
                                </div>
                                <div class="card-body">
                                    <canvas id="comparisonChart" width="400" height="200"></canvas>
                                </div>
                            </div>

                            <!-- Loop untuk menampilkan rincian kategori -->
                            @foreach($categoryPoints as $categoryPoint)
                                <div class="card mb-4">
                                    <div class="card-header bg-warning text-dark">
                                        {{ $categoryPoint->category->name_category }}
                                    </div>
                                    <div class="card-body">
                                        <p>Total Points: {{ $categoryPoint->final_point }}</p>
                                        <p>Classifications:</p>
                                        <ul>
                                            @foreach ($categoryPoint->category->classifications as $classification)
                                                <li>{{ $classification->title }} - {{ $classification->description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


   <script>
    var ctxComparison = document.getElementById('comparisonChart').getContext('2d');
    var backgroundColors = ['rgba(201, 88, 169, 0.8)', 'rgba(255, 0, 0, 0.8)', 'rgba(28, 209, 208, 0.8)', 'rgba(255, 255, 0, 0.8)', 'rgba(27, 217, 178, 0.8)', 'rgba(165, 194, 216, 0.8)'];

    var comparisonChart = new Chart(ctxComparison, {
        type: 'bar',
        data: {
            labels: @json($categoryPoints->pluck('category.name_category')),
            datasets: [{
                backgroundColor: backgroundColors,
                data: @json($categoryPoints->pluck('final_point'))
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
                    display: false
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
@endsection