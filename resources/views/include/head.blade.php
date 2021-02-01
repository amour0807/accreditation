<<<<<<< HEAD
<meta  charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="csrf-token" content="{{ csrf_token() }}">
   
           <title>QAO File Management System</title>
           <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/ico">
   
            <!-- Bootstrap -->
<!--             
            <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet"> -->
            <link href="{{asset('new/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
            <!-- Font Awesome -->
            <link href="{{asset('new/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
            <!-- NProgress -->
            <link href="{{asset('new/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
            <!-- iCheck -->
            <link href="{{asset('new/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
            <!-- Datatables -->
            
            <link href="{{asset('new/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
            <link href="{{asset('new/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
            <link href="{{asset('new/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
            <link href="{{asset('new/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
            <link href="{{asset('new/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

            <!-- Custom Theme Style -->

            <link href="{{asset('new/build/css/custom.min.css')}}" rel="stylesheet">
            <style>
                .nav.side-menu>li.current-page, .nav.side-menu>li.active {
    border-right: 5px solid rgb(192, 42, 42);
}
table tr td {
	overflow-x: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      width: 5px;
	}
    table.jambo_table thead {
    background:  #eceef8ab;
    color: rgb(73, 68, 68);
=======
 <head>

 <meta  charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Accreditation</title>
        <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/ico">

        
        <link rel="stylesheet" href="{{ asset('bootstrap-4.5.3-dist/css/bootstrap.min.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">
        <link href="{{asset('css/general.css')}}" rel="stylesheet">

        <!-- font awesom -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
        <link href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.css') }}" rel="stylesheet" >

        <!-- JS, jQuery -->
        <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('bootstrap-4.5.3-dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}" defer></script>

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
<<<<<<< HEAD
              padding: 2px;    
          }

=======
              padding: 2px;
              font-size: 13px;    
          }

          /* Header */
