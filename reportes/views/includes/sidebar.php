 <!-- Sidebar -->
 <!--
  <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
  -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">




<!-- Sidebar - Brand -->
<li style="background-color: #212424" class="nav-item">

  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
  <div  class="sidebar-brand-icon">

    <img class="img-fluid" src="views/assets/img/whitelogo.png">

  </div>

    <div class="sidebar-brand-text mx-3">

    </div>
</a>
</li>

<!-- Divider
<hr class="sidebar-divider my-0">
-->

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
  <a class="nav-link" href="index.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>


<br>
<!-- Heading -->
<div class="sidebar-heading">
  Interface
</div>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-clock"></i>
            <span>Reportes de produccion</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Reportes:</h6>
                <a class="collapse-item" href="index.php?page=reporte_planta">Plantas</a>
                <a class="collapse-item" href="index.php?page=reporte_celda">Celdas</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts
    <li class="nav-item">
        <a class="nav-link" href="index.php?page=completed">
            <i class="fas fa-fw fa-check"></i>
            <span>Completed trainings</span></a>
    </li>
    -->
    






        <?php 
        if($_SESSION['report_isadmin'] == 1){
        ?>

         <!-- Heading -->
         <div class="sidebar-heading">
             Admins
         </div>

         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-user"></i>
                 <span>Usuarios</span>
             </a>
             <div id="collapseUsers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header">Administrar:</h6>
                     <a class="collapse-item" href="index.php?page=new_user">Registrar usuarios</a>
                     <a class="collapse-item" href="index.php?page=user_list">Administrar/Ver lista</a>
                     <div class="collapse-divider"></div>
                 </div>
             </div>
         </li>
        <?php } ?>


       
        




         <br>
         



<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
<!-- End of Sidebar -->
