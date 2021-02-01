
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('include.head')
</style>
<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form id="my_form" method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="role" value="staff" >
            <h1><img src="{{asset('images/favicon.ico')}}" style="width: 40px;">&nbsp;&nbsp;<span><img src="{{asset('images/UBanner.png')}}" style="width: 120px;"></span></h1>
            <p><a href="{{route('login')}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back&nbsp;&nbsp;</a>Login Form</p>
            <p>Staff</p>
            <div>
              <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

              @if ($errors->has('username'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('username') }}</strong>
                  </span>
              @endif
            </div>
            <div>
              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" >

              @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
            </div>
            <div>
              <a class="btn btn-default" href="javascript:{}" onclick="document.getElementById('my_form').submit();">Log in</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
             

              <div class="clearfix"></div>
              <br />

              <div>
                 <p>©2020 All Rights Reserved. UB Quality Assurance Office</p>
              </div>
            </div>
          </form> 
        </section>
      </div>
    </div>
  </div>
</body>
</html>