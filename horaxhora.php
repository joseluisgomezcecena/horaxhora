<?php  
include_once("includes/header.php");
//include_once("includes/sidebar.php");
include_once("includes/top-menu.php");
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Hora X Hora</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Maquina</th>
                    <th>6:00 am</th>
                    <th>7:00 am</th>
                    <th>8:00 am</th>
                    <th>9:00 am</th>
                    <th>10:00 am</th>
                    <th>11:00 am</th>
                    <th>12:00 pm</th>
                    <th>13:00 pm</th>
                    <th>14:00 pm</th>
                    <th>15:00 pm</th>
                    <th>16:00 pm</th>
                    <th>17:00 pm</th>
                    <th>18:00 pm</th>
                    <th>19:00 pm</th>
                    <th>20:00 pm</th>
                    <th>21:00 pm</th>
                    <th>22:00 pm</th>
                    <th>23:00 pm</th>
                    <th>00:00 am</th>
                    <th>01:00 am</th>
                    <th>02:00 am</th>
                    <th>03:00 am</th>
                    <th>04:00 am</th>
                    <th>05:00 am</th>     
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Maquina</th>
                    <th>6:00 am</th>
                    <th>7:00 am</th>
                    <th>8:00 am</th>
                    <th>9:00 am</th>
                    <th>10:00 am</th>
                    <th>11:00 am</th>
                    <th>12:00 pm</th>
                    <th>13:00 pm</th>
                    <th>14:00 pm</th>
                    <th>15:00 pm</th>
                    <th>16:00 pm</th>
                    <th>17:00 pm</th>
                    <th>18:00 pm</th>
                    <th>19:00 pm</th>
                    <th>20:00 pm</th>
                    <th>21:00 pm</th>
                    <th>22:00 pm</th>
                    <th>23:00 pm</th>
                    <th>00:00 am</th>
                    <th>01:00 am</th>
                    <th>02:00 am</th>
                    <th>03:00 am</th>
                    <th>04:00 am</th>
                    <th>05:00 am</th>     
                </tr>
                </tfoot>
                <tbody>
                    <?php 
                    $query = "SELECT * FROM horas";
                    $result = mysqli_query($connection, $query);
                    if(!$result)
                    {
                        die($query);
                    }
                        while($row = mysqli_fetch_array($result)):
                    
                    ?>


                    <tr>
                        <td><?php echo $row['maquina']; ?></td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="6" name="6" value="<?php echo $row['6'] ?>">
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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