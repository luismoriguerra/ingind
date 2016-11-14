<!-- /.modal -->
<div class="modal fade" id="anexos" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Anexos</h4>
      </div>
      <div class="modal-body">
            <div class="box">
                <fieldset>
                    <div class="row form-group filtros" >
                        <div class="col-sm-12">
                            <div class="col-md-4 col-sm-4">
                                <label class="control-label">INGRESAR COD O NOMBRE DEL ANEXO:</label>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <input type="text" class="form-control" id="txt_anexobuscar" name="txt_anexobuscar">
                            </div>
                            <div class="col-md-1 col-sm-2">
                                <span class="btn btn-primary btn-md" id="generarAnexo" name="generarAnexo"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                            </div>

                            <div class="col-md-1 col-sm-2" style="padding:24px">
                                <!-- <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a> -->
                                <span class='btn btn-primary btn-sm' data-toggle='modal' data-target='#estadoAnexo'>Listar</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div><!-- /.box -->

            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_anexo" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>COD</th>
                                        <th>NOMBRE DEL ANEXO</th>
                                        <th>FECHA DE INGRESO</th>
                                        <th>USUARIO REGISTRADOR</th>
                                        <th>ESTADO</th>
                                        <th>OBSERVACION</th>
                                        <th>AREA</th>
                                        <th>VER DETALLE</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_anexo">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer" style="margin-top:8px">
         <!-- <span id="btnAgregarAnexo" class="btn btn-primary btn-sm" onclick=""><i class="glyphicon glyphicon-plus"></i> AGREGAR ANEXO</span> -->
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
