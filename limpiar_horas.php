<?php
    include_once "_config/db.php";
    include_once "_config/ajax-functions.php";
    global $connection;

    $date = Date("Y/m/d");
    
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
    
    // $query_create_plan_loaded  = "SELECT orden_id FROM ordenes_main WHERE estado = 0 OR estado = 3";
    // $result_create_plan_loaded = $connection->query($query_create_plan_loaded);
    // if($result_create_plan_loaded)
    // {
    //     if($result_create_plan_loaded->num_rows > 0)
    //     {
    //         while($row_create_plan_loaded = $result_create_plan_loaded->fetch_assoc())
    //         {
    //             agregar_reporteA($row_create_plan_loaded['orden_id']);
    //         }
    //         $result_create_plan_loaded->close();
    //     }
    // }
    // else
    // {
    //     echo "Failed with query: $query_create_plan_loaded";
    // }