<?php  
include_once("includes/header.php");
?>


<div class="row">
    <div class="col-lg-12">
        <div class="container">
        
            <table class="table talbe-striped">
                <thead>
                    <th>Maquina</th>
                    <th>Orden/Item</th>
                    <th>Actual/Planeado</th>
                    <th>Eficiencia</th>
                    <th>Andon</th>
                </thead>
                <tbody>
                    <?php 
                    //$display = $_GET['display'];
                    $fecha = date("Y-m-d H:i:s");
                    $hora = date("H:i:s");
                    //$hr = idate("H");
                    $hr = "6";

                    $query = "SELECT * FROM horas 
                    left join plan on horas.maquina = plan.maquina 
                    left join ordenes_main on horas.maquina = ordenes_main.maquina 
                    WHERE horas.display = '14' AND ordenes_main.estado = 0"; 

                    $run = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_row($run)):

                    ?>
                    <tr>
                        <td><?php echo $row['1'] ?></td>
                        
                        <td><?php echo $row['68'] ?></td>
                        
                        <td>
                            <?php



                            $x = 3;//plan
                            $y = 37;//actual
                            $h = 5;//inicio
                            
                            $acum_plan = 0;
                            $acum_actual = 0;


                            for($i = 1; $i <= $hr-5; $i++ )
                            {
                                
                                $acum_plan += $row[$x+$i]; 
                                $acum_actual += $row[$y+$i];

                            }
                            echo "@ $hr:00 <br>";
                            echo $acum_plan;
                            echo "/";
                            echo $acum_actual;


                            $eficiencia = ($acum_plan/$acum_actual)*100;
                            /*
                            if($hora >= "06:00:00" && $hora < "07:00:00" ){

                                $plan = $row['4'];
                                $actual = $row['38'];
                            }
                            if($hora >= "07:00:00" && $hora < "08:00:00" ){


                            }
                            if($hora >= "08:00:00" && $hora < "09:00:00" ){

                            }
                            if($hora >= "09:00:00" && $hora < "10:00:00" ){

                            }
                            if($hora >= "10:00:00" && $hora < "11:00:00" ){

                            }
                            if($hora >= "11:00:00" && $hora < "12:00:00" ){

                            }
                            if($hora >= "12:00:00" && $hora < "13:00:00" ){

                            }
                            if($hora >= "13:00:00" && $hora < "14:00:00" ){

                            }
                            if($hora >= "14:00:00" && $hora < "15:00:00" ){

                            }
                            if($hora >= "15:00:00" && $hora < "16:00:00" ){

                            }
                            if($hora >= "16:00:00" && $hora < "17:00:00" ){
                                
                                

                            }
                            if($hora >= "17:00:00" && $hora < "18:00:00" ){

                            }
                            if($hora >= "18:00:00" && $hora < "19:00:00" ){

                            }
                            if($hora >= "19:00:00" && $hora < "20:00:00" ){

                            }
                            if($hora >= "20:00:00" && $hora < "21:00:00" ){

                            }
                            if($hora >= "21:00:00" && $hora < "22:00:00" ){

                            }
                            if($hora >= "22:00:00" && $hora < "23:00:00" ){

                            }
                            if($hora >= "23:00:00" && $hora < "00:00:01" ){

                            }
                            if($hora >= "00:00:01" && $hora < "01:00:00" ){

                            }
                            if($hora >= "01:00:00" && $hora < "02:00:00" ){

                            }
                            if($hora >= "02:00:00" && $hora < "03:00:00" ){

                            }
                            if($hora >= "03:00:00" && $hora < "04:00:00" ){

                            }
                            if($hora >= "04:00:00" && $hora < "05:00:00" ){

                            }
                            if($hora >= "05:00:00" && $hora < "06:00:00" ){

                            }
                            */
                            ?>
                        </td>
                        
                        <td><?php echo $eficiencia; ?> %</td>
                        
                        <td><?php echo $row['68'] ?></td>
                    </tr>

                    <?php endwhile; ?>

                </tbody>
            </table>

        </div>     
    </div>
</div>

        

<?php 
include_once("includes/footer.php");
?>