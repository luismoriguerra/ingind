<!-- /.modal -->
<div class="modal fade"  id="ticketscompletogmgm_historicoModal" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Incidencias</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <!-- Inicia contenido -->
                
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                    </div><!-- /.box-header -->
                                        
                  <form id="form_ticketscompletogmgm_historico" name="form_ticketscompletogmgm_historico" method="POST" action="">
                      <!-- <a class="btn btn-success btn-md" id="btnexport" name="btnexport" href="" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Exportar Documentos2</a> -->
                      <input class='form-control mant' type='hidden' id="estado_solucion" name="estado_solucion" value='3'>
                        <div class="box-body table-responsive">
                            <table id="t_ticketscompletogmgm_historico" class="table table-bordered table-striped">
                                <thead>
                                <tr><th colspan="11" style="text-align:center;background-color:#A7C0DC;"><h2>Historico Incidencias</h2></th></tr>
                                    <tr>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                      </div><!-- /.box-body -->
                    </form>
                    
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
