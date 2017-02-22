<!-- /.modal -->
<div class="modal fade" id="estratpeiModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">New message</h4>
            </div>
            <div class="modal-body">
                <form id="form_estrat_pei_modal" name="form_estrat_pei_modal" action="" method="post">

                    <input type='hidden' value='' name='txt_poi_id' id='txt_poi_id'>

                    <div class="form-group">
                        <label class="control-label">Descripción:</label>
                        <textarea type="text" class="form-control" placeholder="" name="txt_descripcion" id="txt_descripcion"></textarea>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
