<div class="modal" id="agregar-orden-modal">
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
          <input id="work-order" type="text" class="form-control m-1" placeholder="Work order" style="text-transform: uppercase; border-radius: .35rem!important;">
          <input id="item" type="text" class="form-control m-1" placeholder="Item" style="text-transform: uppercase; border-radius: .35rem!important;">
        </div>
        <div class="input-group">
          <select id="machine" class="form-control m-1" style="border-radius: .35rem!important;">
              <option value="" selected disabled>SELECCIONE MAQUINA</option>
              <?php
              $query_maquinas  = "SELECT * FROM horas";
              $result_maquinas = $connection->query($query_maquinas);
              if($result_maquinas && $result_maquinas->num_rows > 0){
                while($row_maquinas = $result_maquinas->fetch_assoc()){
              ?>
                  <option value="<?php echo $row_maquinas['maquin'];?>"><?php echo $row_maquinas['maquina']; ?></option>
              <?php
                }
              }

              ?>
          </select>
          <input id="quantity" type="number" class="form-control m-1" min="1" placeholder="CANTIDAD" style="border-radius: .35rem!important;">
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