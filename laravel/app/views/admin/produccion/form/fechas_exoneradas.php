<!-- /.modal -->
<div class="modal fade" id="fechaExonerar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Fechas Exoneradas</h4>
      </div>
      <div class="modal-body">
          <div class="row form-group">
              <div class="col-sm-12">
              <form id="form_exoneracion" name="form_exoneracion" method="POST" action="">
                  <input type="hidden" name="txt_idpersona2" id="txt_idpersona2">
                  <div class="box-body table-responsive">
                      <table id="t_exoneracion" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Observacion</th>
                                        <th>[]</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_exoneracion">
                                </tbody>
                                <tfoot>
                                  <tr class="trNuevo hidden">
                                      <td id="tdRol" style="vertical-align : middle;">
                                          <input type='text' name='txt_fechaini' id='txt_fechaini' class='form-control datepicker txt_fechaini'/>
                                      </td>
                                      <td id="tdVerbo" style="vertical-align : middle;">
                                          <input type='text' name='txt_fechafin' id='txt_fechafin' class='form-control datepicker txt_fechafin'/>
                                      </td>
                                      <td id="tdTipoDoc" style="vertical-align : middle;">
                                          <textarea class="form-control txt_observacion" rows="2" id="txt_observacion" name="txt_observacion"></textarea>
                                      </td>
                                      <td id="tdDescripcion" style="vertical-align : middle;display: flex;padding-top: 18px;padding-bottom: 18px">
                                           <span id="btnSave" name="btnSave" class="btn btn-success btn-sm" style="margin-right: 5px;" onclick="saveVerbo(this)"><i class="glyphicon glyphicon-ok"></i></span>  
                                           <span id="btnDelete" name="btnDelete" class="btn btn-danger  btn-sm btnDelete" onclick="Deletetr(this)"><i class="glyphicon glyphicon-remove"></i></span>
                                      </td>
                                  </tr>
                                </tfoot>
                      </table>
                        <button id="btnAdd" class="btn btn-yellow" style="width: 100%;margin-top:-20px" type="button" onclick="Addtr(event)"><span class="glyphicon glyphicon-plus"></span> AGREGAR </button>
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
