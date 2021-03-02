<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");

saveEntry();

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Quarantine Entries</h1>
</div>


<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-default">New Entry</h6>
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


                        <div class="form-group col-lg-3">
                            <label for="revision">Part No.</label>
                            <!--
                            <input id="revision" class="login_input form-control" type="text"  name="partno"  required  autocomplete="off" required />
                            -->
                            <input class="login_input form-control" type="text" name="partno" list="partno" required>
                            <datalist id="partno">
                                <?php
                                $get_active = "SELECT * FROM activeparts";
                                $run_get = mysqli_query($connection, $get_active);
                                while($row_active = mysqli_fetch_array($run_get)):
                                ?>

                                <option value="<?php echo $row_active[0] ?>">

                                    <?php endwhile; ?>

                            </datalist>
                            <small>Part number <i style="color:red">*</i></small>
                        </div>



                        <div class="form-group col-lg-3">
                            <label for="video">Lot No.</label>
                            <input id="video" class=" form-control" type="text"  name="lotno"   required />
                            <small>Lot number <i style="color:red">*</i></small>
                        </div>


                        <div class="form-group col-lg-2">
                            <label for="video">Quantity</label>
                            <input id="video" class=" form-control" type="number"  name="quantity" onkeydown="javascript: return event.keyCode == 69 ? false : true"  step=".01"  required />
                            <small>Number of parts <i style="color:red">*</i></small>
                        </div>
                        
                        <div class="form-group col-lg-2">
                            <label for="measure">Measure</label>
                            <select name="measure" id="measure" class=" form-control">
                                <?php
                                    $query_measures  = "SELECT * FROM measures";
                                    $result_measures = $connection->query($query_measures);
                                    if($result_measures)
                                    {
                                        while($row_measures = $result_measures->fetch_assoc())
                                        {
                                            $id      = $row_measures['id_measure'];
                                            $measure = $row_measures['measure'];
                                            $descrip = $row_measures['description'];

                                            echo "<option value=\"$id\">$measure - $descrip </option>";
                                        }
                                    }

                                ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="video">Cost</label>
                            <input id="video" class=" form-control" type="number" onkeydown="javascript: return event.keyCode == 69 ? false : true" name="cost"  step=".01"  required />
                            <small>Cost <i style="color:red">*</i></small>
                        </div>


                        <div class="form-group col-lg-12">
                            <label for="video">Description</label>
                            <textarea id="video" class=" form-control" type="text"  name="description" rows="5" required></textarea>
                            <small>Item description <i style="color:red">*</i></small>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="video">Reason</label>
                            <textarea id="video" class=" form-control" type="text"  name="reason" rows="5" required></textarea>
                            <small>Reason for quarantine <i style="color:red">*</i></small>
                        </div>

                    </div>



                    <div class="row">


                        <div class="form-group col-lg-4">
                            <label for="video">Number of days</label>
                            <input id="video" class=" form-control" type="number" onkeydown="javascript: return event.keyCode == 69 ? false : true"  name="days"  min="1"  required />
                            <small>Number of days to spend in quarantine <i style="color:red">*</i></small>
                        </div>

                        <!--
                        <div class="form-group col-lg-4">
                            <label for="video">Department</label>
                            <select id="video" class=" form-control" type="text"  name="department_id"  >
                                <option value="">Select</option>

                                <?php

                                $get_dept = "SELECT * FROM departamentos";
                                $run_dept = mysqli_query($connection, $get_dept);
                                while($row_dept = mysqli_fetch_array($run_dept)):
                                    ?>

                                    <option value="<?php echo $row_dept['id'] ?>"><?php echo $row_dept['name'] ?></option>

                                <?php endwhile; ?>
                            </select>
                            <small>Mandatory field <i style="color:red">*</i></small>
                        </div>
                        -->
                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-primary btn-flat" name="save_entry">Save Entry</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </form>
    </div>
</div>


