<?php


include_once "db.php";
global $connection;

$rep  = 0; //global variable
$dias = 0;

if(isset($_GET['f']))
{
    if($_GET['f'] == "addOrder")
    {
        $work_order    = htmlspecialchars($_POST['workorder']);
        $item          = htmlspecialchars($_POST['item']);
        $machine       = htmlspecialchars($_POST['machine']);
        $quantity      = htmlspecialchars($_POST['quantity']);

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
        if($planta == 1)
        {
            $query_pph_setup  = "SELECT  pph, setup FROM pph WHERE routing = '$item' AND facility = '$machine'";
        }
        else
        {
            $query_pph_setup  = "SELECT  pph, setup FROM pph_linea WHERE item = '$item'";
        }
        $result_pph_setup = $connection->query($query_pph_setup);
        if($result_pph_setup)
        {
            if($result_pph_setup->num_rows > 0)
            {
                while($row_pph_setup = $result_pph_setup->fetch_assoc())
                {
                    $no_pph = "";
                    $pph   = $row_pph_setup['pph'];
                    $setup = $row_pph_setup['setup'] * 60;
                }
            }
            else
            {
                $no_pph = "style='background-color: red; color: white; font-weight: bold'";
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
            echo "<td id=\"pph$last_id\" $no_pph>$pph</td>";
            echo "<td>$setup</td>";
            echo "<td style=\"text-align: center\"><button class=\"btn btn-primary start-order\" data-id=\"$last_id\">Comenzar <i class=\"fas fa-play\"></i></button> <button class=\"btn btn-warning edit-order\" data-id=\"$last_id\">Editar <i class=\"fas fa-edit\"></i></button> <button class=\"btn btn-danger delete-order\" data-id=\"$last_id\">Eliminar <i class=\"fas fa-trash-alt\"></i></button> </td></tr>";


            agregar_reporteA($last_id);
        }
    }
    else if($_GET['f'] == "startOrder")
    {
        $id    = $_GET['id'];
        $pph   = $_GET['pph'];
        $hc    = $_GET['hc'];
        if(isset($_GET['time']))
        {
            $date  = date("Y/m/d");
            $time = date("H:i", strtotime($_GET['time']));
            $turno = turno($_GET['time']);
        }
        else
        {
            $date  = date("Y/m/d");
            $time = date("H:i");
            $turno = turno(date("H:i"));
        }


        $query = "UPDATE `ordenes_main` SET `pph_std` = $pph, `fecha_inicial` = '$date $time', `fecha_reinicio` = '$date $time', `head_count$turno` = $hc WHERE `orden_id` = $id;";
        $connection->query($query);
        editar_reporteA($id);
        
        $query = "UPDATE `ordenes_main` SET `estado` = 1 WHERE `orden_id` = $id;";
        $result_insert = $connection->query($query);
        if($result_insert)
        {
            $connection->query("INSERT INTO ordenes_diarias(id_orden, fecha_dia) VALUES($id,'" . date("Y/m/d") ."');");
            echo "start";


            $select = "SELECT * FROM eficiencias WHERE maquina = (SELECT maquina from ordenes_main WHERE orden_id = $id) AND dia = '". date('Y/m/d') ."'";
            $result = $connection->query($select);
            if($result)
            {
                if($result->num_rows == 0)
                {
                    $insert = "INSERT INTO eficiencias(maquina, dia) SELECT maquina, '". date('Y/m/d') ."' from ordenes_main WHERE orden_id = $id ";
                    $result = $connection->query($insert);
                }
            }
            else
                echo "Failed query in: ". $select;
        }
        else
        {
            echo $connection->error;
        }
        
    }
    else if($_GET['f'] == "editOrder")
    {
        $id            = htmlspecialchars($_GET['id']);
        $work_order    = htmlspecialchars($_POST['workorder']);
        $item          = htmlspecialchars($_POST['item']);
        $machine       = htmlspecialchars($_POST['machine']);
        $quantity      = htmlspecialchars($_POST['quantity']);
        $pph           = htmlspecialchars($_POST['pph']);
        $setup         = htmlspecialchars($_POST['setup']);
        $headcount1    = htmlspecialchars($_POST['headcount1']);
        $headcount2    = htmlspecialchars($_POST['headcount2']);
        $headcount3    = htmlspecialchars($_POST['headcount3']);


        

        $stmt_edit = $connection->prepare("UPDATE ordenes_main SET work_order = ?, item = ?, maquina = ?, meta_orden = ?, pph_std = ?, setup = ?, head_count1 = $headcount1, head_count2 = $headcount2, head_count3 = $headcount3  WHERE orden_id = $id ");
        $stmt_edit->bind_param("sssidi", $work_order, $item, $machine, $quantity, $pph, $setup);
        $result = $stmt_edit->execute();
        if($result)
        {
            echo "edit";
        }
        else
        {
            $connection->error;
        }
    }
    else if($_GET['f'] == "deleteOrder")
    {
        $id = $_GET['id'];

        $query  = "DELETE FROM ordenes_main WHERE orden_id = $id";
        $result = $connection->query($query);
        if($result)
        {
            echo "delete";
        }
        else
            echo "Fail with: " . $query;
    }
    else if($_GET['f'] == "completeOrder")
    {
        $id_orden = $_GET['id'];
        $date     = date("Y/m/d");
        $query_complete  = "UPDATE ordenes_main SET estado = 2, fecha_final = '$date' WHERE orden_id = $id_orden";
        $result_complete = $connection->query($query_complete);
        if($result_complete)
        {
            $query_next_order  = "SELECT * FROM ordenes_main WHERE maquina = (SELECT maquina FROM ordenes_main WHERE orden_id = $id_orden) AND estado = 0 LIMIT 1";
            $result_next_order = $connection->query($query_next_order);
            if($result_next_order)
            {
                if($result_next_order->num_rows == 1)
                {
                    $row_next_order = $result_next_order->fetch_assoc();
                    $turno          = turno(date("H:i"));

                    echo "{\"workorder\" : \"{$row_next_order['work_order']}\", \"id\" : {$row_next_order['orden_id']}, \"headcount\" : {$row_next_order['head_count'.$turno]}, \"pph\" : {$row_next_order['pph_std']}}";
                }
            }
        }
    }
    else if($_GET['f'] == "pauseOrder")
    {
        $id_orden = $_GET['id'];
        $query_complete  = "UPDATE ordenes_main SET estado = 3 WHERE orden_id = $id_orden";
        $result_complete = $connection->query($query_complete);
        if($result_complete)
        {
            echo "Pause";
        }
    }
    else if($_GET['f'] == "searchOrder")
    {
        $id_orden = $_GET['id'];
        $r        = $_GET['r'];
        $turno    = turno(date("H:i"));

        $query_search  = "SELECT * FROM ordenes_main WHERE orden_id = $id_orden";
        $result_search = $connection->query($query_search);
        if($result_search)
        {
            if($result_search->num_rows == 1)
            {
                while($row_search = $result_search->fetch_assoc())
                {
                    if($r == "start")
                    {
                        $headcount = $row_search['head_count'.$turno];
                        $pph       = $row_search['pph_std'];

                        echo "{\"headcount\":$headcount, \"pph\":$pph}";
                    }
                    else if($r == "edit")
                    {
                        echo "{\"workorder\" : \"{$row_search['work_order']}\", \"item\" : \"{$row_search['item']}\", \"maquina\" : \"{$row_search['maquina']}\", \"cantidad\" : {$row_search['meta_orden']}, \"pph\" : {$row_search['pph_std']}, \"setup\" : {$row_search['setup']}, \"headcount1\" : {$row_search['head_count1']}, \"headcount2\" : {$row_search['head_count2']}, \"headcount3\" : {$row_search['head_count3']}}";
                    }
                }
            }
        }
    }

}


function agregar_reporteA($id_orden)
{
    global $connection;

    $date = date("Y/m/d");
    $query_datos  = "SELECT * FROM ordenes_main WHERE orden_id = $id_orden";
    $result_datos = $connection->query($query_datos);
    if($result_datos)
    {
        while($row_datos = $result_datos->fetch_assoc())
        {
            $maquina    = $row_datos['maquina'];
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
                        if(isset($_POST['time']))
                        {
                            $time = strtotime($_POST['time']);
                            $hora     = Date("H", $time) * 1;
                            $minutos  = 60 - Date("i", $time) * 1;
                        }
                        else
                        {
                            $hora     = $row_plan['hora_pendiente'];
                            $minutos  = $row_plan['minutos_pendientes'];
                        }

                        if($row_plan['total'] == 0)
                        {
                            if(isset($_POST['time']))
                            {
                                $time = strtotime($_POST['time']);
                                $hora     = Date("H", $time) * 1;
                                $minutos  = 60 - Date("i", $time) * 1;
                            }
                            else
                            {
                                $hora    = 1 * date("H"); //1 * to quit leading zero
                                $minutos = 60 - date("i");
                            }
                        }
                    }
                }
            }
        }
        $breaktime  = 36;
        $start_flag = 1;

        

        while($cantidad > 0 && $lleno == 0)
        {
            if($hora == 0) //If hour is 0 we use it like 24
                $hora = 24;

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
                $query_qty_hour  = "UPDATE plan SET `$hora`= `$hora`+$cant_hour, total = total + $cant_hour WHERE id = $id_plan";
                $cantidad -= $cant_hour;
            }
            else
            {   
                $minutos_pendientes = 60 - ($cantidad * 60)/$pph_std;
                $query_qty_hour = "UPDATE plan SET `$hora`= `$hora`+$cantidad, total = total + $cantidad, hora_pendiente = $hora, minutos_pendientes = $minutos_pendientes WHERE id = $id_plan";
                $cantidad = 0;
            }
            $result_qty_hour = $connection->query($query_qty_hour);
            if($result_qty_hour)
            {
                $query_plan_items  = "SELECT `$hora` as 'hora' FROM plan_items WHERE maquina = '$maquina'";
                $result_plan_items = $connection->query($query_plan_items);
                if($result_plan_items)
                {
                    if($result_plan_items->num_rows == 1)
                    {
                        $row_plan_items = $result_plan_items->fetch_assoc();
                        $columna = (!empty($row_plan_items['hora']) ? $row_plan_items['hora'] . "<br><b>$item</b>" : "<b>$item</b>");
                        $query_insert_item = "UPDATE plan_items SET `$hora` = '$columna' WHERE maquina = '$maquina'";
                        $connection->query($query_insert_item);
                    }
                }
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
        $result_datos->free();
        $connection->next_result();
    }
    else
        echo "Error with query $query_datos, ". $connection->error;
}

