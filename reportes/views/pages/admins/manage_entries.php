<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");

if(isset($_GET['followup']) && $_GET['followup']== 'true')
{
    include ("modals/forms/followup.php");
}
saveUpdate();

if(isset($_GET['pickup']) && $_GET['pickup']== 'true')
{
    include ("modals/forms/pickup.php");
}
savePickUp();
?>
<!--
<form method="post" class="dropzone" id="my-awesome-dropzone" action="config/upload.php"></form>
-->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manage Entries.</h1>
</div>






<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Quarantine Items As OF <?php echo date("m/d/Y"); ?></h6>
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
                <div class="table-responsive">
                <table style="font-size: 10px;" class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>End</th>
                        <th>Part/Lot</th>
                        <th>Quantity</th>
                        <th>Measure</th>
                        <th>Cost</th>
                        <th>Description</th>
                        <th>Q days</th>
                        <th>Responsile</th>
                        <th>Reason</th>
                        <th>Update</th>
                        <th>Status</th>
                        <th>Follow up</th>
                        <th>Pickup</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>End</th>
                        <th>Part/Lot</th>
                        <th>Quantity</th>
                        <th>Measure</th>
                        <th>Cost</th>
                        <th>Description</th>
                        <th>Q days</th>
                        <th>Responsile</th>
                        <th>Reason</th>
                        <th>Update</th>
                        <th>Status</th>
                        <th>Follow up</th>
                        <th>Pickup</th>

                    </tr>
                    </tfoot>
                    <tbody>

                    <?php
                    $today = date("Y-m-d");
                    $query = "SELECT * FROM incoming_log LEFT JOIN measures as measures ON measures.id_measure = incoming_log.measure_id  WHERE out_quarantine = 0 AND rejected = 0;";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):

                        if($row['received'] == 0)
                        {
                          $received = 0;
                        }
                        elseif($row['received'] == 1)
                        {
                          $received = 1;
                        }
                        else
                        {
                          $received = "N/A";
                        }

                        if($row['rejected'] == 0)
                        {
                          $rejected = 0;
                        }
                        elseif($row['rejected'] == 1)
                        {
                          $rejected = 1;
                        }
                        else
                        {
                          $rejected = "N/A";
                        }

                        ?>

                        <tr>
                            <td>
                              <?php
                               $rdate = date_create($row['register_date']);
                               echo "Registered: ".date_format($rdate,"m/d/Y");

                               if($row['received']== 1)
                               {
                                 $date = date_create($row['date']);
                                 echo "<br>Received: ".date_format($date,"m/d/Y");
                               }
                               else
                               {
                                 echo "";
                               }

                              ?>
                            </td>

                            <td>
                              <?php
                              $date_end = date_create($row['date_end']);
                              echo date_format($date_end,"m/d/Y");
                              ?>
                            </td>

                            <td>
                              Part:<?php echo $row['part'] ?>
                              <br>
                              Lot:<?php echo $row['lot'] ?>
                            </td>

                            <td>
                              <?php echo $row['quantity'] ?>
                            </td>

                            <td>
                              <?php echo $row['measure'] ?>
                            </td>

                            <td>
                              <?php echo $row['cost'] ?>
                            </td>

                            <td>
                              <?php echo $row['8'] ?>
                            </td>

                            <td>
                              <?php echo $row['time'] ?>
                            </td>

                            <td>
                              <?php echo $row['responsible'] ?>
                            </td>

                            <td>
                              <?php echo $row['reason'] ?>
                            </td>

                            <td>
                                <?php
                                $get_update = "SELECT * FROM actualizacion WHERE id_incoming = {$row['incoming_id']}";
                                $run_update = mysqli_query($connection, $get_update);
                                while($row_update = mysqli_fetch_array($run_update))
                                {
                                    echo "<b style='color:#089be7'>{$row_update['actualizacion_date']}:</b><br>{$row_update['comentarios']}<br>";
                                }
                                ?>
                            </td>

                            <td>
                              <?php

                              if($received == 1)
                              {
                                  if($row['date_end'] < $today)
                                  {
                                    echo "<b class='text-center'><h5 class='blink_me text-danger'><i class='fa fa-clock'></i>Late</h5></b>";
                                  }
                                  else
                                  {
                                    $start = strtotime($today);

                                    $end = strtotime($row['date_end']);

                                    $days = ($end - $start)/60/60/24;

                                    $days = round($days,0);

                                    echo "<b class='text-center'><p class='text-success'><i class='fa fa-check'></i>&nbsp;&nbsp;$days Days left</p></b>";
                                  }
                              }
                              else
                              {
                                  if($rejected == 1)
                                  {
                                    echo "<b class='text-center'><p class='blink_me text-dark'><i class='fa fa-times text-danger'></i>Rejected</p></b>";
                                  }
                                  else
                                  {
                                    echo "<b class='text-center'><p class='blink_me text-warning'><i class='fa fa-exclamation-triangle'></i>Pending Reception</p></b>";
                                  }
                              }
                              ?>
                            </td>

                            <td>
                              <?php
                              if($rejected == 1)
                              {
                              ?>

                              <?php
                              }
                              else
                              {
                              ?>
                                <a class="btn btn-primary" href="index.php?page=client_manage_entries&id=<?php echo $row['incoming_id'] ?>&u=admin&followup=true">Update</a>
                              <?php
                              }
                              ?>
                            </td>


                            <td>
                              <?php
                              if($rejected == 1)
                              {
                              ?>

                              <?php
                              }
                              else
                              {
                              ?>
                                <a class="btn btn-danger" href="index.php?page=manage_entries&pickup=true&id=<?php echo $row['incoming_id'] ?>">Pickup</a>
                              <?php
                              }
                              ?>





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
</div>
