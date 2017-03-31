<!-- /.modal -->
<div class="modal fade" id="accionBien" tabindex="-1" role="dialog" aria-hidden="true">
  <form id="form_AccionBien" name="form_AccionBien">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header logo">
          <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
              <i class="fa fa-close"></i>
          </button>
          <h4 class="modal-title">New message</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Descripcion
                    </label>
                    <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Categoria
                    </label>
                    <select class="form-control" name="slct_categoria" id="slct_categoria"></select>
                  </div>

                   <div class="form-group">
                    <label class="control-label">Marca
                    </label>
                     <input type="text" class="form-control" placeholder="Ingrese Marca" name="txt_marca" id="txt_marca">
                  </div>

                   <div class="form-group">
                    <label class="control-label">Modelo
                    </label>
                    <input type="text" class="form-control" placeholder="Ingrese Modelo" name="txt_modelo" id="txt_modelo">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Nro Interno
                    </label>
                     <input type="text" class="form-control" placeholder="Ingrese nro interno" name="txt_nroInterno" id="txt_nroInterno">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Serie
                    </label>
                     <input type="text" class="form-control" placeholder="Ingrese Serie" name="txt_serie" id="txt_serie">
                  </div>

                   <div class="form-group">
                    <label class="control-label">Ubicacion
                    </label>
                     <input type="text" class="form-control" placeholder="Ingrese Ubicacion" name="txt_ubicacion" id="txt_ubicacion">
                  </div>

                   <div class="form-group">
                    <label class="control-label">Fecha Adquisicion
                    </label>
                     <input type="text" class="form-control datepicker" name="txt_fechaadquisicion" id="txt_fechaadquisicion">
                  </div>
                </div>

              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btnAccion" onclick="Agregar()">Guardar</button>
<!--          <input type="submit" class="btn btn-primary btn-sm btnAction" id="" value="Guardar"> -->
        </div>
      </div>
    </div>
  </form>
</div>
<!-- /.modal -->