<!-- /.modal -->
<div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true">
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
          <div class="form-group">
            <label class="control-label">Nemonico
                <a id="error_nemonico" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Int.">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Id Int." name="txt_nemonico" id="txt_nemonico">
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
 
        <div class="row form-group"> 
        
          <div class="col-sm-12">
            <div class="col-sm-4">
              <label class="control-label">Imagen
                  <a id="error_imagen" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Ext.">
                      <i class="fa fa-exclamation"></i>
                  </a>
              </label></br>
              <img id="img_imagen_" src="" class="img-thumbnail imgArea" />
              <form id="form_imagen_" name="form_imagen_" action="area/imagen" enctype="multipart/form-data" method="post" >
                <input type="file" id="upload_imagen" name="upload_imagen" accept="image/*" >
                <input type='hidden' name='upload_id' id='upload_id'>
              </form>
            </div>
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
