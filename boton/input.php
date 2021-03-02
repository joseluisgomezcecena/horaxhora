<?php 
//error_reporting(0); 
require_once("includes/header.php"); 
?>

<div class="col-lg-12">
    <div class="container">
    

        <?php 
            $hr = date('G');
            $date = $hr >= 6 && $hr != 24 ? date("Y/m/d") : date("Y/m/d", strtotime("-1 days"));
            $maquina = $_GET['maquina'];
            $query = "SELECT * FROM horas WHERE maquina = '$maquina' ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);


            if($hora_actual >= "06:00:00" && $hora_actual < "07:00:00")
            {
                $cantidad = $row['6'];
                $hora = '6';
                
            }
            if($hora_actual >= "07:00:00" && $hora_actual < "08:00:00")
            {
                $cantidad =  $row['7'];
                $hora = '7';
            }
            if($hora_actual >= "08:00:00" && $hora_actual < "09:00:00")
            {
                $cantidad =  $row['8'];
                $hora = '8';
            }
            if($hora_actual >= "09:00:00" && $hora_actual < "10:00:00")
            {
                $cantidad =  $row['9'];
                $hora = '9';
                
            }
            if($hora_actual >= "10:00:00" && $hora_actual < "11:00:00")
            {
                $cantidad =  $row['10'];
                $hora = '10';
                
            }
            if($hora_actual >= "11:00:00" && $hora_actual < "12:00:00")
            {
                $cantidad =  $row['11'];
                $hora = '11';
                
            }
            if($hora_actual >= "12:00:00" && $hora_actual < "13:00:00")
            {
                $cantidad =  $row['12'];
                $hora = '12';
                
            }
            if($hora_actual >= "13:00:00" && $hora_actual < "14:00:00")
            {
                $cantidad =  $row['13'];
                $hora = '13';
                
            }
            if($hora_actual >= "14:00:00" && $hora_actual < "15:00:00")
            {
                $cantidad =  $row['14'];
                $hora = '14';
                
            }
            if($hora_actual >= "15:00:00" && $hora_actual < "16:00:00")
            {
                $cantidad =  $row['15'];
                $hora = '15';
                
            }
            if($hora_actual >= "16:00:00" && $hora_actual < "17:00:00")
            {
                $cantidad =  $row['16'];
                $hora = '16';
                
            }
            if($hora_actual >= "17:00:00" && $hora_actual < "18:00:00")
            {
                $cantidad =  $row['17'];
                $hora = '17';
                
            }
            if($hora_actual >= "18:00:00" && $hora_actual < "19:00:00")
            {
                $cantidad =  $row['18'];
                $hora = '18';
                
            }
            if($hora_actual >= "19:00:00" && $hora_actual < "20:00:00")
            {
                $cantidad =  $row['19'];
                $hora = '19';
                
            }
            if($hora_actual >= "20:00:00" && $hora_actual < "21:00:00")
            {
                $cantidad =  $row['20'];
                $hora = '20';
                
            }
            if($hora_actual >= "21:00:00" && $hora_actual < "22:00:00")
            {
                $cantidad =  $row['21'];
                $hora = '21';
                
            }
            if($hora_actual >= "22:00:00" && $hora_actual < "23:00:00")
            {
                $cantidad =  $row['22'];
                $hora = '22';
                
            }
            if($hora_actual >= "23:00:00" && $hora_actual < "00:00:00")
            {
                $cantidad =  $row['23'];
                $hora = '23';
                
            }
            if($hora_actual >= "00:00:00" && $hora_actual < "01:00:00")
            {
                $cantidad =  $row['24'];
                $hora = '24';
                
            }
            if($hora_actual >= "01:00:00" && $hora_actual < "02:00:00")
            {
                $cantidad =  $row['1'];
                $hora = '1';
                
            }
            if($hora_actual >= "02:00:00" && $hora_actual < "03:00:00")
            {
                $cantidad =  $row['2'];
                $hora = '2';
                
            }
            if($hora_actual >= "03:00:00" && $hora_actual < "04:00:00")
            {
                $cantidad =  $row['3'];
                $hora = '3';
                
            }
            if($hora_actual >= "04:00:00" && $hora_actual < "05:00:00")
            {
                $cantidad =  $row['4'];
                $hora = '4';
                
            }
            if($hora_actual >= "05:00:00" && $hora_actual < "06:00:00")
            {
                $cantidad =  $row['5'];
                $hora = '5';
                
            }
        ?>

        <h1 style="margin-top: -50px; margin-bottom: 50px;font-size:68px;" class="text-center"><?php echo $cantidad ?></h1>

        <?php 
            $query_order  = "SELECT * FROM ordenes_main WHERE maquina = '$maquina' AND estado = 1";
            $result_order = $connection->query($query_order);
            if($result_order) {
                $row_order = $result_order->fetch_assoc();
                ?>
                    <h3 style="margin-bottom: 50px;font-size:52px;" class="text-center">Piezas totales de la orden <?php echo "{$row_order['work_order']}: {$row_order['cantidad_actual']}" ?> </h3>
                <?php
            }
        ?>
        <form method="post">


        <input type="hidden" name="cantidad" value="<?php echo $cantidad ?>">
        <input type="hidden" name="maquina" value="<?php echo $maquina ?>">
        <input type="hidden" name="hora" value="<?php echo $hora ?>">

        <div class="row">
            <div class="col-lg-4">
                <input style="height:120px;" class="btn btn-danger btn-block btn-lg" type="submit" name="submit" value="CAPTURAR <?php echo $_GET['maquina'] ?>">
            </div>
            
            <div class="col-lg-4">
                <input style="height:120px;" class="btn btn-primary btn-block btn-lg" type="submit" name="submit2" value="CAPTURAR <?php echo $_GET['maquina'] ?> (X2)">
            </div>    
            
            <div class="col-lg-4">               
                <input style="height:120px;" class="btn btn-warning btn-block btn-lg" type="submit" name="submit5" value="CAPTURAR <?php echo $_GET['maquina'] ?> (X5)">
            </div>
        </div>
        
	    <div style="margin-top: 15px;" class="row">
            <div class="col-lg-4">
                <input style="height:120px;" class="btn btn-info btn-block btn-lg" type="submit" name="submit6" value="CAPTURAR <?php echo $_GET['maquina'] ?> (X6)">
            </div>

            <div class="col-lg-4">
                <input style="height:120px;" class="btn btn-success btn-block btn-lg" type="submit" name="submit8" value="CAPTURAR <?php echo $_GET['maquina'] ?> (X8)">
            </div>
            
            <div class="col-lg-4">
                <input style="height:120px;" class="btn btn-dark btn-block btn-lg" type="submit" name="submit10" value="CAPTURAR <?php echo $_GET['maquina'] ?> (X10)">
            </div>

            <div class="col-lg-4">
                <input style="height:120px;" class="btn btn-secondary btn-block btn-lg" type="submit" name="submit20" value="CAPTURAR <?php echo $_GET['maquina'] ?> (X20)">
            </div>
        </div>
        
	    
        

        
                            

                    



        </form>


        <?php 
        
        if(isset($_POST['submit']))
        {
            $maquina = $_POST['maquina'];


            echo $insert = "UPDATE horas SET `$hora` = `$hora` + 1 WHERE maquina = '$maquina'";
            $run_insert = mysqli_query($connection, $insert );
		
            if($run_insert)
            {
                saveTotal($maquina, 1);
                header("Location: input.php?maquina=$maquina");
            }
        }


	    elseif(isset($_POST['submit2']))
        {
            $maquina = $_POST['maquina'];

            echo $insert = "UPDATE horas SET `$hora` = `$hora` + 2 WHERE maquina = '$maquina'";
            $run_insert = mysqli_query($connection, $insert );
		
            if($run_insert)
            {
                saveTotal($maquina, 2);
                header("Location: input.php?maquina=$maquina");
            }
        }


	    elseif(isset($_POST['submit5']))
        {
            $maquina = $_POST['maquina'];

            echo $insert = "UPDATE horas SET `$hora` = `$hora` + 5 WHERE maquina = '$maquina'";
            $run_insert = mysqli_query($connection, $insert );
		
            if($run_insert)
            {
                saveTotal($maquina, 5);
                header("Location: input.php?maquina=$maquina");
            }
        }

	    elseif(isset($_POST['submit6']))
        {
            $maquina = $_POST['maquina'];

            echo $insert = "UPDATE horas SET `$hora` = `$hora` + 6 WHERE maquina = '$maquina'";
            $run_insert = mysqli_query($connection, $insert );
		
            if($run_insert)
            {
                saveTotal($maquina, 6);
                header("Location: input.php?maquina=$maquina");
            }
        }


	    elseif(isset($_POST['submit8']))
        {
            $maquina = $_POST['maquina'];
            echo $insert = "UPDATE horas SET `$hora` = `$hora` + 8 WHERE maquina = '$maquina'";
            $run_insert = mysqli_query($connection, $insert );
            
            if($run_insert)
            {
                saveTotal($maquina, 8);
                header("Location: input.php?maquina=$maquina");
            }
        }

	    elseif(isset($_POST['submit10']))
        {
            $maquina = $_POST['maquina'];
            echo $insert = "UPDATE horas SET `$hora` = `$hora` + 10 WHERE maquina = '$maquina'";
            $run_insert = mysqli_query($connection, $insert );
            
            if($run_insert)
            {
                saveTotal($maquina, 10);
                header("Location: input.php?maquina=$maquina");
            }
        }

        elseif(isset($_POST['submit20']))
        {
            $maquina = $_POST['maquina'];
            echo $insert = "UPDATE horas SET `$hora` = `$hora` + 20 WHERE maquina = '$maquina'";
            $run_insert = mysqli_query($connection, $insert );
            
            if($run_insert)
            {
                saveTotal($maquina, 20);
                header("Location: input.php?maquina=$maquina");
            }
        }


        



        function saveTotal($maquina, $value) {
            global $connection;
            global $date;
            global $hr;

            $turno = hora_turno($hr);
             $query = "UPDATE horas SET total = `6`+`7`+`8`+`9`+`10`+`11`+`12`+`13`+`14`+`15`+`16`+`17`+`18`+`19`+`20`+`21`+`22`+`23`+`24`+`1`+`2`+`3`+`4`+`5` WHERE maquina = '$maquina'";
            $connection->query($query);
            
             
             $query_last_update  = "SELECT orden_id FROM ordenes_main WHERE maquina = '$maquina' AND estado = 1";
            $result_last_update = $connection->query($query_last_update);
            if($result_last_update)
            {
                if($result_last_update->num_rows == 1)
                {
                     
                    $row_last_update = $result_last_update->fetch_assoc();
                     $id_orden  = $row_last_update['orden_id'];

                     
                     $query_daily_order  = "SELECT * FROM ordenes_diarias WHERE id_orden = $id_orden AND fecha_dia = '$date'";
                    $result_daily_order = $connection->query($query_daily_order);
                    if($result_daily_order->num_rows == 1)
                    {
                        $update_cantidad = "UPDATE ordenes_diarias SET `cantidad_turno$turno` = `cantidad_turno$turno` + $value WHERE id_orden = $id_orden AND fecha_dia = '$date'";
                    }
                    else
                    {
                        $update_cantidad = "INSERT INTO ordenes_diarias(`cantidad_turno$turno`, id_orden, fecha_dia) VALUES($value, $id_orden, '$date')";
                    }

                     
                     $update_cantidad;
                    $connection->query($update_cantidad);
                    
                    $query_daily_data  = "SELECT * FROM datos_diarios WHERE maquina = '$maquina' AND date = '$date'";
                    $result_daily_data = $connection->query($query_daily_data);
                    if($result_daily_data->num_rows == 1)
                    {
                        //UPDATE datos_diarios SET planeado_turno1 = planeado_turno1 + (SELECT `10` FROM plan WHERE maquina = 'HEM01') WHERE maquina = 'HEM01' AND date = '2020/11/09'
                        $update_daily = "UPDATE datos_diarios SET `realizado_turno$turno` = `realizado_turno$turno` + $value, `realizado_total` = `realizado_total` + $value WHERE maquina = '$maquina' AND date = '$date'";
                    }
                    else
                    {
                        $update_daily = "INSERT INTO datos_diarios(`realizado_turno$turno`,realizado_realizado, maquina, date) VALUES($value, $value, '$maquina', '$date')";
                    }

                    if($connection->query($update_daily))
                    {
                        
                        calc_cantidad_actual($id_orden);
                        calc_eficiencia_turno($turno);
                        calc_eficiencia_total();
                    }
                }
            }
        }
        
        function calc_cantidad_actual($id_orden)
        {
            global $connection;
            //Calcular cantidad actual
            $query_cantidades  = "SELECT SUM(cantidad_turno1) AS 'cantidad_turno1', SUM(cantidad_turno2) AS 'cantidad_turno2', SUM(cantidad_turno3) AS 'cantidad_turno3' FROM ordenes_diarias WHERE id_orden = $id_orden";
            $result_cantidades = $connection->query($query_cantidades);
            if($result_cantidades->num_rows == 1)
            {
                $row_cantidades = $result_cantidades->fetch_assoc();

                $cantidad_actual = $row_cantidades['cantidad_turno1'] + $row_cantidades['cantidad_turno2'] + $row_cantidades['cantidad_turno3'];
                $query_cantidad_total = "UPDATE ordenes_main SET cantidad_actual = $cantidad_actual WHERE orden_id = $id_orden";
                if($connection->query($query_cantidad_total))
                {
                    echo "Quantity updated.";
                }
                else
                {
                    echo "Query Failed :".$query_cantidad_total;
                }
            }
        }


        function calc_eficiencia_turno($turno)
        {
            global $connection;
            global $date;
            global $maquina;

            $hr = date("H") * 1;

            if($turno == 1)
            {
                $i = 6;
                if($hr > 15)
                    $hr = 15;
            }
            else if($turno == 2)
            {
                $i = 16;
                if($hr > 23)
                    $hr = 22;
            }
            else
            {
                $i = 23;
                if($hr > 5)
                    $hr = 5;
            }

            $query_cantidades_turno  = "SELECT A.`$i`";
            $query_cantidades_turno2 = ", B.`$i` ";

            if($turno == 1 || $turno == 2)
            {
                for($i = $i + 1; $i <= $hr; $i++)
                {
                    $query_cantidades_turno .= " + A.`$i`";
                    $query_cantidades_turno2 .= " + B.`$i` ";
                }
            }
            else
            {
                for($i = $i + 1; $i >= 23 || $i <= $hr; $i++)
                {
                    if($i == 25)
                        $i -= 24;
                    $query_cantidades_turno .= " + A.`$i`";
                    $query_cantidades_turno2 .= " + B.`$i` ";
                }
            }



            if($hr == date("H"))
                $min = date("i")/60;
            else
                $min = 1;

            //$query_cantidades_turno .= " + A.`$hr` AS cantidad_total" . $query_cantidades_turno2 . " + ( B.`$hr` * $min) AS cantidad_planeada FROM horas AS A INNER JOIN plan AS B ON B.maquina = A.maquina WHERE A.maquina = '$maquina'";
            $query_cantidades_turno .= " AS cantidad_total" . $query_cantidades_turno2 . " AS cantidad_planeada FROM horas AS A INNER JOIN plan AS B ON B.maquina = A.maquina WHERE A.maquina = '$maquina'";
            $result_cantidades_turno = $connection->query($query_cantidades_turno);

            if($result_cantidades_turno)
            {
                if($result_cantidades_turno->num_rows == 1)
                {
                    while($row_cantidades_turno = $result_cantidades_turno->fetch_assoc())
                    {
                        $cantidad_realizada = $row_cantidades_turno['cantidad_total'];
                        $cantidad_planeada  = $row_cantidades_turno['cantidad_planeada'];
                    }

                    if($cantidad_planeada > 0)
                        $eficiencia_turno = round(($cantidad_realizada / $cantidad_planeada)*100, 2);
                    else
                        $eficiencia_turno = 0;

                    $select = "SELECT * FROM eficiencias WHERE maquina = '$maquina' AND dia = '$date'";
                    $result = $connection->query($select);
                    if($result)
                    {
                        if($result->num_rows == 1)
                            $query_eficiencia_turno  = "UPDATE eficiencias SET `eficiencia_turno$turno`=$eficiencia_turno WHERE maquina = '$maquina' AND dia = '$date'";
                        else 
                            $query_eficiencia_turno  = "INSERT INTO eficiencias(`eficiencia_turno$turno`, maquina, dia) VALUES($eficiencia_turno,'$maquina','$date')";
                    }
                    $result_eficiencia_turno = $connection->query($query_eficiencia_turno);
                }
            }
        }

        function calc_eficiencia_total()
        {
            global $connection;
            global $date;
            global $maquina;

            $hr = date("H") * 1;

            $query_cantidades_total  = "SELECT A.`6`";
            $query_cantidades_total2 = ", B.`6` ";

            for($i = 7; $i <= $hr; $i++)
            {
                $query_cantidades_total .= " + A.`$i`";
                $query_cantidades_total2 .= " + B.`$i` ";
            }

            if($hr == date("H"))
                $min = date("i")/60;
            else
                $min = 1;

            //$query_cantidades_total .= "+ A.`$hr` AS cantidad_total" . $query_cantidades_total2 . " + ( B.`$hr` * $min) AS cantidad_planeada FROM horas AS A INNER JOIN plan AS B ON B.maquina = A.maquina WHERE A.maquina = '$maquina'";
            $query_cantidades_total .= " AS cantidad_total" . $query_cantidades_total2 . " AS cantidad_planeada FROM horas AS A INNER JOIN plan AS B ON B.maquina = A.maquina WHERE A.maquina = '$maquina'";
            $result_cantidades_total = $connection->query($query_cantidades_total);

            if($result_cantidades_total)
            {
                if($result_cantidades_total->num_rows == 1)
                {
                    while($row_cantidades_total = $result_cantidades_total->fetch_assoc())
                    {
                        $cantidad_realizada = $row_cantidades_total['cantidad_total'];
                        $cantidad_planeada  = $row_cantidades_total['cantidad_planeada'];
                    }

                    if($cantidad_planeada > 0)
                        $eficiencia_total = round(($cantidad_realizada / $cantidad_planeada)*100, 2);
                    else
                        $eficiencia_total = 0;

                    $query_eficiencia_total  = "UPDATE eficiencias SET `eficiencia_total`=$eficiencia_total WHERE maquina = '$maquina' AND dia = '$date'";
                    $result_eficiencia_total = $connection->query($query_eficiencia_total);
                }
            }
        }

        function hora_turno($hr)
        {
            if($hr >= 6 && $hr < 16)
                return 1;
            else if($hr >= 16 && $hr < 23)
                return 2;
            else if($hr >= 23 || $hr < 6)
                return 3;
        }
        ?>

    </div>
</div>
<?php require_once("includes/footer.php"); ?>
