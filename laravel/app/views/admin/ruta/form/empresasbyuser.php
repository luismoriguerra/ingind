<!-- /.modal -->
<div class="modal fade" id="empresasbyuser" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
         <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Buscar Tramite</h4>
      </div>
      <div class="modal-body">
            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_empresa" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>RUC</th>
                                        <th>TIPO EMPRESA</th>
                                        <th>RAZON SOCIAL</th>
                                        <th>NOMBRE COMERCIAL</th>
                                        <th>DIRECCION FISCAL</th>
                                        <th>TELEFONO</th>
                                        <th>FECHA VIGENCIA</th>
                                        <th>ESTADO</th>
                                        <th>REPRESENTANTE</th>
                                        <th>REPRENSEN. DNI</th>
                                        <th>SELECCIONAR</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_empresa">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <span class="btn btn-success btn-sm" id="btnAgregarEmpresa">Agregar Empresa <i class="glyphicon glyphicon-plus"></i></span>
        <!--  <span id="btnAgregarAnexo" class="btn btn-primary btn-sm" onclick="updateTiempo(this)"><i class="glyphicon glyphicon-plus"></i> AGREGAR ANEXO</span> -->
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
