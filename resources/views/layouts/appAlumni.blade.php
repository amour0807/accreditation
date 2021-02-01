<?php
session_start();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  @include('include.head')
  <style>

body, .container, .body, .nav-md{
	background-color: #fff;
}
.nav.side-menu>li>a:hover {
    color: red !important;
}
.nav_menu{
	color:white;
}
.navbar{
	background:#2f333e;
	height:50px;}
.nav.side-menu>li.current-page, .nav.side-menu>li.active {
	border-right: 5px solid rgb(218, 68, 68);
	background-color:rgba(77, 23, 23, 0.06);
	color:white;
}
.nav.side-menu>li>a, .nav.child_menu>li>a {
    color: #2f333e;
}
.nav.side-menu>li.active>a {
	background-color:rgba(77, 23, 23, 0.06);
	color: white;
}
.flats{
  width:18px;
  height: 18px;
}
.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
.has-error{
	background: #fff0f4; 
  color: #c51244;
  border: 1px solid #c51244 !important; 
}
.left_col,.main_container{
    background: #eceef8;
    color:#2f333e;
}
.nav_menu {
    float: left;
    background: #eceef8;
    border-bottom: 1px solid #D9DEE4;
    margin-bottom: 10px;
    width: 100%;
    position: relative;
    color:#2f333e;
}
.container, .body, .nav-md {
    background-color: #fff;
}
.navbar{
    background: #eceef8;
    height: 50px;
}

.nav.side-menu>li.active>a {
    background-color: rgba(77, 23, 23, 0.06);
    color: red;
}
.nav.side-menu>li>a, .nav.child_menu>li>a {
   color:#2f333e;
}

  </style>
<body class="nav-md">
  <div class="container body" style="background-color:white;">
    <div class="main_container">
      @if(Auth::guard('alumni')->user()->user_role != 'graduate') @include('include.navAlumni')@endif

      <!-- page content -->
      <div class="right_col" role="main">

          <div class="row">
            @yield('content')
          </div>
            </div>
          </div>
            </div>
        
      <!-- /page content -->
  @include('include.scripts')
</body>
</html>
