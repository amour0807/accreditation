<nav class="t-header">
      <div class="t-header-brand-wrapper" id="logo">
        <a href="">
          <img class="logo" src="{{asset('images/UBanner.png')}}">
        </a>
        <a href="">
          <img class="logo-mini" src="{{asset('images/ubl.png')}}">
        </a>
      </div>
      <div class="t-header-content-wrapper" style="background: #e9ecef;">
         
          <div class="viewport-header" style="width: 100%;">

            <nav aria-label="breadcrumb" style="margin-top:20px; ">
              <ol class="breadcrumb has-arrow" style="background: transparent;">
                <a id="menu-toggle" ><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-layout-sidebar" >
              <path fill-rule="evenodd" d="M14 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
              <path fill-rule="evenodd" d="M4 14V2h1v12H4z"/>
            </svg>
          </a>
                <li class="nav-item dropdown ml-auto" style="text-align: right;">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->username}}
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">View Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); 
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>   
              @if(Auth::user()->is_admin == 1)
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('accounts') }}" onclick="event.preventDefault();
                                                     document.getElementById('account-form').submit();">
                                        {{ __('Accounts') }}
                                    </a>

                                <form id="account-form" action="{{ route('accounts') }}" method="POST" class="d-none">
                                    @csrf
                                </form> 
                @endif
                
              </div>
            </li>
              </ol>

            </nav>
          </div>
          
        </div>
    </nav>
    <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
