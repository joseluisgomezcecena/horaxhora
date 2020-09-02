<?php  
    include_once("includes/header.php");
    //include_once("includes/sidebar.php");
    include_once("includes/top-menu.php");
    include_once("modals/plant_modal.php");
    
    if(isset($_GET['plant']))
    {
        $plant = $_GET['plant'];
    }
?>

<!-- Page Heading -->
<div id="titulo"><h1 class="h3 mb-4 text-gray-800" style="display: inline">Hora X Hora</h1> <h6 style="display: inline"><?php if(isset($plant)) echo 'Planta '.$plant;?></h6></div>

<div class="col-md-6 offset-md-3 ">
    <div class="card shadow mb-4 ">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Seleccione una opcion</h5>
        </div>
        <div class="card-body">
            <a id="horaxhora" href="horaxhora.php<?php if(isset($plant)) echo '?plant='.$plant;?>" class="btn btn-primary btn-lg btn-block">Hora x Hora</a>
            <a id="cargar" href="cargar_ordenes.php<?php if(isset($plant)) echo '?plant='.$plant;?>" class="btn btn-dark btn-lg btn-block">Cargar Ordenes</a>
            <a id="actual" href="ordenes_actuales.php<?php if(isset($plant)) echo '?plant='.$plant;?>"  class="btn btn-success btn-lg btn-block">Ordenes Actuales</a>
            <a id="completas" href="ordenes_completadas.php<?php if(isset($plant)) echo '?plant='.$plant;?>" class="btn btn-info btn-lg btn-block">Ordenes Completadas</a>
            <a id="reporte" href="reporteA.php<?php if(isset($plant)) echo '?plant='.$plant;?>" class="btn btn-warning btn-lg btn-block">Planeacion</a>
        </div>
    </div>
</div>

<?php 
include_once("includes/footer.php");
?>