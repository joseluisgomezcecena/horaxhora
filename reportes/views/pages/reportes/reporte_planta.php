

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Reportes por planta</h1>
</div>


<form method="POST" autocomplete="off">
  <div class="form-row align-items-center">
    <div class="col-auto">
      <label class="sr-only" for="inlineFormInputGroup">Inicio</label>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
        <input name="inicio" type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="inlineFormInputGroup" placeholder="Fecha inicial" required>
      </div>
    </div>
    <div class="col-auto">
      <label class="sr-only" for="inlineFormInputGroup">Final</label>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
        <input name="final" type="text"  class="form-control datepicker" data-date-format="yyyy-mm-dd" id="inlineFormInputGroup" placeholder="Fecha final" required>
      </div>
    </div>
    <div class="col-auto">
      <label class="sr-only" for="inlineFormInputGroup">Planta</label>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="far fa-building"></i></div>
        </div>
        <select name="planta"  class="form-control" required>
            <option value="">Selecciona</option>
            <option value="1">MMW1</option>
            <option value="2">MMW2</option>
            <option value="3">MMW3</option>
        </select>
      </div>
    </div>
    <div class="col-auto">
      <button type="submit" name="submit" class="btn btn-primary mb-2">Buscar</button>
    </div>
  </div>
</form>



<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Reportes al dia: <?php echo date("m/d/Y"); ?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>

                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">
                <table style="font-size: 12px;" class="table table-hover" id="dataTable2" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Maquina</th>
                        <th>Celda</th>
                        <th>Eficiencia 1er</th>
                        <th>Eficiencia 2do</th>
                        <th>Eficiencia 3er</th>
                        <th>Eficiencia Total</th>
                        
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Fecha</th>
                        <th>Maquina</th>
                        <th>Celda</th>
                        <th>Eficiencia 1er</th>
                        <th>Eficiencia 2do</th>
                        <th>Eficiencia 3er</th>
                        <th>Eficiencia Total</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    <?php
                    $today = date("Y-m-d");
                    
                    $sum1 = 0;
                    $sum2 = 0;
                    $sum3 = 0;

                    $cont1 = 0;
                    $cont2 = 0;
                    $cont3 = 0;


                    if(isset($_POST['submit']))
                    {
                        $inicio = $_POST['inicio'];
                        $final = $_POST['final'];
                        $planta = $_POST['planta'];
                        //$query = "SELECT * FROM eficiencias LEFT JOIN horas ON eficiencias.maquina = horas.maquina WHERE horas.planta_id = $planta AND eficiencias.dia BETWEEN '$inicio' AND '$final' ORDER BY horas.maquina";
                        $query = "SELECT A.`maquina`, A.`dia`, A.`eficiencia_turno1`, A.`eficiencia_turno2`, A.`eficiencia_turno3`, A.`eficiencia_total`, B.realizado_turno1, B.planeado_turno1, B.realizado_turno2, B.planeado_turno2, B.realizado_turno3, B.planeado_turno3, B.realizado_total, B.planeado_total, C.celda 
                                  FROM eficiencias AS A 
                                  LEFT JOIN datos_diarios AS B ON A.maquina = B.maquina AND A.dia = B.date 
                                  LEFT JOIN horas AS C ON A.maquina = C.maquina 
                                  WHERE horas.planta_id = $planta AND A.dia BETWEEN '$inicio' AND '$final' ORDER BY horas.maquina";
                    }
                    else
                    {
                        $query = "SELECT A.`maquina`, A.`dia`, A.`eficiencia_turno1`, A.`eficiencia_turno2`, A.`eficiencia_turno3`, A.`eficiencia_total`, B.realizado_turno1, B.planeado_turno1, B.realizado_turno2, B.planeado_turno2, B.realizado_turno3, B.planeado_turno3, B.realizado_total, B.planeado_total, C.celda 
                                  FROM eficiencias AS A 
                                  LEFT JOIN datos_diarios AS B ON A.maquina = B.maquina AND A.dia = B.date 
                                  LEFT JOIN horas AS C ON A.maquina = C.maquina 
                                  WHERE A.dia = '$today' ";
                    }
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><?php echo $row['dia'] ?> </td>

                            <td><?php echo $row['maquina'] ?> </td>
                            
                            <td><?php echo $row['celda'] ?></td>
                            
                            <td data-toogle="tooltip" title="<?php echo "{$row['realizado_turno1']} / {$row['planeado_turno1']}" ?>">
                              <?php
                              echo $row['eficiencia_turno1']; 
                              if($row['eficiencia_turno1']!=0)
                                $cont1++;
                              //echo $cont1;  
                              ?>
                            
                            </td>
                            
                            <td data-toogle="tooltip" title="<?php echo "{$row['realizado_turno2']} / {$row['planeado_turno2']}" ?>">
                              <?php
                              echo $row['eficiencia_turno2']; 
                              if($row['eficiencia_turno2']!=0)
                                $cont2++;
                              //echo $cont2;  
                              ?>
                              </td>
                            
                            <td data-toogle="tooltip" title="<?php echo "{$row['realizado_turno3']} / {$row['planeado_turno3']}" ?>">
                              <?php
                              echo $row['eficiencia_turno3']; 
                              if($row['eficiencia_turno3']!=0)
                                $cont3++;
                              //echo $cont3;
                              ?>
                            </td>
                            
                            <td data-toogle="tooltip" title="<?php echo "{$row['realizado_total']} / {$row['planeado_total']}" ?>"><?php echo $row['eficiencia_total'] ?></td>
                        </tr>

                    <?php

                    $sum1 +=  $row['eficiencia_turno1'];
                    $sum2 +=  $row['eficiencia_turno2'];
                    $sum3 +=  $row['eficiencia_turno3'];

                    endwhile;
                    ?>

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>










<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Reportes al dia: <?php echo date("m/d/Y"); ?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>

                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">
                <table style="font-size: 12px;" class="table table-hover" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Eficiencia Turno 1</th>
                        <th>Eficiencia Turno 2</th>
                        <th>Eficiencia Turno 3</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Eficiencia Turno 1</th>
                        <th>Eficiencia Turno 2</th>
                        <th>Eficiencia Turno 3</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    <tr>
                    <td>
                        <?php
                        if($cont1>0)
                         echo round($sum1/$cont1,1);
                        else
                          echo "0"; 
                        ?>
                      </td>
                      <td>
                        <?php
                        if($cont2>0)
                          echo round($sum2/$cont2,1);
                        else
                          echo "0";  
                        ?>
                      </td>
                      <td>
                        <?php
                        if($cont3>0)
                          echo round($sum3/$cont3,1);
                        else
                          echo "0";  
                        ?>
                      </td>
                    </tr>
                    

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
