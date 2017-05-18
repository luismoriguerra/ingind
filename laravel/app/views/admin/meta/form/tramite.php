<!-- /.modal -->
<div class="modal fade" id="tramiteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lgz">
        <div class="modal-content">
            <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">tramite</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="col-xl-12">
                            <form id="form_1" name="form_1">

                            </form>
                            <form id="form_tramite" name="form_tramite" method="POST" action="">
                                <div class="box-body table-responsive" style="overflow: auto; height: 388px; width: 100%;">
                                    <table id="t_tramite" class="table table-bordered no-footer dataTable">
                                        <thead id="tt_tramite">
                                            <tr>
                                                <th>Trámite</th>
                                                <th>Tipo Sol</th>
                                                <th>Solicitante</th>
                                                <th>Sumilla</th>
                                                <th>Estado</th>
                                                <th>Paso a la fecha</th>
                                                <th>Total de pasos</th>
                                                <th>Fecha Inicio</th>
                                                <th>[]</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tb_tramite">
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        <br>
                        <hr>
                        <div class="col-xl-12">
                            <div class="form-group">
                                <table id="t_reported_tab_1" class="table table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="6" style='background-color:#DEFAFA; width: 30% !important;'>Datos del paso</th>
                                            <th style='background-color:#F5DF9D; width: 35% !important;'>Acciones a realizar</th>
                                            <th style='background-color:#FCD790; width: 35% !important;'>Acciones realizadas</th>
                                        </tr>
                                        <tr>
                                            <th style='background-color:#DEFAFA'>N°</th>
                                            <th style='background-color:#DEFAFA'>Área</th>
                                            <th style='background-color:#DEFAFA'>Tiempo</th>
                                            <th style='background-color:#DEFAFA'>Inicio</th>
                                            <th style='background-color:#DEFAFA'>Final</th>
                                            <th style='background-color:#DEFAFA'>Estado final</th>

                                            <th style='background-color:#F5DF9D'>Rol "tiene que"
                                                Accion
                                                Tipo Doc.
                                                (Descripcion)
                                            </th>

                                            <th style='background-color:#FCD790'>Estado
                                                (N° Doc.
                                                Descripcion)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form name="form_ruta_flujo" id="form_ruta_flujo" style="display:none" method="POST" action="">
                            <div class="row form-group">
                                <div class="col-sm-12">
                                    <h1><span id="txt_titulo">Nueva Ruta</span>
                                        <small>
                                            <i class="fa fa-angle-double-right fa-lg"></i>
                                            <span id="texto_fecha_creacion">Fecha Creación:</span>
                                            <span id="fecha_creacion"></span>
                                        </small>
                                    </h1>
                                </div>
                                <div class="col-sm-12">
                                    <div class="col-sm-4">
                                        <label class="control-label">Dueño del Proceso:</label>
                                        <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label">Proceso:</label>
                                        <input class="form-control" type="text" id="txt_proceso" name="txt_proceso" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label">Area del Dueño del Proceso:</label>
                                        <input class="form-control" type="text" id="txt_area" name="txt_area" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12">
                                    <div class="box-body table-responsive">
                                        <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                                            <thead> 
                                                <tr class="head">
                                                    <th style="width:250px !important;min-width: 200px !important;" >
                                                    </th>
                                                    <th class="eliminadetalleg" style="min-width:1000px important!;">[]</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="body">
                                                    <td>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr><th colspan="2">
                                                                    </th></tr>
                                                                <tr class="head">
                                                                    <th>#</th>
                                                                    <th>Area</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tb_rutaflujodetalleAreas">
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="head">
                                                    <th>#</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                                        <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                                    </a>
                                </div>
                            </div>
                        </form>
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
