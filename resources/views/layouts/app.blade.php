<?php
session_start();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('include.head')
<style type="text/css">
  .page-content-wrapper{
    width: 100%;
  }
</style>
  <body class="header-fixed" data-smart-device-detect data-smart-layout
        data-smart-page-title="Accreditation" onload="onInactive(1800000, logout); checking();" style="padding-right: 0px !important;">
    
    <div class="d-flex" id="wrapper" style="background: #e9ecef;">
      @include('include.nav')
        <div class="sidebar" id="sidebar-wrapper" style="background: #e9ecef;">
          <center class="info-wrapper">
            <label style="color: red;">{{ Auth::user()->username}}</label><br>
              <label style="color: gray;">{{ Auth::user()->user_role}}</label>
         
          </center>
            @if(Auth::user()->is_admin == '1')
                @include('include.admin_nav')
            @elseif (Auth::user()->is_admin == '0' || Auth::user()->is_admin == '')
                @include('include.guest_nav')
            @endif
       
      </div>
      <!-- /#sidebar-wrapper -->
      <div class="page-content-wrapper" style="margin-top: 50px; overflow: scroll;">
               @yield('content')
      </div>
       <div class="auth_footer">
        <p class="text-muted text-center">© UB Quality Assurance Office 2020</p>
      </div>
    </div>
    <script type="text/javascript">
      $("a").on("click", function() {
  $("a").removeClass("active");
  $(this).addClass("active");
});
    </script>
</body>

</html>
