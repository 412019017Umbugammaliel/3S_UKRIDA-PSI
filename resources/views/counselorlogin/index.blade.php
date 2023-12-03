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
                                                <th>Final Point</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($histories as $history)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $history->username }}</td>
                                                    <td>{{ $history->final_point }}</td>
                                                    <td class="align-middle">
                                                        <button type="button" class="btn btn-primary" onclick="showhistoryDetails('{{ $history->id }}', '{{ $history->username }}', '{{ $history->final_point }}')">Details</button>
                                                    </td>
                                                </tr>
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
                    }
                ]
            });
        });

        function showhistoryDetails(id, username, final_point) {
            // Use SweetAlert to display history details
            Swal.fire({
                title: 'History Details',
                html: `<strong>ID:</strong> ${id}<br><strong>Username:</strong> ${username}<br><strong>Final Point:</strong> ${final_point}`,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
@endsection
