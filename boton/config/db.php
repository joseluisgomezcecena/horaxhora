<?php

date_default_timezone_set("America/Tijuana");

define("DB_HOST", "localhost");
define("DB_NAME", "hourxhour");
define("DB_USER", "root");
define("DB_PASS", "");


$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$connection)
{
    die("Error de conexion con base de datos. Hr x Hr");
}



?>