<!-- /.modal -->
<div class="modal fade" id="rutaflujoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Ruta</h4>
      </div>
      <div class="modal-body">
            <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="">
                    <div class="row form-group" style="display">
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
                                <input class="form-control" type="text" id="txt_persona_1" name="txt_persona_1" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Proceso:</label>
                                <input class="form-control" type="text" id="txt_proceso_1" name="txt_proceso_1" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Area del Dueño del Proceso:</label>
                                <input class="form-control" type="text" id="txt_area_1" name="txt_area_1" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="display:none">
                        <div class="col-sm-12">
                            <div class="box-body table-responsive">
                                <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                                    <thead> 
                                        <tr class="head">
                                            <th style="width:250px !important;min-width: 200px !important;" >
                                            </th>
                                            <th class="eliminadetalleg" style="min-width:1000px !important;">[]</th>
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
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
