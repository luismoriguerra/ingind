<!-- /.modal -->
<div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_usuarios" name="form_usuarios" action="" method="post">
          <fieldset>
            <legend>Datos personales</legend>
            <div class="row form-group">

              <div class="col-sm-12">
                <div class="col-sm-6">
                  <label class="control-label">Nombre
                      <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
                </div>
                <div class="col-sm-6">
                  <label class="control-label">Apellidos
                      <a id="error_apellidos" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Apellidos">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese Apellidos" name="txt_apellido" id="txt_apellido">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="col-sm-6">
                  <label class="control-label">Usuario
                      <a id="error_usuario" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Usuario">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese Usuario" name="txt_usuario" id="txt_usuario">
                </div>
                <div class="col-sm-6">
                  <label class="control-label">Password
                      <a id="error_dni" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Password">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="password" class="form-control" placeholder="Ingrese Password" name="txt_password" id="txt_password">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="col-sm-6">
                  <label class="control-label">DNI
                      <a id="error_dni" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese DNI">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese DNI" name="txt_dni" id="txt_dni">
                </div>
                <div class="col-sm-6">
                  <label class="control-label">Estado:
                  </label>
                  <select class="form-control" name="slct_estado" id="slct_estado">
                      <option value='0'>Inactivo</option>
                      <option value='1' selected>Activo</option>
                  </select>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="col-sm-6">
                  <label class="control-label">Perfil:
                  </label>
                  <select class="form-control" name="slct_perfil_id" id="slct_perfil_id">
                  </select>
                </div>
                <div class="col-sm-6">
                  <label class="control-label">Sexo:
                  </label>
                  <select class="form-control" name="slct_sexo" id="slct_sexo">
                      <option value='F'>Femenino</option>
                      <option value='M' selected>Masculino</option>
                  </select>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="col-sm-6">
                  <label class="control-label">Empresa:
                  </label>
                  <select class="form-control" name="slct_empresa_id" id="slct_empresa_id">
                  </select>
                </div>
                <div class="col-sm-6">
                  <label class="control-label">Empresas:
                  </label>
                  <select class="form-control" multiple="multiple" name="slct_empresas[]" id="slct_empresas">
                  </select>
                </div>
              </div>

              <div class="col-sm-12">
                  <label class="control-label">Quiebres:
                  </label>
                  <select class="form-control" multiple="multiple" name="slct_quiebres[]" id="slct_quiebres">
                  </select>
              </div>
            </div>
          </fieldset>
          <fieldset>
          <legend>Permisos y accesos a Modulos</legend>
            
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