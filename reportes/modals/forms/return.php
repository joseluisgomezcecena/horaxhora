<?php
$select = "SELECT * FROM incoming_log WHERE incoming_id = {$_GET['id']}";
$run_select = mysqli_query($connection, $select);
$row_select = mysqli_fetch_array($run_select);
?>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pickup Part:<?php echo $row_select['part'] ?> Lot:<?php echo $row_select['lot'] ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">


                <form method="post">
                    <input type="submit" name="return" class="btn btn-outline-success" value="Return to Quarantine">
                </form>


                <?php


                ?>



            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>