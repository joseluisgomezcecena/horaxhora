<?php
date_default_timezone_set("America/Tijuana");

include_once "db.php";
global $connection;

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
        $query_machine_data  = "SELECT mdisplay, celda FROM horas WHERE maquina = $machine";
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
            echo "Fail in: " . $query_machine_name;
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

function turno($time)
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