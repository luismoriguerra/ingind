<!-- /.modal -->
<div class="modal fade" id="NuevoDocDigital" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formNuevoDocDigital" name="form_plantilla" method="post">
        <input type="hidden" id="txt_iddocdigital" name="txt_iddocdigital" value="">
        <input type="hidden" id="txt_area_plantilla" name="txt_area_plantilla" value="">
        <div class="modal-header logo">
          <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
              <i class="fa fa-close"></i>
          </button>
          <h4 class="modal-title">Documento Digital</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-xs-5">
                <div class="form-group">
                    <label class="control-label">Titulo:
                       <!--  <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                            <i class="fa fa-exclamation"></i>
                        </a> -->
                    </label>
                    <div class="row">
                      <div class="col-xs-5">
                         <label id="lblDocumento" style="margin-top:5px;float:right;">Documento Prueba Nº</label>
                      </div>
                      <div class="col-xs-3">
                          <input type="text" class="form-control txttittle" placeholder="Ingrese Titulo" name="txt_titulo" id="txt_titulo">
                      </div>
                      <div class="col-xs-3">
                          <label id="lblArea" style="margin-top:5px;">-MDI</label>
                      </div>                      
                    </div>
                    <input type="hidden" id="txt_titulofinal" name="txt_titulofinal" value="">
                </div>
              </div>
              <div class="col-xs-2">
                <div class="form-group">
                    <label class="control-label">Plantilla:
                    </label>
                    <select class="form-control" name="slct_plantilla" id="slct_plantilla">
                        <!-- <option value='0' >Inactivo</option>
                        <option value='1' selected>Activo</option> -->
                    </select>
                </div>
              </div>
              <div class="col-xs-5">
                <div class="form-group">
                  <label class="control-label">Tipo Envio:</label>
                    <select class="form-control" id="slct_tipoenvio" name="slct_tipoenvio">
                      <option value="0">::Seleccionar::</option>
                      <option value="1">Personas</option>
                      <option value="2">Gerencias</option>
                    </select>
                </div>

             

              </div>
            </div>
            <div class="row">
              <div class="col-xs-7 form-group">
                <div class="form-group">
                  <label class="control-label">Asunto: </label>
                  <textarea class="form-control" name="txt_asunto" id="txt_asunto" placeholder="Asunto .." rows="5"></textarea>
                </div>               
              </div>
              <div class="col-xs-5">
                <div class="form-group araesgerencia hidden">
                    <label class="control-label">Area(s) Envio:
                    </label>
                    <select class="form-control" name="slct_areas" id="slct_areas" multiple>
                    </select>
                </div>

                <div class="form-group areaspersona hidden">
                    <label class="control-label">Seleccione Area Persona:
                    </label>
                    <select class="form-control" name="slct_areasp" id="slct_areasp">
                    </select>
                </div>

                <div class="form-group personasarea hidden">
                    <label class="control-label">Seleccione persona:
                    </label>
                    <select class="form-control" name="slct_personaarea" id="slct_personaarea">
                    </select>
                </div>

                 <div class="form-group">
                  <label class="control-label">Seleccione Copia: </label>
                  <select class="form-control" name="slct_copia" id="slct_copia" multiple></select>
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
              <div class="col-xs-12">
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