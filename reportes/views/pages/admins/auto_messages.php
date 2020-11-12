<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");

saveAutoMessage();

$query_message = "SELECT * FROM automated_messages ORDER BY id DESC LIMIT 1";
$run_query_message = mysqli_query($connection, $query_message);
$row_message = mysqli_fetch_array($run_query_message);

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Automated Messages</h1>
</div>


<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-default">Message</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Options:</div>
                <a class="dropdown-item" href="index.php?page=auto_messages">Restore</a>
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




                    <div class="form-group col-lg-12">
                        <label for="video">Your Message:</label>
                        <textarea id="video" class=" form-control" type="text"  name="message" rows="5"><?php if(isset($row_message['message'])){echo $row_message['message']; }else{echo "";} ?></textarea>
                        <small>This message will be sent along with every email sent on late items.<i style="color:red">*</i></small>
                    </div>


                </div>



                <div class="row">
                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary btn-flat" name="save_message">Save Message</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        </form>
    </div>
</div>
