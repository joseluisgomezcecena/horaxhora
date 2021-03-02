<?php 

$query = "SELECT * FROM users WHERE user_name = '{$_SESSION['report_user_name']}'";
$result = mysqli_query($connection, $query);
if($result)
{
    $row = mysqli_fetch_array($result);
}
else
{
    die("There was an unexpected error: $query <br><a href='index.php'>Go back</a>");
}

//Functions
editarPerfil();



?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Editar mi perfil</h1>


<div class="">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Editando el perfil de <?php echo $_SESSION['report_user_name'] ?></h6>
        </div>
        <div class="card-body">
        
            <!---form--->

            <form role="form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       
                        <div class="form-group row">
                            
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="login_input_email">Email</label>
                                <input id="login_input_email" class="login_input form-control" type="email" name="user_email" required value="<?php echo $row['user_email'] ?>" />
                            </div>
                            
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="login_input_username">Nombre</label>
                                <input id="login_input_username" class="login_input form-control" type="text"  name="nombre" value="<?php echo $row['user_nombre'] ?>" required />
                            </div>

                            <div class=" col-lg-3">
                                <!-- the user name input field uses a HTML5 pattern check -->
                                <label for="login_input_username">Apellido</label>
                                <input id="login_input_username" class="login_input form-control" type="text"  name="apellido" value="<?php echo $row['user_apellido'] ?>" required />
                            </div>

                            <div class=" col-lg-3">
                                <!-- the user name input field uses a HTML5 pattern check -->
                                <label for="login_input_username">Numero de empleado</label>
                                <input id="login_input_username" class="login_input form-control" type="text"  name="empleado" value="<?php echo $row['user_numero'] ?>" required />
                            </div>

                        </div>


                        
                        <div class="form-group row">

                            



                            <div class="form-group col-lg-4">
                                <label for="login_input_password_new">Contraseña (6 caracteres min)</label>
                                <input id="login_input_password_new" class="login_input form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="login_input_password_repeat">Repetir contraseña</label>
                                <input id="login_input_password_repeat" class="login_input form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
                            </div>

                        </div>


                        <div class="form-group row">
                            <div class="input-group col-lg-6">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        Buscar&hellip; <input type="file" style="display: none;" name="profile_pic" onchange="readURL(this);">
                                    </span>
                                </label>
                                <input type="text" class="form-control" placeholder="Profile picture" readonly>
                            </div>

                        
                            <div class="col-lg-6 text-center center-block">                
                                <br><br/>
                                <img class="img-thumbnail text-center center center-block img-fluid rounded-circle" style="width:50%; margin-top:-50px;" id="blah" src="<?php if($row['profile_pic'] == ""){echo "views/assets/img/noimage.png";}else {echo $row['profile_pic'];} ?>" alt="your image" />
                            </div>

                        
                        </div>



                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="form-group row">
                            <div class="form-group col-lg-12">
                                <input type="submit" class="btn btn-primary btn-flat" name="submit" value="Guardar" />
                            </div>
                        </div>
                    </div>
                </form>
            


        
            <!---form--->
        
        </div>
    </div>

</div>


