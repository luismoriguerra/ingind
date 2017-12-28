<!-- /.modal -->
<div class="modal fade" id="inicioModal" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header logo">
<!--                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>-->
                <h4 class="modal-title" style="text-align:center">New message</h4>
            </div>
            <div class="modal-body">
                <form id="form_inicio_modal" name="form_inicio_modal" action="" method="post">
                    <div class="form-group">
                        <label class="control-label">Responda lo siguiente:</label>
                        <label class="control-label">¿La acción a realizar pertenece a un proceso?</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"></label>
                                <label class="control-label">
                                    <a class="btn btn-primary" onclick="GrabarAuditoriaInicio(1)">SI</a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"></label>
                                <label class="control-label">
                                    <a class="btn btn-danger" onclick="GrabarAuditoriaInicio(2)">NO</a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"></label>
                                <label class="control-label">
                                    <a class="btn btn-primary" onclick="GrabarAuditoriaInicio(3)">Deseo ver mis procesos</a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span style="color: red;text-align: left !important;font-size:15px !important;">*Tiene que escoger una opción para continuar</span>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
