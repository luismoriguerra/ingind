<!-- /.modal -->
<div class="modal fade" id="actividadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lgz">
        <div class="modal-content">
            <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">Actividades</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <form id="form_actividad" name="form_actividad" method="POST" action="">
                            <div class="box-body table-responsive">
                                <table id="t_actividad" class="table table-bordered table-striped">
                                    <thead id="tt_actividad">
                                        <tr>
                                            <th>N°</th>
                                            <th>Actividad</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Tiempo Transcurrido</th>
                                            <th>Formato</th>
                                            <th>Cantidad</th>
                                            <th>Documentos</th>
                                            <th>Archivos</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_actividad">
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12" style="text-align:center">
                        <label id="exonera" style="background-color:blue;color: #ffffff"></label> 
                    </div>
                    <div class="col-sm-12" style="text-align:center">
                        <label id="fechas" style="background-color:blue;color: #ffffff"></label> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
