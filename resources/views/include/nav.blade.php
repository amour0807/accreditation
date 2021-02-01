<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="{{route('accredIndex')}}" class="site_title"><img src="{{asset('images/favicon.ico')}}" style="width: 40px;">&nbsp;&nbsp;<span><img src="{{asset('images/UBanner.png')}}" style="width: 120px;"></span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
       {{-- <div class="profile_pic">
        <img src="images/img.jpg" alt="..." class="img-circle profile_img">
      </div> --}}
      <center><div class="profile_info">
        <span>{{ Auth::user()->username}}</span>
        <h2>{{ Auth::user()->user_role}}</h2>
      </div></center>
      <a data-target="#myModal" data-toggle="modal" class="btn btn-danger"><small style="color:white;"><i class="fa fa-key"></i>Change Password</small></a>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>Main</h3>            
        <ul class="nav side-menu">
        <li><a href="{{route('accredIndex')}}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
         @if(Auth::user()->hasPermission('create-accred','view-accred','edit-accred'))  
          <li><a><i class="fa fa-list-ul"></i> Accreditation <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" >
              <li class="accredProg"><a href="{{route('adminAcred_prog')}}">Accredited Programs</a></li>
              <li id="accredStat"><a href="{{route('accred_status')}}">Accreditation Status</a></li>
            </ul>
          </li>
        @endif
        @if(Auth::user()->hasPermission('create-school','edit-school','view-school'))
          <li><a><i class="fa fa-edit"></i> School / Departments <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('viewSchool')}}">Lists</a></li>
              <li><a href="{{ route('academic_programs')}}">Academic Program</a></li>
            </ul>
          </li>
        @endif
        
    @if(Auth::user()->hasPermission('create-student','edit-student','view-student','create-instaward','edit-instaward','view-instaward'))  
          <li><a><i class="fa fa-trophy"></i> Awards <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              @if(Auth::user()->hasPermission('create-instaward','edit-instaward','view-instaward'))
              <li><a href="{{route('instAward')}}">Institutional Awards </a></li>
              @if(Auth::user()->hasPermission('create-schoolAward','edit-schoolAward','view-schoolAward'))
              <li><a href="{{route('schoolAward')}}">School Awards </a></li>
              @endif
              @endif
              @if(Auth::user()->hasPermission('create-student','edit-student','view-student'))  
              <li><a href="{{ route('userStudentAward')}}">Students Award</a></li>
              @endif
            </ul>
          </li>
    @endif
          {{-- <li><a><i class="fa fa-users"></i> UB Employees <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="#">Teaching</a></li>
              <li><a href="#">Non-Teaching</a></li>
            </ul>
          </li> --}}
          <h3>---</h3> 
         
        @if(Auth::user()->hasPermission('create-partner','edit-partner','view-partner'))
          <li><a href="{{route('partners')}}"><i class="fa fa-puzzle-piece"></i> Partners </a></li>
        @endif
    @if(Auth::user()->hasPermission('create-board','edit-board','view-board'))
          <li><a><i class="fa fa-language"></i>Licensure Examination <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{route('boardExam')}}">Examination</a></li>
              <li><a href="{{route('topnotchers')}}">Topnotchers</a></li>
            </ul>
          </li>
    @endif
   
        </ul>
      </div>
      
      <div class="menu_section">
        <h3>Reports</h3>
        <ul class="nav side-menu">
          <li><a><i class="fa fa-file-pdf-o"></i>Reports <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              @if(Auth::user()->hasPermission('create-accred','view-accred'))
              <li><a href="{{ route('accredReport')}} ">Accreditation Reports</a></li>
              <li><a href="{{ route('viewProgramHistory')}}">Accreditation History Reports</a></li>
              @endif
              @if(Auth::user()->hasPermission('create-employees','edit-employees','view-employees'))
              <li><a href="{{route('hrInput')}}">Employees </a></li>
              @endif
              @if(Auth::user()->hasPermission('create-enrollment','edit-enrollment','view-enrollment'))
              <li><a href="{{route('enrollment')}}">Enrollment </a></li>
              @endif
              @if(Auth::user()->hasPermission('create-graduate','edit-graduate','view-graduate'))
              <li><a href="{{route('graduate')}}">Graduates </a></li>
              @endif
            </ul>
          </li>
          @if(Auth::user()->hasPermission('create-scholar','edit-scholar','view-scholar'))
          <li><a><i class="fa fa-money"></i> Scholarships / Grants <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('listScholar')}}">Lists</a></li>
              <li><a href="{{ route('scholarIndex')}}">Academic Year Discounts</a></li>
            </ul>
          </li>
        @endif
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
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
        <ul class=" navbar-right">
          <li class="nav-item dropdown open" style="padding-left: 15px;">
            <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
              {{ Auth::user()->username}}
            </a>
            <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
             
              <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault(); 
                            document.getElementById('logout-form').submit();">
               {{ __('Logout') }}
           </a>

       <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
           @csrf
       </form>   
           
              @if(Auth::user()->hasPermission('create-user') || Auth::user()->hasPermission('view-user'))
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('accounts') }}">
                                  {{ __('Accounts') }}<i class="fa fa-users pull-right"></i>
                              </a>
          @endif
            </div>
          </li>

        </ul>
      </nav>
    </div>
  </div>
<!-- /top navigation -->