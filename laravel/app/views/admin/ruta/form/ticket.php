<!-- /.modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_tickets_modal" name="form_tickets_modal" action="" method="post" >
        <fieldset>
        <legend>Datos Importantes</legend>
        <div class="form-group"> 


  
         
        <!-- INICIA EL DIV DE 12 -->
        <div class="col-sm-12">        
          <!-- JALA EL NOMBRE DE LA PERSONA QUE ESTA LOGEADA -->
          <div class="col-sm-3">
            <label class="control-label"> Persona</label>
              <input class='form-control mant' type='hidden' id="slct_solicitante" name="slct_solicitante" value='<?php echo Auth::user()->id;  ?>'>
              <input class='form-control text-center' id='nombre_solicitante' name='nombre_solicitante' value='<?php echo Auth::user()->paterno.' '.Auth::user()->materno.' '.Auth::user()->nombre; ?>' readOnly=''>
          </div>

          <!-- JALA EL AREA DE LA PERSONA QUE ESTA LOGEADA -->
          <div class="col-sm-7">           
            <label class="control-label"> Area</label>
              <input class='form-control mant' type='hidden' id="slct_solicitante_area" name="slct_solicitante_area" value='<?php echo Auth::user()->area_id;  ?>'>
              <input class='form-control text-center' id='nombre_solicitante_area' name='nombre_solicitante_area' value='<?php echo Auth::user()->areas->nombre; ?>' readOnly=''>
          </div>

          <!-- JALA LA FECHA ACTUAL -->
          <div class="col-sm-2">
            <label class="control-label">Fecha Pendiente</label>
              <input type="text" class="form-control text-center mant" name="txt_fecha_pendiente" id="txt_fecha_pendiente" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly=""> 
          </div>
        </div> <!-- FIN DEL DIV DE 12 -->        



        <!-- INICIA EL DIV DE 12 -->
       
        <div class="col-sm-12"> 
          <div class="col-sm-6"> 
            <label>Descripcion:</label>
              <textarea class="form-control" id="txt_descripcion" name="txt_descripcion" rows="8"></textarea>
            
          </div>

         <!--  <div class="col-md-4">
            <label>Documentos:</label>
              <form name="form_ddocumento" id="form_ddocumento" enctype="”multipart/form-data”">
                <table id="t_ddocumento" class="table table-bordered">
                  <thead class="bg-teal disabled color-palette">
                  <tr>
                    <th>N°</th>
                      <th>Documento</th>
                      <th><span class="btn btn-default btn-xs" data-toggle="modal" data-target="#docdigitalModal"  data-form="this" onClick='MostrarDocumentos(this);' id="btn_list_digital" data-texto="txt_codigo"    data-id="txt_doc_digital_id"><i class="glyphicon glyphicon-file"></i></span>
                    </th> 
                  </tr> 
                  </thead> 
                    <tbody id="tb_ddocumento"> 
                      <tr style="display: none">
                        <td><input type="hidden" value="0"></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                      </tr>
                    </tbody>
                </table>
              </form>
          </div> -->
          <!-- <div class="col-md-2 form-group">
            <label>Cantidad:</label>
              <input type="text" class="form-control mant" id="txt_cantidad" name="txt_cantidad" value="0">
          </div> -->

          <!-- <div class="col-sm-6 validoarchivo" style= "margin-top: 40px;">
            <label>Archivos:</label>
              <form name="form_darchivo" id="form_darchivo" enctype="”multipart/form-data”">
                <table id="t_darchivo" class="table table-bordered">
                  <thead class="bg-aqua disabled color-palette">
                    <tr>
                      <th>Archivo</th>
                      <th>
                        <a class="btn btn-default btn-xs" onclick="AgregarD(this)"><i class="fa fa-plus fa-lg"></i></a>
                      </th> 
                    </tr> 
                  </thead> 
                    <tbody id="tb_darchivo"> 
                      <tr style="display: none">
                        <td><input type="hidden" value="0"></td>
                        <td><input type="hidden" value="0"></td>
                      </tr>
                    </tbody>
                </table>
              </form>
           </div> -->

           
        </div><!-- FIN DEL DIV DE 12 -->   

            

      

          </fieldset>
        </form>
         

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
