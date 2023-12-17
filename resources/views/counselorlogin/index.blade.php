@extends('counselorlogin.layouts.app')

@section('title', 'UKRIDA 3S - Selamat datang')

@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data History User</h3>
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
                                                        <a href="{{ route('counselorlogin.details', $history['id']) }}" class="btn btn-primary">Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        
                                    </table>
                                @else
                                    <p class="text-center">No History Found</p>
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
