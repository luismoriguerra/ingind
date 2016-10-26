<!-- /.modal -->
<div class="modal fade" id="edit_fecha_tramite" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Edit Fecha Tramite</h4>
      </div>
      <div class="modal-body">
            <div class="col-md-12">
                <div class="col-md-4">
                     <label class="control-label">Nro Tramite:</label>
                    <input type="text" name="txtnrotramite" id="txtnrotramite" value="" class="form-control" readonly="readonly">
                </div>
                <div class="col-md-4">
                    <label class="control-label">Solicitante:</label>
                    <input type="text" name="txtsolicitante" id="txtsolicitante" value="" class="form-control" readonly="readonly">
                </div>
                <div class="col-md-4">
                    <label class="control-label">Sumilla:</label>
                    <input type="text" name="txtsumilla" id="txtsumilla" value="" class="form-control" readonly="readonly">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <label class="control-label">Proceso:</label>
                    <input type="text" name="txtproceso" id="txtproceso" value="" class="form-control" readonly="readonly">
                </div>
                <div class="col-md-4">
                    <label class="control-label">Area:</label>
                    <input type="text" name="txtarea" id="txtarea" value="" class="form-control" readonly="readonly">
                </div>
                <div class="col-md-4">
                    <label class="control-label">Tiempo asignado al paso: (edit)</label>
                    <div class="row">
                      <div class="col-md-5">
                          <select class="form-control" id="sltiempo" name="sltiempo">
                            
                          </select>
                      </div>
                      <div class="col-md-7">
                          <input type="text" name="txttiempoa" id="txttiempoa" value="" class="form-control">
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label class="control-label">Motivo Cambio</label>
                <textarea class="form-control" name="txtmotivo" id="txtmotivo" rows="5"></textarea>
            </div>
      </div>
      <div class="modal-footer" style="margin-top:8px">
         <span id="btneditTiempo" class="btn btn-primary btn-md" onclick="updateTiempo(this)"><i class="glyphicon glyphicon-edit"></i> Actualizar</span>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
