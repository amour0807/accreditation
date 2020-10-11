<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Accreditation</title>

       <!-- bootstrap css -->
       <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
       <!-- Custom styles for side and top nav template -->
        <link href="{{asset('css/simple-sidebar.css')}}" rel="stylesheet">

        <!-- Custom general css -->
        <link href="{{asset('css/general.css')}}" rel="stylesheet">


        <!-- font awesom -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
  

        <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">

        <!-- JS, Popper.js, and jQuery -->
        <script src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script>
        <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset('js/popper.min.js')}}" ></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>

        <!-- custom general js -->
        <script src="{{asset('js/general.js')}}"></script>



        <!-- datatables responsiveness -->
       

      <!--  <style type="text/css">
           .alert {
              position: fixed;
              margin: auto;
              top: 0%;
              left: 0;
              right: 0;
              width: 50%;
              z-index: 9;
            }
       </style> -->

        

    </head>
    <body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-ub-grey border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Quality Assurance</div>
      <div class="list-group list-group-flush">
        <a href='#pageSubmenu' data-toggle="collapse" class="dropdown-toggle list-group-item list-group-item-action bg-ub-grey">Accreditation</a>

        <ul class="collapse list-unstyled bg-ub-grey" id="pageSubmenu">
            <li>
                <a href="{{route('accredIndex')}}" class="clear-link list-group-item list-group-item-action bg-ub-grey pl-5">Accredited Programs</a>
            </li>

            <li>
                <a href="{{route('accred_status')}}" class="clear-link list-group-item list-group-item-action bg-ub-grey pl-5">Accreditation Status</a>
            </li>

            <li>
              <a href='#page2Submenu' data-toggle="collapse" class="dropdown-toggle  clear-link list-group-item list-group-item-action bg-ub-grey pl-5">Reports</a>

              <ul class="collapse list-unstyled bg-ub-grey" id="page2Submenu">
                <li>
                    <a href="{{ route('accredReport')}}" class="clear-link list-group-item list-group-item-action bg-ub-grey pl-5">Accreditation Reports</a>
                </li>
                <li>
                    <a href="{{ route('viewProgramHistory')}}" class="clear-link list-group-item list-group-item-action bg-ub-grey pl-5">Accreditation History Reports</a>
                </li>
            </ul>

            </li>
        </ul>


        
        <a href="#" class="list-group-item list-group-item-action bg-ub-grey">Schools</a>
       <!--  <a href="#" class="list-group-item list-group-item-action bg-ub-grey">Events</a>
        <a href="#" class="list-group-item list-group-item-action bg-ub-grey">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-ub-grey">Status</a> -->

        
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-dark bg-ub-grey border-bottom">
        


          <a class="btn text-light" id="menu-toggle" style=""><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-layout-sidebar" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M14 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
              <path fill-rule="evenodd" d="M4 14V2h1v12H4z"/>
            </svg>
          </a>

      
        

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">View Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <div class="dropdown-divider"></div>
                
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid  my-2 px-4">
        @yield('content')
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
   

       <!-- Menu Toggle Script -->
        <script>
            $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("toggled");
            });
        </script>



    </body>
</html>
