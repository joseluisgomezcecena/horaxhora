<?php

    include_once "_config/db.php";
    include_once "_config/ajax-functions.php";
    global $connection;

    $date = Date("Y/m/d", strtotime('-1 day'));
    echo $query_maquinas  = "SELECT * FROM `datos_diarios` WHERE date = '$date'";
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
