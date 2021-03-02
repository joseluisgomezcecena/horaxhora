

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
                        $query = "SELECT AVG(eficiencia_turno1) AS ef1, AVG(eficiencia_turno2) AS ef2, AVG(eficiencia_turno3) AS ef3, horas.celda FROM eficiencias LEFT JOIN horas ON eficiencias.maquina = horas.maquina WHERE horas.planta_id = '$planta' AND eficiencias.dia BETWEEN '$inicio' AND '$final' GROUP BY horas.celda ORDER BY horas.maquina";
                    }
                    else
                    {
                        $query = "SELECT AVG(eficiencia_turno1) AS ef1, AVG(eficiencia_turno2) AS ef2, AVG(eficiencia_turno3) AS ef3, horas.celda FROM eficiencias LEFT JOIN horas ON eficiencias.maquina = horas.maquina WHERE eficiencias.dia = '$today'  GROUP BY horas.celda ORDER BY horas.maquina";
                        
                    }
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><?php echo $row['3'] ?> </td>

                            <td><?php echo round($row['0'],1) ?> </td>
                            
                            <td><?php echo round($row['1'],1) ?></td>               
                            
                            <td><?php echo round($row['2'],1) ?></td>
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








