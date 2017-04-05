<!-- /.modal -->
<div class="modal fade" id="nuevaCaracteristica" tabindex="-1" role="dialog" aria-hidden="true">
  <form id="form_nuevaCaracteristica" name="form_nuevaCaracteristica" action="" method="post">
    <input type="hidden" name="txt_idbien" id="txt_idbien">
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

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Descripcion
                    </label>
                    <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Observacion
                    </label>
                   <textarea name="txt_observ" id="txt_observ" class="form-control"></textarea>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Valor
                    </label>
                     <input type="text" class="form-control" placeholder="Ingrese valor" name="txt_valor" id="txt_valor">
                  </div>

                  <div class="form-group">
                    <div class="form-group">
                      <label class="control-label">Alerta
                      </label>
                      <select class="form-control" name="slct_alerta" id="slct_alerta">
                        <option value="">Seleccione</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 motivoAlerta hidden">
                  <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="control-label">Fecha Alerta
                        </label>
                        <input type="text" class="form-control datepicker" name="txt_fechaalerta" id="txt_fechaalerta">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="control-label">Motivo Alerta
                        </label>
                        <textarea class="form-control" name="txt_motivoalerta" id="txt_motivoalerta" rows="3"></textarea>
                    </div>
                  </div>
                </div>

              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary"  id="btnAccion2" >Guardar</button>
<!--          <input type="submit" class="btn btn-primary btn-sm btnAction" id="" value="Guardar" onclick="AgregarEditarBienCaracteristica()"> -->
        </div>
      </div>
    </div>
  </form>
</div>
<!-- /.modal -->