<!-- /.modal -->
<div class="modal fade" id="historicoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">Historico de Documentos</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <form id="form_historico" name="form_historico" method="POST" action="">
                            <div class="box-body table-responsive">
                                <table id="t_historico" class="table table-bordered table-striped">
                                    <thead id="tt_historico">
                                        <tr>
                                            <th>N°</th>
                                            <th>Titulo</th>
                                            <th>Vista</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_historico">
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_cerrar_asignar" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
