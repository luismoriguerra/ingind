<!-- /.modal -->
<div class="modal fade" id="produccionusuModal" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Detalle de Tareas</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <!-- Inicia contenido -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <form id="form_detalles" name="form_detalles" method="POST" action="">
                            <input type="hidden" id="txt_usuario_id" name="txt_usuario_id" value="">
                            <input type="hidden" id="txt_proceso_id" name="txt_proceso_id" value="">
                            <input type="hidden" id="txt_fecha" name="txt_fecha" value="">
                            <table id="t_detalles" class="table table-bordered table-hover">
                                <thead>
                            
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                        </form>
                        <form id="form_detalles_tramite" name="form_detalles_tramite" method="POST" action="">
                            <input type="hidden" id="txt_usuario_id" name="txt_usuario_id" value="">
                            <input type="hidden" id="txt_proceso_id" name="txt_proceso_id" value="">
                            <input type="hidden" id="txt_fecha" name="txt_fecha" value="">
                            <table id="t_detalles_tramite" class="table table-bordered table-hover">
                                <thead>
                            
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                        </form>
                            
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Finaliza contenido -->
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
