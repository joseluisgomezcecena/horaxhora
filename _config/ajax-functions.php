<?php
date_default_timezone_set("America/Tijuana");

include_once "db.php";
global $connection;

$rep  = 0; //global variable
$dias = 0;

if(isset($_GET['f']))
{
    if($_GET['f'] == "addOrder")
    {
        $work_order    = htmlspecialchars($_GET['workorder']);
        $item          = htmlspecialchars($_GET['item']);
        $machine       = htmlspecialchars($_GET['machine']);
        $quantity      = htmlspecialchars($_GET['quantity']);

        /* filter space and transform to upper */
        $work_order = str_replace(" ", "", strtoupper($work_order));
        $item       = str_replace(" ", "", strtoupper($item));

        /* Search name, display and cell for machine */
        $query_machine_data  = "SELECT display, celda FROM horas WHERE maquina = '$machine'";
        $result_machine_data = $connection->query($query_machine_data);
        if($result_machine_data)
        {
            if($result_machine_data->num_rows == 1)
            {
                while($row_machine_data = $result_machine_data->fetch_assoc())
                {
                    $display      = $row_machine_data['display'];
                    $celda        = $row_machine_data['celda'];
                }
            }
        }
        else
        {
            echo "Fail in: " . $query_machine_data;
        }

        /* Search breaks */
        $query_breaks  = "SELECT turno_1, turno_2, turno_3 FROM celdas_descansos WHERE celda = '$celda'";
        $result_breaks = $connection->query($query_breaks);
        if($result_breaks)
        {
            if($result_breaks->num_rows == 1)
            {
                while($row_breaks = $result_breaks->fetch_assoc())
                {
                    $break_1 = $row_breaks['turno_1'];
                    $break_2 = $row_breaks['turno_2'];
                    $break_3 = $row_breaks['turno_3'];
                }
            }
            else
            {
                $break_1 = 0;
                $break_2 = 0;
                $break_3 = 0;
            }
        }
        else
        {
            echo "Fail in: " . $query_breaks;
        }

        /* Search pph and setup */
        $query_pph_setup  = "SELECT  pph, setup FROM pph WHERE routing = '$item' AND facility = '$machine'";
        $result_pph_setup = $connection->query($query_pph_setup);
        if($result_pph_setup)
        {
            if($result_pph_setup->num_rows > 0)
            {
                while($row_pph_setup = $result_pph_setup->fetch_assoc())
                {
                    $pph   = $row_pph_setup['pph'];
                    $setup = $row_pph_setup['setup'] * 60;
                }
            }
            else
            {
                $pph   = 0;
                $setup = 0;
            }
        }
        else
        {
            echo "Fail in: " . $query_pph_setup;
        }

        //turno_1, turno_2, turno_3 FROM celdas_descansos WHERE celda = '$celda')



        $stmt   = $connection->prepare("INSERT INTO ordenes_main(`work_order`, `item`, `meta_orden`, `maquina`, `pph_std`, `setup`, `display`, `celda`, `break1`, `break2`, `break3`) VALUES(?, ?, ?, ?, $pph, $setup, $display, '$celda', $break_1, $break_2, $break_3)");
        $stmt->bind_param("ssis", $work_order, $item, $quantity, $machine);
        $result = $stmt->execute();

        if($result)
        {
            $last_id = $connection->insert_id;

            echo "<td>$work_order</td>";
            echo "<td>$item</td>";
            echo "<td>$quantity</td>";
            echo "<td>$machine</td>";
            echo "<td>$pph</td>";
            echo "<td>$setup</td>";
            echo "<td style=\"text-align: center\"><button class=\"btn btn-primary start-order\" data-id=\"$last_id\">Comenzar <i class=\"fas fa-play\"></i></button> <button class=\"btn btn-warning edit-order\" data-id=\"$last_id\">Editar <i class=\"fas fa-edit\"></i></button> <button class=\"btn btn-danger delete-order\" data-id=\"$last_id\">Eliminar <i class=\"fas fa-trash-alt\"></i></button> </td>";
        }
        

        

    }
    if($_GET['f'] == "startOrder")
    {
        $id   = $_GET['id'];
        $pph  = $_GET['pph'];
        $hc   = $_GET['hc'];
        $date = date("Y/m/d H:i");
        $turno = turno(date("H:i"));

        $query = "UPDATE `ordenes_main` SET `estado` = 1, `pph_std` = $pph, `fecha_inicial` = '$date', `fecha_reinicio` = '$date', `head_count$turno` = $hc WHERE `orden_id` = $id;";
       /*
        switch($turno)
        {
            case 1:
                $query .= "UPDATE `ordenes_main` SET `head_count1` = $hc WHERE orden_id = $id;";
                break;
            case 2:
                $query .= "UPDATE ordenes_main SET head_count2 = $hc WHERE orden_id = $id;";
                break;
            case 3:
                $query .= "UPDATE ordenes_main SET head_count3 = $hc WHERE orden_id = $id;";
                break;
        }
        */

        $result_insert = $connection->query($query);
        if($result_insert)
        {
            echo "start";
            agregar_reporteA($id);
        }
        else
        {
            echo "Fail with: " . $query;
        }
    }
    if($_GET['f'] == "editOrder")
    {
        $work_order    = htmlspecialchars($_GET['workorder']);
        $item          = htmlspecialchars($_GET['item']);
        $machine       = htmlspecialchars($_GET['machine']);
        $quantity      = htmlspecialchars($_GET['quantity']);
        $pph           = htmlspecialchars($_GET['pph']);
        $setup         = htmlspecialchars($_GET['setup']);

        $id            = htmlspecialchars($_GET['id']);

        $stmt_edit = $connection->prepare("UPDATE ordenes_main SET work_order = ?, item = ?, maquina = ?, meta_orden = ?, pph_std = ?, setup = ? WHERE orden_id = $id ");
        $stmt_edit->bind_param("sssidi", $work_order, $item, $machine, $quantity, $pph, $setup);
        $result = $stmt_edit->execute();

        if($result)
        {
            echo "edit";
        }
    }
    if($_GET['f'] == "deleteOrder")
    {
        $id = $_GET['id'];

        $query  = "DELETE FROM ordenes_main WHERE orden_id = $id";
        $result = $connection->query($query);
        if($result)
            echo "delete";
        else
            echo "Fail with: " . $query;
    }
    



}




