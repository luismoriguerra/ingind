<!-- /.modal -->
<div class="modal fade" id="poiModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_pois_modal" name="form_pois_modal" action="" method="post">

          

          <div class="form-group">
            <label class="control-label">Objetivo General:</label>
            <textarea type="text" class="form-control" placeholder="" name="txt_objetivo_general" id="txt_objetivo_general"></textarea>
          </div>
          <div class="form-group">
            <label class="control-label">Año:</label>
            <input type="text" class="form-control" placeholder="" name="txt_anio" id="txt_anio">
          </div>
          <div class="form-group">
            <label class="control-label">Tipo de organo:</label>
            <textarea type="text" class="form-control" placeholder="" name="txt_tipo_organo" id="txt_tipo_organo"></textarea>
          </div>
          <div class="form-group">
            <label class="control-label">Centro de Apoyo:</label>
            <textarea type="text" class="form-control" placeholder="" name="txt_centro_apoyo" id="txt_centro_apoyo"></textarea>
          </div>
    
          <div class="form-group">
            <label class="control-label">Meta SIAF:</label>
            <input type="text" class="form-control" placeholder="" name="txt_meta_siaf" id="txt_meta_siaf">
          </div>
     
          <div class="col-sm-6">
          <div class="form-group">
            <label class="control-label">Unidad Medida:</label>
            <input type="text" class="form-control" placeholder="" name="txt_unidad_medida" id="txt_unidad_medida">
          </div>
          </div>
          <div class="col-sm-6">
          <div class="form-group">
            <label class="control-label">Cantidad Programada Semestral:</label>
            <input type="text" class="form-control" placeholder="Ingrese Monto" name="txt_cp_semestral" id="txt_cp_semestral">
          </div>
          </div>
          <div class="col-sm-6">
          <div class="form-group">
            <label class="control-label">Cantidad Programada Anual:</label>
            <input type="text" class="form-control" placeholder="Ingrese Monto" name="txt_cp_anual" id="txt_cp_anual">
          </div>
          </div>
          <div class="col-sm-6"> 
          <div class="form-group">
            <label class="control-label">Línea Estratégica PDLC:</label>
            <input type="text" class="form-control" placeholder="Ingrese Monto" name="txt_linea_estrat" id="txt_linea_estrat">
          </div>
          </div>    
           
            <div class="col-sm-12">
          <div class="form-group">
                  <label class="control-label">Area:
                  </label>
                  <select class="form-control" name="slct_area" id="slct_area">
                  </select>
                </div>
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
