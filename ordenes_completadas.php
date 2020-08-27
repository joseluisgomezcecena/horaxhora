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
                            <th>Horas aplicadas 1er turno</th>
                            <th>Cantidad 1er turno</th>
                            <th>PPH real 1er turno</th>
                            <th>Eficiencia 1er turno</th>
                            <th>Horas aplicadas 2do turno</th>
                            <th>Cantidad 2do turno</th>
                            <th>PPH real 2do turno</th>
                            <th>Eficiencia 2do turno</th>
                            <th>Horas Aplicadas 3er turno</th>
                            <th>Cantidad 3er turno</th>
                            <th>PPH real 3er turno</th>
                            <th>Eficiencia 3er turno</th>
                            <th>H.A. total</th>
                            <th>PPH real total</th>
                            <th>Eficiencia total</th>
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
                            <th>Horas aplicadas 1er turno</th>
                            <th>Cantidad 1er turno</th>
                            <th>PPH real 1er turno</th>
                            <th>Eficiencia 1er turno</th>
                            <th>Horas aplicadas 2do turno</th>
                            <th>Cantidad 2do turno</th>
                            <th>PPH real 2do turno</th>
                            <th>Eficiencia 2do turno</th>
                            <th>Horas Aplicadas 3er turno</th>
                            <th>Cantidad 3er turno</th>
                            <th>PPH real 3er turno</th>
                            <th>Eficiencia 3er turno</th>
                            <th>H.A. total</th>
                            <th>PPH real total</th>
                            <th>Eficiencia total</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                        $query_orders  = "SELECT A.orden_id, A.work_order, A.item, A.meta_orden, A.maquina, A.fecha_inicial, A.fecha_final, A.pph_std, SUM(B.cantidad_turno1) as cant_turno1, SUM(B.horas_aplicadas1) as horas_aplicadas1, SUM(B.cantidad_turno2) as cant_turno2, SUM(B.horas_aplicadas2) as horas_aplicadas2, SUM(B.cantidad_turno3) as cant_turno3, SUM(B.horas_aplicadas3) as horas_aplicadas3  FROM ordenes_main AS A LEFT JOIN ordenes_diarias AS B ON B.id_orden = A.orden_id  WHERE estado = 2 AND planta_id = $planta";
                        $result_orders = $connection->query($query_orders);
                        if(!$result_orders)
                        {
                            die($query_orders);
                        }
                        if($result_orders->num_rows > 0)
                        {
                            while($row_orders = $result_orders->fetch_assoc()):
                        ?>
                        <tr id="row<?php echo $row_orders['orden_id'];?>">
                            <td><?php echo $row_orders['work_order'];?></td>
                            <td><?php echo $row_orders['item'];?></td>
                            <td><?php echo $row_orders['meta_orden'];?></td>
                            <td><?php echo $row_orders['maquina'];?></td>
                            <td><?php echo date("m/d/Y H:i:s", strtotime($row_orders['fecha_inicial']));?></td>
                            <td><?php echo date("m/d/Y H:i:s", strtotime($row_orders['fecha_final']));?></td>
                            <td><?php echo $row_orders['pph_std'];?></td>
                            <td><?php echo $row_orders['horas_aplicadas1'];?></td>
                            <td><?php echo $row_orders['cant_turno1'];?></td>
                            <td>
                                <?php
                                    if($row_orders['horas_aplicadas1'] > 0)
                                    {
                                        $pph1 = $row_orders['cant_turno1'] / $row_orders['horas_aplicadas1'];
                                        echo $pph1;
                                    }
                                    else
                                    {
                                        $pph1 = 0;
                                        echo "N/A";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($pph1 > 0 && $row_orders['pph_std'] > 0)
                                       echo (100 * ($pph1 / $row_orders['pph_std'])) . "%";
                                    else
                                        echo "N/A";
                                ?>
                            </td>
                            <td><?php echo $row_orders['horas_aplicadas2'];?></td>
                            <td><?php echo $row_orders['cant_turno2'];?></td>
                            <td>
                                <?php
                                    if($row_orders['horas_aplicadas2'] > 0)
                                    {
                                        $pph2 = $row_orders['cant_turno2'] / $row_orders['horas_aplicadas2'];
                                        echo $pph2;
                                    }
                                    else
                                    {
                                        $pph2 = 0;
                                        echo "N/A";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($pph2 > 0 && $row_orders['pph_std'] > 0)
                                       echo (100 * ($pph2 / $row_orders['pph_std'])) . "%";
                                    else
                                        echo "N/A";
                                ?>
                            </td>
                            <td><?php echo $row_orders['horas_aplicadas3'];?></td>
                            <td><?php echo $row_orders['cant_turno3'];?></td>
                            <td>
                                <?php
                                    if($row_orders['horas_aplicadas3'] > 0)
                                    {
                                        $pph3 = $row_orders['cant_turno3'] / $row_orders['horas_aplicadas3'];
                                        echo $pph3;
                                    }
                                    else
                                    {
                                        $pph3 = 0;
                                        echo "N/A";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($pph3 > 0 && $row_orders['pph_std'] > 0)
                                       echo (100 * ($pph3 / $row_orders['pph_std'])) . "%";
                                    else
                                        echo "N/A";
                                ?>
                            </td>
                            <td>
                                <?php
                                    $horas_total = $row_orders['horas_aplicadas1'] + $row_orders['horas_aplicadas2'] + $row_orders['horas_aplicadas3'];
                                    echo $horas_total;
                                ?>
                            </td>
                            <td>
                                <?php
                                    if( $horas_total > 0)
                                    {
                                        $pph_total = $row_orders['meta_orden']/$horas_total;
                                        echo $pph_total;
                                    }
                                    else
                                    {
                                        $pph_total = 0;
                                        echo "N/A";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if( $pph_total > 0 && $row_orders['pph_std'] > 0)
                                        echo (100 * ($pph_total / $row_orders['pph_std'] )) . "%";
                                    else
                                        echo "N/A";
                                ?>
                            </td>
                            
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