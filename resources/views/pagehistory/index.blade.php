@extends('layouts.app')

@section('title', 'UKRIDA 3S - Page History')
    
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title">Data History UKRIDA 3S</h3>
                            </div>
                            {{-- <div class="col-4 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahHistoryModal">Tambah Riwayat</button>
                            </div>
                            @if (session()->has('success'))
                                <script>
                                    Swal.fire({
                                        title: 'Success',
                                        text: "{{ session('success') }}",
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                </script>
                            @endif --}}
                        </div>
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
    {{-- <div class="modal fade" id="tambahHistoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Riwayat Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pagehistory.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id_category">Pilih Kategori:</label>
                            <select name="id_category" id="id_category" class="form-control" required>
                                <option value="" disabled selected>Select Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id_category }}">{{ $category->name_category }}</option>
                                @endforeach
                            </select>
                            @error('id_category')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_user">Pilih User:</label>
                            <select name="id_user" id="id_user" class="form-control" required>
                                <option value="" disabled selected>Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="final_point">Final Point:</label>
                            <input type="text" name="final_point" id="final_point" class="form-control" required>
                            @error('final_point')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit history Modal -->
    <div class="modal fade" id="edithistoryModal" tabindex="-1" role="dialog" aria-labelledby="edithistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edithistoryModalLabel">Edit history</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form for editing histories goes here -->
                    <form id="edithistoryForm" action="{{ route('pagehistory.update', ['id' => 0]) }}" method="post">
                        @csrf
                        @method('put')
                        <!-- Add your form fields here (id_category, id_user, final_point) -->
                        <div class="form-group">
                            <label for="edithistoryCategory">Category</label>
                            <select class="form-control" id="edithistoryCategory" name="id_category" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id_category }}">{{ $category->name_category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edithistoryUser">User</label>
                            <select class="form-control" id="edithistoryUser" name="id_user" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edithistoryFinalPoint">final_point</label>
                            <input type="text" class="form-control" id="edithistoryFinalPoint" name="final_point" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}


</section>
<script>
    //details
    function showhistoryDetails(id, username, final_point) {
        // Use SweetAlert to display history details
        Swal.fire({
            title: 'history Details',
            html: `<strong>ID:</strong> ${id}<br><strong>Username:</strong> ${username}<br><strong>Final Point:</strong> ${final_point}`,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    }

    // // edit
    // function Edithistory(id, id_category, id_user, final_point) {
    //     // Set the form action dynamically based on the history ID
    //     var edithistoryForm = document.getElementById('edithistoryForm');
    //     edithistoryForm.action = '/pagehistory/update/' + id;

    //     // Populate the form fields with existing history details
    //     document.getElementById('edithistoryCategory').value = id_category;
    //     document.getElementById('edithistoryUser').value = id_user;
    //     document.getElementById('edithistoryFinalPoint').value = final_point;

    //     // Open the edit modal
    //     $('#edithistoryModal').modal('show');
    // }

    
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
                window.location.href = '/pagehistory/delete/' + historyId;
            }
        });
    }


</script>

@include('sweetalert::alert')
@endsection