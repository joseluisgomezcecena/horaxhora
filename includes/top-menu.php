<?php
if(isset($_GET['plant']))
{
    $plant = $_GET['plant'];
}
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
      <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
      <!-- Nav Item - Menu -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="index.php<?php if(isset($plant)) echo '?plant='.$plant;?>" id="hrxhr-icon" data-toggle="tooltip" title="HoraxHora" aria-haspopup="true" aria-expanded="false" style="font-size: 20px">
        <i class="fas fa-home"></i><br>
        </a>
      </li>
      <!-- Nav Item - HrxHr -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="horaxhora.php<?php if(isset($plant)) echo '?plant='.$plant;?>" id="hrxhr-icon" data-toggle="tooltip" title="HoraxHora" aria-haspopup="true" aria-expanded="false" style="font-size: 20px">
          <i class="fas fa-table"></i><br>
        </a>
      </li>
      <!-- Nav Item - Cargar Ordenes -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="cargar_ordenes.php<?php if(isset($plant)) echo '?plant='.$plant;?>" id="cargar-icon" data-toggle="tooltip" title="Cargar ordenes" aria-haspopup="true" aria-expanded="false" style="font-size: 20px">
          <i class="fas fa-upload"></i><br>
        </a>
      </li>
      <!-- Nav Item - Ordenes Actuales -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="ordenes_actuales.php<?php if(isset($plant)) echo '?plant='.$plant;?>" id="actuales-icon" data-toggle="tooltip" title="Ordenes Actuales" aria-haspopup="true" aria-expanded="false" style="font-size: 20px">
          <i class="fas fa-list"></i><br>
        </a>
      </li>
      <!-- Nav Item - Ordenes Completadas -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="ordenes_completadas.php<?php if(isset($plant)) echo '?plant='.$plant;?>" id="completadas-icon" data-toggle="tooltip" title="Ordenes Completas" aria-haspopup="true" aria-expanded="false" style="font-size: 20px">
          <i class="far fa-check-circle"></i><br>
        </a>
      </li>
      <!-- Nav Item - Planeacion -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="reporteA.php<?php if(isset($plant)) echo '?plant='.$plant;?>" id="planeacion-icon" data-toggle="tooltip" title="Planeacion" aria-haspopup="true" aria-expanded="false" style="font-size: 20px">
          <i class="far fa-clipboard"></i><br>
        </a>
      </li>
      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li id="change-plants" class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cambio de planta <i class="ml-1 fas fa-cogs"></i>
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item plant-1" href="#" >
            <i class="fas fa-angle-right mr-2"></i> Planta 1
          </a>
          <a class="dropdown-item plant-2" href="#">
            <i class="fas fa-angle-right mr-2"></i> Planta 2
          </a>
          <a class="dropdown-item plant-3" href="#">
            <i class="fas fa-angle-right mr-2"></i> Planta 3
          </a>

        </div>
      </li>

    </ul>

  </nav>
  <!-- End of Topbar -->

  <!-- Begin Page Content -->
  <div class="container-fluid">