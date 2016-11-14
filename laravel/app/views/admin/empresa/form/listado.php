<modal :show.sync="showModal">

  <div slot="modal-header" class="modal-header">
    <button type="button" class="close" @click="showModal = false"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">{{tituloModal}}</h4>
  </div>

  <div slot="modal-body" class="modal-body">

    <div class="alert alert-danger" transition="danger" v-if="danger">
      <ul>
        <li v-for="error in errores">
          {{ error }}
        </li>
      </ul>
    </div>

    <form action="#" @submit.prevent="accionModal">

    <div class="form-group">

      <div class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-3" for="tipo_id">Tipo Empresa:
                <a v-show="!validation.tipo_id" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Seleccione tipo de empresa">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <div class="col-sm-9">
              <select v-model="newEmpresa.tipo_id" type="text" id="tipo_id" name="tipo_id" class="form-control input-sm">
                  <option value="">Seleccione tipo de empresa</option>
                  <option value="1">Natural</option>
                  <option value="2">Juridico</option>
                  <!--<option value="3">Organizacion Social</option>-->
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="validar_ruc">RUC
              <a v-show="!validation.ruc" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Telefono">
                  <i class="fa fa-exclamation"></i>
              </a>
            </label>
            <div class="col-sm-6">
              <input v-model="ruc" type="text" id='validar_ruc' placeholder="Ingrese RUC" maxlength="11" class="form-control input-sm">
            </div>
            <div class="col-sm-3">
            <input :disabled="ruc==''" @click.prevent="validarRuc(ruc)" class="btn btn-sm btn-primary" type="button" value='VALIDAR'>
            </div>
          </div>

      </div>

    </div>

    <div class="form-group">
      <fieldset>
          <legend>Datos</legend>
          <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="nombre">RUC:</label>
                <div class="col-sm-9">
                  <input v-model="newEmpresa.ruc" readonly type="text" id="ruc" name="ruc" class="form-control input-sm pull-right">
                </div>
              </div>
          </div>

          <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="razon_social">Razon social:
                    <a v-show="!validation.razon_social" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Razon social">
                        <i class="fa fa-exclamation"></i>
                    </a>
                </label>
                <div class="col-sm-9">
                  <input v-model="newEmpresa.razon_social" type="text" id="razon_social" name="razon_social" class="form-control input-sm pull-right">
                </div>
              </div>
          </div>

          <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="nombre_comercial">Nombre comercial:
                  <a v-show="!validation.nombre_comercial" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre comercial">
                      <i class="fa fa-exclamation"></i>
                  </a>
                </label>
                <div class="col-sm-9">
                  <input v-model="newEmpresa.nombre_comercial" type="text" id="nombre_comercial" name="nombre_comercial" class="form-control input-sm pull-right">
                </div>
              </div>
          </div>

          <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="direccion_fiscal">Direccion fiscal:
                  <a v-show="!validation.direccion_fiscal" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Direccion fiscal">
                      <i class="fa fa-exclamation"></i>
                  </a>
                </label>
                <div class="col-sm-9">
                  <input v-model="newEmpresa.direccion_fiscal" type="text" id="direccion_fiscal" name="direccion_fiscal" class="form-control input-sm pull-right">
                </div>
              </div>
          </div>

          <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="fecha_vigencia">Vigencia:
                  <a v-show="!validation.fecha_vigencia" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese fecha de Vigencia">
                      <i class="fa fa-exclamation"></i>
                  </a>
                </label>
                <div class="col-sm-9">
                  <input type="text" id='fecha_vigencia' name='fecha_vigencia' v-model="newEmpresa.fecha_vigencia" class="form-control input-sm pull-right" placeholder="AAAA-MM-DD" onfocus="blur()" autocomplete="off">
                </div>
              </div>
          </div>
          <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="cargo">Cargo:
                  <a v-show="!validation.cargo" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese cargo">
                      <i class="fa fa-exclamation"></i>
                  </a>
                </label>
                <div class="col-sm-9">
                  <input v-model="newEmpresa.cargo" type="text" maxlength="50" id="cargo" name="cargo" class="form-control input-sm pull-right">
                </div>
              </div>
          </div>
          <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="telefono">Telefono:
                    <a v-show="!validation.telefono" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Telefono">
                        <i class="fa fa-exclamation"></i>
                    </a>
                </label>
                <div class="col-sm-9">
                  <input v-model="newEmpresa.telefono" type="text"  maxlength="12" id="telefono" name="telefono" class="form-control input-sm pull-right">
                </div>
              </div>
          </div>
    </div>
    </fieldset>
    <div class="row form-group">
        <div  class="modal-footer">
            <button type="button" class="btn btn-default" @click="showModal = false">Close</button>
            <button :disabled="!isValid" class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>

    </form>

  </div>
  <div v-show="false" slot="modal-footer" class="modal-footer"></div>
</modal>