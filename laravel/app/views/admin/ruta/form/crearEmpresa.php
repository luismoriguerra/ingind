<div class="modal-dialog modal-sm">
<div class="modal fade" id="crearEmpresa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content" style="width: 45%;margin: 0 auto;">
      <div class="modal-header logo">
             <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </button>
        <h4 class="modal-title">Crear Empresa</h4>
      </div>
      <div class="modal-body">

        <form class="FrmCrearEmpresa" id="FrmCrearEmpresa" method="post" action="">
                   <!--  <fieldset> -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group padding-10">
                                    <label class="control-label">Persona:</label>
                                    <input type="hidden" id='txt_persona_id2' name='txt_persona_id2'  class="form-control">
                                    <input type="text" id='txt_persona2' name='txt_persona2' readonly="" class="form-control">
                                    <input class="btn btn-sm btn-primary" type="button" value='Buscar' id="btnSeleccionarPersona">
                                </div>
                                   <div class="form-group padding-10">
                                    <label class="control-label">Ruc:</label>
                                    <input type="text" id="txt_ruc2" name="txt_ruc2" maxlength="11" class="form-control pull-right" placeholder="Ruc:" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Razon Social:</label>
                                    <input type="text" id="txt_razonsocial2"  name='txt_razonsocial2' maxlength="50" class="form-control  pull-right" placeholder="Razon Social" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Nombre Comercial:</label>
                                    <input type="text" id="txt_nombcomer"  name='txt_nombcomer' maxlength="50" class="form-control  pull-right" placeholder="Nombre Comercial" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Direccion Fiscal:</label>
                                    <input type="text" id="txt_direcfiscal"  name='txt_direcfiscal' maxlength="100" class="form-control  pull-right" placeholder="Direccion Fiscal" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Tipo Empresa:</label>
                                    <select id="cbo_tipoempresa" name="cbo_tipoempresa" class="form-control">
                                      <option value="">Seleccione tipo de empresa</option>
                                      <option value="1">Natural</option>
                                      <option value="2">Juridico</option>
                                      <option value="3">Organizacion Social</option>
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="submitWrap" style="margin-top:10px">
                             <span class="btn btn-primary btn-sm" id="" onclick="generarEmpresa()">Regístrate</span>
                        </div>




                      
                      
                    
                   <!--  </fieldset> -->
                </form>
  
      </div>
      <div class="modal-footer" style="border-top: 0px;">
       <!--  <span class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> IMPRIMIR</span>         -->
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->