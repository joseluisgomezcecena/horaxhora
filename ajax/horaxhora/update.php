<<<<<<< HEAD
<?php
require_once("../../_config/db.php");

$maquina = $_POST['maquina'];
$hr      = $_POST['hr'];
$value   = $_POST['value'];

$update = "UPDATE horas SET `$hr` = $value WHERE maquina = '$maquina' ";
$run = mysqli_query($connection, $update);
if(!$run)
{
    echo "Query Failed :".$update;
}
else
{
    echo "Update Success";
}

=======
<?php
require_once("../../_config/db.php");



$update = "UPDATE horas SET ";

>>>>>>> 6b9a48d126bb2404b5928f625229f222f2af51f8
?>