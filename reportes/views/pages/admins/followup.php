<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");

saveUpdate();
$id = $_GET['id'];

$query = "SELECT * FROM incoming_log LEFT JOIN departamentos ON incoming_log.responsible_dept_id = departamentos.id WHERE incoming_log.incoming_id = $id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Follow Up</h1>
</div>


<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-default">Follow Up Data</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Options:</div>
                <a class="dropdown-item" href="index.php?page=upload_form">Clear Data</a>
                <!--
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
                -->
            </div>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body">


        <form method="post" enctype="multipart/form-data" action="" ">
        <div class="box-body">

            <div class="text-center center-block" id="demo">

            </div>

            <div id="disp">
                <div class="row">


                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Registered Date:</label>
                        <br>
                        <?php
                        echo $row['date'];
                        ?>
                    </div>

                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Pick Up Date:</label>
                        <br>
                        <?php
                        echo $row['date_end'];
                        ?>
                    </div>

                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Part No:</label>
                        <br>
                        <?php echo $row['part'] ?>
                    </div>


                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Lot No:</label>
                        <br>
                        <?php echo $row['lot'] ?>
                    </div>


                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Quantity:</label>
                        <br>
                        <?php echo $row['quantity'] ?>
                    </div>


                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Description:</label>
                        <br>
                        <?php echo $row['description'] ?>
                    </div>


                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Days:</label>
                        <br>
                        <?php echo $row['time'] ?>
                    </div>

                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Responsible:</label>
                        <br>
                        <?php echo $row['responsible'] ?>
                    </div>

                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Responsible Department:</label>
                        <br>
                        <?php echo $row['name'] ?>
                    </div>

                    <div class="form-group col-lg-4">
                        <label style="color:#0087f6; font-weight: bold" for="video">Reason for quarantine:</label>
                        <br>
                        <?php echo $row['reason'] ?>
                    </div>

                </div>



                <div class="row">

                    <form method="post">
                    <div class="form-group col-lg-12">
                        <label>Notes</label>
                        <textarea class="form-control" name="comentarios"></textarea>
                    </div>



                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary btn-flat" name="submit">Save Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.box-body -->

    </div>
</div>


