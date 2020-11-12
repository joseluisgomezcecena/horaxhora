<?php
/**
 * Created by PhpStorm.
 * User: josel
 * Date: 8/10/2017
 * Time: 7:08 PM
 */





function newUser()
{
    global $connection;

    if(isset($_POST['register']))
    {
        $error1 = "";
        $error2 = "";
        $error3 = "";
        $error4 = "";
        $error5 = "";


        $update             = $_POST['update'];

        if(isset($_GET['id']))
        {

            $id = $_GET['id'];
        }

        $user_name          = $_POST['user_name'];
        $email              = $_POST['user_email'];
        $passnew            = $_POST['user_password_new'];
        $passrep            = $_POST['user_password_repeat'];
        $nombre             = $_POST['nombre'];
        $apellido           = $_POST['apellido'];
        $user_numero        = $_POST['user_numero'];
        $is_admin           = 0;

       



        if($update == 1)
        {
            //editar

            if(empty($_FILES['profile_pic'] ['name']))
            {
                $status_ok = 1;
                $query = mysqli_query($connection,"SELECT user_email FROM users WHERE user_name != '$user_name' AND user_email = '$email'");
                if(mysqli_num_rows($query)>0)
                {
                    //echo "Email already in use";
                    $status_ok = 0;
                }
                if($passnew != $passrep)
                {
                    //echo "Passwords dont match";
                    $status_ok = 0;
                }

                if($status_ok == 1)
                {
                    //encrypt password
                    $user_password_hash = password_hash($passnew, PASSWORD_DEFAULT);

                    $insert = "UPDATE users SET user_email = '$email', user_password_hash = '$user_password_hash',
                    user_nombre = '$nombre', user_apellido = '$apellido', user_numero = '$user_numero', 
                    isadmin = '$is_admin' WHERE user_id = $id";

                    $result = mysqli_query($connection, $insert);

                    if($result)
                    {
                        
                        echo 
                        '
                        <script>swal("Exito!", "Datos guardados", "success");</script>
                        
                        ';
                    }
                    else
                    {
                        
                        echo 
                        '
                        <script>swal("Error!", "Hubo un error al insertar los datos", "error");</script>
                        
                        ';
                    }
                }
                else
                {
                    //echo "Fallo validacion sin archivo";
                    //header("Location: index.php?page=new_user&success=0&validation");
                    echo 
                    '
                    <script>swal("Error!", "Verifique que los datos son correctos e intente de nuevo", "error");</script>
                    
                    ';
                }

            }
            else
            {
                $uploadOk = 1;
                $status_ok = 1;
                $target_dir = "uploads/profiles/";
                $target_file = $target_dir .rand().basename($_FILES["profile_pic"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // repetido
                if (file_exists($target_file))
                {
                    $error1 = "File exists";
                    $uploadOk = 0;
                    $status_ok = 0;
                }
                // peso
                if ($_FILES["profile_pic"]["size"] > 2000000)
                {
                    $error2 = "Your file is too big, 2MB max";
                    $uploadOk = 0;
                    $status_ok = 0;
                }

                // formatos
                if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "JPEG"
                    && $imageFileType != "jpeg" && $imageFileType != "PNG" && $imageFileType != "png"
                    && $imageFileType != "gif" && $imageFileType != "GIF")
                {
                    $error3 = "Only jpg, png and gif formats are supported.";
                    $uploadOk = 0;
                }


                if ($uploadOk == 0)
                {
                    $status_ok = 0;
                }
                else
                {

                    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file))
                    {
                        $uploadOk = 1;
                        $status_ok = 1;
                    }
                    else
                    {
                        $uploadOk = 0;
                        $status_ok = 0;
                    }
                }


                $query = mysqli_query($connection,"SELECT user_email FROM users WHERE user_name != '$user_name' AND user_email = '$email'") ;
                if(mysqli_num_rows($query)>0)
                {
                    $error4 =  "Email already in use";
                    $status_ok = 0;
                }
                if($passnew != $passrep)
                {
                    $error5 =  "Passwords dont match";
                    $status_ok = 0;
                }

                if($status_ok == 1)
                {

                    //encrypt password
                    $user_password_hash = password_hash($passnew, PASSWORD_DEFAULT);

                    $edit = "UPDATE users SET user_email = '$email', user_password_hash = '$user_password_hash', user_nombre = '$nombre',
                    user_apellido = '$apellido', user_numero = '$user_numero',  user_name = '$user_name',
                     profile_pic = '$target_file', isadmin = '$is_admin' WHERE user_id = $id" ;

                    $result = mysqli_query($connection, $edit);

                    if($result)
                    {
                        echo 
                        '
                        <script>swal("Exito!", "Los datos fueron guardados", "success");</script>
                        
                        ';
                    }
                    else
                    {
                        echo "Falla la insertada con archivo $edit";
                        //header("Location: index.php?page=editar_perfil&success=0&q=$edit");
                    }

                }
                else
                {
                    echo "Fallo validacion: $error1 $error2 $error3 $error4 $error5 ";
                    //header("Location: index.php?page=editar_perfil&success=0");
                }

        }


        //editar end
        }
        else
        {

            //insertar
            if(empty($_FILES['profile_pic'] ['name']))
            {
                $status_ok = 1;
                $query = mysqli_query($connection,"SELECT user_email FROM users WHERE user_name != '$user_name' AND user_email = '$email'");
                if(mysqli_num_rows($query)>0)
                {
                    //echo "Email already in use";
                    $status_ok = 0;
                }
                if($passnew != $passrep)
                {
                    //echo "Passwords dont match";
                    $status_ok = 0;
                }

                if($status_ok == 1)
                {
                    //encrypt password
                    $user_password_hash = password_hash($passnew, PASSWORD_DEFAULT);

                    $insert = "INSERT INTO users (user_email, user_password_hash, user_nombre, user_apellido, user_numero, user_name, isadmin)
                    VALUES ('$email',  '$user_password_hash',  '$nombre',  '$apellido',  '$user_numero',  '$user_name', '$is_admin' )";

                    $result = mysqli_query($connection, $insert);

                    if($result)
                    {
                        //echo "insertado sin archivo";
                        //header("Location: index.php?page=new_user&success=1");
                        echo 
                        '
                        <script>swal("Exito!", "Los datos fueron guardados", "success");</script>
                        
                        ';
                    }
                    else
                    {
                        echo "Falla la insertada".$insert;
                        //header("Location: index.php?page=new_user&success=0");
                    }
                }
                else
                {
                    //echo "Fallo validacion sin archivo";
                    //header("Location: index.php?page=new_user&success=0");
                    echo 
                    '
                    <script>swal("Error!", "Check all fields and try again", "error");</script>
                    
                    ';
                }

            }
            else
            {
                $uploadOk = 1;
                $status_ok = 1;
                $target_dir = "uploads/profiles/";
                $target_file = $target_dir .rand().basename($_FILES["profile_pic"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // repetido
                if (file_exists($target_file))
                {
                    $error1 = "File exists";
                    $uploadOk = 0;
                    $status_ok = 0;
                }
                // peso
                if ($_FILES["profile_pic"]["size"] > 2000000)
                {
                    $error2 = "Your file is too big, 2MB max";
                    $uploadOk = 0;
                    $status_ok = 0;
                }

                // formatos
                if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "JPEG"
                    && $imageFileType != "jpeg" && $imageFileType != "PNG" && $imageFileType != "png"
                    && $imageFileType != "gif" && $imageFileType != "GIF")
                {
                    $error3 = "Only jpg, png and gif formats are supported.";
                    $uploadOk = 0;
                }

                if ($uploadOk == 0)
                {
                    $status_ok = 0;
                }
                else
                {
                    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file))
                    {
                        $uploadOk = 1;
                        $status_ok = 1;
                    }
                    else
                    {
                        $uploadOk = 0;
                        $status_ok = 0;
                    }
                }


                $query = mysqli_query($connection,"SELECT user_email FROM users WHERE user_name != '$user_name' AND user_email = '$email'") ;
                if(mysqli_num_rows($query)>0)
                {
                    $error4 =  "Email already in use";
                    $status_ok = 0;
                }
                if($passnew != $passrep)
                {
                    $error5 =  "Passwords dont match";
                    $status_ok = 0;
                }

                if($status_ok == 1)
                {

                    //encrypt password
                    $user_password_hash = password_hash($passnew, PASSWORD_DEFAULT);

                    $edit = "INSERT INTO users (user_email, user_password_hash, user_nombre, user_apellido, user_numero,  user_name, profile_pic, isadmin)
                    VALUES ('$email',  '$user_password_hash',  '$nombre',  '$apellido',  '$user_numero',   '$user_name', '$target_file', '$is_admin')";

                    $result = mysqli_query($connection, $edit);

                    if($result)
                    {
                        $_SESSION['cbt_profile_pic'] = $target_file;
                        echo 
                        '
                        <script>swal("Exito!", "Los datos fueron guardados con exito", "success");</script>
                        
                        ';
                    }
                    else
                    {
                        echo "Falla la insertada con archivo";
                        //header("Location: index.php?page=new_user&success=0&query=$edit&status=$status_ok");
                    }
                }
                else
                {
                     //echo "Fallo validacion: $error1 $error2 $error3 $error4 $error5 ";
                    //header("Location: index.php?page=editar_perfil&success=0");
                    echo 
                    '
                    <script>swal("Error!", "Verifique todos los campos e intente de nuevo", "error");</script>
                    
                    ';
                }

            }


            //insertar end

        }
    }
}




