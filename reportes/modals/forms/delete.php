<?php
$select = "SELECT * FROM users WHERE user_id = {$_GET['id']}";
$run_select = mysqli_query($connection, $select);
$row_select = mysqli_fetch_array($run_select);
?>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete:<?php echo $row_select['user_name'] ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">

                This action cannot be undone.

                <form method="post">
                    <input type="submit" name="delete_user" class="btn btn-outline-danger" value="Delete User">
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