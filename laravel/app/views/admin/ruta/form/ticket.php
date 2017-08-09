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



        <!-- JALA EL NOMBRE DE LA PERSONA QUE ESTA LOGEADA -->
        <div class="form-group">           
               <label class="control-label"> Persona</label>
               <input class='form-control mant' type='hidden' id="slct_solicitante" name="slct_solicitante" value='<?php echo Auth::user()->id;  ?>'>
                <input class='form-control' id='nombre_solicitante' name='nombre_solicitante' value='<?php echo Auth::user()->paterno.' '.Auth::user()->materno.' '.Auth::user()->nombre; ?>' readOnly=''>
        </div>

        <!-- JALA EL AREA DE LA PERSONA QUE ESTA LOGEADA -->
        <div class="form-group">
           
               <label class="control-label"> Area</label>
               <input class='form-control mant' type='hidden' id="slct_solicitante_area" name="slct_solicitante_area" value='<?php echo Auth::user()->area_id;  ?>'>
                <input class='form-control' id='nombre_solicitante_area' name='nombre_solicitante_area' value='<?php echo Auth::user()->areas->nombre; ?>' readOnly=''>
        </div>




          <div class="form-group">
            <label class="control-label">Descripcion
                <a id="error_descripcion" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Int.">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Id Int." name="txt_descripcion" id="txt_descripcion">
          </div>

    



          <div class="form-group">
            <label class="control-label">Fecha Atencion
                <a id="error_fecha_atencion" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Int.">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Id Int." name="txt_fecha_atencion" id="txt_fecha_atencion">
          </div>

          <div class="form-group">
            <label class="control-label">Fecha Solucion
                <a id="error_fecha_solucion" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Int.">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Id Int." name="txt_fecha_solucion" id="txt_fecha_solucion">
          </div>


          <div class="form-group">
            <label class="control-label">Estado:
            </label>
            <select class="form-control" name="slct_estado" id="slct_estado">
                <option value='0'>Inactivo</option>
                <option value='1' selected>Activo</option>
            </select>
          </div>
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
