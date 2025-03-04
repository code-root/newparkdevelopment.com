@extends('dashboard.auth.layouts.app')
@section('content')
        <!-- login page start-->
        <div class="container-fluid p-0">
                  <div class="row m-0">
              <div class="col-12 p-0">
                <div class="login-card login-dark" style="background-image: url('https://img.freepik.com/free-vector/abstract-technology-betwork-wire-mesh-background_1017-17263.jpg?t=st=1739892439~exp=1739896039~hmac=a5cec97906de772258891b308d3f6e017a18e3fe1d49cbd35a8d86c8582f8511&w=2000');">
                  <div>
                    <div>

                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    </div>
                    <div class="login-main">
                        <form class="theme-form" method="POST" action="{{ route('login.custom') }}">
                        @csrf
                        <h3>Sign in to account</h3>
                        <p>Enter your email & password to login</p>
                        <a class="logo" href=""><img class="img-fluid for-light" src="{{ route('view-image', ['m' => 'Setting', 'id' => 0, 'nameVar' => 'logo']) }}" alt="looginpage" width="60%">
                            <img class="img-fluid for-dark" src="{{ route('view-image', ['m' => 'Setting', 'id' => 0, 'nameVar' => 'logo']) }}"  width="10%" alt="looginpage"></a>

                        <div class="form-group">
                            <label for="emailaddress">Email address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <a href="{{ route('password.request') }}" class="text-muted float-right"><small>Forgot your password?</small></a>
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}  class="custom-control-input">
                                <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                          <div class="text-end mt-3">
                            <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                          </div>
                        </div>
                        <br>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

</body>
@endsection
