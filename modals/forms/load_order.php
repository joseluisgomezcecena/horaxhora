<?php
if(isset($_GET['plant']))
{
    $planta = $_GET['plant'];
}
else
    $planta = 1;

?>
<div class="modal fade" id="agregar-orden-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Agregar Orden</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="input-group">
          <div class="form-group m-1 mx-2">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Workorder</label>
            <input id="work-order" type="text" class="form-control" placeholder="Work order" style="text-transform: uppercase; border-radius: .35rem!important;">
          </div>
          <div class="form-group m-1">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Item</label>
            <input id="item" type="text" class="form-control" placeholder="Item" style="text-transform: uppercase; border-radius: .35rem!important;">
          </div>
        </div>
        <div class="input-group">
          <div class="form-group m-1 mx-2">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Maquina</label>
            <select id="machine" class="form-control" style="border-radius: .35rem!important; width: 205px!important;">
              <option value="" selected disabled>SELECCIONE MAQUINA</option>
              <?php
              $query_maquinas  = "SELECT * FROM horas WHERE planta_id = $planta";
              $result_maquinas = $connection->query($query_maquinas);
              if($result_maquinas && $result_maquinas->num_rows > 0){
                while($row_maquinas = $result_maquinas->fetch_assoc()){
              ?>
                  <option value="<?php echo $row_maquinas['maquina'];?>"><?php echo $row_maquinas['maquina']; ?></option>
              <?php
                }
              }

              ?>
            </select>
          </div>
          <div class="form-group m-1">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Item</label>
            <input id="quantity" type="number" class="form-control" min="1" placeholder="CANTIDAD" style="border-radius: .35rem!important;">
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="confirmar-agregar-orden" type="button" class="btn btn-primary">Agregar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>