function toEliminarUsuario()
{
    if(isset($_POST['delete']))
    {
        
        $id = $_POST['user_id'];
            
        header("Location: index.php?page=confirm_delete&id=$id");
        
    }
}




function editarPerfil()
{
    global $connection;

    if(isset($_POST['submit']))
    {

        //common vars
        $usuario      = $_SESSION['report_user_name'];
        $email        = $_POST['user_email'];
        $passnew      = $_POST['user_password_new'];
        $passrep      = $_POST['user_password_repeat'];
        $nombre       = $_POST['nombre'];
        $apellido     = $_POST['apellido'];
        $empleado     = $_POST['empleado'];


        if(empty($_FILES['profile_pic'] ['name']))
        {
            $status_ok = 1;
            $query = mysqli_query($connection,"SELECT user_email FROM users WHERE user_name != '$usuario' AND user_email = '$email'") ;
            if(mysqli_num_rows($query)>0)
            {
                echo "Email already in use";
                $status_ok = 0;
            }
            if($passnew != $passrep)
            {
                echo "Passwords dont match";
                $status_ok = 0;
            }

            if($status_ok == 1)
            {
                //encrypt password
                $user_password_hash = password_hash($passnew, PASSWORD_DEFAULT);

                $edit = "UPDATE users SET user_email = '$email', user_password_hash = '$user_password_hash', user_nombre = '$nombre', user_apellido = '$apellido', user_numero = '$empleado' WHERE user_name = '$usuario'";
                $result = mysqli_query($connection, $edit);

                if($result)
                {
                    //echo "insertado sin archivo";
                    //header("Location: index.php?page=editar_perfil&success=1");
                    echo 
                    '
                    <script>swal("Success!", "Data successfully saved", "success");</script>
                    
                    ';
                }
                else
                {
                    //echo "Falla la insertada";
                    echo $edit;
                    //header("Location: index.php?page=editar_perfil&success=0");
                }
            }
            else
            {
                //echo "Fallo validacion sin archivo";
                header("Location: index.php?page=editar_perfil&success=0&aqui");
            }

        }
        else
        {
            $uploadOk = 1;
            $status_ok = 1;
            $target_dir = "uploads/profiles/";
            $target_file = $target_dir .rand().basename($_FILES["profile_pic"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // repetido
            if (file_exists($target_file))
            {
                //$this->errors[] = "File exists";
                $uploadOk = 0;
                $status_ok = 0;
            }
            // peso
            if ($_FILES["profile_pic"]["size"] > 2000000)
            {
                //$this->errors[] = "Your file is too big, 2MB max";
                $uploadOk = 0;
                $status_ok = 0;
            }

            // formatos
            if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "JPEG"
            && $imageFileType != "jpeg" && $imageFileType != "PNG" && $imageFileType != "png"
            && $imageFileType != "gif" && $imageFileType != "GIF")
            {
                //$this->errors[] = "Only jpg, png and gif formats are supported.";
            }


            if ($uploadOk == 0)
            {
                $status_ok = 0;
            }
            else
            {
                $uploadOk = 1;
                $status_ok = 1;
                if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file))
                {
                }
                else
                {
                }
            }


            $query = mysqli_query($connection,"SELECT user_email FROM users WHERE user_name != '$usuario' AND user_email = '$email'") ;
            if(mysqli_num_rows($query)>0)
            {
                //echo "Email already in use";
                $status_ok = 0;
            }
            if($passnew != $passrep)
            {
                //echo "Passwords dont match";
                $status_ok = 0;
            }

            if($status_ok == 1)
            {

                //encrypt password
                $user_password_hash = password_hash($passnew, PASSWORD_DEFAULT);

                $edit = "UPDATE users SET user_email = '$email', user_password_hash = '$user_password_hash', user_nombre = '$nombre', user_apellido = '$apellido', user_numero = '$empleado', profile_pic = '$target_file' WHERE user_name = '$usuario'";
                $result = mysqli_query($connection, $edit);

                if($result)
                {
                    $_SESSION['cbt_profile_pic'] = $target_file;
                    //echo "insertado con archivo";
                    //header("Location: index.php?page=editar_perfil&success=1");
                    echo 
                    '
                    <script>swal("Success!", "Data successfully saved", "success");</script>
                    
                    ';
                }
                else
                {
                    //echo "Falla la insertada con archivo";
                    header("Location: index.php?page=editar_perfil&success=0");
                }

            }
            else
            {
               // echo "Fallo validacion";
               header("Location: index.php?page=editar_perfil&success=0");
            }

        }//end else archivo

    }

}
