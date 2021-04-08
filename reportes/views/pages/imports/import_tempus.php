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

        $date = date('Y/m/d', strtotime($_POST['date']));
        $columna = 2;
        $columna_supervisor = 0;

        switch(date('w', strtotime($_POST['date']))) 
        {
            case 1: // Martes -> Nos dara reporte de Lunes
                $columna = 2;
                break;
            case 2: // Miercoles -> Nos dara reporte de Martes
                $columna = 4;
                break;
            case 3: // Jueves -> Nos dara reporte de Miercoles
                $columna = 6;
                break;
            case 4: // Viernes -> Nos dara reporte de Jueves
                $columna = 8;
                break;
            case 5: // Sabado -> Nos dara reporte de Viernes
                $columna = 10;
                break;
            case 6: // Domingo -> Nos dara reporte de Sabado
                $columna = 12;
                break;
            case 7: // Lunes -> Nos dara reporte de Domingo
                $columna = 14;
                break;
            default:
                $columna = 2;
                break;
        }


        $count = 1;
        $file = $_FILES["file"]["tmp_name"];
        if($file != "")
        {
            $delete = "DELETE FROM horas_tress";
            $run_delete = mysqli_query($connection, $delete);

            $file_open = fopen($file,"r");
            while(($csv = fgetcsv($file_open, 10000, ",")) !== false)
            {
                if($count < 5) {
                    $count++;
                    continue;
                } else if($columna_supervisor == 0) {
                    $x = 0;
                    while($columna_supervisor == 0)
                    {
                        if( $csv[$x] == 'Super' )
                            $columna_supervisor = $x;

                        $x++;
                        echo $x . " " . !isset($csv[$x]);
                        if(!isset($csv[$x])) break;
                    }

                    if($columna_supervisor == 0)
                        break;
                    
                    continue;
                }

                
                $employee_number = mysqli_real_escape_string($connection,$csv[0]);
                $employee_name   = mysqli_real_escape_string($connection,$csv[1]);
                $hours           = mysqli_real_escape_string($connection,$csv[$columna]);
                $supervisor      = mysqli_real_escape_string($connection,$csv[$columna_supervisor]);
                
                if($employee_number != "")
                {
                    $search = "SELECT * FROM horas_tress WHERE employee_number = '$employee_number'";
                    $run_search = mysqli_query($connection, $search);
                    
                    if($run_search)
                    {
                        if(mysqli_num_rows($run_search) == 0)
                            $query = "INSERT INTO `horas_tress`(`employee_number`,`employee_name`, `hours`, `supervisor`, `posted`) 
                                      VALUES('$employee_number','$employee_name','$hours', '$supervisor', '$date');";    
                        else
                            $query = "UPDATE horas_tress SET `employee_name`='$employee_name',`hours` = '$hours', `supervisor` = '$supervisor', posted = '$date' 
                                        WHERE employee_number = '$employee_number'";
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
            }
        }

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
                        <form  id="submit_csv" action="index.php?page=import_tempus" method="post" enctype="multipart/form-data">
                            <label for="date">Fecha de reporte: </label>
                            <input id="date" type="date" name="date" class="mr-3" required>
                            <input id="file" type="file" name="file" accept=".csv" required>
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
                    <table style="font-size: 12px;" class="table table-hover" id="table_tress" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee number</th>
                                <th>Employee</th>
                                <th>Hours</th>
                                <th>Supervisor</th>
                                <th>Update</th>
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
                <?php
                    $query = "SELECT DISTINCT posted FROM `horas_tress`";
                    $result = $connection->query($query);
                    if($result)
                    {
                        while($row = $result->fetch_assoc())
                        {
                            $date = $row['posted'];
                            break;
                        }
                    }
                ?>
                <h6 class="m-0 font-weight-bold text-default">Daily hours by plant <?php echo date('m/d/Y', strtotime($date)) ?></h6>
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
                                $query = "SELECT `supervisores`.`planta_supervisor` AS 'planta', ROUND(SUM(`horas_tress`.`hours`),2) AS 'horas' 
                                        FROM `horas_tress` 
                                        INNER JOIN supervisores ON `horas_tress`.supervisor = `supervisores`.`nombre_supervisor` 
                                        WHERE `horas_tress`.`supervisor` IN (SELECT nombre_supervisor from supervisores)
                                        GROUP BY `supervisores`.`planta_supervisor`";
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