<?php  
include_once("includes/header.php");
//include_once("includes/sidebar.php");
include_once("includes/top-menu.php");
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Hora X Hora</h1>

<div class="col-md-6 offset-md-3 ">
    <div class="card shadow mb-4 ">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Seleccione una opcion</h6>
        </div>
        <div class="card-body">
            <a href="horaxhora.php" class="btn btn-primary btn-lg btn-block">Hora x Hora</a>
            <a href="horaxhora" class="btn btn-dark btn-lg btn-block">Cargar Ordenes</a>
            <a href="horaxhora" class="btn btn-success btn-lg btn-block">Ordenes Actuales</a>
            <a href="horaxhora" class="btn btn-info btn-lg btn-block">Ordenes Completadas</a>
            <a href="horaxhora" class="btn btn-warning btn-lg btn-block">Planeacion</a>
        </div>
    </div>
</div>

<?php 
include_once("includes/footer.php");
?>