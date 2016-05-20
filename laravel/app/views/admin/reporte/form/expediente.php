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
                      <table id="t_expediente" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>Carta</th>
                                  <th>Objetivo</th>
                                  <th>Entregable</th>
                                  <th>[ ]</th>
                              </tr>
                          </thead>
                          <tbody id="tb_expediente">
                              
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th>Carta</th>
                                  <th>Objetivo</th>
                                  <th>Entregable</th>
                                  <th>[ ]</th>
                              </tr>
                          </tfoot>
                      </table>
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
