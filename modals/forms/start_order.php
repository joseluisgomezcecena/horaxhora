<div class="modal fade" id="comenzar-orden-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <b>Para comenzar la orden debe añadir los siguientes datos:</b>        
        <div class="input-group">
          <div class="form-group m-1">
            <label style="font-size: 14px; margin: 0; margin-left: 1rem">Headcount</label>
            <input type="number" id="headcount" class="form-control mx-2" data-toggle="tooltip" title="Ingrese la cantidad de personas que trabajaran en la orden." data-placement="down" placeholder="HEADCOUNT" min="1" style="border-radius: .35rem!important;">
          </div>
          <div class="form-group m-1">
            <label style="font-size: 14px; margin: 0; margin-left: 1rem">PPH</label>
            <input type="number" id="pph-std" class="form-control mx-2" data-toggle="tooltip" title="Ingrese el PPH Standard, en caso de no saberlo, preguntar a un superior." data-placement="down" placeholder="PPH STANDARD" min="1" style="border-radius: .35rem!important;">
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="start-order" type="button" class="btn btn-primary" data-dismiss="modal">Comenzar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>