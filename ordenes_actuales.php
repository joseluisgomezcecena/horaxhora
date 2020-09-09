<?php  
include_once("includes/header.php");
//include_once("includes/sidebar.php");
include_once("includes/top-menu.php");

include_once "_config/ajax-functions.php";
include_once "modals/forms/start_order.php";

$turn = turno(date("H:i"));

if(isset($_GET['plant']))
{
    $planta = $_GET['plant'];
}
else
    $planta = 1;
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Hora X Hora</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 row" style="justify-content: space-between; align-items: baseline;">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabla-ordenes-actuales" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Work order</th>
                            <th>Item</th>
                            <th>Maquina</th>
                            <th>Cantidad total de orden</th>
                            <th>Cantidad actual</th>
                            <th>PPH Standard</th>
                            <th>Setup (Minutos)</th>
                            <th>Fecha de inicio</th>
                            <th>Cantidad del dia turno <?php echo turno(date("H:i")); ?></th>
                            <th>Cantidad total turno <?php echo turno(date("H:i")); ?></th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Work order</th>
                            <th>Item</th>
                            <th>Maquina</th>
                            <th>Cantidad total de orden</th>
                            <th>Cantidad actual</th>
                            <th>PPH Standard</th>
                            <th>Setup (Minutos)</th>
                            <th>Fecha de inicio</th>
                            <th>Cantidad del dia turno <?php echo $turn; ?></th>
                            <th>Cantidad total turno <?php echo $turn; ?></th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php 
                        $query_orders  = "SELECT * FROM ordenes_main WHERE estado = 1 AND planta_id = $planta";
                        $result_orders = $connection->query($query_orders);
                        if(!$result_orders)
                        {
                            die($query_orders);
                        }
                            while($row_orders = $result_orders->fetch_assoc()):
                        ?>
                        <tr id="row<?php echo $row_orders['orden_id'];?>">
                            <td><?php echo $row_orders['work_order'];?></td>
                            <td><?php echo $row_orders['item'];?></td>
                            <td><?php echo $row_orders['maquina'];?></td>
                            <td><?php echo $row_orders['meta_orden'];?></td>
                            <td><?php echo $row_orders['cantidad_actual'];?></td>
                            <td><?php echo $row_orders['pph_std'];?></td>
                            <td><?php echo $row_orders['setup'];?></td>
                            <td><?php echo date("m/d/Y H:i:s", strtotime($row_orders['fecha_inicial']));?></td>
                            <td><?php 
                                //Calculo de piezas hechas en este dia
                                $query_cantidad_turno  = "SELECT `cantidad_turno$turn` AS 'Cantidad' FROM ordenes_diarias WHERE id_orden = {$row_orders['orden_id']} AND fecha_dia = '". date('Y/m/d') ."'";
                                $result_cantidad_turno = $connection->query($query_cantidad_turno);
                                if($result_cantidad_turno)
                                {
                                    if($result_cantidad_turno->num_rows == 1)
                                    {
                                        $row_cantidad_turno = $result_cantidad_turno->fetch_assoc();
                                        echo $row_cantidad_turno['Cantidad'];
                                    }
                                    else
                                        echo "0";
                                }
                                else
                                    echo "0";
                                ?>
                            </td>
                            <td><?php 
                                //Calculo de piezas hechas en total
                                $query_cantidad_turno  = "SELECT SUM(`cantidad_turno$turn`) AS 'Cantidad' FROM ordenes_diarias WHERE id_orden = {$row_orders['orden_id']}";
                                $result_cantidad_turno = $connection->query($query_cantidad_turno);
                                if($result_cantidad_turno)
                                {
                                    if($result_cantidad_turno->num_rows == 1)
                                    {
                                        $row_cantidad_turno = $result_cantidad_turno->fetch_assoc();
                                        echo $row_cantidad_turno['Cantidad'];
                                    }
                                    else
                                        echo "0";
                                }
                                else
                                    echo "0";
                                ?>
                            </td>
                            <td style="text-align: center">
                                <button class="btn btn-success complete-order m-1" data-id="<?php echo $row_orders['orden_id'];?>">Completar <i class="fas fa-play"></i></button>
                                <button class="btn btn-warning pause-order m-1" data-id="<?php echo $row_orders['orden_id'];?>">Interrumpir <i class="fas fa-stop"></i></button>
                            </td>
                        </tr>
                        <?php 
                        endwhile;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php 
include_once("includes/footer.php");
?>