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
        $query_machine_data  = "SELECT planta_id, display, celda FROM horas WHERE maquina = '$machine'";
        $result_machine_data = $connection->query($query_machine_data);
        if($result_machine_data)
        {
            if($result_machine_data->num_rows == 1)
            {
                while($row_machine_data = $result_machine_data->fetch_assoc())
                {
                    $planta       = $row_machine_data['planta_id'];
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
                $pph   = 100;
                $setup = 0;
            }
        }
        else
        {
            echo "Fail in: " . $query_pph_setup;
        }

        //turno_1, turno_2, turno_3 FROM celdas_descansos WHERE celda = '$celda')



        $stmt   = $connection->prepare("INSERT INTO ordenes_main(`work_order`, `item`, `meta_orden`, `maquina`, `pph_std`, `setup`, `display`, `celda`, `break1`, `break2`, `break3`, `planta_id`) VALUES(?, ?, ?, ?, $pph, $setup, $display, '$celda', $break_1, $break_2, $break_3, $planta)");
        $stmt->bind_param("ssis", $work_order, $item, $quantity, $machine);
        $result = $stmt->execute();

        if($result)
        {
            $last_id = $connection->insert_id;
            
            echo "<tr id=\"row$last_id\"><td id=\"wo$last_id\">$work_order</td>";
            echo "<td >$item</td>";
            echo "<td>$quantity</td>";
            echo "<td>$machine</td>";
            echo "<td id=\"pph$last_id\">$pph</td>";
            echo "<td>$setup</td>";
            echo "<td style=\"text-align: center\"><button class=\"btn btn-primary start-order\" data-id=\"$last_id\">Comenzar <i class=\"fas fa-play\"></i></button> <button class=\"btn btn-warning edit-order\" data-id=\"$last_id\">Editar <i class=\"fas fa-edit\"></i></button> <button class=\"btn btn-danger delete-order\" data-id=\"$last_id\">Eliminar <i class=\"fas fa-trash-alt\"></i></button> </td></tr>";


            agregar_reporteA($last_id);
        }
        

        

    }
    if($_GET['f'] == "startOrder")
    {
        $id   = $_GET['id'];
        $pph  = $_GET['pph'];
        $hc   = $_GET['hc'];
        $date = date("Y/m/d H:i");
        $turno = turno(date("H:i"));

        editar_reporteA($id);
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
            $connection->query("INSERT INTO ordenes_diarias(id_orden, fecha_dia) VALUES($id,'" . date("Y/m/d") ."');");
            echo "start";
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
            $planta     = $row_datos['planta_id'];

            if($pph_std == 0)
                $pph_std = 100;
        }

        //Search if already exist a plan in this machine
        $query_plan  = "SELECT * FROM plan WHERE maquina = '$maquina'";
        $result_plan = $connection->query($query_plan);
        if($result_plan)
        {
            if($result_plan->num_rows == 1)
            {
                while($row_plan = $result_plan->fetch_assoc())
                {
                    $lleno    = $row_plan['lleno'];

                    if($lleno == 0)
                    {
                        $id_plan  = $row_plan['id'];
                        $hora     = $row_plan['hora_pendiente'];
                        $minutos  = $row_plan['minutos_pendientes'];
    
                        if($row_plan['total'] == 0)
                        {
                            $hora    = 1 * date("H"); //1 * to quit leading zero
                            $minutos = 60 - date("i");
                        }
                    }
                    else
                    {
                        $query   = "INSERT INTO plan(maquina , planta_id, fecha) VALUES('$maquina', '$planta_id')";
                        $result  = $connection->query($query);
                        $id_plan = $connection->insert_id;
                        $hora    = 1 * date("H");
                        $minutos = 60 - date("i");
                    }
                }
            }
        }
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
                {
                    $query_finish = "UPDATE ordenes_main SET finish_one_day = 0 WHERE orden_id = $id_orden; UPDATE plan SET lleno = 1 WHERE maquina = '$maquina'";
                    $connection->multi_query($query_finish);
                    break 2;
                }
                
                if($minutos > 0)
                    break;
            }
            $cant_hour = (int)($minutos * $pph_std) / 60;
            if($cantidad > $cant_hour)
            {
                $query_qty_hour = "UPDATE plan SET `$hora`= `$hora`+$cant_hour, total = total + $cant_hour WHERE maquina = '$maquina'";
                $cantidad -= $cant_hour;
            }
            else
            {   
                $minutos_pendientes = 60 - ($cantidad * 60)/$pph_std;
                $query_qty_hour = "UPDATE plan SET `$hora`= `$hora`+$cantidad, total = total + $cantidad, hora_pendiente = $hora, minutos_pendientes = $minutos_pendientes WHERE maquina = '$maquina'";
                $cantidad = 0;
            }
            $result_qty_hour = $connection->query($query_qty_hour);
            if($result_qty_hour)
            {
                $hora++;
                $minutos = 60;

                if($hora == 6)
                {
                    $query_finish = "UPDATE ordenes_main SET finish_one_day = 0 WHERE orden_id = $id_orden; UPDATE plan SET lleno = 1 WHERE maquina = '$maquina'";
                    $connection->multi_query($query_finish);
                    break;
                }
            } 
        }
    }
    else
        echo "Error with query $query_datos, ". $connection->error;
}

