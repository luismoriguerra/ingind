
<!-- /.modal -->
<div class="modal fade" id="documentoModal" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>

      <div class="modal-body">

        <form id="form_documento" name="form_documento" method="post">

          <input type="hidden" name="txt_cabecera" id="txt_cabecera">

          <div class="row">
            <div class="col-xs-4">
                <div class="form-group">
                    <label class="control-label">Seleccionar Plantilla:
                      <a id="error_plantilla" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Seleccionar Plantilla">
                            <i class="fa fa-exclamation"></i>
                      </a>
                      </label>
                    <select class="form-control" name="slct_plantilla" id="slct_plantilla" >
                    </select>
                </div>
            </div>
          </div>
          <div class="row" id="divTitulo" style="display: none;">
            <div class="col-xs-6">
              <div class="form-group">
                  <label class="control-label">Título
                      <a id="error_titulo" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Título">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese Título" name="txt_titulo" id="txt_titulo">
              </div>
            </div>
            <div class="col-xs-3">
              <div class="form-group">
                  <label class="control-label">Correlativo
                      <a id="error_correlativo" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" name="txt_correlativo" id="txt_correlativo" readonly="true" value="">
              </div>
            </div>
          </div>
          <div class="row" id="divCebecera" style="display: none;">
            <div class="col-xs-12">
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Partes de la Cabecera
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                      <table class="tabla-cabecera">
                          <tr>
                              <td width='20%' class='text-negrita'>A</td>
                              <td width='5px' class='text-negrita'>:</td>
                              <td width='75%'>
                                  Nombre de Gerencia y/o Subgerencia:
                                  <select class="form-control" name="slct_area_a" id="slct_area_a" ></select>
                                  Nombre de Encargado:
                                  <select class="form-control" name="slct_encargado_area_a" id="slct_encargado_area_a" ></select>
                              </td>
                          </tr>
                          <tr>
                              <td width='25%' class='text-negrita'>DE</td>
                              <td width='5px' class='text-negrita'>:</td>
                              <td width='75%'>
                                  Nombre de Gerencia y/o Subgerencia:
                                  <br>
                                  <b><span id="gerencia_de"></span></b>
                                  <input type="hidden" name="txt_area_de" id="txt_area_de">
                                  <br>
                                  Nombre de quien va dirigido:
                                  <br>
                                  <b><span id="encargado_de"></span></b>
                                  <input type="hidden" name="txt_encargado_area_de" id="txt_encargado_area_de">
                               </td>
                          </tr>
                          <tr>
                              <td width='25%' class='text-negrita'>ASUNTO</td>
                              <td width='5px' class='text-negrita'>:</td>
                              <td width='75%'>
                                <input type="text" class="form-control" placeholder="Ingrese Asunto" name="txt_asunto" id="txt_asunto"/>
                              </td>
                          </tr>
                          <tr>
                              <td width='25%' class='text-negrita'>FECHA</td>
                              <td width='5px' class='text-negrita'>:</td>
                              <td width='75%'>
                                <input type="hidden" name="txt_fechaDocumento" id="txt_fechaDocumento"/>
                                <div class="fecha">
                                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                  <span></span>
                                </div>
                              </td>
                          </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="divPlantillaWord" style="display: none;">
            <div class="col-xs-12">
              <div class="form-group">
                  <textarea id="plantillaWord" name="word" class="form-control" rows="6"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-info">Previsualizar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->