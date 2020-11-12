
<?php
require_once("../../_config/db.php");

$maquina = $_POST['maquina'];
$hr      = $_POST['hr'];
$value   = $_POST['value'];
$turno   = hora_turno($hr);
$date    = date("Y/m/d");

$query_old_qty  = "SELECT `$hr` as Hora FROM horas WHERE maquina = '$maquina'";
if($result_old_qty = $connection->query($query_old_qty))
{
    if($result_old_qty->num_rows == 1)
    {
        while($row_old_qty = $result_old_qty->fetch_assoc())
            $last_value = $row_old_qty['Hora'];
    }
}

$update = "UPDATE horas SET `$hr` = $value WHERE maquina = '$maquina' ";
$run = mysqli_query($connection, $update);
if(!$run)
{
    echo "Query Failed :".$update;
}
else
{
    echo "Update Success";
    $value = $value - $last_value;
    $connection->query("UPDATE horas SET total = `6`+`7`+`8`+`9`+`10`+`11`+`12`+`13`+`14`+`15`+`16`+`17`+`18`+`19`+`20`+`21`+`22`+`23`+`24`+`1`+`2`+`3`+`4`+`5` WHERE maquina = '$maquina'");
    

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
        if($hr > 6)
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