<!-- /.modal -->
<div class="modal fade" id="tituloModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_titulos_modal" name="form_titulos_modal" action="" method="post">
                <div class="form-group">
                    <label class="control-label">Titulo:
                       <!--  <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                            <i class="fa fa-exclamation"></i>
                        </a> -->
                    </label>
                    <div class="row">
                      <div class="col-xs-5">
                         <label id="lblDocumento" style="margin-top:5px;float:right;">Documento Prueba Nº</label>
                      </div>
                      <div class="col-xs-3">
                          <input type="text" maxlength="6" class="form-control txttittle" placeholder="Ingrese Titulo" name="txt_titulo" id="txt_titulo">
                      </div>
                      <div class="col-xs-4">
                          <label id="lblArea" style="margin-top:5px;">-MDI</label>
                      </div>                      
                    </div>
                    <input type="hidden" id="txt_titulofinal" name="txt_titulofinal" value="">
                </div>
<!--          <div class="form-group">
            <label class="control-label">Comentario:
            </label>
              <textarea type="text" class="form-control" name="txt_comentario" id="txt_comentario"></textarea> 
          </div>
-->

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
