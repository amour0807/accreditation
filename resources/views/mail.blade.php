<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US">
    <head>
      <title>Alumni</title>
      <meta  charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
             <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="csrf-token" content="{{ csrf_token() }}">
         <!-- Datatables -->
    <link rel="icon" type="image/png" href="images/favicon.ico"/>
  <style>
  
  body, .container, .body, .nav-md{
    background-color: #fff;
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
  .nav.side-menu>li.active>a {
    background-color:rgba(77, 23, 23, 0.06);
    color: white;
  }
  table.jambo_table thead {
      background:#2f333e;
    color: #ECF0F1;
  }
  </style>
  </head>
  </head>
  <body>
    <!-- price element -->
    <div class="col-md-12 col-sm-12  ">
      <div class="pricing">
        <div class="title">
          <h2>December 2020 Graduating Students </h2>
          <h1>Information and Feedback Form</h1>
        </div>
        <div class="x_content">
          <div class="">
            <div class="pricing_features">
              <div class="pricing_features">
                <p>Congratulation on your upcoming graduation!</p>

                <p>  The University of Baguio maintains an Alumni Database which contains the personal information including the contact details of all graduates. We use these data to disseminate information to the alumni, and for recruitment purposes (if permitted by the alumnus). </p>
                  
                <p>  Since you will be part of the UB Alumni very soon, may we request you to fill out this form and entrust to us your contact details? Also, we would like to take this opportunity to get your feedback and suggestions. These will help us improve our services, and the delivery of the different academic programs that UB offers.</p>

                <p>  All feedback will be collated and will be furnished to concerned offices with the names of the respondents treated anonymously.</p>

                 <p> All data gathered will be processed in accordance with the Data Privacy Policy of the University of Baguio which is accessible at the UB website.  </p>
             
            </div>
            </div>
          </div>
          <div class="pricing_footer">
            <h2><a href="{{url('http://192.168.51.2/Accreditation/public/alumni')}}" class="btn btn-success btn-block" role="button">Evaluate <span> now!</span></a><h2>
          </div>
        </div>
      </div>
    </div>
    <!-- price element -->
  </body>
</html>