<!-- /.modal -->
<div class="modal fade" id="nuevoEvento" tabindex="-1" role="dialog" aria-hidden="true">
  <form id="form_nuevoEvento" name="form_nuevoEvento" action="" method="post">
    <input type="text" name="txt_idcaracteristica" id="txt_idcaracteristica">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header logo">
          <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
              <i class="fa fa-close"></i>
          </button>
          <h4 class="modal-title">New message</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                  <div class="form-group">
                    <label class="control-label">Categoria
                    </label>
                    <select class="form-control" name="slct_categoriaevent" id="slct_categoriaevent">
                      
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Observacion
                    </label>
                   <textarea name="txt_observ" id="txt_observ" class="form-control"></textarea>
                  </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Guardar</button>
<!--          <input type="submit" class="btn btn-primary btn-sm btnAction" id="" value="Guardar" onclick="AgregarEditarBienCaracteristica()"> -->
        </div>
      </div>
    </div>
  </form>
</div>
<!-- /.modal -->