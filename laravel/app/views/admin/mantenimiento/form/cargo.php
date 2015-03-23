<!-- /.modal -->
<div class="modal fade" id="cargoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_cargos" name="form_cargos" action="" method="post">
          <div class="form-group">
            <label class="control-label">Nombre
                <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
          </div>
          <div class="form-group">
            <label class="control-label">Estado:
            </label>
            <select class="form-control" name="slct_estado" id="slct_estado">
                <option value='0'>Inactivo</option>
                <option value='1' selected>Activo</option>
            </select>
          </div>

          <fieldset>
            <legend>Opciones por cargo</legend>

            <div class="row form-group">
              <div class="col-sm-12">
                <div class="col-sm-6">
                  <label class="control-label">Menus:
                  </label>
                  <select class="form-control" name="slct_menus" id="slct_menus">
                  </select>
                </div>
                <div class="col-sm-6">
                    <br>
                    <button type="button" class="btn btn-success" Onclick="AgregarOpcion();">
                      <i class="fa fa-plus fa-sm"></i>
                      &nbsp;Nuevo
                    </button>
                </div>
              </div>
            </div>
            <ul class="list-group" id="t_opcionCargo"></ul>
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