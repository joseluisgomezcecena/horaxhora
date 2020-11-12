<?php
require_once("config/config.php");
require_once("config/db.php");
require_once("classes/Login.php");
$login = new Login();

if ($login->isReportUserLoggedIn() == true)
{
    include("views/logged_in.php");
}
else
{
    include("views/not_logged_in.php");
}

?>

