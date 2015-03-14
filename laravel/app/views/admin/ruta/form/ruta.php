<!-- /.modal -->
<div class="modal fade" id="rutaflujoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_celulas" name="form_celulas" action="" method="post">
          <div class="form-group">
            <label class="control-label">Nombre
                <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
          </div>
          <div class="form-group">
            <label class="control-label">Empresa:
            </label>
            <select class="form-control" name="slct_empresa_id" id="slct_empresa_id">
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Quiebres:
            </label>
            <select class="form-control" multiple="multiple" name="slct_quiebres" id="slct_quiebres">
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Responsable
                <a id="error_responsable" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Responsable">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Responsable" name="txt_responsable" id="txt_responsable">
          </div>
          <div class="form-group">
            <label class="control-label">Estado:
            </label>
            <select class="form-control" name="slct_estado" id="slct_estado">
                <option value='0'>Inactivo</option>
                <option value='1' selected>Activo</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
