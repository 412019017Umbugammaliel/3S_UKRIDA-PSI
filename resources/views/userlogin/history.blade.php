@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - Page History')

@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data History UKRIDA 3S</h3>
                        </div>
                        <div class="card-body">
                            @if($histories->count() > 0)
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Username</th>
                                            <th>Final Point</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($histories as $history)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $history->username }}</td>
                                                <td>{{ $history->final_point }}</td>
                                                <td class="align-middle">
                                                    <a href="#" class="btn btn-primary btn-details" 
                                                        data-toggle="modal" 
                                                        data-target="#detailsModal"
                                                        data-username="{{ $history->username }}" 
                                                        data-final-point="{{ $history->final_point }}">
                                                        Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center">Tidak ada riwayat untuk pengguna ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display detailed information here -->
                    <h3 class="text-center mb-4 font-weight-bold text-warning">Hasil Psikotes</h3>
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            Perbandingan Hasil Psikotes
                        </div>
                        <div class="card-body">
                            <canvas id="comparisonChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    @php
                        $datasets = [];
                        $labels = [];
                    @endphp

                    @php
                        // Periksa apakah $categoryPoints sudah didefinisikan dan tidak null
                        $categoryPointsDefined = isset($categoryPoints);
                    @endphp

                    @if($categoryPointsDefined)
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
                                    <div class="card mb-4">
                                        <div class="card-header bg-warning text-dark">
                                            {{ $category->name_category }}
                                        </div>
                                        <div class="card-body">
                                            @if(isset($categoryPoint))
                                                <p>Total Points: {{ $categoryPoint->total_points }}</p>
                                                <p>Classifications:</p>
                                                <ul>
                                                    @foreach ($classifications as $classification)
                                                        <li>{{ $classification->title }} - {{ $classification->description }}</li>
                                                    @endforeach
                                                </ul>
                                                @php
                                                    // Add dataset for each category
                                                    $datasets[] = $categoryPoint->total_points;
                                                    array_unshift($labels, $category->name_category);
                                                @endphp
                                            @else
                                                <p>{{ __('No data available yet') }}</p>
                                            @endif
                                        </div>                            
                                    </div>
                                </div>                            
                            </div>
                        @endforeach
                    @else
                        <p>{{ __('No category points available') }}</p>
                    @endif

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')
@endsection
