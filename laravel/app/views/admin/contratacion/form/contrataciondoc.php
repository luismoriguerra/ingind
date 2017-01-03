<!-- /.modal -->
<div class="modal fade" id="contratacionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_contrataciones_modal" name="form_contrataciones_modal" action="" method="post">

          

          <div class="form-group">
            <label class="control-label">Titulo:</label>
            <input type="text" class="form-control" placeholder="Ingrese Titulo" name="txt_titulo" id="txt_titulo" disabled="">
          </div>
          <div class="form-group">
            <label class="control-label">Objeto:</label>
            <textarea type="text" class="form-control" placeholder="Ingrese Objeto" name="txt_objeto" id="txt_objeto" disabled=""></textarea>
          </div>
          <div class="form-group">
            <label class="control-label">Justificación:</label>
            <textarea type="text" class="form-control" placeholder="Ingrese Justificación" name="txt_justificacion" id="txt_justificacion" disabled=""></textarea>
          </div>
          <div class="form-group">
            <label class="control-label">Actividades:</label>
            <textarea type="text" class="form-control" placeholder="Ingrese Actividades" name="txt_actividades" id="txt_actividades" disabled=""></textarea>
          </div>
            <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Monto Total:</label>
            <input type="text" class="form-control" placeholder="Ingrese Monto" name="txt_monto_total" id="txt_monto_total" disabled="">
          </div>
                </div>
            <div class="col-sm-3" hidden="">
               <div class="form-group">
            <label class="control-label">Fecha Conformidad:</label>
            <input type="text" class="form-control fecha" placeholder="AAAA-MM-DD" id="fecha_conformidad" name="fecha_conformidad" onfocus="blur()" disabled=""/>
                </div>
            </div>
            <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Fecha Inicio:</label>
            <input type="text" class="form-control fecha" placeholder="AAAA-MM-DD" id="fecha_inicio" name="fecha_inicio" onfocus="blur()" disabled=""/>
          </div>
              </div>
            <div class="col-sm-3">  
          <div class="form-group">
            <label class="control-label">Fecha Fin:</label>
            <input type="text" class="form-control fecha" placeholder="AAAA-MM-DD" id="fecha_fin" name="fecha_fin" onfocus="blur()" disabled=""/>
          </div>
                 </div>
            <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Fecha Aviso:</label>
            <input type="text" class="form-control fecha" placeholder="AAAA-MM-DD" id="fecha_aviso" name="fecha_aviso" onfocus="blur()" disabled=""/>
          </div>
             </div>
              <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Pro. Aviso:</label>
            <input type="text" class="form-control" placeholder="Programación Aviso" name="txt_programacion_aviso" id="txt_programacion_aviso" disabled="">
          </div>
             </div>
            <div class="col-sm-9">
          <div class="form-group">
            <label class="control-label">Nro Doc:</label>
            <input type="text" class="form-control" placeholder="Nro Doc" name="txt_nro_doc" id="txt_nro_doc">
          </div>
              </div>
       
          <div class="form-group">
                  <label class="control-label">Area:
                  </label>
                  <select class="form-control" name="slct_area" id="slct_area" disabled="">
                  </select>
                </div>
            
            <div class="form-group">
            <label class="control-label">Estado:
            </label>
            <select class="form-control" name="slct_estado" id="slct_estado" disabled="">
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
