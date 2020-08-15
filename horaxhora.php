<<<<<<< HEAD
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
                    <th>Total</th>          
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
                    <th>Total</th>     
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
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="6" name="value" value="<?php echo $row['6'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="7" name="value" value="<?php echo $row['7'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="8" name="value" value="<?php echo $row['8'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="9" name="value" value="<?php echo $row['9'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="10" name="value" value="<?php echo $row['10'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="11" name="value" value="<?php echo $row['11'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="12" name="value" value="<?php echo $row['12'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="13" name="value" value="<?php echo $row['13'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="14" name="value" value="<?php echo $row['14'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="15" name="value" value="<?php echo $row['15'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="16" name="value" value="<?php echo $row['16'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="17" name="value" value="<?php echo $row['17'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="18" name="value" value="<?php echo $row['18'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="19" name="value" value="<?php echo $row['19'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="20" name="value" value="<?php echo $row['20'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="21" name="value" value="<?php echo $row['21'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="22" name="value" value="<?php echo $row['22'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="23" name="value" value="<?php echo $row['23'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="24" name="value" value="<?php echo $row['24'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="1" name="value" value="<?php echo $row['1'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="2" name="value" value="<?php echo $row['2'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="3" name="value" value="<?php echo $row['3'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="4" name="value" value="<?php echo $row['4'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="5" name="value" value="<?php echo $row['5'] ?>">
                        </td>
                        <td>
                            <input class="tablahrxhr"  value="<?php echo $row['total'] ?>">
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