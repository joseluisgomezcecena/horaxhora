<?php  
include_once("includes/header.php");
//include_once("includes/sidebar.php");
include_once("includes/top-menu.php");

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
                <table class="table table-bordered" id="tabla-ordenes" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th>Work order</th>
                            <th>Item</th>
                            <th>Cantidad</th>
                            <th>Maquina</th>
                            <th style="width: 100px">Fecha de Inicio</th>
                            <th>Fecha de Finalizacion</th>
                            <th>PPH Standard</th>
                            <th>Cantidad 1er turno</th>
                            <th>Cantidad 2do turno</th>
                            <th>Cantidad 3er turno</th>
                            <th>Horas totales</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr style="text-align: center">
                            <th>Work order</th>
                            <th>Item</th>
                            <th>Cantidad</th>
                            <th>Maquina</th>
                            <th style="width: 100px">Fecha de Inicio</th>
                            <th>Fecha de Finalizacion</th>
                            <th>PPH Standard</th>
                            <th>Cantidad 1er turno</th>
                            <th>Cantidad 2do turno</th>
                            <th>Cantidad 3er turno</th>
                            <th>Horas totales</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                        $query_orders  = "SELECT A.orden_id, A.work_order, A.item, A.meta_orden, A.maquina, A.fecha_inicial, A.fecha_final, A.pph_std FROM ordenes_main AS A WHERE estado = 2 AND planta_id = $planta ORDER BY A.`fecha_final` DESC";
                        $result_orders = $connection->query($query_orders);
  
                        if(!$result_orders)
                        {
                            die($query_orders);
                        }
                        if($result_orders->num_rows > 0)
                        {
                            while($row_orders = $result_orders->fetch_assoc()):

                                $final_date = new DateTime($row_orders['fecha_final']);
                                $initial_date = new DateTime($row_orders['fecha_inicial']);

                                $total_time = $final_date->diff($initial_date);
                                
                                $query_cantidades  = "SELECT SUM(B.cantidad_turno1) as cant_turno1, SUM(B.cantidad_turno2) as cant_turno2, SUM(B.cantidad_turno3) as cant_turno3 FROM ordenes_diarias AS B WHERE B.id_orden = {$row_orders['orden_id']}";
                                $result_cantidades = $connection->query($query_cantidades);
                                if($result_cantidades)
                                {
                                    if($result_cantidades->num_rows == 1)
                                    {
                                        $row_cantidades = $result_cantidades->fetch_assoc();
                                        $cantidad_turno1 = $row_cantidades['cant_turno1'] > 0 ?  $row_cantidades['cant_turno1'] :  "N/A";
                                        $cantidad_turno2 = $row_cantidades['cant_turno2'] > 0 ?  $row_cantidades['cant_turno2'] :  "N/A";
                                        $cantidad_turno3 = $row_cantidades['cant_turno3'] > 0 ?  $row_cantidades['cant_turno3'] :  "N/A";
                                    }
                                }
                        ?>
                        <tr id="row<?php echo $row_orders['orden_id'];?>">
                            <td><?php echo $row_orders['work_order'];?></td>
                            <td><?php echo $row_orders['item'];?></td>
                            <td><?php echo $row_orders['meta_orden'];?></td>
                            <td><?php echo $row_orders['maquina'];?></td>
                            <td><?php echo date("m/d/Y H:i:s", strtotime($row_orders['fecha_inicial']));?></td>
                            <td><?php echo date("m/d/Y H:i:s", strtotime($row_orders['fecha_final']));?></td>
                            <td><?php echo $row_orders['pph_std'];?></td>
                            <td><?php echo $cantidad_turno1;?></td>
                            <td><?php echo $cantidad_turno2;?></td>
                            <td><?php echo $cantidad_turno3;?></td>
                            <td><?php echo round($total_time->days * 24 + $total_time->h + $total_time->i / 60, 2) . " horas";?></td>
                            
                        </tr>
                        <?php 
                        endwhile;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php 
include_once("includes/footer.php");
?>