<?php

//testing values
/*
define("DB_HOST", "192.168.7.133");
define("DB_NAME", "hourxhour");
define("DB_USER", "jgomez");
define("DB_PASS", "");

define("DB_HOST2", "192.168.7.133");
define("DB_NAME2", "smartstu_martech_dev");
define("DB_USER2", "jgomez");
define("DB_PASS2", "");
*/

//production values
define("DB_HOST", "localhost");
define("DB_NAME", "hourxhour");
define("DB_USER", "root");
define("DB_PASS", "");

define("DB_HOST2", "localhost");
define("DB_NAME2", "smartstu_martech_dev");
define("DB_USER2", "root");
define("DB_PASS2", "");


$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$connection)
{
    die("Error de conexion con base de datos.");
}

$connection2 = mysqli_connect(DB_HOST2, DB_USER2, DB_PASS2, DB_NAME2);
if(!$connection2)
{
    die("Error de conexion con base de datos Andon.");
}

require_once ("functions.php");
require_once ("functions_users_account.php");
require_once ("ajaxpoll.php");
