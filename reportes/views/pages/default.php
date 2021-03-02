<?php 
$cont1 = 0;
$cont2 = 0;
$cont3 = 0;
$sum1 = 0;
$sum2 = 0;
$sum3 = 0;
$today = date("Y-m-d");
$query = "SELECT * FROM eficiencias LEFT JOIN horas ON eficiencias.maquina = horas.maquina WHERE  eficiencias.dia = '$today' ";
$run = mysqli_query($connection, $query);
while($row = mysqli_fetch_array($run)){
    
    if($row['eficiencia_turno1']!=0)
        $cont1++;

    if($row['eficiencia_turno2']!=0)
    $cont2++;

    if($row['eficiencia_turno3']!=0)
    $cont3++;

    $sum1 +=  $row['eficiencia_turno1'];
    $sum2 +=  $row['eficiencia_turno2'];
    $sum3 +=  $row['eficiencia_turno3'];

   
    
    
}
if($cont1 == 0)
    $e1 = 0;
else
    $e1 = round($sum1/$cont1,1);

if($cont2 == 0)
$e2 = 0;
else
$e2 = round($sum2/$cont2,1);

if($cont3 == 0)
    $e3 = 0;
else
    $e3 = round($sum3/$cont3,1);

?>



<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Eficiencias en tiempo real</h1>
</div>


<div id="eficiencias" class="row">

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Planta 1</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <?php echo $e1."%"; ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Planta 2</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <?php echo $e2."%"; ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Planta 3</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <?php echo $e3."%"; ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <?php echo round((($e1+$e2+$e3)/3))."%"; ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
</div>




<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Interrupciones en tiempo real</h1>
</div>



<div id="andones" class="row">

                <?php 
                $query = "SELECT * FROM martech_fallas WHERE (atendido_flag = 'no' AND offline = 'si' AND tipo_error != 'falta_material') OR (atendido_flag = 'si' AND offline = 'si' AND tipo_error != 'falta_material' ) ";
                $run = mysqli_query($connection2, $query);
                while($row = mysqli_fetch_array($run)):

                    
                $start_date = new DateTime($row['inicio']);

                $hoy = date("Y-m-d H:i:s");

                $since_start = $start_date->diff(new DateTime($hoy));
                $td = $since_start->days.' total days<br>';
                $y  = $since_start->y.' years';
                $mo =$since_start->m.' meses';
                $d = $since_start->d.' dias ';
                $h = $since_start->h.' horas ';
                $m = $since_start->i.' mins ';
                $s = $since_start->s.' segs ';    

                $t =  $d." ".$h." ".$m." ".$s."";


                ?>

                    <div class="col-lg-4 mb-4">
                    <div class="card <?php if($row['atendido_flag']=='no'){echo"bg-danger";} else {echo "bg-warning";} ?> text-white shadow">
                        <div class="card-body">
                        <?php echo strtoupper($row['tipo_error']);?>
                        <?php echo strtoupper($row['maquina_centro_trabajo']);?>
                        <?php echo strtoupper($row['descripcion_operador']);?>
                        <div class="text-white-50 small">
                            <?php echo $t?>
                        </div>
                        <?php if($row['atendido_flag']=='no'){echo"<p class='blink_me'>Waiting...</p>";} else {echo "<p class='none'>Atiende: {$row['atendio']}</p>";} ?>
                        </div>
                    </div>
                    </div>

                   
                <?php endwhile; ?>

                <!--
                <div class="col-lg-4 mb-4">
                  <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                      Danger
                      <div class="text-white-50 small">#e74a3b</div>
                    </div>
                  </div>
                </div>
                -->

</div>