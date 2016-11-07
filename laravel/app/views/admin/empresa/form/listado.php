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

    <div class="row form-group">
      <div class="col-sm-12">
        <label class="control-label">Tipo Empresa:
            <a v-show="!validation.tipo_id" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Seleccione tipo de empresa">
                <i class="fa fa-exclamation"></i>
            </a>
        </label>
        <select v-model="newEmpresa.tipo_id" type="text" id="tipo_id" name="tipo_id" class="form-control input-sm pull-right">
            <option value=""></option>
            <option value="1">Natural</option>
            <option value="2">Juridico</option>
            <option value="3">Organizacion Social</option>
            <option value="4">Institucion Publica</option>
        </select>
      </div>
      <div class="col-sm-12">
        <label class="control-label">RUC:
            <a v-show="!validation.ruc" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese RUC">
                <i class="fa fa-exclamation"></i>
            </a>
        </label>
        <input v-model="newEmpresa.ruc" type="text" maxlength="11" id="ruc" name="ruc" class="form-control input-sm pull-right">
      </div>
      <div class="col-sm-12">
        <label class="control-label">Razon social:
            <a v-show="!validation.razon_social" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Razon social">
                <i class="fa fa-exclamation"></i>
            </a>
        </label>
        <input v-model="newEmpresa.razon_social" type="text" id="razon_social" name="razon_social" class="form-control input-sm pull-right">
      </div>
      <div class="col-sm-12">
        <label class="control-label">Nombre comercial:
            <a v-show="!validation.nombre_comercial" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre comercial">
                <i class="fa fa-exclamation"></i>
            </a>
        </label>
        <input v-model="newEmpresa.nombre_comercial" type="text" id="nombre_comercial" name="nombre_comercial" class="form-control input-sm pull-right">
      </div>
      <div class="col-sm-12">
        <label class="control-label">Direccion fiscal:
            <a v-show="!validation.direccion_fiscal" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Direccion fiscal">
                <i class="fa fa-exclamation"></i>
            </a>
        </label>
        <input v-model="newEmpresa.direccion_fiscal" type="text" id="direccion_fiscal" name="direccion_fiscal" class="form-control input-sm pull-right">
      </div>
      <div class="col-sm-12">
        <label class="control-label">Vigencia:
            <a v-show="!validation.fecha_vigencia" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese fecha de Vigencia">
                <i class="fa fa-exclamation"></i>
            </a>
        </label>
        <input type="text" id='fecha_nacimiento' name='fecha_nacimiento' v-model="newEmpresa.fecha_vigencia" class="form-control input-sm pull-right" placeholder="AAAA-MM-DD" onfocus="blur()" autocomplete="off">
      </div>

      <div class="col-sm-12">
        <label class="control-label">Cargo:
            <a v-show="!validation.cargo" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese cargo">
                <i class="fa fa-exclamation"></i>
            </a>
        </label>
        <input v-model="newEmpresa.cargo" type="text" maxlength="50" id="cargo" name="cargo" class="form-control input-sm pull-right">
      </div>
      <div class="col-sm-12">
        <label class="control-label">Telefono:
            <a v-show="!validation.telefono" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Telefono">
                <i class="fa fa-exclamation"></i>
            </a>
        </label>
        <input v-model="newEmpresa.telefono" type="text"  maxlength="12" id="telefono" name="telefono" class="form-control input-sm pull-right">
      </div>
    </div>

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