<?php
$update = 0;
if(isset($_GET['id']))
{
    $update = 1;
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE user_id= $id";
    $result = mysqli_query($connection, $query);
    if($result)
    {
        $row = mysqli_fetch_array($result);
    }
    else
    {
        die("Ocurrio un error: $query <br><a href='index.php'>Volver</a>");
    }
}





?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Eliminar usuario</h1>


<div class="">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo "Eliminando: {$row['user_name']}" ?></h6>
        </div>
        <div class="card-body">

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Advertencia!</strong> Al eliminar el usuario debera contactarse con desarrollo de software para restaurar los datos.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

            <!---form--->

            <form role="form" method="post" enctype="multipart/form-data">
                <div class="box-body">


                    <div class="row">   

                        <div class="col-lg-6 text-center center-block">
                            <?php echo $row['user_name']; ?>
                            <br>
                            <?php echo $row['user_email']; ?>
                        </div>

                        <div class="col-lg-6 text-center center-block">
                            <br><br/>
                            <img class="img-thumbnail text-center center center-block img-fluid rounded-circle" style="width:50%; margin-top:-50px;" id="blah" src="<?php if($update == 1){if($row['profile_pic'] == ""){echo "views/assets/img/noimage.png";}else {echo $row['profile_pic'];}}else{echo "views/assets/img/noimage.png";}  ?>" alt="your image" />
                        </div>

                    </div>



                    
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <div class="form-group row">
                        <div class="form-group col-lg-12">
                            <input type="submit" class="btn btn-danger btn-flat" name="eliminar" value="Eliminar" />
                        </div>
                    </div>
                </div>
            </form>




            <!---form--->

        </div>
    </div>

</div>


