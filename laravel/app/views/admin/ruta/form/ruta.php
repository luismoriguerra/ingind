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
            <label class="control-label">Tipo Flujo:</label>
            <select class="form-control" name="slct_tipo_flujo_id" id="slct_tipo_flujo_id">
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Creador:</label>
            <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
          </div>
          <div class="form-group">
            <label class="control-label">Area:</label>
            <select class="form-control" name="slct_area_id" id="slct_area_id">
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