function agregar_reporteA($id_orden)
{
    global $connection;
    $query_datos  = "SELECT * FROM ordenes_main WHERE orden_id = $id_orden";
    $result_datos = $connection->query($query_datos);
    if($result_datos)
    {
        while($row_datos = $result_datos->fetch_assoc())
        {
            $maquina    = $row_datos['maquina'];
            $work_order = $row_datos['work_order'];
            $cantidad   = $row_datos['meta_orden'] - $row_datos['cantidad_actual'];
            $item       = $row_datos['item'];
            $pph_std    = $row_datos['pph_std'];
            $break1     = $row_datos['break1'];
            $break2     = $row_datos['break2'];
            $break3     = $row_datos['break3'];
            $setup      = $row_datos['setup'];
            $fecha      = date("Y/m/d");
        }

        $query_insert  = "INSERT INTO plan(maquina, work_order, parte, meta, pph, fecha) VALUES('$maquina', '$work_order', '$item', $cantidad, $pph_std, '$fecha')";
        $result_insert = $connection->query($query_insert);
        if($result_insert)
        {
            $id         = $connection->insert_id;
            $hora       = date("H");
            $minutos    = 60 - date("i");
            $breaktime  = 36;
            $start_flag = 1;

            if($hora == 0) //If hour is 0 we use it like 24
                $hora = 24;

            while($cantidad > 0)
            {
                if($hora == 25) //If hour pass of 24 format restart it
                    $hora -= 24;

                //removing time of setups or breaks
                if($start_flag == 1)
                {
                    $start_flag = 0;
                    $minutos -= $setup;
                }

                if($hora == $break1 || $hora == $break2 || $hora == $break3)
                    $minutos -= $breaktime;
                
                if($hora == 6 || $hora == 15 || $hora == 23)
                    $minutos -= 15;

                while($minutos <= 0) //Change hour
                {
                    $minutos += 60;
                    $hora++;
                    if($hora == 25)
                        $hora -= 24;
                    else if($hora == 6)
                        $id = cambio_dia($id, $cantidad);

                    if($minutos > 0)
                        break;
                }

                $cant_hour = (int)($minutos * $pph_std) / 60;
                if($cantidad > $cant_hour)
                {
                    $query_qty_hour = "UPDATE plan SET `$hora`= `$hora`+$cant_hour WHERE id = $id";
                    $cantidad -= $cant_hour;
                }
                else
                {
                    $query_qty_hour = "UPDATE plan SET `$hora`= `$hora`+$cantidad WHERE id = $id";
                    $cantidad = 0;
                }
                $result_qty_hour = $connection->query($query_qty_hour);
                if($result_qty_hour)
                {
                    $hora++;
                    $minutos = 60;

                    if($hora == 6)
                        $id = cambio_dia($id, $cantidad);
                } 
            }
        }
    }
}

function cambio_dia($id, $cantidad)
{
    global $connection;
    global $rep;
    global $dias;

    if($rep == $id)
        $dias++;
    else
    {
        $dias = 1;
        $rep = $id;
    }
    
    $fecha = date('Y-m-d',strtotime('+' . $dias . ' day'));

    $query_insert  = "INSERT INTO plan(maquina, work_order, parte, meta, pph, fecha) SELECT maquina, work_order, parte, $cantidad, pph, '$fecha' FROM plan WHERE id = $id";
    $result_insert = $connection->query($query_insert);
    if($result_insert)
    {
        return $connection->insert_id;
    }
}

function turno($time) //Regresa el turno dependiendo la hora que se meta
{
    if(strtotime($time) >= strtotime("6:00") && strtotime($time) <= strtotime("15:36"))
    {
        return 1;
    }
    else if(strtotime($time) > strtotime("15:36") && strtotime($time) <= strtotime("23:00"))
    {
        return 2;
    }
    else if(strtotime($time) > strtotime("23:00") || strtotime($time) < strtotime("6:00"))
    {
        return 3;
    }
}
?>