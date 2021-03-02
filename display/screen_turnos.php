<?php  
include_once("includes/header.php");
?>


<div class="row">
    <div style="padding-right:0; padding-left:0;" class="col-lg-8">
        <div >
        
            <table class="table talbe-striped table-hover">
                <thead style="" class="thead-dark text-center">
                    <th style="width: 15%;">Maquina</th>
                    <th style="width: 15%;">Orden/Item</th>
                    <th style="width: 20%;">Actual/Planeado</th>
                    <th style="width: 20%;">Eficiencia</th>
                </thead>
                <tbody class="text-center"  id="table1">
                    
                    
                    
                    <?php 
                        /**********************QUERY Y CALCULOS***********************/

                        //$display = $_GET['display'];
                        $fecha = date("Y-m-d H:i:s");
                        $hora = date("H:i:s");
                        //$hr = idate("H");
                        $hr = ("5");
                        $query = "SELECT * FROM horas 
                        left join plan on horas.maquina = plan.maquina 
                        left join ordenes_main on horas.maquina = ordenes_main.maquina 
                        WHERE horas.display = '14' AND ordenes_main.estado = 0"; 

                        $run = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_row($run)):

                        //vars
                        //$limit = 18;
                        $maquina    =  $row['1'];
                        $planta_id  =  $row['2'];
                        $orden      =  $row['68'];   
                        $item       =  $row['69'];   

                        

                        //calculo de acumulado y eficiencia
                        
                        $x = 3;//plan
                        $y = 37;//actual
                        $h = 5;//inicio
                        $limit = $hr-5;
                        
                        if($limit<=0)
                            $limit= $limit+24;
                        elseif($limit>18)
                            $limit= $limit+5;
                        else    
                            $limit = $hr-5;

                        //echo "limite:".$limit;
                        $acum_plan = 0;
                        $acum_actual = 0;


                        if($hr>=6 && $hr <16)
                        {
                            //echo "turno :primer<br>";
                            //echo "limite: $limit<br>";
                            for($i = 1; $i <= $limit; $i++ )
                            {
                                
                                $acum_plan += $row[$x+$i]; 
                                $acum_actual += $row[$y+$i];
    
                            }
                        }

                        

                        if($hr>=16 && $hr <23)
                        {
                            //echo "turno :segundo<br>";
                            //echo "limite: $limit<br>";
                            for($i = 13; $i <= $limit; $i++ )
                            {
                                
                                $acum_plan += $row[$x+$i]; 
                                $acum_actual += $row[$y+$i];
    
                            }
                        }


                        if($hr==23)
                        {
                            //echo "turno :segundo 2<br>";
                            //echo "limite: $limit<br>";
                            for($i = 20; $i <= $limit; $i++ )
                            {
                                
                                $acum_plan += $row[$x+$i]; 
                                $acum_actual += $row[$y+$i];
    
                            }
                        }



                        if($hr>=1 && $hr <6)
                        {
                            //echo "turno :tercer<br>";
                            //echo "limite: $limit<br>";
                            for($i = 20; $i <= $limit; $i++ )
                            {
                                
                                $acum_plan += $row[$x+$i]; 
                                $acum_actual += $row[$y+$i];
    
                            }
                        }
                       
                       

                        $eficiencia = round(($acum_plan/$acum_actual)*100,1);
                        
                        if($eficiencia >= 100)
                            $background = "green";
                        elseif($eficiencia > 80 && $eficiencia < 100)
                            $background = "yellow";
                        else
                            $background = "red";   
                            
                        /**********************QUERY Y CALCULOS***********************/    
                    ?>


                    <tr>
                        <td><?php echo $maquina ?></td>
                        
                        <td><?php echo $orden ?><br><?php echo $item ?></td>
                        
                        <td>
                            <?php
                            echo "@ $hr:00 <br>";
                            echo $acum_plan;
                            echo "/";
                            echo $acum_actual;  
                            ?>
                        </td>
                        
                        <td style='color:white; font-size:48px; background-color: <?php echo $background ?>'><?php echo $eficiencia; ?> %</td>
                        
                    </tr>


                    <?php 
                    endwhile; 
                    ?>

                </tbody>
            </table>

        </div>     
    </div>



    <div style="padding-right:0; padding-left:0;" class="col-lg-4">
        <table class="table talbe-striped table-hover">
            <thead class="thead-dark text-center">
                <th >Andon</th>
            </thead>
            <tbody class="text-center"  id="table2">
                <?php 
                
                $get_andon = "SELECT * FROM martech_fallas WHERE offline = 'si' AND planta_id = $planta_id";
                
                
                ?>
            </tbody>
        </table>
    </div>





</div>





<?php 
include_once("includes/footer.php");
?>