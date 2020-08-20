<?php  
include_once("includes/header.php");
//include_once("includes/sidebar.php");
include_once("includes/top-menu.php");
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
                        <th rowspan="2">Maquina</th>
                        <th id="6am" colspan="2">6:00 am</th>
                        <th id="7am" colspan="2">7:00 am</th>
                        <th id="8am" colspan="2">8:00 am</th>
                        <th id="9am" colspan="2">9:00 am</th>
                        <th id="10am" colspan="2">10:00 am</th>
                        <th id="11am" colspan="2">11:00 am</th>
                        <th id="12pm" colspan="2">12:00 pm</th>
                        <th id="13pm" colspan="2">13:00 pm</th>
                        <th id="14pm" colspan="2">14:00 pm</th>
                        <th id="15pm" colspan="2">15:00 pm</th>
                        <th id="16pm" colspan="2">16:00 pm</th>
                        <th id="17pm" colspan="2">17:00 pm</th>
                        <th id="18pm" colspan="2">18:00 pm</th>
                        <th id="19pm" colspan="2">19:00 pm</th>
                        <th id="20pm" colspan="2">20:00 pm</th>
                        <th id="21pm" colspan="2">21:00 pm</th>
                        <th id="22pm" colspan="2">22:00 pm</th>
                        <th id="23pm" colspan="2">23:00 pm</th>
                        <th id="12pm" colspan="2">00:00 am</th>
                        <th id="1pm" colspan="2">01:00 am</th>
                        <th id="2pm" colspan="2">02:00 am</th>
                        <th id="3pm" colspan="2">03:00 am</th>
                        <th id="4pm" colspan="2">04:00 am</th>
                        <th id="5pm" colspan="2">05:00 am</th>
                        <th id="total" colspan="2">Total</th>          
                    </tr>`
                    <tr>
                        <th>Real</th><th>Planeado</th>
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>    
                        <th>Real</th><th>Planeado</th>  
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th rowspan="2">Maquina</th>
                        <th>Real</th><th>Planeado</th>
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>  
                        <th>Real</th><th>Planeado</th>    
                        <th>Real</th><th>Planeado</th>  
                    </tr>
                    <tr>
                        <th colspan="2">6:00 am</th>
                        <th colspan="2">7:00 am</th>
                        <th colspan="2">8:00 am</th>
                        <th colspan="2">9:00 am</th>
                        <th colspan="2">10:00 am</th>
                        <th colspan="2">11:00 am</th>
                        <th colspan="2">12:00 pm</th>
                        <th colspan="2">13:00 pm</th>
                        <th colspan="2">14:00 pm</th>
                        <th colspan="2">15:00 pm</th>
                        <th colspan="2">16:00 pm</th>
                        <th colspan="2">17:00 pm</th>
                        <th colspan="2">18:00 pm</th>
                        <th colspan="2">19:00 pm</th>
                        <th colspan="2">20:00 pm</th>
                        <th colspan="2">21:00 pm</th>
                        <th colspan="2">22:00 pm</th>
                        <th colspan="2">23:00 pm</th>
                        <th colspan="2">00:00 am</th>
                        <th colspan="2">01:00 am</th>
                        <th colspan="2">02:00 am</th>
                        <th colspan="2">03:00 am</th>
                        <th colspan="2">04:00 am</th>
                        <th colspan="2">05:00 am</th>
                        <th colspan="2">Total</th>     
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    // " A.`6` as '6P', B.`6` as '6R', A.`7` as '7P', B.`7` as '7R', A.`8` as '8P', B.`8` as '8R', A.`9` as '9P', B.`9` as '9:00 am Real', A.`10` as '10:00 am Planeado', B.`10` as '10:00 am Real', A.`11` as '11:00 am Planeado', B.`11` as '11:00 am Real', A.`12` as '12:00 pm Planeado', B.`12` as '12:00 pm Real', A.`13` as '1:00 pm Planeado', B.`13` as '1:00 pm Real', A.`14` as '2:00 pm Planeado', B.`14` as '2:00 pm Real', A.`15` as '3:00 pm Planeado', B.`15` as '3:00 pm Real', A.`16` as '4:00 pm Planeado', B.`16` as '4:00 pm Real', A.`17` as '5:00 pm Planeado', B.`17` as '5:00 pm Real', A.`18` as '6:00 pm Planeado', B.`18` as '6:00 pm Real', A.`19` as '7:00 pm Planeado', B.`19` as '7:00 pm Real', A.`20` as '8:00 pm Planeado', B.`20` as '8:00 pm Real', A.`21` as '9:00 pm Planeado', B.`21` as '9:00 pm Real', A.`22` as '10:00 pm Planeado', B.`22` as '10:00 pm Real', A.`23` as '11:00 pm Planeado', B.`23` as '11:00 pm Real', A.`24` as '12:00 am Planeado', B.`24` as '12:00 am Real', A.`1` as '1:00 am Planeado', B.`1` as '1:00 am Real', A.`2` as '2:00 am Planeado', B.`2` as '2:00 am Real', A.`3` as '3:00 am Planeado', B.`3` as '3:00 am Real', A.`4` as '4:00 am Planeado', B.`4` as '4:00 am Real', A.`5` as '5:00 am Planeado', B.`5` as '5:00 am Real',cumple, A.total as 'Piezas totales planeadas', B.total as 'Piezas totales producidas' from plan as A, horas as B where B.Maquina = A.Maquina and A.planta_id = 1
                    $query = "SELECT A.maquina, A.`6` as '6:00 am planeado', B.`6` as '6:00 am Real', A.`7` as '7:00 am Planeado', B.`7` as '7:00 am Real', A.`8` as '8:00 am Planeado', B.`8` as '8:00 am Real', A.`9` as '9:00 am Planeado', B.`9` as '9:00 am Real', A.`10` as '10:00 am Planeado', B.`10` as '10:00 am Real', A.`11` as '11:00 am Planeado', B.`11` as '11:00 am Real', A.`12` as '12:00 pm Planeado', B.`12` as '12:00 pm Real', A.`13` as '1:00 pm Planeado', B.`13` as '1:00 pm Real', A.`14` as '2:00 pm Planeado', B.`14` as '2:00 pm Real', A.`15` as '3:00 pm Planeado', B.`15` as '3:00 pm Real', A.`16` as '4:00 pm Planeado', B.`16` as '4:00 pm Real', A.`17` as '5:00 pm Planeado', B.`17` as '5:00 pm Real', A.`18` as '6:00 pm Planeado', B.`18` as '6:00 pm Real', A.`19` as '7:00 pm Planeado', B.`19` as '7:00 pm Real', A.`20` as '8:00 pm Planeado', B.`20` as '8:00 pm Real', A.`21` as '9:00 pm Planeado', B.`21` as '9:00 pm Real', A.`22` as '10:00 pm Planeado', B.`22` as '10:00 pm Real', A.`23` as '11:00 pm Planeado', B.`23` as '11:00 pm Real', A.`24` as '12:00 am Planeado', B.`24` as '12:00 am Real', A.`1` as '1:00 am Planeado', B.`1` as '1:00 am Real', A.`2` as '2:00 am Planeado', B.`2` as '2:00 am Real', A.`3` as '3:00 am Planeado', B.`3` as '3:00 am Real', A.`4` as '4:00 am Planeado', B.`4` as '4:00 am Real', A.`5` as '5:00 am Planeado', B.`5` as '5:00 am Real', A.total as 'Piezas totales planeadas', B.total as 'Piezas totales producidas' FROM horas as A, plan as B where B.Maquina = A.Maquina";
                    $result = mysqli_query($connection, $query);
                    if(!$result)
                    {
                        die($query);
                    }
                        while($row = mysqli_fetch_array($result)):
                    
                    ?>


                    <tr>
                        <td><?php echo $row['maquina']; ?></td>
                        <?php
                            $hr = 6;
                            for($x = 1; $x < count($row); $x++)
                            { 
                        ?>
                                
                                <td>
                                    <input class="tablahrxhr" data-maquina="<?php echo $row['maquina'] ?>" data-hr="<?php echo $hr;?>" name="value" value="<?php echo $row[$x] ?>">
                                </td>
                                <td>
                                    <?php 
                                        $x++;
                                        echo $row[$x];
                                    ?>
                                </td>
                        <?php
                                if($x == 50)
                                    break;

                                $hr++;
                            }
                        ?>
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