function editar_reporteA($id_orden)
{
    global $connection;
    $flag_clean = 1;
    $date = date("Y/m/d");
    $query_ordenes_maquina  = "SELECT * FROM ordenes_main WHERE maquina = (SELECT maquina from ordenes_main WHERE orden_id = $id_orden ) AND (estado = 0 OR estado = 3) ORDER BY `ordenes_main`.`estado` ASC, `ordenes_main`.`orden_id` ASC";
    $result_ordenes_maquina = $connection->query($query_ordenes_maquina);
    if($result_ordenes_maquina)
    {
        while($row_ordenes_maquina = $result_ordenes_maquina->fetch_assoc())
        {
            $maquina    = $row_ordenes_maquina['maquina'];
            $cantidad   = $row_ordenes_maquina['meta_orden'] - $row_ordenes_maquina['cantidad_actual'];
            $pph_std    = $row_ordenes_maquina['pph_std'];
            $item       = $row_ordenes_maquina['item'];
            $setup      = $row_ordenes_maquina['setup'];
            $headcount1 = $row_ordenes_maquina['head_count1'];
            $headcount2 = $row_ordenes_maquina['head_count2'];
            $headcount3 = $row_ordenes_maquina['head_count3'];
            $break1     = $row_ordenes_maquina['break1'];
            $break2     = $row_ordenes_maquina['break2'];
            $break3     = $row_ordenes_maquina['break3'];

            
            if($flag_clean == 1)
            {

                if(isset($_GET['time']))
                {
                    $time = strtotime($_GET['time']);
                    $hora     = Date("H", $time) * 1;
                    $minutos  = 60 - Date("i", $time) * 1;
                }
                else
                {
                    $hora    = 1 * date("H"); //1 * to quit leading zero
                    $minutos = 60 - date("i");
                }
                cleanPlanbyMachine($hora, $maquina);
                $flag_clean = 0;
            }

            //_config/ajax-functions.php?f=startOrder&id=41&pph=100&hc=2
            
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
                            $pph_por_headcount = $pph_std * $headcount2;
                        else if($hora >= 23  || $hora < 6)
                            $pph_por_headcount = $pph_std * $headcount3;

                        $cant_hour = (int)($minutos * $pph_por_headcount) / 60;

                        if($cantidad > $cant_hour)
                        {
                            $query_qty_hour = "UPDATE plan SET `$hora`= `$hora`+$cant_hour, total = total + $cant_hour WHERE id = $id_plan";
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
                            $query_plan_items  = "SELECT `$hora` as 'hora' FROM plan_items WHERE maquina = '$maquina'";
                            $result_plan_items = $connection->query($query_plan_items);
                            if($result_plan_items)
                            {
                                if($result_plan_items->num_rows == 1)
                                {
                                    $row_plan_items = $result_plan_items->fetch_assoc();
                                    $columna = (!empty($row_plan_items['hora']) ? $row_plan_items['hora'] . "<br><b>$item</b>" : "<b>$item</b>");
                                    $query_insert_item = "UPDATE plan_items SET `$hora` = '$columna' WHERE maquina = '$maquina'";
                                    $connection->query($query_insert_item);
                                }
                            }
                            $hora++;
                            $minutos = 60;
            
                            if($hora == 6)
                            {
                                $query_finish = "UPDATE ordenes_main SET finish_one_day = 0 WHERE orden_id = $id_orden; UPDATE plan SET lleno = 1 WHERE id = $id_plan";
                                $connection->multi_query($query_finish);
                                break;
                            }
                        } 
                    }
                }
                $result_plan->free();
                $connection->next_result();
            }
        }
        
        $result_ordenes_maquina->free();
        $connection->next_result();
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

