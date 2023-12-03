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
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $history->id }}')">Hapus</button>
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
<script>
    //delete
    function confirmDelete(historyId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/history/delete/' + historyId;
            }
        });
    }
</script>
@include('sweetalert::alert')
@endsection
