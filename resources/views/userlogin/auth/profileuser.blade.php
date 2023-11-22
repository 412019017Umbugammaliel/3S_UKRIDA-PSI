@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - Profile ')
    
@section('contents')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">setProfile</h3>
            </div>
            <div class="card-body text-center">
                <form method="POST" action="{{ route('updateprofileuser') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}">
                    </div>

                    <div class="form-group">
                        <label for="class">Class</label>
                        <select class="form-control form-control-user @error('class') is-invalid @enderror" name="class" id="class">
                            <option value="" disabled>--Please Choose an Option</option>
                            <option value="9" @if(old('class') == '9' || auth()->user()->class == 9) selected @endif>Grade 9</option>
                            <option value="10" @if(old('class') == '10' || auth()->user()->class == 10) selected @endif>Grade 10</option>
                            <option value="11" @if(old('class') == '11' || auth()->user()->class == 11) selected @endif>Grade 11</option>
                            <option value="12" @if(old('class') == '12' || auth()->user()->class == 12) selected @endif>Grade 12</option>
                        </select>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>                  

                    <div class="form-group">
                        <label for="school_name">School Name</label>
                        <input type="text" name="school_name" id="school_name" class="form-control" value="{{ auth()->user()->school_name }}">
                    </div>

                    
                    <button type="submit" class="btn btn-warning">Ubah Profile</button>
                </form>
            </div>
          </div>
          <!-- /.card -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- Form Element sizes -->
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">setPassword</h3>
            </div>
            <div class="card-body text-center">
                <form method="POST" action="{{ route('updatepassworduser') }}">
                    @csrf
                    @method('PUT')

                    <!-- Input password baru -->
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password Baru">
                    </div>
        
                    <!-- Konfirmasi password baru -->
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru">
                    </div>

                    <button type="submit" class="btn btn-warning">Ubah Password</button>
                </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@include('sweetalert::alert')
@endsection