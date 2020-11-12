<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");

if(isset($_GET['pickup']) && $_GET['pickup']== 'true')
{
    include ("modals/forms/pickup.php");
}

if(isset($_GET['return']) && $_GET['return']== 'true')
{
    include ("modals/forms/return.php");
}
savePickUp();
returns();
?>
<!--
<form method="post" class="dropzone" id="my-awesome-dropzone" action="config/upload.php"></form>
-->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pickups</h1>
</div>






<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Picked Up Items As OF <?php echo date("m/d/Y"); ?></h6>
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
                        <th>Measure</th>
                        <th>Cost</th>
                        <th>Description</th>
                        <th>Q days</th>
                        <th>Responsile</th>
                        <th>Reason</th>
                        <th>Days overdue</th>
                        <th>Return</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>End</th>
                        <th>Part</th>
                        <th>Lot</th>
                        <th>Quantity</th>
                        <th>Measure</th>
                        <th>Cost</th>
                        <th>Description</th>
                        <th>Q days</th>
                        <th>Responsile</th>
                        <th>Reason</th>
                        <th>Days overdue</th>
                        <th>Return</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    <?php
                    $today = date("Y-m-d");
                    //$query = "SELECT * FROM users";
                    $query = "SELECT * FROM incoming_log LEFT JOIN measures ON measures.id_measure = incoming_log.measure_id WHERE out_quarantine = 1 AND responsible_dept_id = $department_id AND received = 1;";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                        ?>

                        <tr>
                            <td><?php echo $row['date'] ?> </td>
                            <td><?php echo $row['date_end'] ?> </td>
                            <td><?php echo $row['part'] ?></td>
                            <td><?php echo $row['lot'] ?></td>
                            <td><?php echo $row['quantity'] ?></td>
                            <td><?php echo $row['measure'] ?></td>
                            <td><?php echo $row['cost'] ?></td>
                            <td><?php echo $row['description'] ?></td>
                            <td><?php echo $row['time'] ?></td>
                            <td><?php echo $row['responsible'] ?></td>
                            <td><?php echo $row['reason'] ?></td>
                            <td>
                                <?php
                                if($today > $row['date_end'] )
                                {
                                    $datetime1 = new DateTime($row['date_end']);
                                    $datetime2 = new DateTime($row['pickup_date']);
                                    $interval = $datetime1->diff($datetime2);
                                    echo $days    = $interval->format('%d');
                                }
                                else
                                {
                                    echo "0";
                                }

                                ?>
                            </td>
                            <td><a class="btn btn-primary" href="index.php?page=pickups&return=true&id=<?php echo $row['incoming_id'] ?>">Return</a></td>
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
