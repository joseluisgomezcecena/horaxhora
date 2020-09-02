
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
          <div class="form-group m-1 mx-2">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Workorder</label>
            <input id="work-order-edit" type="text" class="form-control" placeholder="Work order" style="text-transform: uppercase; border-radius: .35rem!important;">
          </div>
          <div class="form-group m-1">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Item</label>
            <input id="item-edit" type="text" class="form-control" placeholder="Item" style="text-transform: uppercase; border-radius: .35rem!important;">
          </div>
        </div>
        <div class="input-group">
          <div class="form-group m-1 mx-2">
              <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Maquina</label>
              <select id="machine-edit" class="form-control" style="border-radius: .35rem!important; width: 205px!important;">
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
          </div>
          <div class="form-group m-1">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Cantidad</label>
            <input id="quantity-edit" type="number" class="form-control" min="1" placeholder="CANTIDAD" style="border-radius: .35rem!important;">
          </div>
        </div>
        <div class="input-group">
          <div class="form-group m-1 mx-2">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">PPH</label>
            <input id="pph-edit" type="number" class="form-control" placeholder="PPH STANDARD" min="1" style="border-radius: .35rem!important;">
          </div>
          <div class="form-group m-1">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Setup (minutos)</label>
            <input id="setup-edit" type="number" class="form-control" placeholder="SETUP STANDARD" min="1" style="border-radius: .35rem!important;">
          </div>
        </div>

        <div class="input-group">
          <div class="form-group m-1 mx-2">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Headcount turno 1</label>
            <input id="pph-edit" type="number" class="form-control" placeholder="Headcount 1" min="1" style="border-radius: .35rem!important;">
          </div>
          <div class="form-group m-1">
            <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Headcount turno 2</label>
            <input id="setup-edit" type="number" class="form-control" placeholder="Headcount 2" min="1" style="border-radius: .35rem!important;">
          </div>
          <div class="form-group m-1 mx-2">
              <label style="font-size: 14px; margin: 0; margin-left: 0.5rem">Headcount turno 3</label>
              <input id="pph-edit" type="number" class="form-control" placeholder="Headcount 3" min="1" style="border-radius: .35rem!important;">
            </div>
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