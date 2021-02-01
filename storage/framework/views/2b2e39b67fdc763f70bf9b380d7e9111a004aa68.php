<meta  charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
   
           <title>QAO File Management System</title>
           <link rel="icon" href="<?php echo e(asset('images/favicon.ico')); ?>" type="image/ico">
   
            <!-- Bootstrap -->
<!--             
            <link href="<?php echo e(asset('css/jquery.dataTables.min.css')); ?>" rel="stylesheet"> -->
            <link href="<?php echo e(asset('new/vendors/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
            <!-- Font Awesome -->
            <link href="<?php echo e(asset('new/vendors/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
            <!-- NProgress -->
            <link href="<?php echo e(asset('new/vendors/nprogress/nprogress.css')); ?>" rel="stylesheet">
            <!-- iCheck -->
            <link href="<?php echo e(asset('new/vendors/iCheck/skins/flat/green.css')); ?>" rel="stylesheet">
            <!-- Datatables -->
            
            <link href="<?php echo e(asset('new/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet">
            <link href="<?php echo e(asset('new/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')); ?>" rel="stylesheet">
            <link href="<?php echo e(asset('new/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')); ?>" rel="stylesheet">
            <link href="<?php echo e(asset('new/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')); ?>" rel="stylesheet">
            <link href="<?php echo e(asset('new/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')); ?>" rel="stylesheet">

            <!-- Custom Theme Style -->

            <link href="<?php echo e(asset('new/build/css/custom.min.css')); ?>" rel="stylesheet">
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
    font-size: 13px;
}
.dataTables_wrapper {
    font-family: tahoma;
    font-size: 12px;
}
</style> <?php /**PATH C:\xampp\htdocs\Accreditation\resources\views/include/head.blade.php ENDPATH**/ ?>