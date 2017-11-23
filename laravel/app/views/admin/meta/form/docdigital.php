<!-- /.modal -->
<div class="modal fade" id="docdigitalModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Documentos digitales</h4>
      </div>
      <div class="modal-body">
          <div class="row form-group">
              <div class="col-sm-12">
              <form id="form_docdigital" name="form_docdigital" method="POST" action="">
                   <input type="hidden" name="tipo" id="tipo" value="1">
                   <input type="hidden" name="solo_area" id="solo_area" value="|">
                  <div class="box-body table-responsive">
                      <table id="t_docdigital" class="table table-bordered table-striped">
                          <thead>
                              <tr><th colspan="3" style="text-align:center;background-color:#A7C0DC;"><h2>Documentos Digitales</h2></th></tr>
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
