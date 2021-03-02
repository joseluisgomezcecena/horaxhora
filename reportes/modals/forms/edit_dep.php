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
                    <h5 class="modal-title" id="exampleModalLabel">Editing: <?php echo $row_get_cat['name']; ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group col-lg-12">
                        <label for="video">Name</label>
                        <input id="video" class=" form-control" type="text"  name="name" value="<?php echo $row_get_cat['name']; ?>"    />
                        <small>Department Name <i style="color:red">*</i></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" name="edit_dep" >Edit</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                </div>
            </div>
        </div>
    </div>
</form>