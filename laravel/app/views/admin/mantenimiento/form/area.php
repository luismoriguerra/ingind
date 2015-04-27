<!-- /.modal -->
<div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">New message</h4>
      </div>
      <div class="modal-body">
        <form id="form_areas" name="form_areas" action="" method="post" >
          <div class="form-group">
            <label class="control-label">Nombre
                <a id="error_nombre" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Nombre">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Nombre" name="txt_nombre" id="txt_nombre">
          </div>
          <div class="form-group">
            <label class="control-label">Id Int.
                <a id="error_id_int" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Int.">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Id Int." name="txt_id_int" id="txt_id_int">
          </div>
          <div class="form-group">
            <label class="control-label">Id Ext.
                <a id="error_id_ext" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Ext.">
                    <i class="fa fa-exclamation"></i>
                </a>
            </label>
            <input type="text" class="form-control" placeholder="Ingrese Id Ext." name="txt_id_ext" id="txt_id_ext">
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

          <div class="form-group"> 
          
            <div class="col-sm-12">
              <div class="col-sm-6">
                <label class="control-label">Imagen
                    <a id="error_id_ext" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Ext.">
                        <i class="fa fa-exclamation"></i>
                    </a>
                </label>
                <img id="img_imagenp" src="" class="img-thumbnail imgArea" />
                <form id="form_imagenp" name="form_imagenp" action="area/imagenp" enctype="multipart/form-data" method="post" >
                  <input type="file" id="imagenp" name="imagenp" accept="image/*" >
                  <input type='hidden' name='idp' id='idp'>
                </form>
              </div>
              <div class="col-sm-6">
                <label class="control-label">Imagen condicional
                    <a id="error_id_ext" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Id Ext.">
                        <i class="fa fa-exclamation"></i>
                    </a>
                </label>
                <img id="img_imagenc" src="" class="img-thumbnail imgArea" />
                <form id="form_imagenc" name="form_imagenc" action="area/imagenc" enctype="multipart/form-data" method="post" >
                  <input type="file" id="imagenc" name="imagenc" accept="image/*">
                  <input type='hidden' name='idc' id='idc'>
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
