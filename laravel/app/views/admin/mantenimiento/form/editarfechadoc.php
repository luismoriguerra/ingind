<!-- /.modal -->
<div class="modal fade" id="fechaModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_fechas_modal" name="form_fechas_modal" action="" method="post">
          <div class="form-group">
            <label class="control-label">Documento:</label>
            <input type="text" class="form-control" name="txt_documento" id="txt_documento" disabled="">
          </div>
          <div class="form-group">
            <label class="control-label">Fecha:</label>
            <input type="text" class="form-control fechaG" name="txt_fecha" id="txt_fecha" onfocus="blur()">
          </div>
          <div class="form-group">
            <label class="control-label">Comentario:
            </label>
              <textarea type="text" class="form-control" name="txt_comentario" id="txt_comentario"></textarea> 
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
