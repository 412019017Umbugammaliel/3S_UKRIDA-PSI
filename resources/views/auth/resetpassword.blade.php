
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Forgot Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/') }}plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('/') }}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/') }}dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ asset('/') }}"><b>UKRIDA</b>3S</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Input Your New Password</p>
  
      <form action="{{ route('password.update') }}" method="post">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">
          
          <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $email ?? old('email') }}" required>
              <div class="input-group-append">
                  <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                  </div>
              </div>
          </div>
          @error('email')
              <div class="text-danger">{{ $message }}</div>
          @enderror
  
          <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="New Password" name="password" required>
              <div class="input-group-append">
                  <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                  </div>
              </div>
          </div>
          @error('password')
              <div class="text-danger">{{ $message }}</div>
          @enderror
  
          <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
              <div class="input-group-append">
                  <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                  </div>
              </div>
          </div>
  
          <div class="row">
              <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
              </div>
          </div>
      </form>
  
      <p class="mt-3 mb-1">
          <a href="{{ route('login') }}">Login</a>
      </p>
      <p class="mb-0">
          <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
      </p>
    </div>  
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/') }}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/') }}dist/js/adminlte.min.js"></script>
</body>
</html>
