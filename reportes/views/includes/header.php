<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Production Reports</title>

  <!-- Custom fonts for this template-->
  <link href="views/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="views/assets/css/sb-admin-2.css" rel="stylesheet">

   <!-- Data Tables styles for this page -->
   <link href="views/assets/vendor/datatables/buttons.css" rel="stylesheet">

    <!--Particles js -->
    <link href="views/assets/particles/particles.css" rel="stylesheet">

    <!-- Dropzone js -->
    <link href="views/assets/vendor/dropzone/dropzone.css" rel="stylesheet">

    <link href="views/assets/vendor/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">

    <script src="views/assets/vendor/sweetalert/sweetalert.js"></script>


    <?php
    if(isset($datatablesop))
    {
        if($datatablesop == 1)
        {
            //datatables normal
            echo "<link href=\"views/assets/vendor/datatables/dataTables.bootstrap4.min.css\" rel=\"stylesheet\">";
        }
        else
        {
            echo
            "<link rel=\"stylesheet\" href=\"views/assets/datatables/buttons.dataTables.min.css\">
            <link rel=\"stylesheet\" href=\"views/assets/datatables/jquery.dataTables.min.css\">";
        }
    }
    else
    {
        //datatables normal
        echo "<link href=\"views/assets/vendor/datatables/dataTables.bootstrap4.min.css\" rel=\"stylesheet\">";

    }
    ?>

  <style>
      .bg-gradient-primary2 {
          background-color: #36b9cc;
          background-image: linear-gradient(180deg, #4e73df 10%, #1cc88a 100%);
          background-size: cover;
      }
      .bg-gradient-primary {
          background-color: #232222;
          background-image: linear-gradient(180deg, #40474c 10%, #343436 100%);
          background-size: cover;
      }

  </style>


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">                                                                                                                       
