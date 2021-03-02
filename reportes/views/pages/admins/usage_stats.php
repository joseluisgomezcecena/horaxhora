<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");
?>
<!--
<form method="post" class="dropzone" id="my-awesome-dropzone" action="config/upload.php"></form>
-->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Usage Stats</h1>
</div>



<div class="row">
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Usage By Department As OF <?php echo date("m/d/Y"); ?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Reports:</div>
                        <a class="dropdown-item" href="#">Get usage reports</a>

                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table style="font-size: 12px;" class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Department</th>
                        <th>Count</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Department</th>
                        <th>Count</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    <?php
                    $today = date("Y-m-d");
                    //$query = "SELECT * FROM users";
                    $query = "SELECT incoming_id, responsible_dept_id, name, COUNT(*) AS numero  FROM   incoming_log  LEFT JOIN departamentos ON incoming_log.responsible_dept_id = departamentos.id   GROUP BY incoming_log.responsible_dept_id;";
                    $result = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_array($result)):
                        ?>

                        <tr>
                            <td><?php echo $row['name'] ?> </td>
                            <td><?php echo $row['numero'] ?> </td>
                        </tr>

                    <?php
                    endwhile;
                    ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>










    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Monthy Usage By Year <?php echo date("Y"); ?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Reports:</div>
                        <a class="dropdown-item" href="#">Get usage reports</a>

                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>