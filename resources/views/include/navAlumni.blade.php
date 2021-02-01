<div class="col-md-3 left_col" id="side">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="{{route('secretary')}}" class="site_title"><img src="{{asset('images/favicon.ico')}}" style="width: 40px;">&nbsp;&nbsp;<small style="color:#2f333e;">Alumni Database</small></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix" >
       {{-- <div class="profile_pic">
        <img src="images/img.jpg" alt="..." class="img-circle profile_img">
      </div> --}}
      <center><div class="profile_info" >
        <span style="color:#2f333e;">{{ Auth::guard('alumni')->user()->email}}</span>
        <h2 style="color:#2f333e;">{{ Auth::guard('alumni')->user()->user_role}}</h2>
      </div></center>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>Main</h3>            
        <ul class="nav side-menu">
      {{-- @if(Auth::guard('alumni')->user()->user_role == 'admin')
          <li><a><i class="fa fa-edit"></i> School / Departments <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('viewSchool')}}">Lists</a></li>
              <li><a href="{{ route('academic_programs')}}">Academic Program</a></li>
            </ul>
          </li>@endif --}} 
          @if(Auth::guard('alumni')->user()->user_role == 'admin')<li><a href="{{route('userAccounts')}}"><i class="fa fa-user"></i> User Accounts </a></li>@endif
          <li><a href="{{route('graduateindex')}}"><i class="fa fa-graduation-cap"></i> Graduates </a></li>
          <li><a href="{{route('report')}}"><i class="fa fa-table"></i> Reports </a></li>
         
        </ul>
      </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons 
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{route('logout')}}">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>-->
    <!-- /menu footer buttons -->
  </div>
</div>

<!-- top navigation -->
<div class="top_nav" >
    <div class="nav_menu">
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
        <ul class=" navbar-right">
          <li class="nav-item dropdown open" style="padding-left: 15px;">
            
            
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); 
            document.getElementById('logout-form').submit();" style="color:#2f333e;">
              {{ __('Logout') }} <i class="fa fa-sign-out"></i></a>
          

       <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
           @csrf
       </form>   
          </li>

        </ul>
      </nav>
    </div>
  </div>
<!-- /top navigation -->