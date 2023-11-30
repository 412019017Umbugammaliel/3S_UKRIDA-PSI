@extends('layouts.app')

@section('title', 'UKRIDA 3S - Page classification')
    
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title">Data Classification UKRIDA 3S</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahclassificationModal">Tambah Klasifikasi</button>
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
                            @endif
                        </div>
                    </div>                
                   <!--.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(isset($classifications) && $classifications->count() > 0)
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Category</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $classificationNumber = 1;
                                        @endphp
                                        @foreach ($classifications as $classification)
                                        <tr>
                                            <td>{{ $classificationNumber++ }}</td>
                                            <td>{{ $classification->name_category }}</td>
                                            <td>{{ $classification->title }}</td>
                                            <td>{{ $classification->description }}</td>

                                            <td class="align-middle">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <div class="btn-group" role="group">
                                                        <button id="contentActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="contentActions">
                                                            <a class="dropdown-item" href="#" onclick="showClassificationDetails('{{ $classification->id }}','{{ $classification->name_category }}', '{{ $classification->title }}', '{{ $classification->description }}')">Details</a>
                                                            <a class="dropdown-item" href="#" onclick="editClassification('{{ $classification->id }}', '{{ $classification->id_category }}', '{{ $classification->title }}', '{{ $classification->description }}')">Edit</a>
                                                            <a class="dropdown-item" href="#" onclick="confirmDelete('{{ $classification->id }}')">Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="text-center">Klasifikasi Tidak Ditemukan</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahclassificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pageclassification.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id_category">Pilih Kategori:</label>
                            <select name="id_category" id="id_category" class="form-control" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id_category }}">{{ $category->name_category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="Description" class="form-control" required></textarea>
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
    {{-- @foreach ($classifications as $classification) --}}
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Classification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <form id="editForm" action="{{ route('pageclassification.update', ['id' => $classification->id]) }}" method="post"> --}}
                    <form id="editForm" action="{{ route('pageclassification.update', ['id' => 0]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="editCategory">Category</label>
                            <select class="form-control" id="editCategory" name="id_category" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id_category }}">{{ $category->name_category }}</option>
                                @endforeach
                            </select>                        
                        </div>                        
                        <div class="form-group">
                            <label for="editTitle">Title</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @endforeach --}}
</section>

<script>

     //details
     function showClassificationDetails(id, name_category, title, description) {
        // Gunakan SweetAlert untuk menampilkan detail pertanyaan
        Swal.fire({
            title: 'Classification Details',
            html: `<strong>ID:</strong> ${id}<br><strong>Category:</strong> ${name_category}<br><strong>Title:</strong> ${title}<br><strong>Description:</strong> ${description}`,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    }

    //edit
    function editClassification(id, id_category, title, description) {
        var editForm = document.getElementById('editForm');
        editForm.action = '/pageclassification/update/' + id;

        document.getElementById('editCategory').value = id_category;
        document.getElementById('editTitle').value = title;
        document.getElementById('editDescription').value = description;

        // Open edit modal
        $('#editModal').modal('show');
    }


    //delete
    function confirmDelete(classificationId) {
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
                // Lakukan tindakan penghapusan di sini, seperti mengarahkan ke rute penghapusan
                window.location.href = '/pageclassification/delete/' + classificationId;
            }
        });
    }

</script>
@include('sweetalert::alert')
@endsection