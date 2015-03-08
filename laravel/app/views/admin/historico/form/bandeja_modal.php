<!-- /.modal -->
        <div class="modal fade" id="bandejaModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg ">
            <div class="modal-content">
              <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">Gestión Clientes</h4>
              </div>
              <div class="modal-body">
                <form id="form_bandeja" name="form_bandeja" action="" method="post">
                  <div class="row form-group">                                    
                    <div class="col-sm-12">
                      <div class="col-sm-4">
                      <label>Código Actuación:</label>
                        <input type="text" class="form-control" id="txt_codactu_modal" readonly> 
                      </div>
                      <div class="col-sm-4">
                      <label>Estado:</label>
                        <input type="text" class="form-control" id="txt_estado_modal" readonly>
                      </div>
                      <div class="col-sm-4">
                      <label>Empresa:</label>
                        <input type="text" class="form-control" id="txt_empresa_modal" readonly>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-4">
                      <label>Motivo:</label>
                      <select class="form-control" id="slct_motivo_modal" name="slct_motivo_modal">
                          <option value="">.::Seleccione::.</option> 
                      </select>                                    
                      </div>
                      <div class="col-sm-4">
                      <label>Submotivo:</label>
                      <select class="form-control" id="slct_submotivo_modal" name="slct_submotivo_modal">
                          <option value="">.::Seleccione::.</option> 
                      </select>
                      </div>
                      <div class="col-sm-4">
                      <label>Estado:</label>
                      <select class="form-control" id="slct_estado_modal" name="slct_estado_modal">
                          <option value="">.::Seleccione::.</option> 
                      </select>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-4">
                      <label>Coordino con Cliente:</label>
                      <select class="form-control" id="slct_coordinado_modal" name="slct_coordinado_modal">
                          <option value="">.::Seleccione::.</option>
                          <option value="1">Si</option>
                          <option value="0">No</option> 
                      </select>
                      </div>
                      <div class="col-sm-8">
                      <label>Observación:</label>
                      <textarea rows="2" class="form-control" id="txt_observacion_modal" name="txt_observacion_modal"></textarea>
                      </div>                      
                    </div>
                    <div class="col-sm-12 L0">
                      <h3>Liquidados:</h3>
                    </div>
                    <div class="col-sm-12 L0">
                      <div class="col-sm-4">
                      <label>Contacto:</label>
                      <select class="form-control L1" id="slct_coordinado_modal" name="slct_contacto_modal">
                          <option value="">.::Seleccione::.</option>
                          <option value="1">Si</option>
                          <option value="0">No</option> 
                      </select>
                      </div>
                      <div class="col-sm-4">
                      <label>Pruebas:</label>
                      <select class="form-control L1" id="slct_coordinado_modal" name="slct_pruebas_modal">
                          <option value="">.::Seleccione::.</option>
                          <option value="1">Si</option>
                          <option value="0">No</option> 
                      </select>
                      </div>
                      <div class="col-sm-4">
                      <label>Fecha Consolidación:</label>
                          <div class="input-group">
                              <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right L1" name="fecha_consolidacion" id="fecha_consolidacion"/>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-12 L0">
                      <div class="col-sm-4">
                      <label>Feedback:</label>
                      <select class="form-control L1" id="slct_feedback_modal" name="slct_feedback_modal">
                        <option value="">.::Seleccione::.</option> 
                      </select>
                      </div>
                      <div class="col-sm-4">
                      <label>Solución:</label>
                      <select class="form-control L1" id="slct_solucion_modal" name="slct_solucion_modal">
                        <option value="">.::Seleccione::.</option> 
                      </select>
                      </div>
                      <div class="col-sm-4">
                      <label>Penalizable: <input type="checkbox" class="L1" id="chk_penalizable_modal" name="chk_penalizable_modal" value="1"></label>
                      <textarea rows="2" class="form-control L1" id="txt_penalizable_modal" name="txt_penalizable_modal"></textarea>
                      </div>
                    </div>
                    <div class="col-sm-12 T0">
                      <div class="col-sm-4">
                      <label>Celula:</label>
                      <select class="form-control T1" id="slct_celula_modal" name="slct_celula_modal">
                          <option value="">.::Seleccione::.</option>
                      </select>
                      </div>
                      <div class="col-sm-4">
                      <label>Tecnico:</label>
                      <select class="form-control T1" id="slct_tecnico_modal" name="slct_tecnico_modal">
                          <option value="">.::Seleccione::.</option>
                      </select>
                      </div>
                      <div class="col-sm-4">
                      <label>Officetrack:</label>
                      <input type="text" class="form-control T1" id="txt_officetrack" name="txt_officetrack" readonly>
                      </div>
                    </div>
                    <div class="col-sm-12 H0">
                      <div class="col-sm-12">
                      <lavel><br><h3>Aquí el cuadro</lavel>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" id="btn_close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="btn_gestion_modal" name="btn_gestion_modal" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal -->
