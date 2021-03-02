<?php

toEliminarUsuario();

?>




<h1 class="h3 mb-4 text-gray-800">Users</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div  class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-default">Registered Users</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table style="font-size: 12px;" class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Profile</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Employee #</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Profile</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Employee #</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
                <tbody>

                <?php
                //$query = "SELECT * FROM users";
                $query = "SELECT * FROM users";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_array($result)):

                //user type//
                if($row['isadmin'] == 1)
                    $user_type = "Admin";
                else
                    $user_type = "User";
                ?>

                <tr>
                    <td><?php if($row['profile_pic'] == ""){echo "<img width='100px;' class=\"img-thumbnail text-center center center-block img-fluid rounded-circle\" src='views/assets/img/noimage.png'";}else{ echo"<img width=\"100px;\" height=\"100px;\" class=\"img-thumbnail text-center center center-block img-fluid rounded-circle\" src=\" {$row['profile_pic']}\">";} ?>   </td>
                    <td><?php echo $row['user_name'] ?> </td>
                    <td><?php echo $row['user_nombre'] ?> <?php echo $row['user_apellido'] ?></td>
                    <td><?php echo $row['user_email'] ?></td>
                    <td><?php echo $row['user_numero'] ?></td>
                    <td><?php echo $user_type ?></td>
                    <td>
                        <?php
                        if($row['user_name'] != "jgomez"){
                        ?>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-primary" href="index.php?page=new_user&id=<?php echo $row['user_id'] ?>">
                                Administrar
                            </a>

                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                        
                        <?php
                        }
                        else
                        {
                            echo "Super User";
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
