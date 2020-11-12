<?php
$select = "SELECT * FROM incoming_log WHERE incoming_id = {$_GET['id']}";
$run_select = mysqli_query($connection, $select);
$row_select = mysqli_fetch_array($run_select);
?>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Accept Part:<?php echo $row_select['part'] ?> Lot:<?php echo $row_select['lot'] ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">


               

                    <div class="row">

                        <div class="form-group col-lg-3">
                            <label for="revision">Part No.</label>
                            <!--
                            <input id="revision" class="login_input form-control" type="text"  name="partno"  required  autocomplete="off" required />
                            -->
                            <input class="login_input form-control" type="text" id="pn" name="partno" list="partno" value="<?php echo $row_select['part'] ?>" readonly required>
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
                            <input id="lotno" class=" form-control" type="text"  name="lotno" value="<?php echo $row_select['lot'] ?>" readonly onClick="this.readonly=false;" required />
                            <small>Lot number (editable on click)<i style="color:red">*</i></small>
                        </div>


                        <div class="form-group col-lg-3">
                            <label for="video">Quantity</label>
                            <input id="quantity" class=" form-control" type="number"  name="quantity"  step=".01" value="<?php echo $row_select['quantity'] ?>" readonly  required />
                            <small>Number of materials (editable on click)<i style="color:red">*</i></small>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="video">Material Cost</label>
                            <input id="cost" class=" form-control" type="number"  name="cost" step=".01" value="<?php echo $row_select['cost'] ?>" readonly required/>
                            <small>Material Cost (editable on click)<i style="color:red">*</i></small>
                        </div>


                        <div class="form-group col-lg-12">
                            <label for="video">Description</label>
                            <textarea id="description" class=" form-control" type="text"  name="description" rows="5" readonly required><?php echo $row_select['description'] ?></textarea>
                            <small>Item description <i style="color:red">*</i></small>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="video">Reason</label>
                            <textarea id="reason" class=" form-control" type="text"  name="reason" rows="5" readonly required><?php echo $row_select['reason'] ?></textarea>
                            <small>Reason for quarantine <i style="color:red">*</i></small>
                        </div>




                        <div class="form-group col-lg-4">
                            <label for="video">Number of days</label>
                            <input id="days" class=" form-control" type="number"  name="days"  min="1" value="<?php echo $row_select['time'] ?>" readonly required />
                            <small>Number of days to spend in quarantine (editable on click) <i style="color:red">*</i></small>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-lg-12">
                        </div>

                    </div>
                


            </div>
            <div class="modal-footer">
                <input type="submit" name="accept" class="btn btn-outline-success" value="Accept">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        </form>
    </div>
</div>


<script> 

document.getElementById("days").onclick = function() {
    
    document.getElementById("days").readOnly = false;
}

document.getElementById("cost").onclick = function() {
    
    document.getElementById("cost").readOnly = false;
}

document.getElementById("quantity").onclick = function() {
    
    document.getElementById("quantity").readOnly = false;
}

document.getElementById("lotno").onclick = function() {
    
    document.getElementById("lotno").readOnly = false;
}
        
     
</script>