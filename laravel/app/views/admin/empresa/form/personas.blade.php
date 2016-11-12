<!-- /.modal -->
<div class="modal fade" id="personasModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_areas_modal" name="form_areas_modal" action="" method="post" >
          <div class="form-group">
            <label class="control-label">Nombre
                <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
          </div>
        </form>
 
        <div class="row form-group">
          <spinner id="spinner-box" :size="size" :fixed="fixed" v-show="loaded" text="Espere un momento por favor"></spinner>
          <div class="box box-solid">
              <div class="alert alert-success" transition="success" v-if="success">@{{ msj }} </div>

              <div class="form-group">
                  <div class="row form-group form-inline">
                      <div class="col-md-6">
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
                  <vuetable v-ref:vuetable
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
                      detail-row-component="my-detail-row"
                      detail-row-id="id"
                      detail-row-transition="expand"
                      row-class-callback="rowClassCB"
                  ></vuetable>
              </div>
          </div>
        </div>
        <div class="row form-group"> 
        
          <div class="col-sm-12">
            
            <div class="col-sm-4">
              <label class="control-label">Imagen condicional
                  <a id="error_imagenc" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Ext.">
                      <i class="fa fa-exclamation"></i>
                  </a>
              </label></br>
              <img id="img_imagenc" src="" class="img-thumbnail imgArea" />
              <form id="form_imagenc" name="form_imagenc" action="area/imagenc" enctype="multipart/form-data" method="post" >
                <input type="file" id="upload_imagenc" name="upload_imagenc" accept="image/*">
                <input type='hidden' name='upload_idc' id='upload_idc'>
              </form>
            </div>
            <div class="col-sm-4">
              <label class="control-label">Imagen paralela
                  <a id="error_imagenp" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Ext.">
                      <i class="fa fa-exclamation"></i>
                  </a>
              </label></br>
              <img id="img_imagenp" src="" class="img-thumbnail imgArea" />
              <form id="form_imagenp" name="form_imagenp" action="area/imagenp" enctype="multipart/form-data" method="post" >
                <input type="file" id="upload_imagenp" name="upload_imagenp" accept="image/*">
                <input type='hidden' name='upload_idp' id='upload_idp'>
              </form>
            </div>
          </div>
        </div>
          <!-- </div> -->
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
