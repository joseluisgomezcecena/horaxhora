<?php
$id = $_GET['id'];
$get_cat= "SELECT * FROM departamentos WHERE id = $id";
$run_get_cat = mysqli_query($connection, $get_cat);
$row_get_cat = mysqli_fetch_array($run_get_cat);

?>
<form method="post">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are You sure you want to delete: <?php echo $row_get_cat['name']; ?> ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group col-lg-12">
                        You are about to delete <?php echo $row_get_cat['name']; ?>.
                        <b>Warning: This action cannot be undone.</b>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit" name="delete_dep" >Delete</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                </div>
            </div>
        </div>
    </div>
</form>