<?php
    include_once "_config/db.php";
    include_once "_config/ajax-functions.php";
    global $connection;

    $date = date("Y/m/d");

    $query_sumatorias_horas  = "SELECT horas.maquina, horas.planta_id, horas.`6` + horas.`7`+ horas.`8`+ horas.`9`+ horas.`10`+ horas.`11`+ horas.`12`+ horas.`13`+ horas.`14`+ horas.`15` AS 'turno1_horas', horas.`16`+ horas.`17`+ horas.`18`+ horas.`19`+ horas.`20`+ horas.`21`+ horas.`22` AS 'turno2_horas', horas.`23`+ horas.`24`+ horas.`1`+ horas.`2`+ horas.`3`+ horas.`4`+ horas.`5` AS 'turno3_horas', horas.total AS 'total_horas', 
                                plan.`6` + plan.`7`+ plan.`8`+ plan.`9`+ plan.`10`+ plan.`11`+ plan.`12`+ plan.`13`+ plan.`14`+ plan.`15` AS 'turno1_plan', plan.`16`+ plan.`17`+ plan.`18`+ plan.`19`+ plan.`20`+ plan.`21`+ plan.`22` AS 'turno2_plan', plan.`23`+ plan.`24`+ plan.`1`+ plan.`2`+ plan.`3`+ plan.`4`+ plan.`5` AS 'turno3_plan', plan.total AS 'total_plan'
                                FROM horas 
                                INNER JOIN plan ON plan.maquina = horas.maquina
                                WHERE horas.total > 0 OR plan.total > 0";

    $result_sumatorias_horas = $connection->query($query_sumatorias_horas);
    if($result_sumatorias_horas)
    {
        if($result_sumatorias_horas->num_rows > 0)
        {
            while($row_sumatorias_horas = $result_sumatorias_horas->fetch_assoc())
            {
                $maquina       = $row_sumatorias_horas['maquina'];
                $planta        = $row_sumatorias_horas['planta_id'];
                $horas_turno1  = $row_sumatorias_horas['turno1_horas'];
                $horas_turno2  = $row_sumatorias_horas['turno2_horas'];
                $horas_turno3  = $row_sumatorias_horas['turno3_horas'];
                $horas_total   = $row_sumatorias_horas['total_horas'];
                $plan_turno1   = $row_sumatorias_horas['turno1_plan'];
                $plan_turno2   = $row_sumatorias_horas['turno2_plan'];
                $plan_turno3   = $row_sumatorias_horas['turno3_plan'];
                $plan_total    = $row_sumatorias_horas['total_plan'];
                
                $query_insert_sumatoria = "INSERT INTO datos_diarios(maquina, planta_id, date, realizado_turno1, realizado_turno2, realizado_turno3, realizado_total, planeado_turno1, planeado_turno2, planeado_turno3, planeado_total) 
                                            VALUES('$maquina', $planta, '$date', $horas_turno1, $horas_turno2, $horas_turno3, $horas_total, $plan_turno1, $plan_turno2, $plan_turno3, $plan_total)";

                $connection->query($query_insert_sumatoria);
            }
        }
    }

    $query_limpiar_horas = "UPDATE horas SET `6`=0 `7`=0, `8`=0,`9`=0,`10`=0,`11`=0,`12`=0,`13`=0,`14`=0,`15`=0,`16`=0,`17`=0,`18`=0,`19`=0,`20`=0,`21`=0,`22`=0,`23`=0,`24`=0,`1`=0,`2`=0,`3`=0,`4`=0,`5`=0,total = 0";
    $connection->query($query_limpiar_horas);
    
    $query_limpiar_plan = "UPDATE plan SET `6`=0, `7`=0, `8`=0,`9`=0,`10`=0,`11`=0,`12`=0,`13`=0,`14`=0,`15`=0,`16`=0,`17`=0,`18`=0,`19`=0,`20`=0,`21`=0,`22`=0,`23`=0,`24`=0,`1`=0,`2`=0,`3`=0,`4`=0,`5`=0,total = 0, fecha = '$date', lleno = 0, hora_pendiente = 6, minutos_pendientes = 60;;";
    $connection->query($query_limpiar_plan);
    
    $query_limpiar_plan = "UPDATE plan_items SET `6`= null, `7`= null, `8`= null,`9`= null,`10`= null,`11`= null,`12`= null,`13`= null,`14`= null,`15`= null,`16`= null,`17`= null,`18`= null,`19`= null,`20`= null,`21`= null,`22`= null,`23`= null,`24`= null,`1`= null,`2`= null,`3`= null,`4`= null,`5`= null";
    $connection->query($query_limpiar_plan);

    $query_create_plan_actual  = "SELECT orden_id FROM ordenes_main WHERE estado = 1";
    $result_create_plan_actual = $connection->query($query_create_plan_actual);
    if($result_create_plan_actual)
    {
        if($result_create_plan_actual->num_rows > 0)
        {
            while($row_create_plan_actual = $result_create_plan_actual->fetch_assoc())
            {
                agregar_reporteA($row_create_plan_actual['orden_id']);
            }
            $result_create_plan_actual->close();
        }
    }
    else
    {
        echo "Failed with query: $query_create_plan_actual";
    }
    
    $query_create_plan_loaded  = "SELECT orden_id FROM ordenes_main WHERE estado != 2";
    $result_create_plan_loaded = $connection->query($query_create_plan_loaded);
    if($result_create_plan_loaded)
    {
        if($result_create_plan_loaded->num_rows > 0)
        {
            while($row_create_plan_loaded = $result_create_plan_loaded->fetch_assoc())
            {
                agregar_reporteA($row_create_plan_loaded['orden_id']);
            }
            $result_create_plan_loaded->close();
        }
    }
    else
    {
        echo "Failed with query: $query_create_plan_loaded";
    }