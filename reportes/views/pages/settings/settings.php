<?php
include_once("includes/sidebar.php");
include_once("includes/topmenu.php");

$query = "SELECT * FROM settings ";
$result = mysqli_query($connection, $query);
if($result)
{
    $row = mysqli_fetch_array($result);
}
else
{
    die("There was an unexpected error: $query <br><a href='index.php'>Go back</a>");
}

//Functions

settings();

//modals
if(isset($_GET['success']))
{
    if($_GET['success'] == 1)
    {
        include("modals/states/success.php");
    }
    else
    {
        include("modals/states/error.php");
    }
}

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">App Settings</h1>


<div class="">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editing Settings.</h6>
        </div>
        <div class="card-body">

            <!---form--->

            <form role="form" method="post" enctype="multipart/form-data">
                <div class="box-body">

                    <div class="form-group row">

                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <label for="login_input_email">App Name</label>
                            <input id="login_input_email" class="login_input form-control" type="text" name="app_name" required value="<?php echo $row['app_name'] ?>" />
                            <small>This will be displayed on the sidebar.</small>
                        </div>


                        <div class=" col-lg-3">
                            <!-- the user name input field uses a HTML5 pattern check -->
                            <label for="login_input_username">App Refresh</label>
                            <input id="login_input_username" class="login_input form-control" type="number"  name="app_refresh" value="<?php echo substr($row['app_refresh'], 0,-3)  ?>" required />
                            <small>Refresh rate for real time tables (in seconds)</small>
                        </div>

                    </div>




                    <div class="form-group row">
                        <div class="input-group col-lg-6">
                            <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        Browse&hellip; <input type="file" style="display: none;" name="app_logo" onchange="readURL(this);">
                                    </span>
                            </label>
                            <input type="text" class="form-control" placeholder="App Logo" readonly>
                        </div>



                        <div class="col-lg-6 text-center center-block">
                            <br><br/>
                            <img class="img-thumbnail text-center center center-block img-fluid rounded-circle" style="width:50%; margin-top:-50px;" id="blah" src="<?php if($row['app_logo'] == ""){echo "assets/img/noimage.png";}else{echo $row['app_logo'];}  ?>" alt="your image" />
                        </div>


                    </div>



                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <div class="form-group row">
                        <div class="form-group col-lg-12">
                            <input type="submit" class="btn btn-primary btn-flat" name="submit" value="Save Changes" />
                        </div>
                    </div>
                </div>
            </form>




            <!---form--->

        </div>
    </div>

</div>