function editar_reporteA($id_orden)
{
    global $connection;

    $query_ordenes_maquina  = "SELECT * FROM ordenes_main WHERE maquina = (SELECT maquina from ordenes_main WHERE orden_id = $id ) ORDER BY `ordenes_main`.`orden_id` ASC";
    $result_ordenes_maquina = $connection->query($query_ordenes_maquina);
    if($result_ordenes_maquina)
    {
        while($row_ordenes_maquina)
        {
            $maquina    = $row_ordenes_maquina['maquina'];
            $cantidad   = $row_ordenes_maquina['meta_orden'] - $row_ordenes_maquina['cantidad_actual'];
            $pph_std    = $row_ordenes_maquina['pph_std'];
            $setup      = $row_ordenes_maquina['setup'];
            $headcount1 = $row_ordenes_maquina['head_count1'];
            $headcount2 = $row_ordenes_maquina['head_count2'];
            $headcount3 = $row_ordenes_maquina['head_count3'];
            $break1     = $row_ordenes_maquina['break1'];
            $break2     = $row_ordenes_maquina['break2'];
            $break3     = $row_ordenes_maquina['break3'];

            $hora    = 1 * date("H");
            $minutos = 60 - date("i");

            
            cleanPlanbyMachine($hora, $maquina);

            $query_plan  = "SELECT * FROM plan WHERE maquina = '$maquina'";
            $result_plan = $connection->query($query_plan);
            if($result_plan)
            {
                if($result_plan->num_rows == 1)
                {
                    while($row_plan = $result_plan->fetch_assoc())
                        $id_plan  = $row_plan['id'];

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
                                {
                                    $query_finish = "UPDATE ordenes_main SET finish_one_day = 0 WHERE orden_id = $id_orden; UPDATE plan SET lleno = 1 WHERE maquina = '$maquina'";
                                    $connection->multi_query($query_finish);
                                    break 2;
                                }
                                
                                if($minutos > 0)
                                    break;
                            }
                            if($hora >= 6 && $hora <= 15)
                                $pph_por_headcount = $pph_std * $headcount1;
                            else if($hora >= 16 && $hora < 23)
                                $pph_por_headcount = $pph_std * $headcount1;
                            else if($hora >= 23  || $hora < 6)
                                $pph_por_headcount = $pph_std * $headcount1;
                            $cant_hour = (int)($minutos * $pph_por_headcount) / 60;
                            if($cantidad > $cant_hour)
                            {
                                $query_qty_hour = "UPDATE plan SET `$hora`= `$hora`+$cant_hour, total = total + $cant_hour WHERE maquina = '$maquina'";
                                $cantidad -= $cant_hour;
                            }
                            else
                            {   
                                $minutos_pendientes = 60 - ($cantidad * 60)/$pph_std;
                                $query_qty_hour = "UPDATE plan SET `$hora`= `$hora`+$cantidad, total = total + $cantidad, hora_pendiente = $hora, minutos_pendientes = $minutos_pendientes WHERE maquina = '$maquina'";
                                $cantidad = 0;
                            }
                            $result_qty_hour = $connection->query($query_qty_hour);
                            if($result_qty_hour)
                            {
                                $hora++;
                                $minutos = 60;
                
                                if($hora == 6)
                                {
                                    $query_finish = "UPDATE ordenes_main SET finish_one_day = 0 WHERE orden_id = $id_orden; UPDATE plan SET lleno = 1 WHERE maquina = '$maquina'";
                                    $connection->multi_query($query_finish);
                                    break;
                                }
                            } 
                        }
                    
                }
            }
        }
    }
}

/*
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

    $query_insert  = "INSERT INTO plan(maquina, fecha) SELECT maquina, '$fecha' FROM plan WHERE id = $id";
    $result_insert = $connection->query($query_insert);
    if($result_insert)
    {
        return $connection->insert_id;
    }
}
*/

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

function cleanPlanbyMachine($hora, $maquina) //Return a query to clean columns in database
{
    global $connection;

    $y = $hora + 1;
    $query_clean_plan = "UPDATE plan SET  `$y`=0 ";
    $query_clean_plan2 = ", `total`=`total`-`$y`";

    if($hora != 5)
    {
        for($x = $y + 1; $x < 30; $x ++ )
        {
            if($x >= 25)
                $y = $x - 24;
            else
                $y = $x;
    
            $query_clean_plan .= " ,`$y`=0";
            $query_clean_plan2 .= "-`$y`";
        }
    }
    $query_clean_plan .=  $query_clean_plan2 . " WHERE maquina = '$maquina';";
    return $connection->query($query_clean_plan);
}
?>