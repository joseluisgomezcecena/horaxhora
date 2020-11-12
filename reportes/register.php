<?php
ob_start();

require_once("config/db.php");

require_once ("config/configuracion.php");


require_once("classes/Login.php");

require_once("classes/Registration.php");

require_once ("includes/header.php");

$registration = new Registration();

include("views/register.php");

//$datatablesop = 1

require_once ("includes/footer.php");
?>
<script>

    $( document ).ready(function() {
        $('#myModal').modal('show');
    });

</script>