.t-header {
  display: flex;
  height: 50px;
  background: #dee1e6;
  z-index: 100; }
  @media (max-width: 991.98px) {
    .t-header {
      padding-left: 5px;
      padding-right: 5px; } }
  .t-header .t-header-brand-wrapper {
    display: flex;
    align-items: center;
    height: 50px;
    width: 17rem;
    min-width: 17rem;
    max-width: 17rem;
    background: #fff;
    z-index: 100;
    padding-left: 18px; }
    .t-header .t-header-brand-wrapper a {
      display: flex;
      align-items: center;
      color: #f3f5f6;
      font-weight: 500;
      font-size: 1.25rem; }
      .t-header .t-header-brand-wrapper a .logo {
        max-width: 100%;
        width: 80px; }
      .t-header .t-header-brand-wrapper a .logo-mini {
        display: none;
        max-width: 100%;
        width: 35px; }
      .t-header .t-header-brand-wrapper a p {
        color: inherit;
        font-size: inherit;
        font-weight: inherit;
        margin-bottom: 0; }
    @media (max-width: 991.98px) {
      .t-header .t-header-brand-wrapper {
        padding-left: 0;
        justify-content: center; }
        .t-header .t-header-brand-wrapper a .logo-mini {
          width: 25px; } }
  .t-header .t-header-content-wrapper {
    display: flex;
    align-items: center;
    flex-direction: row;
    width: 100%;
    max-width: 100%;
    padding: 0 2.5rem; }
    @media (max-width: 991.98px) {
      .t-header .t-header-content-wrapper {
        padding: 0 1rem; } }
    .t-header .t-header-content-wrapper .t-header-search-box {
      display: flex;
      width: 20%;
      height: 25px;
      background: #fff;
      border-radius: 50px;
      padding: 5px;
      transition: 0.3s ease-in-out;
      transition-property: "width";
      overflow: hidden; }
      @media (max-width: 580px) {
        .t-header .t-header-content-wrapper .t-header-search-box {
          display: none; } }
      .t-header .t-header-content-wrapper .t-header-search-box .form-control {
        height: inherit;
        border: none;
        background: transparent;
        font-size: 1rem;
        font-weight: 500;
        padding-left: 0;
        padding: 5px 20px; }
        .t-header .t-header-content-wrapper .t-header-search-box .form-control.placeholder {
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit; }
        .t-header .t-header-content-wrapper .t-header-search-box .form-control:-moz-placeholder {
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit; }
        .t-header .t-header-content-wrapper .t-header-search-box .form-control::-moz-placeholder {
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit; }
        .t-header .t-header-content-wrapper .t-header-search-box .form-control:-ms-input-placeholder {
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit; }
        .t-header .t-header-content-wrapper .t-header-search-box .form-control::-webkit-input-placeholder {
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit; }
      .t-header .t-header-content-wrapper .t-header-search-box button[type="submit"] {
        height: 100%;
        border-radius: 50px;
        padding: 0 7px;
        box-shadow: 0px 0px 5px -1px #696ffb;
        transition-duration: 0.3s;
        transition-property: "box-shadow"; }
        .t-header .t-header-content-wrapper .t-header-search-box button[type="submit"] i {
          font-size: 15px; }
        .t-header .t-header-content-wrapper .t-header-search-box button[type="submit"]:hover {
          box-shadow: 0px 0px 8px -1px #696ffb; }
    .t-header .t-header-content-wrapper .t-header-content {
      display: flex;
      align-items: center;
      width: 100%;
      max-width: 100%; }
      .t-header .t-header-content-wrapper .t-header-content .nav .nav-item .nav-link {
        position: relative; }
        .t-header .t-header-content-wrapper .t-header-content .nav .nav-item .nav-link i {
          color: #525c5d; }
        .t-header .t-header-content-wrapper .t-header-content .nav .nav-item .nav-link .notification-indicator {
          position: absolute;
          top: 12px;
          right: 12px; }
      .t-header .t-header-content-wrapper .t-header-content .nav .nav-item:last-child .nav-link {
        padding-right: 0; }
  .t-header .t-header-toggler {
    background: transparent;
    border: none;
    margin-left: auto; }
    .t-header .t-header-toggler i {
      font-size: 1.375rem; }
    .t-header .t-header-toggler.t-header-mobile-toggler {
      margin-left: 0;
      margin-right: 15px; }
  .t-header.fixed-top {
    position: fixed; }

.header-fixed .t-header {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  width: 100%;
  z-index: 100; }

.header-fixed .sidebar {
  padding-top: 65px; }
  .header-fixed .sidebar .t-header-brand-wrapper {
    position: fixed;
    left: 0;
    top: 0;
    z-index: 100;
    width: 17rem;
    box-shadow: 0px 2px 8px 0px rgba(0, 0, 0, 0.05); }
  .header-fixed .sidebar .navigation-menu {
    z-index: 1; }

/* Sidebar */
.sidebar {
  position: relative;
  display: block;
  height: 100%;
  min-height: 100vh;
  width: 17rem;
  min-width: 17rem;
  max-width: 17rem;
  background: #fff; }
  .sidebar .sidebar-header {
    border-bottom: 1px solid #2c3744; }
  .sidebar .user-profile {
    display: flex;
    flex-direction: column;
    text-align: center; }
    .sidebar .user-profile .user-name {
      font-weight: 600;
      margin-top: 0px; }
    .sidebar .user-profile .description {
      margin-top: 1px;
      color: rgba(16, 16, 16, 0.4); }
  .sidebar .navigation-menu {
    padding-left: 0;
    padding-bottom: 80px;
    margin-bottom: 0;
    margin-top: 18px; }
    .sidebar .navigation-menu li {
      display: block;
      margin: 0;
      transition-duration: 0.25s;
      transition-timing-function: cubic-bezier(0.26, 0.66, 0.45, 0.78);
      transition-property: "background"; }
      .sidebar .navigation-menu li.nav-category-divider {
        position: -webkit-sticky;
        position: sticky;
        top: 64px;
        display: block;
        background: #fff;
        margin: 15px 0px 0px 0px;
        padding: 20px 30px 10px 30px;
        font-size: 10px;
        color: rgba(16, 16, 16, 0.4);
        z-index: 1;
        font-weight: 500; }
        .sidebar .navigation-menu li.nav-category-divider:first-child {
          margin-top: 0; }
      .sidebar .navigation-menu li a {
        display: flex;
        align-items: center;
        flex-direction: row-reverse;
        justify-content: flex-end;
        padding: 12px 30px 12px 30px;
        font-size: 13px;
        line-height: 1;
        color: #525c5d;
        letter-spacing: 0.03rem;
        font-weight: 500;
        max-width: 100%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden; }
        .sidebar .navigation-menu li a .link-icon, .color_red{
          margin-right: 15px;
          line-height: 1;
          color: #525c5d;
          font-size: 1.1875rem;
          transition-duration: 0.3s;
          transition-property: "margin-right"; }
        
      .sidebar .navigation-menu li:last-child a {
        border-bottom: none; }
      .sidebar .navigation-menu li .navigation-submenu {
        background: #fafafa;
        padding: 0px 0 10px 30px; }
        .sidebar .navigation-menu li .navigation-submenu.collapsing {
          transition: 0.2s ease-in; }
        .sidebar .navigation-menu li .navigation-submenu li {
          display: inherit; }
          .sidebar .navigation-menu li .navigation-submenu li a {
            display: block;
            padding: calc(9px) 30px calc(9px) calc(30px + 2px);
            opacity: 0.5;
            letter-spacing: 0.03rem;
            font-weight: 500;
            font-size: calc(13px - 1px);
            transition: 0.3s ease-in-out;
            transition-property: color; }
            .sidebar .navigation-menu li .navigation-submenu li a[data-toggle="collapse"] {
              position: relative; }
              .sidebar .navigation-menu li .navigation-submenu li a[data-toggle="collapse"]:after {
                content: "";
                height: 7px;
                width: 7px;
                border-radius: 25px;
                position: absolute;
                right: calc(30px + 4px);
                top: 14px; }
            .sidebar .navigation-menu li .navigation-submenu li a.active {
              opacity: 0.7;
              color: #101010; }
            .sidebar .navigation-menu li .navigation-submenu li a:hover {
              opacity: 0.7;
              color: #101010; }
          .sidebar .navigation-menu li .navigation-submenu li:first-child a {
            padding-top: 10px; }
            .sidebar .navigation-menu li .navigation-submenu li:first-child a:after {
              top: 15px; }
          .sidebar .navigation-menu li .navigation-submenu li:nth-child(5n + 1) a:after {
            background: #4CCEAC; }
          .sidebar .navigation-menu li .navigation-submenu li:nth-child(5n + 2) a:after {
            background: #e91e63; }
          .sidebar .navigation-menu li .navigation-submenu li:nth-child(5n + 3) a:after {
            background: #DB504A; }
          .sidebar .navigation-menu li .navigation-submenu li:nth-child(5n + 4) a:after {
            background: #FF6F59; }
          .sidebar .navigation-menu li .navigation-submenu li:nth-child(5n + 5) a:after {
            background: #857bff; }
          .sidebar .navigation-menu li .navigation-submenu li .navigation-submenu {
            padding-left: 0px; }
            .sidebar .navigation-menu li .navigation-submenu li .navigation-submenu li a {
              opacity: 0.5; }
      .sidebar .navigation-menu li.active a .link-title {
        color: #cb0d32; }
      .sidebar .navigation-menu li.active a .link-icon {
        color: #cb0d32; }
    .sidebar .navigation-menu > li:not(.nav-category-divider):hover a:not([aria-expanded="true"]) .link-icon {
      margin-right: 20px;
      color: #cb0d32; }
    .sidebar .navigation-menu > li:not(.nav-category-divider) > a[data-toggle="collapse"] {
      position: relative; }
      .sidebar .navigation-menu > li:not(.nav-category-divider) > a[data-toggle="collapse"]:after {
        content: "\f142";
        font-family: "Material Design Icons";
        font-size: 15px;
        text-rendering: auto;
        line-height: inherit;
        font-weight: bolder;
        position: absolute;
        top: 13px;
        right: 30px;
        display: block;
        transition: 0.3s;
        transition-property: -webkit-transform;
        transition-property: transform;
        transition-property: transform, -webkit-transform;
        color: #839092; }
      .sidebar .navigation-menu > li:not(.nav-category-divider) > a[data-toggle="collapse"][aria-expanded="true"] {
        background: #fafafa; }
        .sidebar .navigation-menu > li:not(.nav-category-divider) > a[data-toggle="collapse"][aria-expanded="true"]:after {
          -webkit-transform: rotate(90deg);
                  transform: rotate(90deg); }
/* Blocks */
.block {
    margin: 0 0 10px;
    padding: 20px 15px 1px;
    background-color: #ffffff;
    border: 1px solid #dbe1e8;
}

.block.full {
    padding: 20px 15px;
}

.block .block-content-full {
    margin: -20px -15px -1px;
}

.block .block-content-mini-padding {
    padding: 8px;
}

.block.full .block-content-full {
    margin: -20px -15px;
}

.block-title {
    margin: -20px -1px 20px;
    background-color: #f9fafc;
    border-bottom: 1px solid #eaedf1;
}

.block-title h1,
.block-title h2,
.block-title h3,
.block-title h4,
.block-title h5,
.block-title h6 {
    display: inline-block;
    font-size: 16px;
    line-height: 1.4;
    margin: 0;
    padding: 10px 16px 7px;
    font-weight: normal;
}

.block-title h1 small,
.block-title h2 small,
.block-title h3 small,
.block-title h4 small,
.block-title h5 small,
.block-title h6 small {
    font-size: 13px;
    color: #777777;
    font-weight: normal;
}

.block-title h1,
.block-title h2,
.block-title h3 {
    padding-left: 15px;
    padding-right: 15px;
}

.block-title .nav-tabs,
.block-options {
    min-height: 40px;
    line-height: 38px;
}

.block-title .nav-tabs {
    padding: 3px 1px 0;
    border-bottom: none;
}

.block-title .nav-tabs > li > a {
    border-bottom: none;
}

.block-title .nav-tabs {
    margin-bottom: -2px;
}

.block-title .nav-tabs > li > a {
    margin-bottom: 0;
}

.block-title .nav-tabs > li > a:hover {
    background: none;
}

.block-title .nav-tabs > li.active > a,
.block-title .nav-tabs > li.active > a:hover,
.block-title .nav-tabs > li.active > a:focus {
    border: 1px solid #eaedf1;
    border-bottom-color: #ffffff;
    background-color: #ffffff;
}

.block-title code {
    padding: 2px 3px;
}

.block-options {
    margin: 0 6px;
    line-height: 37px;
}

.block-options .label {
    display: inline-block;
    padding: 6px;
    vertical-align: middle;
>>>>>>> d471564580cde705a1746260414ac2aa14452cf2
    font-size: 13px;
}
.dataTables_wrapper {
    font-family: tahoma;
    font-size: 12px;
}
<<<<<<< HEAD
</style> 
=======

.block-section {
    margin-bottom: 20px;
}

.block.block-fullscreen {
    position: fixed;
    top: 5px;
    bottom: 5px;
    left: 5px;
    right: 5px;
    z-index: 1031;
    margin-bottom: 0;
    overflow-y: auto;
}
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41

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
>>>>>>> d471564580cde705a1746260414ac2aa14452cf2
