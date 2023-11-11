@extends('layouts.app')

@section('title', 'UKRIDA 3S - Page Category')
    
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title">Data Category UKRIDA 3S</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahCategoryModal">Tambah Category</button>
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
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($category->count() > 0)
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $categoryNumber = 1;
                                    @endphp
                                    @foreach ($category as $categories)
                                    <tr>
                                        <td>{{ $categoryNumber++ }}</td>
                                        <td>{{ $categories->name_category }}</td>
                                        <td>
                                            <img src="{{ asset('images/' . $categories->image_category) }}" alt="Image" style="max-width: 100px; max-height: 100px;">
                                        </td>     
                                        <td class="align-middle">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <div class="btn-group" role="group">
                                                    <button id="contentActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="contentActions">
                                                        <a class="dropdown-item" href="#" onclick="showCategoryDetails('{{ $categories->name_category }}', '{{ asset('images/' . $categories->image_category) }}')">Details</a>
                                                        <a class="dropdown-item" href="#" onclick="showEditForm('{{ $categories->id_category }}', '{{ $categories->name_category }}', '{{ $categories->image_category }}')">Edit</a>
                                                        <a class="dropdown-item" href="#" onclick="confirmDelete('{{ $categories->id_category }}')">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-center">Kategori Tidak Ditemukan</p>
                            @endif
                        </div>
                    </div>                    
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <form action="{{ route('pagecategory.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name_category">Name Category:</label>
                            <textarea name="name_category" id="name_category" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image_category">Image:</label>
                            <input type="file" name="image_category" id="image_category" class="form-control" accept="image/*" required>
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

</section>
<script>
    //details
    function showCategoryDetails(name_category, imageUrl) {
        Swal.fire({
            title: 'Category Details',
            html: `
                <div class="swal-content-details">
                    <div class="swal-details-row">
                        <span class="swal-details-label">Name:</span>
                        <p>${name_category}</p>
                    </div>
                    <div class="swal-details-row">
                        <span class="swal-details-label">Image Category:</span>
                    </div>
                    <div class="swal-details-row">
                        <img src="${imageUrl}" alt="Category Image" style="max-width: 100px; max-height: 100px;">
                    </div>
                </div>
            `,
            confirmButtonText: 'Close'
        });
    }

    function showEditForm(id_category, name_category, image_category) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    Swal.fire({
        title: 'Edit category',
        html: `
            <form id="editCategoryForm" action="/pagecategory/updatecategory/${id_category}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name_category">Name:</label>
                    <textarea class="form-control" id="name_category" name="name_category" rows="4" required>${name_category}</textarea>
                </div>

                <div class="form-group">
                    <label for="image_category">Image</label>
                    <input type="file" class="form-control" id="image_category" name="image_category">
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        focusConfirm: false,
        preConfirm: () => {
            const form = document.getElementById('editCategoryForm');
            const formData = new FormData(form);
            $.ajax({
                type: 'POST',
                url: form.getAttribute('action'),
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', response.message, 'success').then(function () {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'Failed to update category', 'error');
                    }
                },
                error: function (error) {
                    console.error(error);
                    Swal.fire('Error', 'An error occurred while updating category', 'error');
                }
            });
        }
    });
}


    //delete
    function confirmDelete(id_category) {
        console.log('Memulai konfirmasi penghapusan dengan ID:', id_category);
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
                // Menggunakan Ajax untuk menghapus data
                $.ajax({
                    url: '/pagecategory/' + id_category,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Sukses', response.message, 'success').then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message || 'Gagal Menghapus data pengguna', 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire('Error', 'Terjadi kesalahan: ' + error, 'error');
                    }
                });
            }
        });
    }

</script>
@include('sweetalert::alert')
@endsection