      <!-- JS, Popper.js, and jQuery -->
        <script src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script>
        <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset('js/popper.min.js')}}" ></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>


      <!-- Menu Toggle Script -->
        <script>
            $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("toggled");
            });
        </script>