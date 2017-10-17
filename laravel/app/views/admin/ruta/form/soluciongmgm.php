<!-- /.modal -->
<div class="modal fade" id="soluciongmgmModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Solucion GMGM</h4>
      </div>
      <div class="modal-body">
        <form id="form_soluciongmgm_modal" name="form_soluciongmgm_modal" action="" method="post" >
        <fieldset>
        <legend>Respuesta al Ticket</legend>
        <div class="form-group"> 


        <!-- INICIA EL DIV DE 12 -->
       <input class='form-control mant' type='hidden' id="id_1" name="id_1" > <!--ID DEL TICKET -->
       <input class='form-control mant' type='hidden' id="estado_ticket" name="estado_ticket" value="3" > <!--/ estado ticket atendido a solucionado -->

        <div class="col-sm-12"> 
          <div class="col-sm-6"> 
            <label>Descripcion:</label>
              <textarea class="form-control" id="txt_solucion" name="txt_solucion" rows="8"></textarea>      
          </div>      

          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label">Tipo Problema:</label>
              <select class="form-control" name="slct_estado_tipo_problema" id="slct_estado_tipo_problema">
                <option value="" style="display:none"="">.::Seleccione::.</option>
                <option value='1'>Error de Usuario</option>
                <option value='2'>Insidencia del Sistema</option>
                <option value='3'>Consultas</option>
                <option value='4'>Peticiones</option>
                <option value='5'>Problema de Equipo</option>
              </select>
            </div>
          </div>

        </div><!-- FIN DEL DIV DE 12 -->   


      

          </fieldset>
        </form>
         

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="CambiarEstado_Atendido();">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
