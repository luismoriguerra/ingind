<!-- /.modal -->
<div class="modal fade" id="microprocesoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">New message</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <form id="form_microproceso_modal" name="form_microproceso_modal" method="POST" action="">
                            <div class="box-body table-bordered">
                                <input type="hidden" class="mant" name="ruta_flujo_id" id="ruta_flujo_id">
                                <table id="t_microproceso" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>N°&nbsp;<a class='btn btn-success btn-sm'
                                                           onclick="AgregarMicro()"><i class="fa fa-plus fa-lg"></i></a></th>
                                            <th>Micro Proceso</th>
                                            <th></th>
                                            <th>Norden</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_microproceso">
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
