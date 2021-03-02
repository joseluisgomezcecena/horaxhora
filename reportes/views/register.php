<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            //echo $error;
            $modal = <<< DELIMITER
                     <!-- Modal -->
                     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">System Message</h5>
                                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">×</span>
                                 </button>
                             </div>
                             <div class="modal-body">$error</div>
                             <div class="modal-footer">
                                 <button class="btn btn-secondary" type="button" data-dismiss="modal">OK</button>
                             <!--    
                                 <a class="btn btn-primary" href="login.html">Logout</a>
                             -->
                             </div>
                         </div>
                     </div>
                 </div>
DELIMITER;
            echo $modal;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            //echo $message;
            $modal = <<< DELIMITER
                     <!-- Modal -->
                     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">System Message</h5>
                                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">×</span>
                                 </button>
                             </div>
                             <div class="modal-body">$message</div>
                             <div class="modal-footer">
                                 <button class="btn btn-secondary" type="button" data-dismiss="modal">OK</button>
                             <!--    
                                 <a class="btn btn-primary" href="login.html">Logout</a>
                             -->
                             </div>
                         </div>
                     </div>
                 </div>
DELIMITER;
            echo $modal;
        }
    }
}
?>

<!-- register form -->


<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body  bg-register-image-->
        <div class="row">
          <div style="background-color:#4287f5; background-image: linear-gradient(180deg, #41146f 10%, #ef4223 100%);"" class="col-lg-5 d-none d-lg-block "><div id="particles-js"></div></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>

              <form class="user" role="form" method="post" action="register.php" name="registerform" enctype="multipart/form-data">

              
                    <div class="form-group">
                        <input name="user_name" type="text"  pattern="[a-zA-Z0-9]{2,64}"  class="form-control form-control-user" id="user_name" placeholder="User Name, only letters and numbers no spaces">
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input name="nombre" type="text" class="form-control form-control-user"  placeholder="First Name">
                        </div>

                        <div class="col-sm-6">
                            <input name="apellido" type="text" class="form-control form-control-user"  placeholder="Last Name">
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input name="empleado" type="text" class="form-control form-control-user" placeholder="Employee No.">
                        </div>

                        <div class="col-sm-6">
                            <select style="border-radius: 10rem; height:50px;"  name="departamento"  class="form-control form-control-user-two " id="exampleLastName">
                                <option value="">Select</option>    
                                <?php
                                $q = "SELECT * FROM departamentos";
                                $r = mysqli_query($connection, $q);
                                while($row = mysqli_fetch_array($r)):
                                ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>





                    <div class="form-group">
                        <input name="user_email" type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input name="user_password_new" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                        </div>

                        <div class="col-sm-6">
                            <input name="user_password_repeat" type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="input-group col-lg-6">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    Browse&hellip; <input type="file" style="display: none;" name="profile_pic" onchange="readURL(this);">
                                </span>
                            </label>
                            <input type="text" class="form-control" placeholder="Profile picture" readonly>
                        </div>

                        
                        <div class="col-sm-6 text-center center-block">                
                            <br><br/>
                            <img class="thumbnail text-center center center-block" style="width:100%; border-radius:50%;" id="blah" src="assets/img/noimage.png" alt="your image" />
                        </div>

                        
                    </div>


                    <button name="register" class="btn btn-primary btn-user btn-block">
                    Register Account
                    </button>


               

              </form>

              <hr>

              <div class="text-center">
                <a class="small" href="index.php">Already have an account? Login!</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</body>
