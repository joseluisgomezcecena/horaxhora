<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");

if($level < 2)
{
    die("You don't have permission to acces this section. <a href='index.php'>Go back</a>");
}

//FUNCTIONS
addDep();
editDep();
deleteDep();


//FORMS

if(isset($_GET['edit']))
{
    include ("modals/forms/edit_dep.php");
}

if(isset($_GET['delete']))
{
    include ("modals/forms/delete_dep.php");
}




//error_reporting(1);

?>


<h1 class="h3 mb-4 text-gray-800">Departments</h1>

<div class="row">
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div  class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-default">Add Departments</h6>
            </div>
            <div class="card-body">
                    <form method="post">

                        <div class="form-group col-lg-12">
                            <label for="video">Name</label>
                            <input id="video" class=" form-control" type="text"  name="name"    />
                            <small>Department Name <i style="color:red">*</i></small>
                        </div>


                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-primary btn-flat" name="save_dep">Save Department</button>
                        </div>

                    </form>
            </div>
        </div>
    </div>



    <div class="col-lg-8">

        <div class="card shadow mb-4">
            <div  class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-default">All Departments</h6>
            </div>
            <div class="card-body">




                <div class="table-responsive">
                    <table style="font-size: 12px;" class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                        </tfoot>
                        <tbody>

                        <?php
                        $dep_count = 0;
                        $query = "SELECT * FROM departamentos ORDER BY id DESC";
                        $result = mysqli_query($connection, $query);
                        if(!$result){echo "Query: $query Failed";}
                        while($row = mysqli_fetch_array($result)):
                            $dep_count++;
                            ?>

                            <tr>
                                <th><?php echo $dep_count; ?></th>
                                <td><?php echo $row['name'] ?></td>
                                <td><a class="btn btn-secondary btn-flat" href='index.php?page=departments&edit=true&id=<?php echo $row['id'] ?>'><i class="fa fa-edit">&nbsp;&nbsp;</i>Edit</a></td>
                                <td><a class="btn btn-danger btn-flat" href='index.php?page=departments&delete=true&id=<?php echo $row['id'] ?>'><i class="fa fa-times">&nbsp;&nbsp;</i>Delete</a></td>
                            </tr>

                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
