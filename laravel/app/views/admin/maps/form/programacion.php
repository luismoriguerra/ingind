<!-- /.modal -->
<div class="modal fade" id="programacionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">Asignación de Vehiculo y Persona</h4>
            </div>
            <div class="modal-body" >
                <form id="form_programacion_modal" name="form_programacion_modal" action="" method="post">
                    <div class="form-group">
                        <label class="control-label">Dirección:</label>
                        <input type="text" class="form-control" name="txt_direccion" id="txt_direccion" disabled="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Fecha Programada:</label>
                        <input type="text" class="form-control" name="txt_programada" id="txt_programada" disabled="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Vehiculo:
                        </label>
                        <select class="form-control slct_vehiculo" name="slct_vehiculo" id="slct_vehiculo">
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Persona:
                        </label>
                        <input type="hidden" class="form-control" name="txt_persona_id" id="txt_persona_id" readonly="">
                        <input type="text" class="form-control" name="txt_persona" id="txt_persona" disabled="">
                        <button type="button" class="btn btn-info" id="btnPersona">Buscar Persona</button>
                    </div>
                    <div class="form-group">
<!--                        <label class="control-label">Estado:
                        </label>
                        <select class="form-control" name="slct_estado" id="slct_estado">
                            <option value='0'>Inactivo</option>
                            <option value='1' selected>Activo</option>
                        </select>-->
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
