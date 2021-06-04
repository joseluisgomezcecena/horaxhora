<?php  
include_once("includes/header.php");
?>

<style>
::-webkit-scrollbar 
    { 
    display: none; 
    }

    body 
      {
        background-image: linear-gradient(rgb(33, 118, 255), rgb(32, 229, 247));
        font-family:Arial, Helvetica, sans-serif;
      }
</style>


<div style="text-align: center;" id="time" class="col-lg-12">
    <h3 style="text-align: center;" class="text-white text-center">Visual Management <?php echo date("H:i:s"); ?></h3>
</div>


<div style="margin: 20px;" id="wrapper">
    
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">


                <div class="row">
                    <div style="padding-right:0; padding-left:0;" class="col-lg-8">
                        <div >
                        
                            <table class="table table-bordered talbe-striped table-hover">
                                <thead style="background-color:black; color:white;" class=" text-center">
                                    <th style="width: 15%;">Maquina</th>
                                    <th style="width: 15%;">Orden/Item</th>
                                    <th style="width: 20%;">Actual/Planeado</th>
                                    <th style="width: 20%;">Plan %</th>
                                </thead>
                                <tbody class="text-center"  id="table1">
                                    
                                    
                                    
                                    <?php 
                                        /**********************QUERY Y CALCULOS***********************/

                                        $display = $_GET['display'];
                                        $fecha = date("Y-m-d H:i:s");
                                        $hora = date("H:i:s");
                                        $hr = idate("H");
                                        //$hr = ("6");
                                        $query = "SELECT * FROM horas 
                                        left join plan on horas.maquina = plan.maquina 
                                        left join ordenes_main on horas.maquina = ordenes_main.maquina 
                                        WHERE horas.display = '$display' AND ordenes_main.estado = 1"; 

                                        $run = mysqli_query($connection, $query);

                                        while($row = mysqli_fetch_row($run)):

                                        //vars
                                        //$limit = 18;
                                        $maquina    =  $row['1'];
                                        $planta_id  =  $row['2'];
                                        $orden      =  $row['68'];   
                                        $item       =  $row['69'];   

                                        

                                        //calculo de acumulado y eficiencia
                                        $acum_plan   = 0;
                                        $acum_actual = 0;


                                        

                                        switch($hr)
                                        {
                                            case 6:
                                                $acum_actual   = $row[4];
                                                $acum_plan = $row[38];
                                            break;

                                            case 7:
                                                $acum_actual   = $row[4]+$row[5];
                                                $acum_plan = $row[38]+$row[39];
                                            break;

                                            case 8:
                                                $acum_actual   = $row[4]+$row[5]+$row[6];
                                                $acum_plan = $row[38]+$row[39]+$row[40];
                                            break;

                                            case 9:
                                                $acum_actual   = $row[4]+$row[5]+$row[6]+$row[7];
                                                $acum_plan = $row[38]+$row[39]+$row[40]+$row[41];
                                            break;

                                            case 10:
                                                $acum_actual   = $row[4]+$row[5]+$row[6]+$row[7]+$row[8];
                                                $acum_plan = $row[38]+$row[39]+$row[40]+$row[41]+$row[42];
                                            break;

                                            case 11:
                                                $acum_actual   = $row[4]+$row[5]+$row[6]+$row[7]+$row[8]+$row[9];
                                                $acum_plan = $row[38]+$row[39]+$row[40]+$row[41]+$row[42]+$row[43];
                                            break;

                                            case 12:
                                                $acum_actual   = $row[4]+$row[5]+$row[6]+$row[7]+$row[8]+$row[9]+$row[10];
                                                $acum_plan = $row[38]+$row[39]+$row[40]+$row[41]+$row[42]+$row[43]+$row[44];
                                            break;

                                            case 13:
                                                $acum_actual   = $row[4]+$row[5]+$row[6]+$row[7]+$row[8]+$row[9]+$row[10]+$row[11];
                                                $acum_plan = $row[38]+$row[39]+$row[40]+$row[41]+$row[42]+$row[43]+$row[44]+$row[45];
                                            break;

                                            case 14:
                                                $acum_actual   = $row[4]+$row[5]+$row[6]+$row[7]+$row[8]+$row[9]+$row[10]+$row[11]+$row[12];
                                                $acum_plan = $row[38]+$row[39]+$row[40]+$row[41]+$row[42]+$row[43]+$row[44]+$row[45]+$row[46];
                                            break;

                                            case 15:
                                                $acum_actual   = $row[4]+$row[5]+$row[6]+$row[7]+$row[8]+$row[9]+$row[10]+$row[11]+$row[12]+$row[13];
                                                $acum_plan = $row[38]+$row[39]+$row[40]+$row[41]+$row[42]+$row[43]+$row[44]+$row[45]+$row[46]+$row[47];
                                            break;

                                            case 16:
                                                $acum_actual   = $row[14];
                                                $acum_plan = $row[48];
                                            break;

                                            case 17:
                                                $acum_actual   = $row[14]+$row[15];
                                                $acum_plan = $row[48]+$row[49];
                                            break;

                                            case 18:
                                                $acum_actual   = $row[14]+$row[15]+$row[16];
                                                $acum_plan = $row[48]+$row[49]+$row[50];
                                            break;

                                            case 19:
                                                $acum_actual   = $row[14]+$row[15]+$row[16]+$row[17];
                                                $acum_plan = $row[48]+$row[49]+$row[50]+$row[51];
                                            break;

                                            case 20:
                                                $acum_actual   = $row[14]+$row[15]+$row[16]+$row[17]+$row[18];
                                                $acum_plan = $row[48]+$row[49]+$row[50]+$row[51]+$row[52];
                                            break;

                                            case 21:
                                                $acum_actual   = $row[14]+$row[15]+$row[16]+$row[17]+$row[18]+$row[19];
                                                $acum_plan = $row[48]+$row[49]+$row[50]+$row[51]+$row[52]+$row[53];
                                            break;

                                            case 22:
                                                $acum_actual   = $row[14]+$row[15]+$row[16]+$row[17]+$row[18]+$row[19]+$row[20];
                                                $acum_plan = $row[48]+$row[49]+$row[50]+$row[51]+$row[52]+$row[53]+$row[54];
                                            break;

                                            case 23:
                                                $acum_actual   = $row[14]+$row[15]+$row[16]+$row[17]+$row[18]+$row[19]+$row[20]+$row[21];
                                                $acum_plan = $row[48]+$row[49]+$row[50]+$row[51]+$row[52]+$row[53]+$row[54]+$row[55];
                                            break;

                                            case 24:
                                                $acum_actual   = $row[22];
                                                $acum_plan = $row[56];
                                            break;

                                            case 1:
                                                $acum_actual   = $row[22]+$row[23];
                                                $acum_plan = $row[56]+$row[57];
                                            break;

                                            case 2:
                                                $acum_actual   = $row[22]+$row[23]+$row[24];
                                                $acum_plan = $row[56]+$row[57]+$row[58];
                                            break;

                                            case 3:
                                                $acum_actual   = $row[22]+$row[23]+$row[24]+$row[25];
                                                $acum_plan = $row[56]+$row[57]+$row[58]+$row[59];
                                            break;

                                            case 4:
                                                $acum_actual   = $row[22]+$row[23]+$row[24]+$row[25]+$row[26];
                                                $acum_plan = $row[56]+$row[57]+$row[58]+$row[59]+$row[60];
                                            break;

                                            case 5:
                                                $acum_actual   = $row[22]+$row[23]+$row[24]+$row[25]+$row[26]+$row[27];
                                                $acum_plan = $row[56]+$row[57]+$row[58]+$row[59]+$row[60]+$row[61];
                                            break;

                                            default:
                                                $acum_plan   = 0;
                                                $acum_actual = 0;
                                            break;
                                        }

                                        
                                    
                                    
                                        if($acum_plan == 0)
                                            $eficiencia = 0;
                                        else    
                                            $eficiencia = round(($acum_actual/$acum_plan)*100,1);
                                        
                                        if($eficiencia >= 100)
                                            $background = "green";
                                        elseif($eficiencia > 80 && $eficiencia < 100)
                                            $background = "yellow";
                                        else
                                            $background = "red";   
                                            
                                        /**********************QUERY Y CALCULOS***********************/    
                                    ?>


                                    <tr>
                                        <td><?php echo $maquina; ?></td>
                                        
                                        <td><?php echo $orden ?><br><?php echo $item ?></td>
                                        
                                        <td>
                                            <?php
                                            //echo "@ $hr:00 <br>";
                                            echo $acum_actual;
                                            echo "/";
                                            echo $acum_plan;  
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
                            <thead style="background-color:black; color:white;" class=" text-center">
                                <th >Andon</th>
                            </thead>
                            <tbody class="text-center"  id="table2">
                                <?php
                                $planta_andon = $_GET['planta_andon'];
                                $query = "SELECT * FROM martech_fallas WHERE (atendido_flag = 'no' AND offline = 'si' AND planta_id = '$planta_andon' AND tipo_error != 'falta_material') OR (atendido_flag = 'si' AND offline = 'si' AND planta_id = '$planta_andon' AND tipo_error != 'falta_material') ";
                                $run = mysqli_query($connection2, $query);
                                while($row = mysqli_fetch_array($run)):

                                    
                                $start_date = new DateTime($row['inicio']);

                                $hoy = date("Y-m-d H:i:s");

                                $since_start = $start_date->diff(new DateTime($hoy));
                                $td = $since_start->days.' total days<br>';
                                $y  = $since_start->y.' a�os';
                                $mo =$since_start->m.' meses';
                                $d = $since_start->d.' dias ';
                                $h = $since_start->h.' horas ';
                                $m = $since_start->i.' mins ';
                                $s = $since_start->s.' segs ';    

                                $t =  $d." ".$h." ".$m." ".$s."";


                                ?>

                                    <tr style="color: white;background-color:<?php if($row['atendido_flag']=='no'){echo"red";} else {echo "orange";} ?>">
                                        <td>
                                            <?php echo strtoupper($row['tipo_error']);?>
                                            <p style="font-size:24px; margin-top:-10px;"><?php echo strtoupper($row['maquina_centro_trabajo']);?></p>
                                            <p style="font-size:24px;margin-top:-20px;"><?php echo strtoupper($row['descripcion_operador']);?></p>
                                            <p style="font-size:24px; margin-top:-20px;"><?php echo $t?></p>

                                            <?php if($row['atendido_flag']=='no'){echo"<p class='blink_me' style='font-size:24px;margin-top:-20px;'>Waiting...</p>";} else {echo "<p class='' style='font-size:24px;margin-top:-20px;'>Atiende: {$row['atendio']}</p>";} ?>
                                        </td>
                                    </tr>

                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>





                </div>





        </div>
    </div>
</div>
        






<?php 
include_once("includes/footer.php");
?>