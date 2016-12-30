<!-- /.modal -->
<div class="modal fade" id="documentoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Editar Asignacion</h4>
      </div>
      <div class="modal-body">
        <form id="form_tramite_modal" name="form_tramite_modal" action="" method="post">
          <input type="hidden" name="txt_id" id="txt_id" value="">
          

          <div class="form-group">
            <label class="control-label">Nombre:</label>
            <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombret" id="txt_nombret">
          </div>

         


          <div class="form-group">
            <label class="control-label">Fecha Tramite:
            </label>
            <input type="text" class="form-control" placeholder="" name="txt_fechatramite" id="txt_fechatramite" disabled="disabled">
            <!-- select class="form-control" name="slct_estado" id="slct_estado">
                <option value='0'>Inactivo</option>
                <option value='1' selected>Activo</option>
            </select> -->
          </div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="Editar()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
s