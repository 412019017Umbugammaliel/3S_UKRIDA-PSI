@extends('counselorlogin.layouts.app')

@section('title', 'UKRIDA 3S - Selamat datang')

@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with default features</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                @if($histories->count() > 0)
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>User</th>
                                                <th>Test Number</th>
                                                <th>Final Point</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($histories as $history)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $history['username'] }}</td>
                                                    <td>{{ $history['test_number'] }}</td>
                                                    <td>
                                                        @if (isset($history['categoryPoints']) && $history['categoryPoints']->isNotEmpty())
                                                            {{ $history['categoryPoints']->sum('final_point') }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        <button type="button" class="btn btn-primary btn-details" data-toggle="modal"
                                                            data-target="#detailsModal{{ $loop->iteration }}"
                                                            data-test-number="{{ $history['test_number'] }}"
                                                            data-final-point="{{ isset($history['categoryPoints']) && $history['categoryPoints']->isNotEmpty() ? $history['categoryPoints']->sum('final_point') : 0 }}">
                                                            Details
                                                        </button>
                                                    </td>
                                                </tr>
                                                 <!-- Details Modal -->
                                                <div class="modal fade" id="detailsModal{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $loop->iteration }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detailsModalLabel{{ $loop->iteration }}">Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Display detailed information here -->
                                                                @if($categoryPointsDefined)
                                                                    @php
                                                                        $testNumber = $history['test_number'];
                                                                        $categoryPoints = $history['categoryPoints'];
                                                                    @endphp
                                                                    <h3 class="text-center mb-4 font-weight-bold text-warning">Hasil Psikotes - Tes {{ $testNumber }}</h3>
                                                                    <div class="card">
                                                                        <div class="card-header bg-warning text-dark">
                                                                            Perbandingan Hasil Psikotes
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <canvas id="comparisonChart-{{ $testNumber }}" width="400" height="200"></canvas>
                                                                        </div>
                                                                    </div>

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
                                                                                <div class="card-body">
                                                                                    @if(isset($categoryPoint))
                                                                                        <p>Total Points: {{ $categoryPoint->final_point }}</p>
                                                                                        <p>Classifications:</p>
                                                                                        <ul>
                                                                                            @foreach ($classifications as $classification)
                                                                                                <li>{{ $classification->title }} - {{ $classification->description }}</li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                        @php
                                                                                            // Add dataset for each category
                                                                                            $datasets[] = $categoryPoint->final_point;
                                                                                            array_unshift($labels, $category->name_category);
                                                                                        @endphp
                                                                                    @else
                                                                                        <p class="text-danger">{{ __('No data available for this category in test number ' . $testNumber) }}</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach

                                                                    <script>
                                                                        document.addEventListener("DOMContentLoaded", function () {
                                                                            var ctxComparison{{ $testNumber }} = document.getElementById('comparisonChart-{{ $testNumber }}').getContext('2d');
                                                                            var backgroundColors{{ $testNumber }} = ['rgba(201, 88, 169, 0.8)', 'rgba(255, 0, 0, 0.8)', 'rgba(28, 209, 208, 0.8)', 'rgba(255, 255, 0, 0.8)', 'rgba(27, 217, 178, 0.8)', 'rgba(165, 194, 216, 0.8)'];

                                                                            // Destroy existing chart before creating a new one
                                                                            var existingChart{{ $testNumber }} = Chart.getChart(ctxComparison{{ $testNumber }});
                                                                            if (existingChart{{ $testNumber }}) {
                                                                                existingChart{{ $testNumber }}.destroy();
                                                                            }

                                                                            var comparisonChart{{ $testNumber }} = new Chart(ctxComparison{{ $testNumber }}, {
                                                                                type: 'bar',
                                                                                data: {
                                                                                    labels: @json($labels),
                                                                                    datasets: [{
                                                                                        backgroundColor: backgroundColors{{ $testNumber }},
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
                                                                        });
                                                                    </script>
                                                                @else
                                                                    <p class="text-danger">{{ __('No category points available') }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="printModal('{{ $loop->iteration }}')">Print Results Tes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    function printModal(iteration) {
                                                        var printWindow = window.open('', '_blank');
                                                        var printContents = document.getElementById('detailsModal' + iteration).innerHTML;
                                                        var originalContents = document.body.innerHTML;

                                                        printWindow.document.write('<html><head><title>UKRIDA 3S</title>');
                                                        printWindow.document.write('<style> @media print { .modal-footer, .close { display: none; } }</style>');
                                                        printWindow.document.write('</head><body>');
                                                        printWindow.document.write(printContents);
                                                        printWindow.document.write('</body></html>');

                                                        printWindow.document.close();

                                                        printWindow.print();

                                                        // Ensure the original content is restored after printing
                                                        printWindow.onafterprint = function () {
                                                            printWindow.close();
                                                            document.body.innerHTML = originalContents;
                                                        };
                                                    }
                                                </script>
                                            @endforeach
                                        </tbody>
                                        
                                    </table>
                                @else
                                    <p class="text-center">Riwayat Tidak Ditemukan</p>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- JavaScript Function -->
<script>
    $(document).ready(function () {
        var table = $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print All',
                    className: 'text-red',
                    customize: function (win) {
                        // untuk kasih hilang kolom terakhir
                        $(win.document.body).find('table th:last-child, table td:last-child').remove();
                        
                        $(win.document.body)
                            .css('font-size', '10pt')
                            .prepend('<h3>Data Only</h3>');
                        
                        $(win.document.body).find('table')
                            .removeClass('dataTable')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });
    });
</script>

@endsection
