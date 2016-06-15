<!-- /.modal -->
<div class="modal fade" id="asignarModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lgz">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Carta de Inicio</h4>
      </div>
      <div class="modal-body">
        <form name="form_carta" id="form_carta" method="POST" action="">
          <div class="row form-group">
              <div class="col-sm-12">
                  <div class="box-body table-responsive">
                      <table id="t_carta" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>Carta</th>
                                  <th>Fecha Inicio</th>
                                  <th>Objetivo</th>
                                  <th>Entregable</th>
                                  <th>[ ]</th>
                              </tr>
                          </thead>
                          <tbody id="tb_carta">
                              
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th>Carta</th>
                                  <th>Fecha Inicio</th>
                                  <th>Objetivo</th>
                                  <th>Entregable</th>
                                  <th>[ ]</th>
                              </tr>
                          </tfoot>
                      </table>
                  </div>
              </div>
          </div>
          <br>
          <hr>
          <br>
          <div class="row form-group" id="cartainicio" style="display:none">
              <div class="col-sm-12">
                  <div class="col-sm-2">
                      <div class="box box-solid bg-blue">Carta N° :</div>
                  </div>
                  <div class="col-sm-3">
                      <input class="form-control" data-text="Ingrese Nro Carta" data-type="txt" id="txt_nro_carta" name="txt_nro_carta" type="text" disabled>
                  </div>
              </div>
              <div class="col-sm-12">
                  <div class="col-sm-2">
                      <label class="box box-solid bg-blue">Objetivo del Proyecto:</label>
                  </div>
                  <div class="col-sm-10">
                      <textarea class="form-control" data-text="Ingrese Objetivo del Proyecto" data-type="txt" id="txt_objetivo" name="txt_objetivo" disabled></textarea>
                  </div>
              </div>
              <div class="col-sm-12">
                  <div class="col-sm-2">
                      <label class="box box-solid bg-blue">Entregables del Proyecto:</label>
                  </div>
                  <div class="col-sm-10">
                      <textarea class="form-control" data-text="Ingrese Entregables del Proyecto" data-type="txt" id="txt_entregable" name="txt_entregable" disabled></textarea>
                  </div>
              </div>
              <div class="col-sm-12">
                  <div class="col-sm-2">
                      <label class="box box-solid bg-blue">Alcance del Proyecto:</label>
                  </div>
                  <div class="col-sm-10">
                      <textarea class="form-control" data-text="Ingrese Alcance del Proyecto" data-type="txt" id="txt_alcance" name="txt_alcance" disabled></textarea>
                  </div>
              </div>
              <div class="col-sm-12">
                      <label class="box box-solid bg-blue">
                      <a id="btn_recursos_0" onclick="AddTr(this.id,0);" class="btn btn-success btn-sm">
                          <i class="fa fa-plus fa-lg"></i>
                      </a>
                      Recursos (No humanos):
                      </label>
              </div>
              <div class="row form-group" id="tabla_recursos">
                  <div class="col-sm-12">
                      <div class="box-body table-responsive">
                          <table id="t_recursos" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th>N°</th>
                                      <th>Tipo Recurso</th>
                                      <th>Cantidad</th>
                                      <th> [ ] </th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <div class="col-sm-12">
                      <label class="box box-solid bg-blue">
                      <a id="btn_metricos_1" onclick="AddTr(this.id,0);" class="btn btn-success btn-sm">
                          <i class="fa fa-plus fa-lg"></i>
                      </a>
                      Métricos:
                      </label>
              </div>
              <div class="row form-group" id="tabla_metricos">
                  <div class="col-sm-12">
                      <div class="box-body table-responsive">
                          <table id="t_metricos" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th>N°</th>
                                      <th>Métrico</th>
                                      <th>Actual</th>
                                      <th>Objetivo</th>
                                      <th>Comentario</th>
                                      <th> [ ] </th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <div class="col-sm-12">
                      <label class="box box-solid bg-blue">
                      <a id="btn_desgloses_2" onclick="AddTr(this.id,0);" class="btn btn-success btn-sm">
                          <i class="fa fa-plus fa-lg"></i>
                      </a>
                      Desglose de Carta de Inicio N°:
                      </label>
              </div>
              <div class="row form-group" id="tabla_desgloses">
                  <div class="col-sm-12">
                      <div class="box-body table-responsive">
                          <table id="t_desgloses" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th>N°</th>
                                      <th>Tipo Actividad</th>
                                      <th>Actividad</th>
                                      <th style="width:300px !important;">Responsable - Area</th>
                                      <th>Recursos</th>
                                      <th style="width:106px !important;">Fecha Inicio</th>
                                      <th style="width:106px !important;">Fecha Fin</th>
                                      <th style="width:70px !important;">Hora Inicio</th>
                                      <th style="width:70px !important;">Hora Fin</th>
                                      <th> [ ] </th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_cerrar_asignar" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
