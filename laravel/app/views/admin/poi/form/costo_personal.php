<!-- /.modal -->
<div class="modal fade" id="costopersonalModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">New message</h4>
            </div>
            <div class="modal-body">
                <form id="form_costo_personal_modal" name="form_costo_personal_modal" action="" method="post">

                    <input type='hidden' value='' name='txt_poi_id' id='txt_poi_id'>

                    <div class="form-group">
                        <label class="control-label">Rol:
                        </label>
                        <select class="form-control" name="slct_rol" id="slct_rol">
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Modalidad:</label>
                        <textarea type="text" class="form-control" placeholder="" name="txt_modalidad" id="txt_modalidad"></textarea>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Monto:</label>
                            <input type="text" class="form-control" placeholder="" name="txt_monto" id="txt_monto">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" >
                            <label class="control-label">Estimación:</label>
                            <input type="text" class="form-control" placeholder="" id="txt_estimacion" name="txt_estimacion" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Essalud:</label>
                            <input type="text" class="form-control" placeholder="" id="txt_essalud" name="txt_essalud" />
                        </div>
                    </div>
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="control-label">SubTotal:</label>
                            <input type="text" class="form-control" placeholder="" id="txt_subtotal" name="txt_subtotal"/>
                        </div>
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
