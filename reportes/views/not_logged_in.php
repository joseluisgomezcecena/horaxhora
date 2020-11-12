<?php
require_once("views/includes/header.php");
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
          echo "
          <script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function(event) {
              swal('Error!','$error','error');
            });
         </script>
         ";        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
          echo "
          <script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function(event) {
              swal('$message');
            });
         </script>
         ";
        }
    }
}
?>



<body class="bg-gradient-primary">
    <div  class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body bg-login-image-->
            <div class="row">

              <div  style="background-color:#ea4335; background-image: url('views/assets/img/main.jpg'); background-size: cover;" class="col-lg-6 d-none d-lg-block center-block text-center ">
                  <br>
                  <!--
                  <div  id="particles-js"></div>
                -->
              </div>

              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <img style="" class="img-fluid center-block " src="views/assets/img/logocolor.jpg">
                    <br><br>
                    <h1 class="h4 text-gray-900 mb-4">Reportes de producción</h1>
                  </div>
                  <form class="user" method="post" action="index.php" name="loginform" autocomplete="off" role="form">
                      <input style="opacity: 0" type="password">
                    <div class="form-group">
                      <input style="border-radius: 25px;" name="user_name" type="text" class="form-control " id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." autocomplete="false">
                    </div>

                    <div class="form-group">
                      <input style="border-radius: 25px;" name="user_password" type="password" class="form-control " id="exampleInputPassword" placeholder="Password">
                    </div>

                    <br><br><hr><br><br>
                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>

                    <!--
                    <a href="register.php" class="btn btn-google btn-user btn-block">
                      <i class=""></i> Register
                    </a>
                    -->
                    <!--
                    <a href="index.html" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a>
                    -->

                  </form>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
</body>
