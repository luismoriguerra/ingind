<!-- /.modal -->
<div class="modal fade" id="indedocsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Trámites de Indedocs</h4>
      </div>
      <div class="modal-body">
          <div class="row form-group">
              <div class="col-sm-12">
              <form id="form_indedocs" name="form_indedocs" method="POST" action="">
                   <div class="col-sm-4">
                       <label class="control-label">Fecha:</label>
                       <input type="text" class="form-control" placeholder="AAAA-MM-DD" id="fechaI" name="fechaI" value="<?php echo date('Y-m-d')?>" onfocus="blur()"/>
                    </div>
                  <div class="col-sm-6">
                      <label class="control-label">Seleccione Tipo Documento a Listar:</label>
                  <select id="slct_tipo_documento" name="slct_tipo_documento">
                    <option value="">.::Todo::.</option>
                  </select>
                  </div>
                  <div class="col-sm-1">
                  <span class="btn btn-primary btn-lg" onclick="Indedocs.mostrar();"><i class="fa fa-search fa-lg"></i></span>
                  </div>
                  <div class="col-sm-12"><br></div>
                  <div class="col-sm-12">
                  <div class="box-body table-responsive">
                      <table id="t_indedocs" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <td>Nro</td>
                                <td>Documento</td>
                                <td>[]</td>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                              <tr>
                                <td>Nro</td>
                                <td>Documento</td>
                                <td>[]</td>
                              </tr>
                          </tfoot>
                      </table>
                  </div>
                  </div>
              </form>
              </div>
              <div class="col-sm-12"><div  class="col-sm-12" id="mensaje"></div></div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
