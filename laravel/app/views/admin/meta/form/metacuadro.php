<!-- /.modal -->
<div class="modal fade" id="metacuadroModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header logo">
                <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title">New message</h4>
            </div>
            <div class="modal-body">
                <form id="form_metacuadros_modal" name="form_metacuadros_modal" action="" method="post">


                    <div class="form-group">
                        <label class="control-label">Meta:
                        </label>
                        <select class="form-control" name="slct_meta" id="slct_meta">
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Actividad:</label>
                        <input type="text" class="form-control" placeholder="Ingrese Actividad" name="txt_actividad" id="txt_actividad">
                    </div>
                    <div class="form-group" >
                        <label class="control-label">Fecha de Vencimiento:</label>
                        <input type="text" class="form-control fechaG" placeholder="AAAA-MM-DD" id="txt_fecha" name="txt_fecha" onfocus="blur()"/>
                    </div>
                    <div class="form-group" >
                        <label class="control-label">Fecha de Vencimiento Adicional:</label>
                        <input type="text" class="form-control fechaG" placeholder="AAAA-MM-DD" id="txt_fecha_add" name="txt_fecha_add" onfocus="blur()"/>
                    </div>
         
                        <div class="form-group">
                            <label class="control-label">Año:</label>
                            <input type="text" class="form-control" placeholder="" name="txt_anio" id="txt_anio">
                        </div>
      
                    <div class="col-sm-12">
                        <div class="nav-tabs-custom" >
                            <ul class="nav nav-tabs logo modal-header">
                                <li class="logo tab_1 active">
                                    <a href="#tab_1" data-toggle="tab">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-cloud fa-lg"></i> </button>
                                        Descripción
                                    </a>
                                </li>
                                <li class="logo tab_2">
                                    <a href="#tab_2" data-toggle="tab">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-cloud fa-lg"></i> </button>
                                        Pasos
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1" >
                      
                                        <div class="row form-group" id="fecha1" >
                                            <div class="col-sm-12">
                                                <div class="box-body table-responsive">
                                                    <table id="t_fecha1" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>N°&nbsp;<a class='btn btn-success btn-sm'
                                                                         onclick="AgregarFecha1()"><i class="fa fa-plus fa-lg"></i></a></th>
                                                                <th>Fecha</th>
                                                                <th>Fecha Adicional</th>
                                                                <th>Descripción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tb_fecha1">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                
                                </div>
                                <div class="tab-pane" id="tab_2" >
                         
                                        <div class="row form-group" id="fecha2" >
                                            <div class="col-sm-12">
                                                <div class="box-body table-responsive">
                                                    <table id="t_fecha2" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                               <th>N°&nbsp;<a class='btn btn-success btn-sm agregarfecha2'
                                                                         ><i class="fa fa-plus fa-lg"></i></a></th>
                                                                <th>Fecha</th>
                                                                <th>Fecha Adicional</th>
                                                                <th>Paso</th>
                                                                <th>Actividad</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tb_fecha2">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>                
                                        </div>
                                
                                </div>   
                            </div><!-- /.tab-content -->
                        </div><!-- nav-tabs-custom --> 
                    </div>


                    <div class="form-group">
                        <label class="control-label">Estado:
                        </label>
                        <select class="form-control" name="slct_estado" id="slct_estado">
                            <option value='0'>Inactivo</option>
                            <option value='1' selected>Activo</option>
                        </select>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
