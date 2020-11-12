<?php
$select = "SELECT * FROM incoming_log LEFT JOIN departamentos ON incoming_log.responsible_dept_id = departamentos.id WHERE incoming_log.incoming_id = {$_GET['id']}";
$run_select = mysqli_query($connection, $select);
$row_select = mysqli_fetch_array($run_select);
?>


<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Note to: <b><?php echo $row_select['part'] ?></b><br> Lot:<b><?php echo $row_select['lot'] ?></b>.</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">


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
                              echo $row_select['date'];
                              ?>
                          </div>

                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Pick Up Date:</label>
                              <br>
                              <?php
                              echo $row_select['date_end'];
                              ?>
                          </div>

                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Part No:</label>
                              <br>
                              <?php echo $row_select['part'] ?>
                          </div>


                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Lot No:</label>
                              <br>
                              <?php echo $row_select['lot'] ?>
                          </div>


                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Quantity:</label>
                              <br>
                              <?php echo $row_select['quantity'] ?>
                          </div>


                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Description:</label>
                              <br>
                              <?php echo $row_select['description'] ?>
                          </div>


                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Days:</label>
                              <br>
                              <?php echo $row_select['time'] ?>
                          </div>

                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Responsible:</label>
                              <br>
                              <?php echo $row_select['responsible'] ?>
                          </div>

                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Responsible Department:</label>
                              <br>
                              <?php echo $row_select['name'] ?>
                          </div>

                          <div class="form-group col-lg-4">
                              <label style="color:#0087f6; font-weight: bold" for="video">Reason for quarantine:</label>
                              <br>
                              <?php echo $row_select['reason'] ?>
                          </div>

                      </div>



                      <div class="row">

                          <form method="post">
                          <div class="form-group col-lg-12">
                              <label>Notes</label>
                              <textarea class="form-control" name="comentarios"></textarea>
                          </div>



                          <div class="form-group col-lg-12">
                              <button type="submit" class="btn btn-primary btn-flat left" name="submit">Save Update</button>
                          </div>
                          </form>
                      </div>



            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
