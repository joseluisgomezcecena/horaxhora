<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");

if(isset($_GET['accept']) && $_GET['accept']== 'true')
{
    include ("modals/forms/accept.php");
}

if(isset($_GET['accept']) && $_GET['accept']== 'false')
{
    include ("modals/forms/reject.php");
}
//savePickUp();
//returns();
accept();
reject();
?>
<!--
<form method="post" class="dropzone" id="my-awesome-dropzone" action="config/upload.php"></form>
-->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Accept Entries</h1>
</div>






<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Pending reception As OF <?php echo date("m/d/Y"); ?></h6>
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
                        <th>Date</th>
                        <th>End</th>
                        <th>Part</th>
                        <th>Lot</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Q days</th>
                        <th>Responsile</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>End</th>
                        <th>Part</th>
                        <th>Lot</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Q days</th>
                        <th>Responsile</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    <?php
                    $today = date("Y-m-d");
                    //$query = "SELECT * FROM users";
                    $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND received = 0 AND rejected = 0;";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                        ?>

                        <tr>
                            <td><?php echo $row['date'] ?> </td>
                            <td><?php echo $row['date_end'] ?> </td>
                            <td><?php echo $row['part'] ?></td>
                            <td><?php echo $row['lot'] ?></td>
                            <td><?php echo $row['quantity'] ?></td>
                            <td><?php echo $row['description'] ?></td>
                            <td><?php echo $row['time'] ?></td>
                            <td><?php echo $row['responsible'] ?></td>
                            <td><?php echo $row['reason'] ?></td>
                            <td>
                                <a class="btn btn-danger" href="index.php?page=new_entry_list&accept=false&id=<?php echo $row['incoming_id'] ?>">
                                    Dont Accept
                                </a>
                                <a class="btn btn-primary" href="index.php?page=new_entry_list&accept=true&id=<?php echo $row['incoming_id'] ?>">
                                    Accept
                                </a>
                            </td>
                        </tr>

                    <?php
                    endwhile;
                    ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
