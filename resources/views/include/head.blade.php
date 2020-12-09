 <head>
 <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Accreditation</title>

        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
        <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet" >  
        <link href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.css') }}" rel="stylesheet" >
        <link href="{{asset('css/general.css')}}" rel="stylesheet">
        <link href="{{ asset('css/main-pixelcave.css') }}" rel="stylesheet" >
        <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">

        <!-- font awesom -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

        <!-- JS, Popper.js, and jQuery -->
        <!-- JS, Popper.js, and jQuery -->
        <script src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script>
        <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>

        <script src="{{ asset('js/sweetalert.min.js') }}" defer></script>
        <script src="{{asset('js/general.js')}}"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
        <style type="text/css">
                .dataTables_filter input{
            display: block;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            border-style: solid;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6c757d;
            background-color: white;
            background-clip: padding-box;
            border: 2px solid gray;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            float: right;
            width: 200px;
            margin-right: 20px;
          }
           .alertOld {
              position: fixed;
              margin: auto;
              top: 0%;
              left: 0;
              right: 0;
              width: 50%;
              z-index: 9;
            }
            .btn-danger {
                color: #fff;
                background-color: #c9302c;
                border-color: #c12e2a;
            }
            .btn-danger.active, .btn-danger:active, .btn-danger:hover, .open>.dropdown-toggle.btn-danger {
                color: #fff;
                background-color: #c9302c;
                border-color: #c12e2a;
            }
            body{
                font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                font-size: small;
            }
            .pagination-sm > li > a, .pagination-sm > li > span {
                padding: 1px 5px;
            }
            a:focus, a:hover {
                color: red;
            }
            body:not(.menu-on-top).desktop-detected {
                min-height: 0px !important;
            }
            input[type="text"]{
                font-size:13px;
            }
            select option {
               font-size: 13px;
            }
            nav ul li a{
                font-size: 13px;
            }
            nav ul ul li > a{
                font-size: 13px;
            }
             #logo img {
                margin-top: 8px;
                margin-left: 32%;
                width: 120px !important;
            }
            #logo{
                width:auto !important;
                background: #e9ecef;
            }
             #wrapper {
                overflow-x: hidden;
             }

            #sidebar-wrapper {
              min-height: 100vh;
              margin-left: -15rem;
              -webkit-transition: margin .25s ease-out;
              -moz-transition: margin .25s ease-out;
              -o-transition: margin .25s ease-out;
              transition: margin .25s ease-out;
            }

            #sidebar-wrapper .sidebar-heading {
              padding: 0.875rem 1.25rem;
              font-size: 1.2rem;
            }

            #sidebar-wrapper .list-group {
              width: 15rem;
            }

            #page-content-wrapper {
              min-width: 100vw;

            }

            #wrapper.toggled #sidebar-wrapper {
              margin-left: 0;
            }

            @media (min-width: 768px) {
              #sidebar-wrapper {
                margin-left: 0;
              }

              #page-content-wrapper {
                min-width: 0;
                width: 100%;
              }

              #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
              }
            }
                table td {
          overflow-x: hidden;
              text-overflow: ellipsis;
              white-space: nowrap;
          }
          .card{
            height: 80px;
          }
          .card-title{
            height: 40px;
            font-size: 20px;
          }
          .stretched-link{
            height: 30px;
          }
            /* Shadow */
            .hvr-shadow {

              -webkit-transform: perspective(1px) translateZ(0);
              transform: perspective(1px) translateZ(0);
              box-shadow: 0 0 1px rgba(0, 0, 0, 0);
              -webkit-transition-duration: 0.3s;
              transition-duration: 0.3s;
              -webkit-transition-property: box-shadow;
              transition-property: box-shadow;
               box-shadow: 0 12px 10px -10px rgba(0, 0, 0, 0.5);

            }
            .hvr-shadow:hover, .hvr-shadow:focus, .hvr-shadow:active {
              box-shadow: 0 12px 10px -10px rgba(0, 0, 0, 0.5);
            }
            .stretcged-link, a:hover{
                  color: white;
            }
        }
         
            .modal-notify .modal-header {
              border-radius: 3px 3px 0 0;
          }
          .modal-notify .modal-content {
              border-radius: 3px;
          }
          div {
                word-break: break-word;
              }
          hr {
            height: 1px;
            background-color: maroon;
            border: none;"
          }
          input {
            background-color: white;
          }
          .modal {
            overflow-y:auto;
          }
          fieldset {
              margin: 8px;
              border: 1px solid silver;
              padding: 8px; 
              margin-top: 0;   
              border-radius: 4px;
          }

          legend {
              padding: 2px;    
          }


        </style>
        <script type="text/javascript">
              $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("toggled");
            });
            function logout() {
                window.sessionStorage.clear();
                location.href = "/login";
            }

            function onInactive(millisecond, callback){
                var wait = setTimeout(callback, millisecond);
                document.onmousemove =
                document.mousedown =
                document.mouseup =
                document.onkeydown =
                document.onkeyup =
                document.focus = function(){
                    clearTimeout(wait);
                    wait = setTimeout(callback, millisecond);
                };
            }

            function checking() {
                document.onkeydown = function (event) {
                    event = (event || window.event);
                    if (event.keyCode == 123 || event.keyCode == 18 || event.keyCode == 116) {
                        return false;
                    }
                }
                document.addEventListener('contextmenu', event => event.preventDefault());
            }

        </script>
         @yield('additional')
