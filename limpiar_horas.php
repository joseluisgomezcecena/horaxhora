<?php
    include_once "_config/db.php";
    include_once "_config/ajax-functions.php";
    global $connection;

    $date = Date("Y/m/d", strtotime('-1 day'));
    $query_maquinas  = "SELECT * FROM `datos_diarios` WHERE date = '$date'";
    $result_maquinas = $connection->query($query_maquinas);
    if($result_maquinas) {
        while($row_maquinas = $result_maquinas->fetch_assoc()) {
            $maquina = $row_maquinas['maquina'];
            $eft1 = $row_maquinas['planeado_turno1'] > 0 ? ROUND(($row_maquinas['realizado_turno1']/$row_maquinas['planeado_turno1'])*100,2) : 0;
            $eft2 = $row_maquinas['planeado_turno2'] > 0 ? ROUND(($row_maquinas['realizado_turno2']/$row_maquinas['planeado_turno2'])*100,2) : 0;
            $eft3 = $row_maquinas['planeado_turno3'] > 0 ? ROUND(($row_maquinas['realizado_turno3']/$row_maquinas['planeado_turno3'])*100,2) : 0;
            $eftt = $row_maquinas['planeado_total'] > 0 ? ROUND(($row_maquinas['realizado_total']/$row_maquinas['planeado_total'])*100,2) : 0;

            echo "<br>";
            echo $query_eficiencia_total  = "UPDATE eficiencias SET `eficiencia_turno1`=$eft1, `eficiencia_turno2`=$eft2, `eficiencia_turno3`=$eft3, `eficiencia_total`=$eftt WHERE maquina = '$maquina' AND dia = '$date'";
            $result_eficiencia_total = $connection->query($query_eficiencia_total);
        }
    }
    
    echo "<br>";
    echo $query_limpiar_horas = "UPDATE horas SET `6`=0, `7`=0, `8`=0,`9`=0,`10`=0,`11`=0,`12`=0,`13`=0,`14`=0,`15`=0,`16`=0,`17`=0,`18`=0,`19`=0,`20`=0,`21`=0,`22`=0,`23`=0,`24`=0,`1`=0,`2`=0,`3`=0,`4`=0,`5`=0,total = 0";
    if(!($connection->query($query_limpiar_horas)))
        echo $connection->error;
        
    echo "<br>";
    echo $query_limpiar_plan = "UPDATE plan SET `6`=0, `7`=0, `8`=0,`9`=0,`10`=0,`11`=0,`12`=0,`13`=0,`14`=0,`15`=0,`16`=0,`17`=0,`18`=0,`19`=0,`20`=0,`21`=0,`22`=0,`23`=0,`24`=0,`1`=0,`2`=0,`3`=0,`4`=0,`5`=0,total = 0, fecha = '$date', lleno = 0, hora_pendiente = 6, minutos_pendientes = 60;";
    if(!($connection->query($query_limpiar_plan)))
        echo $connection->error;
    
    echo "<br>";
    echo $query_limpiar_plan = "UPDATE plan_items SET `6`= '', `7`= '', `8`= '',`9`= '',`10`= '',`11`= '',`12`= '',`13`= '',`14`= '',`15`= '',`16`= '',`17`= '',`18`= '',`19`= '',`20`= '',`21`= '',`22`= '',`23`= '',`24`= '',`1`= '',`2`= '',`3`= '',`4`= '',`5`= ''";
    if(!($connection->query($query_limpiar_plan)))
        echo $connection->error;

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