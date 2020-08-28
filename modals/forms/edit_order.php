<div class="modal fade" id="editar-orden-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="input-group">
          <input id="work-order-edit" type="text" class="form-control m-1" placeholder="Work order" data-toggle="tooltip" title="Ingrese nuevo work order" style="text-transform: uppercase; border-radius: .35rem!important;">
          <input id="item-edit" type="text" class="form-control m-1" placeholder="Item" data-toggle="tooltip" title="Ingrese nuevo item" style="text-transform: uppercase; border-radius: .35rem!important;">
        </div>
        <div class="input-group">
            <select id="machine-edit" class="form-control m-1" style="border-radius: .35rem!important;">
              <option value="" selected disabled>SELECCIONE MAQUINA</option>
              <?php
              $query_maquinas  = "SELECT * FROM horas";
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
          <input id="quantity-edit" type="number" class="form-control m-1" min="1" placeholder="CANTIDAD" data-toggle="tooltip" title="Ingrese nueva cantidad" style="border-radius: .35rem!important;">
        </div>
        <div class="input-group">
          <input id="pph-edit" type="number" class="form-control m-2" data-toggle="tooltip" title="Ingrese el nuevo PPH Standard, en caso de no saberlo, preguntar a un superior." placeholder="PPH STANDARD" min="1" style="border-radius: .35rem!important;">
          <input id="setup-edit" type="number" class="form-control m-2" data-toggle="tooltip" title="Ingrese nuevo tiempo de setup en minutos." placeholder="SETUP STANDARD" min="1" style="border-radius: .35rem!important;">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="edit-order" type="button" class="btn btn-primary" data-dismiss="modal">Editar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>