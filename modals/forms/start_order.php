<div class="modal" id="comenzar-orden-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Comenzar orden: </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <b>Para comenzar la orden debe añadir los siguientes datos:</b>
        <div class="input-group">
          <input type="number" id="headcount" class="form-control m-2" data-toggle="tooltip" title="Ingrese la cantidad de personas que trabajaran en la orden." placeholder="HEADCOUNT" min="1" style="border-radius: .35rem!important;">
          <input type="number" id="pph-std" class="form-control m-2" data-toggle="tooltip" title="Ingrese el PPH Standard, en caso de no saberlo, preguntar a un superior." placeholder="PPH STANDARD" min="1" style="border-radius: .35rem!important;">
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