function hora_turno($hr)
{
    if($hr > 6 && $hr <= 15)
        return 1;
    else if($hr > 15 && $hr <= 23)
        return 2;
    else if($hr > 23 || $hr < 6)
        return 3;
}

function cleanPlanbyMachine($hora, $maquina) //Clean columns in database
{
    global $connection;

    $query = "UPDATE plan, horas, plan_items SET plan.`$hora`=0, plan.`total`=plan.`total`-plan.`$hora`, plan_items.`$hora` = null WHERE horas.`$hora` = 0 AND horas.maquina = plan.maquina AND horas.maquina = '$maquina'";
    $connection->query($query);

    $y = $hora + 1;
    $query_clean_plan  = "UPDATE plan SET  `$y`=0 ";
    $query_clean_plan2 = "UPDATE plan SET `total`=`total`-`$y`";

    $query_clean_plan_items  = "UPDATE plan_items SET  `$y`= null ";

    if($hora != 5)
    {
        for($x = $y + 1; $x < 30; $x ++ )
        {
            if($x >= 25)
                $y = $x - 24;
            else
                $y = $x;
    
            $query_clean_plan .= " , `$y`=0";
            $query_clean_plan2 .= "-`$y`";

            $query_clean_plan_items  .= " , `$y`= null ";
        }
    }

    $query_clean_plan2 = " $query_clean_plan2 WHERE maquina = '$maquina';"; 
    $connection->query($query_clean_plan2);
    
    $query_clean_plan = $query_clean_plan . " WHERE maquina = '$maquina';";
    $connection->query($query_clean_plan);
    
    $query_clean_plan_items = $query_clean_plan_items . " WHERE maquina = '$maquina';";
    $connection->query($query_clean_plan_items);

    
}

?>