<!-- /.modal -->
<div class="modal fade" id="personaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_personas" name="form_personas" action="" method="post">
          <fieldset>
            <legend>Datos personales</legend>
            <div class="row form-group">

              <div class="col-sm-12">
                <div class="col-sm-4">
                  <label class="control-label">Nombre
                      <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
                </div>
                <div class="col-sm-4">
                  <label class="control-label">Apellido Paterno
                      <a id="error_paterno" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Apellido Paterno">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese Apellido Paterno" name="txt_paterno" id="txt_paterno">
                </div>
                <div class="col-sm-4">
                  <label class="control-label">Apellido Materno
                      <a id="error_materno" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Apellido Materno">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese Apellido Materno" name="txt_materno" id="txt_materno">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="col-sm-4">
                  <label class="control-label">Fecha de Nacimiento
                      <a id="error_fecha_nac" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Fecha de Nacimiento">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="AAAA-MM-DD" id="txt_fecha_nac" name="txt_fecha_nac" onfocus="blur()"/>
                </div>
                <div class="col-sm-4">
                  <label class="control-label">DNI
                      <a id="error_dni" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese DNI">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese DNI" name="txt_dni" id="txt_dni">
                </div>
                <div class="col-sm-4">
                  <label class="control-label">Password
                      <a id="error_password" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Password">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="password" class="form-control" placeholder="Ingrese Password" name="txt_password" id="txt_password">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="col-sm-4">
                  <label class="control-label">Email
                      <a id="error_email" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese email">
                          <i class="fa fa-exclamation"></i>
                      </a>
                  </label>
                  <input type="text" class="form-control" placeholder="Ingrese email" name="txt_email" id="txt_email">
                </div>
                <div class="col-sm-4">
                  <label class="control-label">Sexo:
                  </label>
                  <select class="form-control" name="slct_sexo" id="slct_sexo">
                      <option value='' style="display:none">.:Seleccione:.</option>
                      <option value='F'>Femenino</option>
                      <option value='M' selected>Masculino</option>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label class="control-label">Estado:
                  </label>
                  <select class="form-control" name="slct_estado" id="slct_estado">
                      <option value='0'>Inactivo</option>
                      <option value='1' selected>Activo</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="col-sm-4">
                  <label class="control-label">Area:
                  </label>
                  <select class="form-control" name="slct_area" id="slct_area">
                  </select>
                </div>
                <div class="col-sm-4">
                  <label class="control-label">Rol:
                  </label>
                  <select class="form-control" name="slct_rol" id="slct_rol">
                  </select>
                </div>
              </div>

            </div>
          </fieldset>
          <fieldset id="f_areas_cargo">
            <legend>Niveles de Acceso</legend>

            <div class="row form-group">
              <div class="col-sm-12">
                <div class="col-sm-6">
                  <label class="control-label">Roles:
                  </label>
                  <select class="form-control" name="slct_cargos" id="slct_cargos">
                  </select>
                </div>
                <div class="col-sm-6">
                    <br>
                    <button type="button" class="btn btn-success" Onclick="AgregarArea();">
                      <i class="fa fa-plus fa-sm"></i>
                      &nbsp;Nuevo
                    </button>
                </div>
              </div>
            </div>
            <ul class="list-group" id="t_cargoPersona"></ul>
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
