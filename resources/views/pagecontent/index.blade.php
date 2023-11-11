@extends('layouts.app')

@section('title', 'UKRIDA 3S - Page Content')
    
@section('contents')
<style>
    .swal2-textarea {
        height: 100px; /* Atur tinggi awal textarea, Anda dapat mengganti nilai ini */
        resize: vertical; /* Memungkinkan pengguna untuk memperbesar secara vertikal */
        overflow: auto; /* Menambahkan bilah geser jika teks melebihi area textarea */
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title">Page Content UKRIDA 3S</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahContentModal">Tambah Content</button>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($content->count() > 0)
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $contentNumber = 1;
                                    @endphp
                                    @foreach ($content as $contents)
                                    <tr>
                                        <td>{{ $contentNumber++ }}</td>
                                        <td>{{ $contents->title }}</td>
                                        <td>{{ $contents->description }}</td>
                                        <td>
                                            <img src="{{ asset('images/' . $contents->image) }}" alt="Image" style="max-width: 100px; max-height: 100px;">
                                        </td>                                    
                                        <td class="align-middle">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <div class="btn-group" role="group">
                                                    <button id="contentActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="contentActions">
                                                        <a class="dropdown-item" href="#" onclick="showContentDetails('{{ $contents->title }}', '{{ $contents->description }}', '{{ asset('images/' . $contents->image) }}')">Details</a>
                                                        <a class="dropdown-item" href="#" onclick="showEditForm('{{ $contents->id }}', '{{ $contents->title }}', '{{ $contents->description }}', '{{ $contents->image }}')">Edit</a>
                                                        <a class="dropdown-item" href="#" onclick="confirmDelete('{{ $contents->id }}')">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-center">Tidak Ada Content Ditemukan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahContentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Content</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pagecontent.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div>                        
                
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                        </div>
                                                             
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
    function showContentDetails(title, description, imageUrl) {
        Swal.fire({
            title: title, // Gunakan judul konten
            html: `
                <div class="swal-content-details">
                    <div class="swal-details-row">
                        <span class="swal-details-label">Description:</span>
                        <p>${description}</p>
                    </div>
                    <div class="swal-details-row">
                        <span class="swal-details-label">Image:</span>
                    </div>
                    <div class="swal-details-row">
                        <img src="${imageUrl}" alt="Content Image" style="max-width: 100px; max-height: 100px;">
                    </div>
                </div>
            `,
            confirmButtonText: 'Close'
        });
    }

    // edit
    function showEditForm(contentId, title, description, image) {
        Swal.fire({
            title: 'Edit Content',
            html: `
                <div class="swal-input-container">
                    <label for="swal-input1">Title</label>
                    <input id="swal-input1" class="swal2-input" value="${title}">
                </div>
                <div class="swal-input-container">
                    <label for="swal-input2">Description</label>
                    <textarea id="swal-input2" class="swal2-textarea">${description}</textarea>
                </div>
                <div class="form-group">
                    <label for="swal-input3">Image</label>
                    <input id="swal-input3" class="form-control" type="file" accept="image/*">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const newTitle = document.getElementById('swal-input1').value;
                const newDescription = document.getElementById('swal-input2').value;
                const newImage = document.getElementById('swal-input3').files[0];
                
                // Dapatkan token CSRF
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Buat objek FormData untuk mengirim data termasuk file
                const formData = new FormData();
                formData.append('_token', token);
                formData.append('_method', 'PUT');
                formData.append('title', newTitle);
                formData.append('description', newDescription);

                if (newImage) {
                    formData.append('image', newImage);
                }

                // Kirim permintaan PUT menggunakan AJAX
                $.ajax({
                    type: 'POST', // Bisa juga menggunakan 'PUT'
                    url: `/pagecontent/updatecontent/${contentId}`, // Sesuaikan dengan URL Anda
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': token, // Atur CSRF token dalam header
                    },
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success').then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Failed to update content', 'error');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        Swal.fire('Error', 'An error occurred while updating content', 'error');
                    }
                });

                // Hentikan SweetAlert dari menutup
                return false;
            }
        });
    }



    //delete
    function confirmDelete(contentId) {
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
                    url: '/pagecontent/' + contentId,
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
                            Swal.fire('Error', 'Gagal Menghapus data Content', 'error');
                        }
                    },
                });
            }
        });
    }
</script>
@include('sweetalert::alert')
@endsection