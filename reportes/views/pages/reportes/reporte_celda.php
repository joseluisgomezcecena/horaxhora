

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Reportes por celda</h1>
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
                        <th>Celda</th>
                        <th>Eficiencia 1er</th>
                        <th>Eficiencia 2do</th>
                        <th>Eficiencia 3er</th>
                        
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        
                        <th>Celda</th>
                        <th>Eficiencia 1er</th>
                        <th>Eficiencia 2do</th>
                        <th>Eficiencia 3er</th>
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
                        // $query = "SELECT AVG(eficiencia_turno1) AS ef1, AVG(eficiencia_turno2) AS ef2, AVG(eficiencia_turno3) AS ef3, horas.celda FROM eficiencias LEFT JOIN horas ON eficiencias.maquina = horas.maquina WHERE horas.planta_id = '$planta' AND eficiencias.dia BETWEEN '$inicio' AND '$final' GROUP BY horas.celda ORDER BY horas.maquina";
                        $query = "SELECT SUM(`realizado_turno1`) as sum_realizado1, SUM(`planeado_turno1`) as sum_planeado1, SUM(`realizado_turno2`) as sum_realizado2, SUM(`planeado_turno2`) as sum_planeado2, SUM(`realizado_turno3`) as sum_realizado3, SUM(`planeado_turno3`) as sum_planeado3, horas.celda FROM datos_diarios LEFT JOIN horas ON datos_diarios.maquina = horas.maquina WHERE datos_diarios.planta_id = '$planta' AND datos_diarios.date BETWEEN '$inicio' AND '$final' GROUP BY horas.celda ORDER BY horas.maquina";
                    }
                    else
                    {
                        // $query = "SELECT AVG(eficiencia_turno1) AS ef1, AVG(eficiencia_turno2) AS ef2, AVG(eficiencia_turno3) AS ef3, horas.celda FROM eficiencias LEFT JOIN horas ON eficiencias.maquina = horas.maquina WHERE eficiencias.dia = '$today'  GROUP BY horas.celda ORDER BY horas.maquina";
                        $query = "SELECT SUM(`realizado_turno1`) as sum_realizado1, SUM(`planeado_turno1`) as sum_planeado1, SUM(`realizado_turno2`) as sum_realizado2, SUM(`planeado_turno2`) as sum_planeado2, SUM(`realizado_turno3`) as sum_realizado3, SUM(`planeado_turno3`) as sum_planeado3, horas.celda FROM datos_diarios LEFT JOIN horas ON datos_diarios.maquina = horas.maquina WHERE datos_diarios.date = '$today'  GROUP BY horas.celda ORDER BY horas.maquina";
                        
                    }
                    $result = mysqli_query($connection, $query);
                    if(!$result) echo $connection->error;
                    while($row = mysqli_fetch_array($result)):

                      $eff_t1 = $row['sum_planeado1'] > 0 ? round(($row['sum_realizado1'] / $row['sum_planeado1']) * 100, 1) : 0;
                      $eff_t2 = $row['sum_planeado2'] > 0 ? round(($row['sum_realizado2'] / $row['sum_planeado2']) * 100, 1) : 0;
                      $eff_t3 = $row['sum_planeado3'] > 0 ? round(($row['sum_realizado3'] / $row['sum_planeado3']) * 100, 1) : 0;
                    ?>
                        <tr>
                            <td ><?php echo $row['celda'] ?> </td>

                            <td data-toogle="tooltip" title="<?php echo "{$row['sum_realizado1']} / {$row['sum_planeado1']}" ?>"><?php echo $eff_t1 ?> </td>
                            
                            <td data-toogle="tooltip" title="<?php echo "{$row['sum_realizado2']} / {$row['sum_planeado2']}" ?>"><?php echo $eff_t2 ?></td>               
                            
                            <td data-toogle="tooltip" title="<?php echo "{$row['sum_realizado3']} / {$row['sum_planeado3']}" ?>"><?php echo $eff_t3 ?></td>
                        </tr>

                    <?php
                    endwhile;
                    ?>

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>








