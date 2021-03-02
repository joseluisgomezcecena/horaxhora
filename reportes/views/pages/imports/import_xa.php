<style>
    #personal_table input{
        border: none;
    }
    #personal_table input:focus{
        border: none;
    }

    /* LOADER */
    .sk-circle {
        margin: 100px auto;
        width: 40px;
        height: 40px;
        position: relative;
    }

    .sk-circle .sk-child {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
    }

    .sk-circle .sk-child:before {
        content: '';
        display: block;
        margin: 0 auto;
        width: 15%;
        height: 15%;
        background-color: #333;
        border-radius: 100%;
        -webkit-animation: sk-circleBounceDelay 1.2s infinite ease-in-out both;
        animation: sk-circleBounceDelay 1.2s infinite ease-in-out both;
    }

    .sk-circle .sk-circle2 {
        -webkit-transform: rotate(30deg);
        -ms-transform: rotate(30deg);
        transform: rotate(30deg);
    }

    .sk-circle .sk-circle3 {
        -webkit-transform: rotate(60deg);
        -ms-transform: rotate(60deg);
        transform: rotate(60deg);
    }

    .sk-circle .sk-circle4 {
        -webkit-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    .sk-circle .sk-circle5 {
        -webkit-transform: rotate(120deg);
        -ms-transform: rotate(120deg);
        transform: rotate(120deg);
    }

    .sk-circle .sk-circle6 {
        -webkit-transform: rotate(150deg);
        -ms-transform: rotate(150deg);
        transform: rotate(150deg);
    }

    .sk-circle .sk-circle7 {
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .sk-circle .sk-circle8 {
        -webkit-transform: rotate(210deg);
        -ms-transform: rotate(210deg);
        transform: rotate(210deg);
    }

    .sk-circle .sk-circle9 {
        -webkit-transform: rotate(240deg);
        -ms-transform: rotate(240deg);
        transform: rotate(240deg);
    }

    .sk-circle .sk-circle10 {
        -webkit-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        transform: rotate(270deg);
    }

    .sk-circle .sk-circle11 {
        -webkit-transform: rotate(300deg);
        -ms-transform: rotate(300deg);
        transform: rotate(300deg);
    }

    .sk-circle .sk-circle12 {
        -webkit-transform: rotate(330deg);
        -ms-transform: rotate(330deg);
        transform: rotate(330deg);
    }

    .sk-circle .sk-circle2:before {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }

    .sk-circle .sk-circle3:before {
        -webkit-animation-delay: -1s;
        animation-delay: -1s;
    }

    .sk-circle .sk-circle4:before {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .sk-circle .sk-circle5:before {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }

    .sk-circle .sk-circle6:before {
        -webkit-animation-delay: -0.7s;
        animation-delay: -0.7s;
    }

    .sk-circle .sk-circle7:before {
        -webkit-animation-delay: -0.6s;
        animation-delay: -0.6s;
    }

    .sk-circle .sk-circle8:before {
        -webkit-animation-delay: -0.5s;
        animation-delay: -0.5s;
    }

    .sk-circle .sk-circle9:before {
        -webkit-animation-delay: -0.4s;
        animation-delay: -0.4s;
    }

    .sk-circle .sk-circle10:before {
        -webkit-animation-delay: -0.3s;
        animation-delay: -0.3s;
    }

    .sk-circle .sk-circle11:before {
        -webkit-animation-delay: -0.2s;
        animation-delay: -0.2s;
    }

    .sk-circle .sk-circle12:before {
        -webkit-animation-delay: -0.1s;
        animation-delay: -0.1s;
    }

    @-webkit-keyframes sk-circleBounceDelay {
        0%,
        80%,
        100% {
            -webkit-transform: scale(0);
            transform: scale(0);
        }
        40% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes sk-circleBounceDelay {
        0%,
        80%,
        100% {
            -webkit-transform: scale(0);
            transform: scale(0);
        }
        40% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }
</style>

<?php 
    if(isset($_POST["submit_file"]))
    {

        ?>
        
        <?php

        $count = 0;
        if(count($_FILES['file']['name']) > 0)
        {
            for( $index = 0; $index < count($_FILES['file']['name']); $index++ )
            {
                $count = 0;
                $file = $_FILES["file"]["tmp_name"][$index]; 
                $file_open = fopen($file,"r");
                while(($csv = fgetcsv($file_open, 5000, ",")) !== false)
                {
                    if($count < 1)
                    {
                        $count++;
                        continue;
                    }
                    
                    $item          = trim(mysqli_real_escape_string($connection,$csv[0]));
                    $description   = trim(mysqli_real_escape_string($connection,$csv[1]));
                    $planner       = trim(mysqli_real_escape_string($connection,$csv[2]));
                    $whs           = trim(mysqli_real_escape_string($connection,$csv[3]));
                    $posted        = trim(mysqli_real_escape_string($connection,$csv[4]));
                    $txn           = trim(mysqli_real_escape_string($connection,$csv[5]));
                    $order         = trim(mysqli_real_escape_string($connection,$csv[6]));
                    $quantity      = trim(mysqli_real_escape_string($connection,$csv[7]));
                    $class         = trim(mysqli_real_escape_string($connection,$csv[8]));
    
                    $posted = date("Y/m/d", strtotime($posted));
                    $quantity = str_replace(",", "", $quantity);
                    
                    if($item != "" && str_replace("_", "", $item) != "")
                    {
    
                        $query_labor  = "SELECT run_labor, cur_yield, setup_hours FROM pph_planta1 WHERE routing = '$item'";
                        $result_labor = $connection->query($query_labor);
                        if($result_labor)
                        {
                            $run_labor = 0;
                            $yield = 1;
                            $setup = 0;
    
                            while($row_labor = $result_labor->fetch_assoc())
                            {
                                $run_labor += $row_labor['run_labor'];
                                $yield *= $row_labor['cur_yield'] != 0 ? $row_labor['cur_yield'] : 1;
                                $setup += $row_labor['setup_hours'];
                            }
                        }
    
                        $std_hours = $quantity > 0 && $yield > 0 && $run_labor > 0 ? (($quantity / $yield) / (100/$run_labor)) + $setup : 0;
    
                        $search = "SELECT * FROM horas_std_xa WHERE item = '$item' AND order_number = '$order' AND posted = '$posted'";
                        $run_search = mysqli_query($connection, $search);
                        
                        if($run_search)
                        {
                            if(mysqli_num_rows($run_search) == 0)
                                $query = "INSERT INTO `horas_std_xa`(`item`,`description`, `planner`, `whs`, `posted`, `txn`, `order_number`, `quantity`, `class`, rates, yield, setup, std_hours) 
                                          VALUES('$item','$description','$planner','$whs','$posted','$txn','$order','$quantity','$class', '$run_labor','$yield','$setup',' $std_hours');";    
                            else
                                $query = "UPDATE horas_std_xa SET `quantity` = `quantity` + $quantity, rates = '$run_labor', yield = '$yield', setup = '$setup', std_hours = '$std_hours', `posted` = '$posted'
                                            WHERE item = '$item' AND order_number = '$order' AND posted = '$posted'";
                
                            $result = mysqli_query($connection, $query);
                            if(!$result)
                            {
                                echo "Error: " .$connection->error;
                                echo "<br>Query: " .$query;
                            }
                        }
                        else
                        {
                            echo "Error: " . $connection->error;
                            echo "<br>Query: " . $run_search;
                        }
                    }
                    $count++;
                }
            }

            $date = date('Y/m/d',strtotime("-1 days")); // Return yesterday date
            $query_std_xa  = "SELECT * FROM `horas_std_xa` WHERE posted = '$date'"; 
            $query_tress   = "SELECT * FROM `horas_tress` WHERE posted = '$date'"; 
            
            $result_std_xa = $connection->query($query_std_xa);
            $result_tress  = $connection->query($query_tress);
    
            if($result_std_xa && $result_tress)
            {
                if($result_std_xa->num_rows > 0 && $result_tress->num_rows > 0)
                {
                    $query_xa = "SELECT `planner_codes`.`planta`, ROUND(SUM(`horas_std_xa`.`std_hours`),2) as 'horas' 
                                 FROM `horas_std_xa` 
                                 INNER JOIN planner_codes ON `horas_std_xa`.planner = `planner_codes`.`planner` 
                                 WHERE `horas_std_xa`.`planner` in (SELECT planner from planner_codes) AND posted = '$date'
                                 GROUP BY `planner_codes`.`planta`
                                 ORDER BY `planner_codes`.`planta` ASC";
    
                    $query_tress = "SELECT `supervisores`.`planta_supervisor` AS 'planta', ROUND(SUM(`horas_tress`.`hours`),2) AS 'horas' 
                                    FROM `horas_tress` 
                                    INNER JOIN supervisores ON `horas_tress`.supervisor = `supervisores`.`nombre_supervisor` 
                                    WHERE `horas_tress`.`supervisor` in (SELECT nombre_supervisor from supervisores) AND posted = '$date'
                                    GROUP BY `supervisores`.`planta_supervisor`
                                    ORDER BY `supervisores`.`planta_supervisor` ASC";
                    
                    $result_xa = $connection->query($query_xa);
                    $result_tress = $connection->query($query_tress);
                    if($result_xa && $result_tress)
                    {
                        $plantas     = [];
                        $hours_xa    = [];
                        $hours_tress = [];
                        while($row_xa = $result_xa->fetch_assoc())
                        {
                            $plantas[]  = $row_xa['planta'];
                            $hours_xa[] = $row_xa['horas'];
                        }
                        while( $row_tress = $result_tress->fetch_assoc())
                        {
                            $hours_tress[] = $row_tress['horas'];
                        }
                        for($x = 0; $x < count($plantas); $x++)
                    {
                        $eff = 100 * round($hours_xa[$x]/$hours_tress[$x], 4);

                        $query_select = "SELECT * FROM eficiencia_xa_tress WHERE planta = '$plantas[$x]' AND fecha = '$date'";
                        $result_select = $connection->query($query_select);
                        if($result_select) {
                            if($result_select->num_rows > 0) {
                                $query_insert  = "UPDATE `eficiencia_xa_tress` SET xa_hrs = $hours_xa[$x], tress_hrs =$hours_tress[$x], eficiencia = $eff WHERE planta = '{$plantas[$x]}' AND fecha = '$date';";
                            } else {
                                $query_insert  = "INSERT INTO  `eficiencia_xa_tress`(planta, xa_hrs, tress_hrs, eficiencia, fecha) VALUES($plantas[$x], $hours_xa[$x], $hours_tress[$x], $eff, '$date');";
                            }

                            $connection->query($query_insert);
                        }
                    }
                    }
                }
            }
        }
    }
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div  class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-default">Import report</h6>
            </div>
            <div class="card-body">
                <div class="box"> 
                    <div class="box-header">
                        <h5 class="box-title">Import</h5>
                    </div>
                    <div class="box-body">
                        <form  id="submit_csv" action="index.php?page=import_xa" method="post" enctype="multipart/form-data">
                            <input id="file" type="file" name="file[]" accept=".csv" multiple required>
                            <input id="submit" class="btn btn-primary" type="submit" name="submit_file" value="Import CSV"/>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div  class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-default">Report</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" >
                    <table style="font-size: 12px;" class="table table-hover" id="table_xa" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Planner</th>
                                <th>Whs</th>
                                <th>Posted</th>
                                <th>Txn</th>
                                <th>Order</th>
                                <th>Quantity</th>
                                <th>Class</th>
                                <th>Run Labor</th>
                                <th>Yield</th>
                                <th>Setup hours</th>
                                <th>Standard hours</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div  class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-default">Daily hours by plant</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" >
                    <table style="font-size: 12px;" class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Plant</th>
                                <th>Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $date = date('Y/m/d',strtotime("-1 days")); // Return yesterday date
                                $query = "SELECT `planner_codes`.`planta`, ROUND(SUM(`horas_std_xa`.`std_hours`),2) as 'horas' 
                                          FROM `horas_std_xa` 
                                          INNER JOIN planner_codes ON `horas_std_xa`.planner = `planner_codes`.`planner` 
                                          WHERE `horas_std_xa`.`planner` in (SELECT planner from planner_codes) AND posted = '$date'
                                          GROUP BY `planner_codes`.`planta`";
                                $result = $connection->query($query);
                                if($result)
                                {
                                    while($row = $result->fetch_assoc())
                                    {
                                        echo "<tr>";
                                        echo "<td>Plant {$row['planta']}</td>";
                                        echo "<td>{$row['horas']}</td>";
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="load_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">We're loading your data</h4>
            </div>
            <div class="modal-body">
                <div class="sk-circle" id="spinner">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    submit.addEventListener('click', validateFile);
    function validateFile() {
        if(file.value === "") {
            alert("No hay archivos cargados.")
        } else {
            submit_csv.submit();
        }
    }
</script>