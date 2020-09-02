<?php
    include_once "_config/db.php";
    include_once "_config/ajax-functions.php";
    global $connection;

    $date = date("Y/m/d");

    $query_limpiar_horas = "UPDATE horas SET `6`=0, `7`=0, `8`=0,`9`=0,`10`=0,`11`=0,`12`=0,`13`=0,`14`=0,`15`=0,`16`=0,`17`=0,`18`=0,`19`=0,`20`=0,`21`=0,`22`=0,`23`=0,`24`=0,`1`=0,`2`=0,`3`=0,`4`=0,`5`=0,total = 0";
    $connection->query($query_limpiar_horas);
    
    $query_limpiar_plan = "UPDATE plan SET `6`=0, `7`=0, `8`=0,`9`=0,`10`=0,`11`=0,`12`=0,`13`=0,`14`=0,`15`=0,`16`=0,`17`=0,`18`=0,`19`=0,`20`=0,`21`=0,`22`=0,`23`=0,`24`=0,`1`=0,`2`=0,`3`=0,`4`=0,`5`=0,total = 0, fecha = '$date', lleno = 0;";
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
        }
    }
    else
    {
        echo "Failed with query: $query_create_plan_actual";
    }
    
    $query_create_plan_loaded  = "SELECT orden_id FROM ordenes_main WHERE estado = 0 OR estado = 4";
    $result_create_plan_loaded = $connection->query($query_create_plan_loaded);
    if($result_create_plan_loaded)
    {
        if($result_create_plan_loaded->num_rows > 0)
        {
            while($row_create_plan_loaded = $result_create_plan_loaded->fetch_assoc())
            {
                agregar_reporteA($row_create_plan_loaded['orden_id']);
            }
        }
    }
    else
    {
        echo "Failed with query: $query_create_plan_loaded";
    }