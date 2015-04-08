<!-- /.modal -->
<div class="modal fade" id="tecnicoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_tecnicos" name="form_tecnicos" action="" method="post">
          <div class="form-group">
            <label class="control-label">Apellido Paterno
                <a id="error_ape_paterno" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Apellido Paterno">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Apellido Paterno" name="txt_ape_paterno" id="txt_ape_paterno">
          </div>
          <div class="form-group">
            <label class="control-label">Apellido Materno
                <a id="error_ape_materno" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Apellido Materno">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Apellido Materno" name="txt_ape_materno" id="txt_ape_materno">
          </div>
          <div class="form-group">
            <label class="control-label">Nombres
                <a id="error_nombres" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombres">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombres" id="txt_nombres">
          </div>
          <div class="form-group">
            <label class="control-label">DNI
                <a id="error_dni" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese DNI">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese DNI" name="txt_dni" id="txt_dni">
          </div>
          <div class="form-group">
            <label class="control-label">Carnet
                <a id="error_carnet" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Carnet">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Carnet" name="txt_carnet" id="txt_carnet">
          </div>
          <div class="form-group">
            <label class="control-label">Carnet Criticos
                <a id="error_carnet_tmp" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Carnet Criticos">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Carnet Criticos" name="txt_carnet_tmp" id="txt_carnet_tmp">
          </div>
          <div class="form-group">
            <label class="control-label">Estado:
            </label>
            <select class="form-control" name="slct_estado" id="slct_estado">
                <option value='0'>Inactivo</option>
                <option value='1' selected>Activo</option>
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Empresa:
            </label>
            <select class="form-control" name="slct_empresas" id="slct_empresas">
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Celula:
            </label>
            <select class="form-control" multiple="multiple" name="slct_celulas[]" id="slct_celulas">
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