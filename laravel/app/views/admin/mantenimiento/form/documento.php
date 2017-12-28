<!-- /.modal -->
<div class="modal fade" id="documentoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_documentos_modal" name="f" action="" method="post">

          

          <div class="form-group">
            <label class="control-label">Nombre:</label>
            <input type="text" class="form-control" name="txt_nombre" id="txt_nombre">
          </div>

         <div class="form-group">
            <label class="control-label">Area:</label>
            <select class="form-control" name="slct_area" id="slct_area">
                <option value="">.::Seleccione::.</option>
                <option value='0'>Sin Siglas</option>
                <option value='1'>Con Siglas</option>
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Posición de Título:</label>
            <select class="form-control" name="slct_posicion" id="slct_posicion">
                <option value="">.::Seleccione::.</option>
                <option value='0'>Centro</option>
                <option value='1'>Izquierda</option>
                <option value='2'>Derecha</option>
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Posicion Fecha:</label>
            <select class="form-control" name="slct_posicion_fecha" id="slct_posicion_fecha">
                <option value="">.::Seleccione::.</option>
                <option value='0'>Sin Fecha</option>
                <option value='1'>Arriba Izquierda</option>
                <option value='2'>Arriba Derecha</option>
                <option value='3'>Abajo Izquierda</option>
                <option value='4'>Abajo Derecha</option>
          </select>
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
