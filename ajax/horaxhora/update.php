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

?>