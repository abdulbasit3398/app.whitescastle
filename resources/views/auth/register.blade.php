<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('assets/admin/images/favicon.ico')}}">

    <title>Master Admin - Registration </title>
  
  <!-- Vendors Style-->
  <link rel="stylesheet" href="{{asset('assets/admin/css/vendors_css.css')}}">
    
  <!-- Style-->  
  <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/skin_color.css')}}"> 

</head>

<body class="hold-transition theme-primary bg-gradient-primary">
  
  <div class="container h-p100">
    <div class="row align-items-center justify-content-md-center h-p100">
      
      <div class="col-12">
        <div class="row justify-content-center no-gutters">
          <div class="col-lg-4 col-md-5 col-12">
            <div class="bg-white-10 rounded5">
              <div class="content-top-agile p-10 pb-0">
                <h2 class="text-white">Get started with Us</h2>
                <p class="text-white-50 mb-0">Register a new membership</p>             
              </div>
              <div class="p-30">
                <form method="POST" action="{{ route('register') }}">
                  @csrf
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent text-white"><i class="ti-user"></i></span>
                      </div>
                      <input id="name" type="text" class="form-control pl-15 bg-transparent text-white plc-white @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">

                      @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent text-white"><i class="ti-email"></i></span>
                      </div>
                      <input id="email" type="email" class="form-control pl-15 bg-transparent text-white plc-white @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                      @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent text-white"><i class="ti-lock"></i></span>
                      </div>
                      <input id="password" type="password" class="form-control pl-15 bg-transparent text-white plc-white @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                      @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent text-white"><i class="ti-lock"></i></span>
                      </div>
                      <input id="password-confirm" type="password" class="form-control pl-15 bg-transparent text-white plc-white" name="password_confirmation" required autocomplete="new-password" placeholder="Retype Password">
                    </div>
                  </div>
                    <div class="row">
                    <div class="col-12">
                      <div class="checkbox text-white">
                      <input type="checkbox" id="basic_checkbox_1" >
                      <label for="basic_checkbox_1">I agree to the <a href="#" class="text-warning"><b>Terms</b></a></label>
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 text-center">
                      <button type="submit" class="btn btn-info margin-top-10">SIGN IN</button>
                    </div>
                    <!-- /.col -->
                    </div>
                </form>                         

                <div class="text-center text-white">
                  <p class="mt-20">- Register With -</p>
                  <p class="gap-items-2 mb-20">
                    <a class="btn btn-social-icon btn-round btn-outline btn-white" href="#"><i class="fa fa-facebook"></i></a>
                    <a class="btn btn-social-icon btn-round btn-outline btn-white" href="#"><i class="fa fa-twitter"></i></a>
                    <a class="btn btn-social-icon btn-round btn-outline btn-white" href="#"><i class="fa fa-google-plus"></i></a>
                    <a class="btn btn-social-icon btn-round btn-outline btn-white" href="#"><i class="fa fa-instagram"></i></a>
                  </p>  
                </div>

                <div class="text-center">
                  <p class="mt-15 mb-0 text-white">Already have an account?<a href="auth_login.html" class="text-danger ml-5"> Sign In</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>      
    </div>
  </div>


  <!-- Vendor JS -->
  <script src="{{asset('assets/admin/js/vendors.min.js')}}"></script>
  <script src="{{asset('assets/admin/assets/icons/feather-icons/feather.min.js')}}"></script>
  
  
</body>
</html>