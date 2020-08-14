<?php  
include_once("includes/header.php");
//include_once("includes/sidebar.php");
include_once("includes/top-menu.php");

include "modals/forms/load_order.php";
include "modals/forms/start_order.php";
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Hora X Hora</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 row" style="justify-content: space-between; align-items: baseline;">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            <button id="agregar-orden" class="btn btn-primary"><i class="fas fa-plus-circle mr-2"></i>Agregar nueva orden</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered" id="tabla-ordenes" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Work order</th>
                        <th>Item</th>
                        <th>Cantidad</th>
                        <th>Maquina</th>
                        <th>PPH Standard</th>
                        <th>Setup (Minutos)</th>
                        <th style="text-align: center">Opciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Work order</th>
                        <th>Item</th>
                        <th>Cantidad</th>
                        <th>Maquina</th>
                        <th>PPH Standard</th>
                        <th>Setup (Minutos)</th>
                        <th style="text-align: center">Opciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    $query_orders  = "SELECT * FROM ordenes_main WHERE estado = 0 OR estado = 3";
                    $result_orders = $connection->query($query_orders);
                    if(!$result_orders)
                    {
                        die($query_orders);
                    }
                        while($row_orders = $result_orders->fetch_assoc()):
                    ?>
                    <tr id="row<?php echo $row_orders['orden_id'];?>">
                            <td id="wo<?php echo $row_orders['orden_id'];?>"><?php echo $row_orders['work_order'];?></td>
                            <td><?php echo $row_orders['item'];?></td>
                            <td><?php echo $row_orders['meta_orden'];?></td>
                            <td><?php echo $row_orders['maquina'];?></td>
                            <td id="pph<?php echo $row_orders['orden_id'];?>"><?php echo $row_orders['pph_std'];?></td>
                            <td><?php echo $row_orders['setup'];?></td>
                            <td style="text-align: center">
                                <?php
                                    if($row_orders['estado'] == 3)
                                        echo "<button class=\"btn btn-outline-warning\">Interrumpida</button>";
                                ?>
                                <button class="btn btn-primary start-order" data-id="<?php echo $row_orders['orden_id'];?>">Comenzar <i class="fas fa-play"></i></button>
                                <button class="btn btn-warning edit-order" data-id="<?php echo $row_orders['orden_id'];?>">Editar <i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger delete-order" data-id="<?php echo $row_orders['orden_id'];?>">Eliminar <i class="fas fa-trash-alt"></i></button>
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