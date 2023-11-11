
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UKRIDA3S | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/') }}plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('/') }}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/') }}dist/css/adminlte.min.css">
  <!-- Sweet Alertstyle -->
  <link rel="stylesheet" href="{{ asset('/') }}dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="{{ asset('/') }}"><b>UKRIDA</b>3S</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="{{ route('register.save') }}" method="post" class="user">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" placeholder="Full Name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" placeholder="Email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <select class="form-control form-control-user @error('class') is-invalid @enderror" name="class" id="class">
              <option value="" disabled selected>--Please Choose an Option</option>
              <option value="9" @if(old('class') == '9') selected @endif>Grade 9</option>
              <option value="10" @if(old('class') == '10') selected @endif>Grade 10</option>
              <option value="11" @if(old('class') == '11') selected @endif>Grade 11</option>
              <option value="12" @if(old('class') == '12') selected @endif>Grade 12</option>
          </select>
          @error('class')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>      
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('school_name') is-invalid @enderror" name="school_name" placeholder="School Name">
            @error('school_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" placeholder="Password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Retype Password">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="agreeTerms" name="terms" value="agree">
            <label class="form-check-label" for="agreeTerms">I agree to the <a href="#">terms</a></label>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
    

      <a href="{{ route ('login') }}" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

@include('sweetalert::alert')
<!-- jQuery -->
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/') }}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/') }}dist/js/adminlte.min.js"></script>
</body>
</html>