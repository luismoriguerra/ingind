<!-- /.modal -->
<div class="modal fade" id="buscartramite" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
         <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Buscar Tipo de Trámite</h4>
      </div>
      <div class="modal-body">
            <div class="box">
                <fieldset>
                    <div class="row form-group filtros" >
                        <div class="col-sm-12">
                            <div class="col-md-4 col-sm-5">
                                <label class="control-label">INGRESAR COD O NOMBRE :</label>
                            </div>
                            <div class="col-md-6 col-sm-5">
                                <input type="text" class="form-control" id="txtbuscarclasificador" name="txtbuscarclasificador">
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <span class="btn btn-primary btn-md" id="generar" name="generar" onclick="consultar()"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div><!-- /.box -->

            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_clasificador" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>COD</th>
                                        <th>NOMBRE DEL TRAMITE</th>
                                        <th>REQUISITOS</th>
                                        <th>SELECCIONAR</th>
                                        <th>RUTA</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_clasificador">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row rowArea hidden" style="height:120px;">
              <div class="col-sm-12">
                  <table id="tblAreasCT" class="table table-bordered">
                    <thead>
                      <tr>
                        <label id="clasificarSelect"></label>
                        <td >(*) Seleccione area que tomara el tramite</td>                    
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>
                            <select class="form-control" id="slcAreasct" name="slcAreasct" onchange="selectCA(this)">
                              <!-- <option value="-1">Seleccione</option> -->
                            </select>
                            <input type="hidden" id="txt_clasificador_id" name="txt_clasificador_id">
                            <input type="hidden" id="txt_clasificador_nomb" name="txt_clasificador_nomb">
                          </td>
                        </tr>
                    </tbody>                 
                  </table>

              </div>              
            </div>
      </div>
      <div class="modal-footer" style="padding: 0px">
        <!--  <span id="btnAgregarAnexo" class="btn btn-primary btn-sm" onclick="updateTiempo(this)"><i class="glyphicon glyphicon-plus"></i> AGREGAR ANEXO</span> -->
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->

<!-- /.modal -->
<div class="modal fade" id="requisitos" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
         <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Requisitos</h4>
      </div>
      <div class="modal-body">
            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_requisitos" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td colspan="2" id="nombtramite"></td>
                                    </tr>
                                    <tr>
                                        <th>REQUISITO</th>
                                        <th>CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_requisitos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer" style="padding: 0px">
        <!--  <span id="btnAgregarAnexo" class="btn btn-primary btn-sm" onclick="updateTiempo(this)"><i class="glyphicon glyphicon-plus"></i> AGREGAR ANEXO</span> -->
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->

