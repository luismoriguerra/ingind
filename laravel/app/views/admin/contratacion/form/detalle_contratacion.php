<!-- /.modal -->
<div class="modal fade" id="contrataciondetalleModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_detalle_contrataciones_modal" name="form_detalle_contrataciones_modal" action="" method="post">

          <input type='hidden' value='' name='txt_contratacion_id' id='txt_contratacion_id'>

          <div class="form-group">
            <label class="control-label">Texto:</label>
            <textarea type="text" class="form-control" placeholder="Ingrese Texto" name="txt_texto" id="txt_texto"></textarea>
          </div>
            <div class="col-sm-4">
          <div class="form-group">
            <label class="control-label">Monto:</label>
            <input type="text" class="form-control" placeholder="Ingrese Monto" name="txt_monto" id="txt_monto">
          </div>
                </div>
            <div class="col-sm-4" hidden="">
               <div class="form-group" >
            <label class="control-label">Fecha Conformidad:</label>
            <input type="text" class="form-control fecha" placeholder="AAAA-MM-DD" id="fecha_conformidad" name="fecha_conformidad" onfocus="blur()"/>
                </div>
            </div>
            <div class="col-sm-4">
          <div class="form-group">
            <label class="control-label">Fecha Inicio:</label>
            <input type="text" class="form-control fecha" placeholder="AAAA-MM-DD" id="fecha_inicio" name="fecha_inicio" onfocus="blur()"/>
          </div>
              </div>
            <div class="col-sm-4">  
          <div class="form-group">
            <label class="control-label">Fecha Fin:</label>
            <input type="text" class="form-control fecha" placeholder="AAAA-MM-DD" id="fecha_fin" name="fecha_fin" onfocus="blur()"/>
          </div>
                 </div>
            <div class="col-sm-4">
          <div class="form-group">
            <label class="control-label">Fecha Aviso:</label>
            <input type="text" class="form-control fecha" placeholder="AAAA-MM-DD" id="fecha_aviso" name="fecha_aviso" onfocus="blur()"/>
          </div>
             </div>
              <div class="col-sm-4">
          <div class="form-group">
            <label class="control-label">Programación Aviso:</label>
            <input type="text" class="form-control" placeholder="Programación Aviso" name="txt_programacion_aviso" id="txt_programacion_aviso">
          </div>
             </div>
          <div class="col-sm-12" hidden="">
          <div class="form-group" >
            <label class="control-label">Nro Doc:</label>
            <input type="text" class="form-control" placeholder="Nro Doc" name="txt_nro_doc" id="txt_nro_doc">
          </div>
          </div>
          <div class="form-group">
            <label class="control-label">Tipo:
            </label>
            <select class="form-control" name="slct_tipo" id="slct_tipo">
                <option value='1'>Bienes</option>
                <option value='2' selected>Servicios</option>
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
