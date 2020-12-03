<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('include.head')
  <body>
    <div >
      <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-8 col-11 mx-auto" style="margin-top: 10%;">
          <div class="grid" style="float: center;">
            <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                        <div class="col-md-6">
                          <img src="{{asset('images/ublogo.jpg')}}" style="height:200px;width:210px">
                        </div>
                        <div class="col-md-6">
                        <div class="form-group input-rounded">
                            <div>
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group input-rounded">
                            <div>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" >

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="{{ old('remember') ? 'checked' : '' }}">

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="mdi mdi-login btn btn-primary" style="width: 100%;">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                   <center> <a class="btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a></center>
                                @endif
                            </div>
                        </div>
                        </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
          </div>
          <div class="auth_footer">
        <p class="text-muted text-center">© UB Quality Assurance Office 2020</p>
      </div>
        </div>
        
      </div>
    </div>
  </body>
</html>
