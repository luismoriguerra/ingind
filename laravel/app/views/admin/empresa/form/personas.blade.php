<!-- /.modal -->
<div class="modal fade" id="personasModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Agregar Personal</h4>
      </div>
      <div class="modal-body">
      
        <div class="form-group">
          <spinner id="spinner-box" :size="size" :fixed="fixed" v-show="loaded" text="Espere un momento por favor"></spinner>
          <div class="box box-solid">
              <div class="alert alert-success" transition="success" v-if="success">@{{ msj }} </div>
              <div class="alert alert-danger" transition="danger" v-if="danger">@{{ msj }} </div>

              <div class="form-group">
                  <div class="row form-group form-inline">
                      <div class="col-md-12">
                          <div class="control-group">
                              <label class="control-label">Buscar:</label>
                              <input v-model="searchFor" class="form-control input-sm" @keyup.enter="setFilter">
                              <button class="btn btn-primary btn-sm" @click="setFilter">Go</button>
                              <button class="btn btn-default btn-sm" @click="resetFilter">Reset</button>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="table-responsive">
                  <vuetable v-ref:vuetable id='personas'
                      api-url="personas"
                      data-path="data"
                      pagination-path=""
                      :fields="fields"
                      :sort-order="sortOrder"
                      :multi-sort="multiSort"
                      table-class="table table-bordered table-striped table-hover"
                      ascending-icon="glyphicon glyphicon-chevron-up"
                      descending-icon="glyphicon glyphicon-chevron-down"
                      pagination-class=""
                      pagination-info-class=""
                      pagination-component-class=""
                      :pagination-component="paginationComponent"
                      :item-actions="itemActions"
                      :append-params="moreParams"
                      :per-page="perPage"
                      wrapper-class="vuetable-wrapper"
                      table-wrapper=".vuetable-wrapper"
                      loading-class="loading"
                      row-class-callback="rowClassCB"
                  ></vuetable>
              </div>
              <form action="#" @submit.prevent="AfiliarPersona">
              <div class="row form-group form-inline">
                  <div class="col-xs-6">
                    <div class="control-group">
                      <label class="control-label">Persona</label>
                      <input type="text" readonly="true" class="form-control pull-right" v-model='nombresApellidos' autocomplete="off">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="control-group">
                      <label class="control-label">DNI:</label>
                      <input type="text" readonly="true" class="form-control pull-right" v-model='persona.dni' autocomplete="off">
                    </div>
                  </div>
              </div>
              <div class="row form-group form-inline">
                  <div class="col-xs-6">
                    <div class="control-group">
                      <label class="control-label">Cargo</label>
                      <input type="text" class="form-control pull-right" v-model='persona.cargo' autocomplete="off">
                    </div>
                  </div>
                  
              </div>
               
              <div class="row form-group form-inline">
                <div class="col-xs-12">
                  <div class="control-group">
                    <label class="control-label">Tipo representante </label>
                    <label class="radio-inline">
                      <input type="radio" class="form-control pull-right" v-model="persona.representante_legal" value="1" name="representante_legal">
                      Si
                    </label>
                    <label class="radio-inline">
                      <input type="radio" class="form-control pull-right" v-model="persona.representante_legal" value="0" name="representante_legal">
                      No
                    </label>
                  </div>
                </div>
              </div>

              <div class="row form-group form-inline">
                  <div class="col-xs-6">
                    <div class="control-group">
                      <label class="control-label">Fecha Vigencia</label>
                      <input type="text" id='vigencia' name='vigencia' v-model='persona.vigencia' class="form-control  pull-right" placeholder="AAAA-MM-DD" onfocus="blur()" autocomplete="off">
                    </div>
                  </div>
              </div>
              <div class="row form-group form-inline">
                  <div class="col-xs-6">
                    <div class="control-group">
                      <label class="control-label">Fecha Cese</label>
                      <input type="text" id='cese' name='cese' v-model='persona.cese' class="form-control  pull-right" placeholder="AAAA-MM-DD" onfocus="blur()" autocomplete="off">
                    </div>
                  </div>
              </div>

              <div class="row form-group form-inline">
                  <div class="col-xs-6">
                    <div class="control-group">
                      <div v-if="!imagen">
                        <label class="control-label">Adjuntar Imagen</label>
                        <input type="file" @change="onFileChange" id="imagen" accept="image/*">
                      </div>
                      <div v-else>
                        <img :src="imagen" />
                        <button @click="removeImage('imagen')">Quitar Imagen</button>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <div class="control-group">
                      <div v-if="!imagen_dni">
                        <label class="control-label">Adjuntar Imagen</label>
                        <input type="file" @change="onFileChange" id="imagen_dni" accept="image/*">
                      </div>
                      <div v-else>
                        <img :src="imagen_dni" />
                        <button @click="removeImage('imagen_dni')">Quitar Imagen</button>
                      </div>
                    </div>
                  </div>
              </div>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button  class="btn btn-primary" type="submit">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
@include( 'admin.empresa.js.personas' )
<!-- /.modal -->
