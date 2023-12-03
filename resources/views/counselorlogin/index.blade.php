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
                                @if(isset($histories) && $histories->count() > 0)
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Number</th>
                                                {{-- <th>Category</th> --}}
                                                <th>User</th>
                                                <th>Final Point</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $historyNumber = 1;
                                            @endphp
                                            @foreach ($histories as $history)
                                            <tr>
                                                <td>{{ $historyNumber++ }}</td>
                                                {{-- <td>{{ $history->name_category }}</td> --}}
                                                <td>{{ $history->username }}</td>
                                                <td>{{ $history->final_point }}</td>
                                                    
                                                <td class="align-middle">
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <div class="btn-group" role="group">
                                                            <button id="contentActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Actions
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="contentActions">
                                                                <a class="dropdown-item" href="#" onclick="showhistoryDetails('{{ $history->id }}', '{{ $history->username }}', '{{ $history->final_point }}')">Details</a>
                                                                {{-- <a class="dropdown-item" href="#" onclick="Edithistory('{{ $history->id }}', '{{ $history->id_category }}', '{{ $history->id_user }}', '{{ $history->final_point }}')">Edit</a> --}}
                                                                <a class="dropdown-item" href="#" onclick="confirmDelete('{{ $history->id }}')">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
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
                        text: 'Print',
                        className: 'text-red',
                    }
                ]
            });

            window.printTable = function () {
                table.buttons().print();
            };
        });

    </script>
@endsection
