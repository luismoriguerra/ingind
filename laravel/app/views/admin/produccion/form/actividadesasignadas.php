<!-- /.modal -->
<div class="modal fade" id="actiasignadaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Actividades Asignadas</h4>
      </div>
      <div class="modal-body">
          <div class="row form-group">
              <div class="col-sm-12">
              <form id="form_actiasignada" name="form_actiasignada" method="POST" action="">
                   <input type="hidden" name="asignado" id="asignado" value="1">
                  <div class="box-body table-responsive">
                      <table id="t_actiasignada" class="table table-bordered table-striped">
                          <thead>
                              <tr><th colspan="3" style="text-align:center;background-color:#A7C0DC;"><h2>Actividades Asignadas</h2></th></tr>
                              <tr></tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                              <tr></tr>
                          </tfoot>
                      </table>
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
