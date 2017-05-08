<!-- /.modal -->
<div class="modal fade" id="expedienteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lgz">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Historico de Expediente</h4>
      </div>
      <div class="modal-body">
        <form name="form_expediente" id="form_expediente" method="POST" action="">
          <div class="row form-group">
              <div class="col-sm-12">
                  <div class="box-body table-responsive">
                      <div class="container">
                      <h2 class="text-center">Expediente Unico</h2>
                        <table id="tree-table" class="table table-hover table-bordered">
                          <thead>
                            <th>Documento</th>
                            <th>Fecha</th>
                            <th>Proceso</th>
                            <th>Area</th>
                            <th>Paso</th>
                          </thead>
                          <tbody id="tb_tretable">
                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_cerrar_asignar" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
