<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);


function saveEntry()
{
    global $connection;

    if(isset($_POST['save_entry']))
    {
        $partno         =    mysqli_real_escape_string($connection,$_POST['partno']);
        $lotno          =    mysqli_real_escape_string($connection,$_POST['lotno']);
        $quantity       =    mysqli_real_escape_string($connection,$_POST['quantity']);
        $description    =    mysqli_real_escape_string($connection,$_POST['description']);
        $days           =    mysqli_real_escape_string($connection,$_POST['days']);
        $reason         =    mysqli_real_escape_string($connection,$_POST['reason']);
        $measure        =    mysqli_real_escape_string($connection,$_POST['measure']);
        $date           =    date("Y-m-d");
        $cost           =    mysqli_real_escape_string($connection,$_POST['cost']);

        $user_name      =    $_SESSION['qua_user_name'];

        $select_dept    =    "SELECT * FROM users WHERE user_name = '$user_name'";
        $run            =    mysqli_query($connection, $select_dept);
        $row            =    mysqli_fetch_array($run);
        $dept           =    $row['department_id'];

        $date_end       =  date('Y-m-d', strtotime($date. " + $days days"));


        $query = "INSERT INTO incoming_log (date, date_end ,part, lot, quantity, description, time, responsible, responsible_dept_id, reason, register_date, measure_id, cost)
                  VALUES ('$date', '$date_end', '$partno', '$lotno', '$quantity', '$description', '$days', '$user_name','$dept', '$reason', '$date', $measure, '$cost')";

        $result = mysqli_query($connection, $query);

        if($result)
        {
            //header("Location: index.php?page=new_entry&error=false");
            echo 
            '
            <script>swal("Success!", "Data successfully saved", "success");</script>
            
            ';
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}









function saveEntryAdmin()
{
    global $connection;

    if(isset($_POST['save_entry']))
    {
        $partno         =    mysqli_real_escape_string($connection,$_POST['partno']);
        $lotno          =    mysqli_real_escape_string($connection,$_POST['lotno']);
        $quantity       =    mysqli_real_escape_string($connection,$_POST['quantity']);
        $description    =    mysqli_real_escape_string($connection,$_POST['description']);
        $days           =    mysqli_real_escape_string($connection,$_POST['days']);
        $reason         =    mysqli_real_escape_string($connection,$_POST['reason']);
        $date           =    date("Y-m-d");
        $cost           =    mysqli_real_escape_string($connection,$_POST['cost']);
        $measure        =    mysqli_real_escape_string($connection,$_POST['measure']);




        $user_name      =    $_POST['user_name'];


        $select_dept    =    "SELECT * FROM users WHERE user_name = '$user_name'";
        $run            =    mysqli_query($connection, $select_dept);
        if(mysqli_num_rows($run)>0){
        $row            =    mysqli_fetch_array($run);
        $dept           =    $row['department_id'];
        }
        else{
            $dept       =    mysqli_real_escape_string($connection,$_POST['responsible_dept_id']);

        }
        $date_end       =  date('Y-m-d', strtotime($date. " + $days days"));


        $query = "INSERT INTO incoming_log (date, date_end ,part, lot, quantity, description, time, responsible,
 responsible_dept_id, reason, register_date, cost, measure_id)
  VALUES ('$date', '$date_end', '$partno', '$lotno', '$quantity', '$description', '$days', '$user_name','$dept', '$reason', '$date', '$cost', $measure)";

        $result = mysqli_query($connection, $query);

        if($result)
        {
            //header("Location: index.php?page=new_entry&error=false");
            echo 
            '
            <script>swal("Success!", "Data successfully saved", "success");</script>
            
            ';
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}














function saveUpdate()
{
    global $connection;

    if(isset($_POST['submit']))
    {
        $id             = $_GET['id'];
        $comentarios    = $_POST['comentarios'];
        $u              = $_GET['u'];

        $comentarios = $u.": ".$_POST['comentarios'];

        $query = "INSERT INTO actualizacion (id_incoming, comentarios) VALUES ('$id', '$comentarios')";
        $result = mysqli_query($connection, $query);

        if($result)
        {
            if($u == "client")
            {
              header("Location: index.php?page=client_manage_entries&error=false");
            }
            else
            {
              header("Location: index.php?page=manage_entries&error=false");
            }

        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}



function remove()
{
    global $connection;

    if(isset($_POST['remove']))
    {
        $id             = $_POST['incoming_id'];
        

        $query = "UPDATE incoming_log SET viewed = 1 WHERE incoming_id = $id";
        $result = mysqli_query($connection, $query);

        if($result)
        {
            header("Location: index.php?page=client_manage_entries");
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}




function savePickUp()
{
    global $connection;

    if(isset($_POST['pickup']))
    {
        $id             = $_GET['id'];
        $pickup_date    = date("Y-m-d");
        $pickup_name    = $_POST['pickup_name'];
        $pickup_number  = $_POST['pickup_number'];
        $pickup_by      = $pickup_name." ".$pickup_number;

        $query = "UPDATE incoming_log SET out_quarantine = '1', pickup_date = '$pickup_date', pickup_by = '$pickup_by'  WHERE incoming_id = $id";

        $result = mysqli_query($connection, $query);

        if($result)
        {
           header("Location: index.php?page=manage_entries&error=false");
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}


function returns()
{
    global $connection;

    if(isset($_POST['return']))
    {
        $id             = $_GET['id'];



        $query = "UPDATE incoming_log SET out_quarantine = '0', pickup_date = '0000-00-00'  WHERE incoming_id = $id";

        $result = mysqli_query($connection, $query);

        if($result)
        {
            header("Location: index.php?page=manage_entries&error=false");
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}





function reject()
{
    global $connection;

    if(isset($_POST['reject']))
    {
        $id               = $_GET['id'];
        $user             = $_SESSION['qua_user_name'];
        $rejected_reason  = $_POST['rejected_reason'];


        $query = "UPDATE incoming_log SET rejected = 1, rejected_by = '$user', rejected_reason = '$rejected_reason' WHERE incoming_id = $id";
        $result = mysqli_query($connection, $query);

        if($result)
        {
            header("Location: index.php?page=new_entry_list&error=false");
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}




function accept()
{
    global $connection;

    $user = $_SESSION['qua_user_name'];

    if(isset($_POST['accept']))
    {
        $id             = $_GET['id'];

        //inspection update//
        $idays          = $_POST['days'];
        $icost          = $_POST['cost'];
        $iquantity      = $_POST['quantity'];
        $ilotno         = $_POST['lotno'];

        $inspection_update = "UPDATE incoming_log SET time = '$idays', cost = '$icost', quantity = '$iquantity', lot = '$ilotno' WHERE incoming_id = $id";
        $run_inspection_update = mysqli_query($connection, $inspection_update);
        if(!$run_inspection_update)
        {
            die("Error on: ".$inspection_update);
        }

        $get_data_log     = "SELECT * FROM incoming_log WHERE incoming_id = $id ";
        $run_get_data_log = mysqli_query($connection, $get_data_log);
        $row_get_data_log = mysqli_fetch_array($run_get_data_log);


        $date_end = $row_get_data_log['date_end'];
        $date     = $row_get_data_log['date'];
        $days     = $row_get_data_log['time'];



        $date_received = date("Y-m-d");

        $new_date_end       =  date('Y-m-d', strtotime($date_received. " + $days days"));

        $query = "UPDATE incoming_log SET received = '1', received_by = '$user', date ='$date_received', date_end = '$new_date_end', register_date = '$date'  WHERE incoming_id = $id";

        $result = mysqli_query($connection, $query);

        if($result)
        {
            header("Location: index.php?page=new_entry_list&error=false");
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}










/*
function accept()
{
    global $connection;

    $user = $_SESSION['qua_user_name'];

    if(isset($_POST['accept']))
    {
        $id             = $_GET['id'];

        $get_data_log     = "SELECT * FROM incoming_log WHERE incoming_id = $id ";
        $run_get_data_log = mysqli_query($connection, $get_data_log);
        $row_get_data_log = mysqli_fetch_array($run_get_data_log);


        $date_end = $row_get_data_log['date_end'];
        $date     = $row_get_data_log['date'];
        $days     = $row_get_data_log['time'];





        $date_received = date("Y-m-d");

        $new_date_end       =  date('Y-m-d', strtotime($date_received. " + $days days"));

        $query = "UPDATE incoming_log SET received = '1', received_by = '$user', date ='$date_received', date_end = '$new_date_end', register_date = '$date'  WHERE incoming_id = $id";

        $result = mysqli_query($connection, $query);

        if($result)
        {
            header("Location: index.php?page=new_entry_list&error=false");
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}
*/







function saveAutoMessage()
{
    global $connection;

    if(isset($_POST['save_message']))
    {

        $message = $_POST['message'];

        $query = "INSERT INTO automated_messages (message) VALUES ('$message')";
        $result = mysqli_query($connection, $query);

        if($result)
        {
            header("Location: index.php?page=auto_messages&error=false");
        }
        else
        {
            echo $query;
            //header("Location: index.php?page=new_entry&error=true");
        }

    }
}






function settings()
{
    global $connection;

    if(isset($_POST['submit']))
    {
        $target_file = "";
        $update = 0;
        $previous = "SELECT * FROM settings";
        $run = mysqli_query($connection, $previous);
        if(mysqli_num_rows($run)>0)
        {
            $update = 1;
        }

        $app_name       = $_POST['app_name'];
        $app_refresh    = $_POST['app_refresh']*1000;

        if(empty($_FILES['app_logo'] ['name']))
        {
            $empty = 1;

            if($update == 1)
            {
                $query = "UPDATE settings  SET app_name = '$app_name', app_refresh = '$app_refresh'";
            }
            else
            {
                $query = "INSERT INTO settings (app_name, app_refresh) VALUES ('$app_name', '$app_refresh')";
            }

        }
        else
        {

            $empty = 0;

            $uploadOk = 1;
            $target_dir = "uploads/app/";
            $target_file = $target_dir .rand().basename($_FILES["app_logo"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // repetido
            if (file_exists($target_file))
            {
                //$this->errors[] = "File exists";
                $uploadOk = 0;
            }
            // peso
            if ($_FILES["app_logo"]["size"] > 2000000)
            {
                //$this->errors[] = "Your file is too big, 2MB max";
                $uploadOk = 0;
            }

            // formatos
            if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "JPEG"
                && $imageFileType != "jpeg" && $imageFileType != "PNG" && $imageFileType != "png"
                && $imageFileType != "gif" && $imageFileType != "GIF")
            {
                //$this->errors[] = "Only jpg, png and gif formats are supported.";
            }

            if($uploadOk == 1)
            {

                if (move_uploaded_file($_FILES["app_logo"]["tmp_name"], $target_file))
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

            if($update == 1)
            {
                $query = "UPDATE settings SET app_name = '$app_name', app_refresh = '$app_refresh', app_logo = '$target_file'";
            }
            else
            {
                $query = "INSERT INTO settings (app_name, app_refresh, app_logo) VALUES ('$app_name', '$app_refresh', '$target_file')";
            }
        }



        $result = mysqli_query($connection, $query);

        if($result)
        {
            //echo "sesapp".$_SESSION['app'];
            //echo "<Br>$app_name";
            header("Location: index.php?page=settings&success=1");
        }
        else
        {
            header("Location: index.php?page=settings&success=0");
        }
    }
}





//AGREGAR CATEGORIAS
function addCat()
{
    global $connection;

    if(isset($_POST['submit']))
    {
        $name = $_POST['name'];

        $query = "INSERT INTO categorias (name) VALUES ('$name')";
        $result = mysqli_query($connection, $query);
        if($result)
        {
            header("Location: index.php?page=admin_categorias&success=true");
        }
        else
        {
            header("Location: index.php?page=admin_categorias&success=false&q=$query");
        }
    }
}

//EIDTAR CATEGORIAS
function editCat()
{
    global $connection;

    if(isset($_POST['edit']))
    {
        $id = $_GET['id'];
        $name = $_POST['name'];

        $query = "UPDATE categorias SET name='$name' WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if($result)
        {
            header("Location: index.php?page=admin_categorias&success=true");
        }
        else
        {
            header("Location: index.php?page=admin_categorias&success=false&q=$query");
        }
    }
}


//BORRAR CATEGORIAS
function deleteCat()
{
    global $connection;

    if(isset($_POST['delete']))
    {
        $id = $_GET['id'];

        $query = "DELETE FROM categorias WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if($result)
        {
            header("Location: index.php?page=admin_categorias&success=true");
        }
        else
        {
            header("Location: index.php?page=admin_categorias&success=false&q=$query");
        }
    }
}






//AGREGAR DEPARTAMENTOS
function addDep()
{
    global $connection;

    if(isset($_POST['save_dep']))
    {

        $name = $_POST['name'];

        $query = "INSERT INTO departamentos (name) VALUES ('$name')";
        $result = mysqli_query($connection, $query);
        if($result)
        {
            //header("Location: index.php?page=departments&success=true");
            echo 
            '
            <script>swal("Success!", "Data successfully saved", "success");</script>
            
            ';
        }
        else
        {
            //header("Location: index.php?page=departments&success=false&q=$query");
            echo 
            '
            <script>swal("Error!", "Something went wrong", "error");</script>
            
            ';
        }
    }
}


//EDITAR DEPARTAMENTOS
function editDep()
{
    global $connection;

    if(isset($_POST['edit_dep']))
    {
        $id = $_GET['id'];
        $name = $_POST['name'];

        $query = "UPDATE departamentos SET name='$name' WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if($result)
        {
           
            header("Location: index.php?page=departments&success=true");
        }
        else
        {
           
            header("Location: index.php?page=departments&success=false&q=$query");
        }
    }
}


//BORRAR DEPARTAMENTOS
function deleteDep()
{
    global $connection;

    if(isset($_POST['delete_dep']))
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];

            $query = "DELETE FROM departamentos WHERE id = $id";
            $result = mysqli_query($connection, $query);
            if($result)
            {
                
                header("Location: index.php?page=departments&success=true");
            }
            else
            {
               
                header("Location: index.php?page=departments&success=false&q=$query");
            }
        }
        
    }
}





//AGREGAR SUBDEPARTAMENTOS
function addSubDep()
{
    global $connection;

    if(isset($_POST['submit']))
    {

        $name = $_POST['name'];
        $department_id = $_POST['department_id'];

        $query = "INSERT INTO subdepartamentos (name, departamento_id) VALUES ('$name', '$department_id')";
        $result = mysqli_query($connection, $query);
        if($result)
        {
            header("Location: index.php?page=admin_subdepartamentos&success=true");
        }
        else
        {
            header("Location: index.php?page=admin_subdepartamentos&success=false&q=$query");
        }
    }
}


//EDITAR SUBDEPARTAMENTOS
function editSubDep()
{
    global $connection;

    if(isset($_POST['edit']))
    {
        $id = $_GET['id'];
        $name = $_POST['name'];
        $department_id = $_POST['department_id'];

        $query = "UPDATE subdepartamentos SET name = '$name', departamento_id = '$department_id' WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if($result)
        {
            header("Location: index.php?page=admin_subdepartamentos&success=true");
        }
        else
        {
            header("Location: index.php?page=admin_subdepartamentos&success=false&q=$query");
        }
    }
}


//BORRAR SUBDEPARTAMENTOS
function deleteSubDep()
{
    global $connection;

    if(isset($_POST['delete']))
    {
        $id = $_GET['id'];

        $query = "DELETE FROM subdepartamentos WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if($result)
        {
            header("Location: index.php?page=admin_subdepartamentos&success=true");
        }
        else
        {
            header("Location: index.php?page=admin_subdepartamentos&success=false&q=$query");
        }
    }
}





