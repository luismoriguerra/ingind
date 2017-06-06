<!-- /.modal -->
<div class="modal fade" id="addAnexo" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header logo">
                <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Anexos</h4>
            </div>
            <div class="modal-body">
                <form id="FormNuevoAnexo" name="FormNuevoAnexo" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" id="txt_anexoid" name="txt_anexoid">
                    <input type="hidden" id="txt_persona_id" name="txt_persona_id">
                    <input type="hidden" id="paterno2" name="paterno2">
                    <input type="hidden" id="materno2" name="materno2">
                    <input type="hidden" id="nombre2" name="nombre2">
                    <div class="usuario">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="col-md-4 form-group">
                                    <br>
                                    <span class="btn btn-primary btn-sm" id="btnTipoSolicitante" data-toggle="modal" data-target="#selectPersona">Seleccionar Persona</span>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label>Persona:</label>
                                    <input class="form-control" type="text" name="txt_persona" id="txt_persona" value="" disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="row hidden">
                            <div class="col-md-12">
                                <div class="col-md-4 form-group">
                                    <label>Tipo Doc.Entidad</label>
                                    <input class="form-control" type="text" name="txt_tipodocP" id="txt_tipodocP" value="">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Num Doc.Entidad</label>
                                    <input class="form-control" type="text" name="txt_numdocP" id="txt_numdocP" value="">
                                </div>                     
                            </div>
                        </div>                  
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Cod. Tramite:</label>
                                <input class="form-control" type="text" name="txt_tramite" id="txt_tramite" value="" readonly="readonly">
                                <input class="form-control" type="hidden" name="txt_codtramite" id="txt_codtramite" value="" readonly="readonly">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Fecha Ingreso:</label>
                                <input class="form-control" type="text" name="txt_fechaingreso" id="txt_fechaingreso" value="" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>#Tipo Doc:</label>
                                <select class="form-control" id="cbo_tipodoc" name="cbo_tipodoc"></select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Nombre Tramite:</label>
                                <input class="form-control" type="text" name="txt_nombtramite" id="txt_nombtramite" value="" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>#Num Documento:</label>
                                <input class="form-control" type="text" name="txt_numdocA" id="txt_numdocA" value="" readonly="readonly">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>#Folio:</label>
                                <input class="form-control" type="text" name="txt_folio" id="txt_folio" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="col-md-4">
                                <input class="form-control" type="file" name="txt_file" id="txt_file" value="" style="display:none">
                                <span class="btn btn-primary btn-md" name="btnImagen" id="btnImagen" value="" style="width: 100%">Cargar Imagen <i class="glyphicon glyphicon-upload"></i></span>
                                <img class="img-circle img-anexo" style="height: 142px;width: 100%;border-radius: 8px;border: 1px solid grey;margin-top: 5px;padding: 8px" :src="index.img">                          
                            </div>
                            <div class="col-md-8">
                                <label>Observaciones:</label>
                                <textarea class="form-control" id="txt_observ" name="txt_observ" rows="5" placeholder=""></textarea>
                            </div>
                            <!--                      <div class="col-md-4">
                                                    <span class="btn btn-success btn-md hidden" name="spanRuta" id="spanRuta" value=""></span>                   
                                                  </div>-->
                        </div>
                    </div>
                    <div class="row observ ">
                        <div class="col-md-12">

                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12" style="text-align: right">
                            <input type="submit" class="btn btn-primary btn-md btnAction" id="" value="Guardar">
                            <span class="btn btn-warning btn-md" data-dismiss="modal">Cancelar</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="padding: 0px">
              <!--  <span id="btnAgregarAnexo" class="btn btn-primary btn-sm" onclick="updateTiempo(this)"><i class="glyphicon glyphicon-plus"></i> AGREGAR ANEXO</span> -->
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
