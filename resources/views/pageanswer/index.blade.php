@extends('layouts.app')

@section('title', 'UKRIDA 3S - Page Answer')
    
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title">Data Answer UKRIDA 3S</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahAnswerModal">Tambah Jawaban</button>
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
                            @if(isset($answers) && $answers->count() > 0)
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Question</th>
                                            <th>User</th>
                                            <th>Point</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $answerNumber = 1;
                                        @endphp
                                        @foreach ($answers as $answer)
                                        <tr>
                                            <td>{{ $answerNumber++ }}</td>
                                            <td>{{ $answer->questions }}</td>
                                            <td>{{ $answer->username }}</td>
                                            <td>{{ $answer->point }}</td>
                                                
                                            <td class="align-middle">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <div class="btn-group" role="group">
                                                        <button id="contentActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="contentActions">
                                                            <a class="dropdown-item" href="#" onclick="showAnswerDetails('{{ $answer->id }}', '{{ $answer->questions }}', '{{ $answer->username }}', '{{ $answer->point }}')">Details</a>
                                                            <a class="dropdown-item" href="#" onclick="EditAnswer('{{ $answer->id }}', '{{ $answer->id_question }}', '{{ $answer->id_user }}', '{{ $answer->point }}')">Edit</a>
                                                            <a class="dropdown-item" href="#" onclick="confirmDelete('{{ $answer->id }}')">Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="text-center">Jawaban Tidak Ditemukan</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahAnswerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pageanswer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id_question">Pilih Pertanyaan:</label>
                            <select name="id_question" id="id_question" class="form-control" required>
                                <option value="" disabled selected>Select Pertanyaan</option>
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id_question }}">{{ $question->questions }}</option>
                                @endforeach
                            </select>
                            @error('id_question')
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
                            <label for="point">Answer Point:</label>
                            <input type="text" name="point" id="point" class="form-control" required>
                            @error('point')
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

    <!-- Edit Answer Modal -->
    <div class="modal fade" id="editAnswerModal" tabindex="-1" role="dialog" aria-labelledby="editAnswerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAnswerModalLabel">Edit Answer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form for editing answers goes here -->
                    <form id="editAnswerForm" action="{{ route('pageanswer.update', ['id' => 0]) }}" method="post">
                        @csrf
                        @method('put')
                        <!-- Add your form fields here (id_question, id_user, point) -->
                        <div class="form-group">
                            <label for="editAnswerQuestion">Question</label>
                            <select class="form-control" id="editAnswerQuestion" name="id_question" required>
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id_question }}">{{ $question->questions }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editAnswerUser">User</label>
                            <select class="form-control" id="editAnswerUser" name="id_user" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editAnswerPoint">Point</label>
                            <input type="text" class="form-control" id="editAnswerPoint" name="point" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</section>
<script>
    //details
    function showAnswerDetails(id, questions, username, point) {
        // Use SweetAlert to display answer details
        Swal.fire({
            title: 'Answer Details',
            html: `<strong>ID:</strong> ${id}<br><strong>Questions:</strong> ${questions}<br><strong>Username:</strong> ${username}<br><strong>Point:</strong> ${point}`,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    }

    //edit
    function EditAnswer(id, id_question, id_user, point) {
        // Set the form action dynamically based on the answer ID
        var editAnswerForm = document.getElementById('editAnswerForm');
        editAnswerForm.action = '/pageanswer/update/' + id;

        // Populate the form fields with existing answer details
        document.getElementById('editAnswerQuestion').value = id_question;
        document.getElementById('editAnswerUser').value = id_user;
        document.getElementById('editAnswerPoint').value = point;

        // Open the edit modal
        $('#editAnswerModal').modal('show');
    }
    
    //delete
    function confirmDelete(answerId) {
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
                // Modify the URL to match the route for deleting answers
                window.location.href = '/pageanswer/delete/' + answerId;
            }
        });
    }


</script>

@include('sweetalert::alert')
@endsection