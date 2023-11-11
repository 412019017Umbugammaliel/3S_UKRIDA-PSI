@extends('layouts.app')

@section('title', 'UKRIDA 3S - User Data')
    
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title">Data User Pengguna UKRIDA 3S</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahUserModal">Tambah User</button>
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
                            @if($user->count() > 0)
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Class</th>
                                        <th>School Name</th>
                                        <th>Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $userNumber = 1;
                                    @endphp
                                    @foreach ($user as $users)
                                    <tr>
                                        <td>{{ $userNumber++ }}</td>
                                        <td>{{ $users->name }}</td>
                                        <td>{{ $users->email }}</td>
                                        <td>{{ $users->class }}</td>
                                        <td>{{ $users->school_name }}</td>
                                        <td>{{ $users->level }}</td>
                                        <td class="align-middle">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <div class="btn-group" role="group">
                                                    <button id="userActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="userActions">
                                                        <a class="dropdown-item" href="#" onclick="showUserDetails({{ $users->id }},'{{ $users->name }}', '{{ $users->email }}', '{{ $users->level }}', '{{ $users->class }}', '{{ $users->school_name }}')">Details</a>
                                                        <a class="dropdown-item" href="#" onclick="showEditForm('{{ $users->id }}', '{{ $users->name }}', '{{ $users->email }}', '{{ $users->class }}', '{{ $users->school_name }}', '{{ $users->level }}')">Edit</a>
                                                        <a class="dropdown-item" href="#" onclick="confirmDelete('{{ $users->id }}')">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-center">User Tidak Ditemukan</p>
                            @endif
                        </div>
                    </div>                    
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <form action="{{ route('userdata.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="class">Class:</label>
                            <select name="class" class="form-control" name="class" id="class" required>
                            <option value="" disabled selected>--Please Choose an Option</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                            <option value="11">Grade 11</option>
                            <option value="12">Grade 12</option>
                        </select>
                        </div>     

                        <div class="form-group">
                            <label for="schoolname">School Name:</label>
                            <input type="text" name="school_name" id="school_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select name="level" id="level" class="form-control">
                                <option value="" disabled selected>Pilih Level</option>
                                <option value="Admin">Admin</option>
                                <option value="Counselor">Counselor</option>
                                <option value="User">User</option>
                            </select>
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
    function showUserDetails(userId, name, email, level, classValue, schoolName) {
    Swal.fire({
            title: 'User Details',
            html: `<p>ID: ${userId}</p><p>Name: ${name}</p><p>Email: ${email}</p><p>Level: ${level}</p><p>Class: ${classValue}</p><p>School Name: ${schoolName}</p>`,
            icon: 'info'
        });
    }

    // edit
    function showEditForm(userId, name, email, classValue, schoolName, level) {
        Swal.fire({
            title: 'Edit User',
            html: `
            <span>Name: <input id="swal-input1" class="swal2-input" value="${name}"></span>
        <span>Email: <input id="swal-input2" class="swal2-input" value="${email}"></span>
        <span>Level: 
            <select id="swal-input3" class="swal2-input">
                <option value="User" ${level === 'User' ? 'selected' : ''}>User</option>
                <option value="Admin" ${level === 'Admin' ? 'selected' : ''}>Admin</option>
                <option value="Counselor" ${level === 'Counselor' ? 'selected' : ''}>Counselor</option>
            </select>
        </span>
        <span>Grade: 
            <select id="swal-input4" class="swal2-input">
                <option value="9" ${classValue === '9' ? 'selected' : ''}>Grade 9</option>
                <option value="10" ${classValue === '10' ? 'selected' : ''}>Grade 10</option>
                <option value="11" ${classValue === '11' ? 'selected' : ''}>Grade 11</option>
                <option value="12" ${classValue === '12' ? 'selected' : ''}>Grade 12</option>
            </select>
        </span>
        <span>School Name: <input id="swal-input5" class="swal2-input" value="${schoolName}"></span>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const newName = document.getElementById('swal-input1').value;
                const newEmail = document.getElementById('swal-input2').value;
                const newLevel = document.getElementById('swal-input3').value;
                const newClass = document.getElementById('swal-input4').value;
                const newSchoolName = document.getElementById('swal-input5').value;

                // Mendapatkan token CSRF
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Kirim permintaan PUT menggunakan AJAX
                $.ajax({
                    type: 'PUT',
                    url: `/userdata/${userId}`, // Sesuaikan dengan URL Anda
                    data: {
                        _token: token,
                        name: newName,
                        email: newEmail,
                        level: newLevel,
                        class: newClass,
                        school_name: newSchoolName,
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Sukses', response.message, 'success').then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Gagal memperbarui data pengguna', 'error');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        Swal.fire('Error', 'Terjadi kesalahan saat memperbarui data pengguna', 'error');
                    }
                });

                // Hentikan SweetAlert dari menutup
                return false;
            }
        });
    }

    //delete
    function confirmDelete(userId) {
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
                    url: '/userdata/' + userId,
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
                            Swal.fire('Error', 'Gagal Menghapus data pengguna', 'error');
                        }
                    },
                });
            }
        });
    }

</script>
@include('sweetalert::alert')
@endsection