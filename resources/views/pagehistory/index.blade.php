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
                                <h3 class="card-title">Data Classification UKRIDA 3S</h3>
                            </div>
                        </div>
                    </div>                
                   <!--.card-header -->
                    {{-- <div class="card-body">
                        <div class="table-responsive">
                            @if(isset($classifications) && $classifications->count() > 0)
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
                                        $classificationNumber = 1;
                                        @endphp
                                        @foreach ($classifications as $classification)
                                        <tr>
                                            <td>{{ $classificationNumber++ }}</td>
                                            <td>{{ $classification->questions }}</td>
                                            <td>{{ $classification->username }}</td>
                                            <td>{{ $classification->point }}</td>
                                                
                                            <td class="align-middle">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <div class="btn-group" role="group">
                                                        <button id="contentActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="contentActions">
                                                            <a class="dropdown-item" href="#" onclick="showclassificationDetails('{{ $classification->id }}', '{{ $classification->questions }}', '{{ $classification->username }}', '{{ $classification->point }}')">Details</a>
                                                            <a class="dropdown-item" href="#" onclick="showEditForm({{ $classification->id }}, {{ $classification->id_question }},'{{ $classification->id_user }}', '{{ $classification->point }}')">Edit</a>
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
                                <p class="text-center">Kategori Tidak Ditemukan</p>
                            @endif
                        </div>
                    </div> --}}
                    
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
                {{-- <div class="modal-body">
                    <form action="{{ route('pageclassification.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="point">classification Point:</label>
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
                </div> --}}
            </div>
        </div>
    </div>
</section>
@endsection