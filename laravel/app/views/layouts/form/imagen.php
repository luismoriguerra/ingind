<!-- /.modal -->
        <div class="modal fade" id="imagenModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">Cargar Imagen</h4>
              </div>
              <div class="modal-body">
                <form id="form_imagen" name="form_imagen" action="" enctype="multipart/form-data" method="post">

                    <input name="token" id="token" value="<?php echo csrf_token(); ?>" type="hidden">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Imagen</label>
                      <input type="file" class="form-control" id="imagen" name="imagen" >
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