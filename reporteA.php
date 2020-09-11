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
<style>
    input
    {
        border: none;
        text-align: center;
    }
</style>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Hora X Hora</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Maquina</th>
                        <th id="6am" >6:00 am</th>
                        <th id="7am" >7:00 am</th>
                        <th id="8am" >8:00 am</th>
                        <th id="9am" >9:00 am</th>
                        <th id="10am" >10:00 am</th>
                        <th id="11am" >11:00 am</th>
                        <th id="12pm" >12:00 pm</th>
                        <th id="13pm" >13:00 pm</th>
                        <th id="14pm" >14:00 pm</th>
                        <th id="15pm" >15:00 pm</th>
                        <th id="16pm" >16:00 pm</th>
                        <th id="17pm" >17:00 pm</th>
                        <th id="18pm" >18:00 pm</th>
                        <th id="19pm" >19:00 pm</th>
                        <th id="20pm" >20:00 pm</th>
                        <th id="21pm" >21:00 pm</th>
                        <th id="22pm" >22:00 pm</th>
                        <th id="23pm" >23:00 pm</th>
                        <th id="12pm" >00:00 am</th>
                        <th id="1pm" >01:00 am</th>
                        <th id="2pm" >02:00 am</th>
                        <th id="3pm" >03:00 am</th>
                        <th id="4pm" >04:00 am</th>
                        <th id="5pm" >05:00 am</th>
                        <th id="total" >Total</th>          
                    </tr>`
                </thead>
                <tfoot>
                    <tr>
                        <th >Maquina</th>
                        <th >6:00 am</th>
                        <th >7:00 am</th>
                        <th >8:00 am</th>
                        <th >9:00 am</th>
                        <th >10:00 am</th>
                        <th >11:00 am</th>
                        <th >12:00 pm</th>
                        <th >13:00 pm</th>
                        <th >14:00 pm</th>
                        <th >15:00 pm</th>
                        <th >16:00 pm</th>
                        <th >17:00 pm</th>
                        <th >18:00 pm</th>
                        <th >19:00 pm</th>
                        <th >20:00 pm</th>
                        <th >21:00 pm</th>
                        <th >22:00 pm</th>
                        <th >23:00 pm</th>
                        <th >00:00 am</th>
                        <th >01:00 am</th>
                        <th >02:00 am</th>
                        <th >03:00 am</th>
                        <th >04:00 am</th>
                        <th >05:00 am</th>
                        <th >Total</th>     
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    $date = date("Y/m/d");
                    // " A.`6` as '6P', B.`6` as '6R', A.`7` as '7P', B.`7` as '7R', A.`8` as '8P', B.`8` as '8R', A.`9` as '9P', B.`9` as '9:00 am Real', A.`10` as '10:00 am Planeado', B.`10` as '10:00 am Real', A.`11` as '11:00 am Planeado', B.`11` as '11:00 am Real', A.`12` as '12:00 pm Planeado', B.`12` as '12:00 pm Real', A.`13` as '1:00 pm Planeado', B.`13` as '1:00 pm Real', A.`14` as '2:00 pm Planeado', B.`14` as '2:00 pm Real', A.`15` as '3:00 pm Planeado', B.`15` as '3:00 pm Real', A.`16` as '4:00 pm Planeado', B.`16` as '4:00 pm Real', A.`17` as '5:00 pm Planeado', B.`17` as '5:00 pm Real', A.`18` as '6:00 pm Planeado', B.`18` as '6:00 pm Real', A.`19` as '7:00 pm Planeado', B.`19` as '7:00 pm Real', A.`20` as '8:00 pm Planeado', B.`20` as '8:00 pm Real', A.`21` as '9:00 pm Planeado', B.`21` as '9:00 pm Real', A.`22` as '10:00 pm Planeado', B.`22` as '10:00 pm Real', A.`23` as '11:00 pm Planeado', B.`23` as '11:00 pm Real', A.`24` as '12:00 am Planeado', B.`24` as '12:00 am Real', A.`1` as '1:00 am Planeado', B.`1` as '1:00 am Real', A.`2` as '2:00 am Planeado', B.`2` as '2:00 am Real', A.`3` as '3:00 am Planeado', B.`3` as '3:00 am Real', A.`4` as '4:00 am Planeado', B.`4` as '4:00 am Real', A.`5` as '5:00 am Planeado', B.`5` as '5:00 am Real',cumple, A.total as 'Piezas totales planeadas', B.total as 'Piezas totales producidas' from plan as A, horas as B where B.Maquina = A.Maquina and A.planta_id = 1
                    $query = "SELECT * FROM plan WHERE plan.planta_id = $planta";
                    $result = mysqli_query($connection, $query);
                    if(!$result)
                    {
                        die($query);
                    }
                        while($row = mysqli_fetch_array($result))
                        {
                    ?>
                    <tr>
                        <td rowspan="2"><?php echo $row['maquina']; ?></td>
                        <td><?php echo $row['6']; ?></td>
                        <td><?php echo $row['7']; ?></td>
                        <td><?php echo $row['8']; ?></td>
                        <td><?php echo $row['9']; ?></td>
                        <td><?php echo $row['10']; ?></td>
                        <td><?php echo $row['11']; ?></td>
                        <td><?php echo $row['12']; ?></td>
                        <td><?php echo $row['13']; ?></td>
                        <td><?php echo $row['14']; ?></td>
                        <td><?php echo $row['15']; ?></td>
                        <td><?php echo $row['16']; ?></td>
                        <td><?php echo $row['17']; ?></td>
                        <td><?php echo $row['18']; ?></td>
                        <td><?php echo $row['19']; ?></td>
                        <td><?php echo $row['20']; ?></td>
                        <td><?php echo $row['21']; ?></td>
                        <td><?php echo $row['22']; ?></td>
                        <td><?php echo $row['23']; ?></td>
                        <td><?php echo $row['24']; ?></td>
                        <td><?php echo $row['1']; ?></td>
                        <td><?php echo $row['2']; ?></td>
                        <td><?php echo $row['3']; ?></td>
                        <td><?php echo $row['4']; ?></td>
                        <td><?php echo $row['5']; ?></td>
                        <td><?php echo $row['total']; ?></td>
                    </tr>
                        <?php
                            $query_items = "SELECT * FROM plan_items WHERE maquina = '{$row['maquina']}'";
                            $result_item = $connection->query($query_items);
                            $row_item    = $result_item->fetch_assoc();

                        ?>
                    <tr>
                        <td><?php echo $row_item['6']; ?></td>
                        <td><?php echo $row_item['7']; ?></td>
                        <td><?php echo $row_item['8']; ?></td>
                        <td><?php echo $row_item['9']; ?></td>
                        <td><?php echo $row_item['10']; ?></td>
                        <td><?php echo $row_item['11']; ?></td>
                        <td><?php echo $row_item['12']; ?></td>
                        <td><?php echo $row_item['13']; ?></td>
                        <td><?php echo $row_item['14']; ?></td>
                        <td><?php echo $row_item['15']; ?></td>
                        <td><?php echo $row_item['16']; ?></td>
                        <td><?php echo $row_item['17']; ?></td>
                        <td><?php echo $row_item['18']; ?></td>
                        <td><?php echo $row_item['19']; ?></td>
                        <td><?php echo $row_item['20']; ?></td>
                        <td><?php echo $row_item['21']; ?></td>
                        <td><?php echo $row_item['22']; ?></td>
                        <td><?php echo $row_item['23']; ?></td>
                        <td><?php echo $row_item['24']; ?></td>
                        <td><?php echo $row_item['1']; ?></td>
                        <td><?php echo $row_item['2']; ?></td>
                        <td><?php echo $row_item['3']; ?></td>
                        <td><?php echo $row_item['4']; ?></td>
                        <td><?php echo $row_item['5']; ?></td>
                        <td></td>
                    </tr>

                        <?php
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