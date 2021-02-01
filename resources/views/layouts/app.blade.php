<?php
session_start();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('include.head')
</head>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
    @include('include.nav')

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="clearfix"></div>

          <div class="row">
            @yield('content')
          </div>
              </div>
            </div>
          </div>
            </div>
        
      <!-- /page content -->
    </div>
  </div>
  @include('common.changePassword')
  @include('include.scripts')
</body>
</html>
