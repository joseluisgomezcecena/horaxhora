<?php 
require_once("views/includes/header.php");
require_once("views/includes/sidebar.php");
require_once("views/includes/topmenu.php");

switch($page)
{

    case "reporte_planta":
        include("pages/reportes/reporte_planta.php");
    break;

    case "reporte_celda":
        include("pages/reportes/reporte_celda.php");
    break;

    case "new_user":
        include("pages/usuarios/new_user.php");
    break;

    case "user_list":
        include("pages/usuarios/user_list.php");
    break;

    case "confirm_delete":
        include("pages/usuarios/confirm_delete.php");
    break;

    case "editar_perfil":
        include("pages/perfil/editar_perfil.php");
    break;

    default:
        include("pages/default.php");
    break;
}



require_once("views/includes/footer.php"); 
?>
