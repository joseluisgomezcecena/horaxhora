<?php
ob_start(); 
date_default_timezone_set("America/Tijuana");

if(isset($_GET['page']))
    $page = $_GET['page'];
else
    $page = "";
    

    
if($page == "reporte_planta" || $page == "reporte_celda" || $page == "entregas_historico_editar" || $page == "lista_usuarios" || $page == "tool_crib_crud" || $page == "program_list" )
    $datatablesop= 2;
else
    $datatablesop= 1;


?>