<!-- /.modal -->
<div class="modal fade" id="fechanolaborableModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Nueva fecha <b>NO</b> laborables</h4>
      </div>
      <div class="modal-body">
        <form id="form_fechanolaborable" name="form_fechanolaborable" action="" method="post" >
          <div class="form-group">
            <label class="control-label">Fecha:
                <a id="error_fechanolaborable" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Fecha">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control fecha" placeholder="Fecha" name="txt_fechanolaborable" id="txt_fechanolaborable">
          </div>
          <div class="form-group">
            <label class="control-label">Area:</label>
            <select class="form-control" name="slct_area" id="slct_area"></select>
          </div>
          <div class="form-group">
            <label class="control-label">Estado:
            </label>
            <select class="form-control" name="slct_estado" id="slct_estado">
                <option value='0'>Inactivo</option>
                <option value='1' selected>Activo</option>
            </select>
          </div>
          <input type="hidden" name="txt_id" id="txt_id">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
