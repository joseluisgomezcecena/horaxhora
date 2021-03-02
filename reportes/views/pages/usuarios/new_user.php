<?php
$update = 0;
if(isset($_GET['id']))
{
    $update = 1;
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE user_id= $id";
    $result = mysqli_query($connection, $query);
    if($result)
    {
        $row = mysqli_fetch_array($result);
    }
    else
    {
        die("Ocurrio un error: $query <br><a href='index.php'>Volver</a>");
    }
}




//Functions
newUser();
//modals
if(isset($_GET['success']))
{
    if($_GET['success'] == 1)
    {
        include("modals/states/success.php");
    }
    else
    {
        include("modals/states/error.php");
    }
}

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?php if($update == 1){echo "Actualizando datos";}else{echo "Registrar usuario";} ?></h1>


<div class="">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php if($update == 1){echo "Actualizando datos de: {$row['user_name']}";}else{echo "Registro de usuarios";} ?></h6>
        </div>
        <div class="card-body">

            <!---form--->

            <form role="form" method="post" enctype="multipart/form-data">
                <div class="box-body">

                    <div class="form-group row">

                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <label for="login_input_email">Usuario (Solo numeros y letras)</label>
                            <input id="login_input_email" class="login_input form-control" type="text" name="user_name" <?php if($update == 1){echo "";}else{echo "required";}  ?> <?php if($update == 1){echo "readonly";}else{echo "";}  ?>  value="<?php if($update == 1){echo $row['user_name'];}else{echo "";}  ?>" />
                        </div>


                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <label for="login_input_email">Email</label>
                            <input id="login_input_email" class="login_input form-control" type="email" name="user_email" required value="<?php if($update == 1){echo $row['user_email'];}else{echo "";}  ?>" />
                        </div>

                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <label for="login_input_username">Nombre</label>
                            <input id="login_input_username" class="login_input form-control" type="text"  name="nombre" value="<?php if($update == 1){echo $row['user_nombre'];}else{echo "";}  ?>" required />
                        </div>

                        <div class=" col-lg-3">
                            <!-- the user name input field uses a HTML5 pattern check -->
                            <label for="login_input_username">Apellido</label>
                            <input id="login_input_username" class="login_input form-control" type="text"  name="apellido" value="<?php if($update == 1){echo $row['user_apellido'];}else{echo "";}  ?>" required />
                        </div>



                    </div>



                    <div class="form-group row">


                        <div class=" col-lg-3">
                            <!-- the user name input field uses a HTML5 pattern check -->
                            <label for="login_input_username">Numero de empleado</label>
                            <input id="login_input_username" class="login_input form-control" type="text"  name="user_numero" value="<?php if($update == 1){echo $row['user_numero'];}else{echo "";}  ?>" required />
                        </div>


                        

                        <div class="form-group col-lg-3">
                            <label for="login_input_password_new">Contraseña (6 caracteres min)</label>
                            <input id="login_input_password_new" class="login_input form-control" type="password" name="user_password_new" pattern=".{6,}" <?php if($update == 1){echo "";}else{echo "required"; } ?> autocomplete="off" />
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="login_input_password_repeat">Repetir contraseña</label>
                            <input id="login_input_password_repeat" class="login_input form-control" type="password" name="user_password_repeat" pattern=".{6,}" <?php if($update == 1){echo "";}else{echo "required"; } ?>autocomplete="off" />
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
                            <img class="img-thumbnail text-center center center-block img-fluid rounded-circle" style="width:50%; margin-top:-50px;" id="blah" src="<?php if($update == 1){if($row['profile_pic'] == ""){echo "views/assets/img/noimage.png";}else {echo $row['profile_pic'];}}else{echo "views/assets/img/noimage.png";}  ?>" alt="your image" />
                        </div>


                    </div>



                    <input type="hidden" name="update" value="<?php echo $update ?>">

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <div class="form-group row">
                        <div class="form-group col-lg-12">
                            <input type="submit" class="btn btn-primary btn-flat" name="register" value="Guardar" />
                        </div>
                    </div>
                </div>
            </form>




            <!---form--->

        </div>
    </div>

</div>


