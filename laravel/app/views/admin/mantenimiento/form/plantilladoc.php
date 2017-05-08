<!-- /.modal -->
<div class="modal fade" id="plantillaModal" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form_plantilla" name="form_plantilla" method="post">
        <input type="hidden" id="txt_id" name="txt_id" value="">
        <div class="modal-header logo">
          <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
              <i class="fa fa-close"></i>
          </button>
          <h4 class="modal-title">Nueva Plantilla Documento</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                    <label class="control-label">Nombre
                       <!--  <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                            <i class="fa fa-exclamation"></i>
                        </a> -->
                    </label>
                    <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
                </div>
              </div>
              <div class="col-xs-3">
                <div class="form-group">
                    <label class="control-label">Tipo Documento:
                    </label>
                    <select class="form-control" name="slct_tipodoc" id="slct_tipodoc">
                        <!-- <option value='0' >Inactivo</option>
                        <option value='1' selected>Activo</option> -->
                    </select>
                </div>
              </div>
              <div class="col-xs-3">
                <div class="form-group">
                    <label class="control-label">Area:
                    </label>
                    <select class="form-control" name="slct_area" id="slct_area">
                        <option value='0' selected>NO</option>
                        <option value='1' >SI</option>
                    </select>
                </div>
              </div>
            </div>
           <!--  <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                    <label class="control-label">Título
                        <a id="error_titulo" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Titulo">
                            <i class="fa fa-exclamation"></i>
                        </a>
                    </label>
                    <input type="text" class="form-control" placeholder="Ingrese Titulo" name="txt_titulo" id="txt_titulo">
                </div>
              </div>
            </div> -->
  <!--           <div class="row" id="partesCabecera">
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
                                <td width='25%' class='text-negrita'>A</td>
                                <td width='5px' class='text-negrita'>:</td>
                                <td width='75%'>Nombre de Encargado <br>Nombre de Gerencia y/o Subgerencia</td>
                            </tr>
                            <tr>
                                <td width='25%' class='text-negrita'>DE</td>
                                <td width='5px' class='text-negrita'>:</td>
                                <td width='75%'>Nombre a quien va dirigido <br>Nombre de Gerencia y/o Subgerencia</td>
                            </tr>
                            <tr>
                                <td width='25%' class='text-negrita'>ASUNTO</td>
                                <td width='5px' class='text-negrita'>:</td>
                                <td width='75%'>Titulo, <i>Ejemplo:</i>  Invitación a la Inaguración del Palacio Municipal</td>
                            </tr>
                            <tr>
                                <td width='25%' class='text-negrita'>FECHA</td>
                                <td width='5px' class='text-negrita'>:</td>
                                <td width='75%'>Fecha, <i>Ejemplo:</i> Lima, 01 de diciembre del 2016</td>
                            </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="row">
              <div class="col-xs-7">
                <div class="form-group">
                    <textarea id="plantillaWord" name="word" class="form-control" rows="6"></textarea>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <!-- <button type="submit" class="btn btn-primary">Guardar</button> -->
          <button  id="btnCrear" class="btn btn-primary btn-sm" type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.modal
