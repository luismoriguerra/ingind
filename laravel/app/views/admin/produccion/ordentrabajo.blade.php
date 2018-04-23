<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ HTML::style('lib/datepicker.css') }}
    {{ HTML::script('lib/bootstrap-datepicker.js') }}

    {{ HTML::script('lib/input-mask/js/jquery.inputmask.js') }}
    {{ HTML::script('lib/input-mask/js/jquery.inputmask.date.extensions.js') }}

    {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.produccion.js.ordentrabajo_ajax' )
    @include( 'admin.produccion.js.ordentrabajo' )
    @include( 'admin.produccion.js.actividadesasignadas' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<style type="text/css">
    .btn-yellow{
        color: #0070ba;
        background-color: ghostwhite;
        border-color: #ccc;
        font-weight: bold;
    }

    .yellow-fieldset{
        max-width: 100% !important;
        border: 3px solid #999;
        padding:10px 20px 2px 20px;
        border-radius: 10px; 
    }

    .margin-top-10{
         margin-top: 10px;   
    }
</style>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Crear Actividad Personal
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Actividad Personal</a></li>
                <li class="active">Crear</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="col-md-12 visible-lg visible-md filtros" style="margin-top:10px">
                            <div class="row">
                                <div class="col-md-1 col-xs-3 col-sm-3">
                                    <label>Total Hrs:</label>
                                </div>
                                <div class="col-md-3 col-xs-4 col-sm-4">
                                    <input type="text" class="form-control" id="txt_ttotal" name="txt_ttotal" readonly="readonly">                                            
                                </div>
                                <div class="col-md-3 col-xs-4 col-sm-4">
                                    <span class="btn btn-primary btn-success" id="btnGuardar" onclick="mostrarConfirmacion()">Guardar  <i class="glyphicon glyphicon-plus"></i></span>                                            
                                </div>
                                <div class="col-md-5 col-xs-5 col-sm-5 selectbyPerson hidden">
                                    <div class="col-md-4">
                                         <label>Seleccionar Personal:</label>
                                    </div>
                                    <div class="col-md-8">
                                       <select class="form-control" id="slct_personasA" name="slct_personasA">
                                           
                                       </select>                                                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 visible-sm visible-xs filtros" style="margin-top:10px;margin-bottom: 10px;">
                            <div class="row">
                                <div class="col-md-1 col-xs-3 col-sm-3">
                                    <label>Total Hrs:</label>
                                </div>
                                <div class="col-md-3 col-xs-4 col-sm-4">
                                    <input type="text" class="form-control" id="" name="" readonly="readonly">                                            
                                </div>
                                <div class="col-md-3 col-xs-4 col-sm-4">
                                    <span class="btn btn-primary btn-success" onclick="mostrarConfirmacion()">Guardar  <i class="glyphicon glyphicon-plus"></i></span>                                            
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                        <br>
                            <div class="col-md-12">
                                <div class="ordenesT">
                                    <fieldset class="yellow-fieldset valido">
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>Actividad:</label>
                                                <textarea class="form-control" id="txt_actividad" name="txt_actividad" rows="10"> </textarea>
                                               {{--  <input type="text" class="form-control" id="txt_actividad" name="txt_actividad"> --}}
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha Inicio / Formato 24H:</label>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="form-control fechaInicio mant" id="txt_fechaInicio" name="txt_fechaInicio" onchange="fecha(this)" disabled="disabled" value="<?php echo date('Y-m-d')?>">
<!--                                                        <input type="text" class="datepicker form-control fechaInicio" id="txt_fechaInicio" name="txt_fechaInicio" onchange="fecha(this)">-->
                                                    </div>
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="numeric" class="form-control horaInicio" id="txt_horaInicio" name="txt_horaInicio" onchange="CalcularHrs(this)" data-mask>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha Final / Formato 24H:</label>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="datepicker form-control fechaFin mant" id="txt_fechaFin" name="txt_fechaFin"  disabled="disabled" value="<?php echo date('Y-m-d')?>">
                                                    </div>
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="numeric" class="form-control horaFin" id="txt_horaFin" name="txt_horaFin" onchange="CalcularHrs(this)" data-mask>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Tiempo Transcurrido:</label>
                                                <input type="text" class="form-control ttranscurrido" id="txt_ttranscurrido" name="txt_ttranscurrido" readonly="readonly">
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <div class="col-md-10 form-group">
                                                    <label>Actividad Asignada:</label>
                                                    <input type="hidden" id="txt_actividad_asignado_id" name="txt_actividad_asignado_id" readonly="">
                                                    <input type="text" class="form-control" id="txt_actividad" name="txt_actividad_asignado" disabled="">
                                                </div>
                                                <div class="col-md-1 form-group">
                                                <label>-</label>
                                                <span class="btn btn-primary" data-toggle="modal" data-target="#actiasignadaModal" id="btn_buscar" onclick="MostrarActividad(this)">
                                                            <i class="fa fa-search fa-lg"></i>
                                                </span>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                <label>-</label>
                                                <span class="btn btn-danger" onclick="BorrarAsignado(this)" id="btn_borrar">
                                                            <i class="fa fa-eraser fa-lg"></i>
                                                </span>
                                                </div>
                                            </div>
                                           <div class="col-md-5 form-group">
                                                <div class="col-md-8 form-group">
                                                <label>Documentos:</label>
                                                <form name="form_ddocumento" id="form_ddocumento" enctype="”multipart/form-data”">
                                                    <table id="t_ddocumento" class="table table-bordered">
                                                        <thead class="bg-teal disabled color-palette">
                                                            <tr>
                                                                <th>N°</th>
                                                                <th>Documento</th>
                                                                <th><span class="btn btn-default btn-xs" data-toggle="modal" data-target="#docdigitalModal"  onClick='MostrarDocumentos(this);' id="btn_list_digital" data-texto="txt_codigo"    data-id="txt_doc_digital_id"><i class="glyphicon glyphicon-file"></i></span></th> 
                                                            </tr> 
                                                        </thead> 
                                                        <tbody id="tb_ddocumento">
                                                            <tr style="display: none">
                                                                <td><input type="hidden" value="0"></td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                <label>Cantidad:</label>
                                                <input type="text" class="form-control" id="txt_cantidad" name="txt_cantidad" value="0">
                                                </div>
                                           </div>
                                            <div class="col-md-3 form-group">
                                                <label>Archivos:</label>
                                                <form name="form_darchivo" id="form_darchivo" enctype="”multipart/form-data”">
                                                    <table id="t_darchivo" class="table table-bordered">
                                                        <thead class="bg-aqua disabled color-palette">
                                                            <tr>
                                                                <th>Archivo</th>
                                                                <th>
                                                                    <a class="btn btn-default btn-xs" onclick="AgregarD(this)"><i class="fa fa-plus fa-lg"></i></a>
                                                                </th> 
                                                            </tr> 
                                                        </thead> 
                                                        <tbody id="tb_darchivo"> 
                                                            <tr style="display: none">
                                                                <td><input type="hidden" value="0"></td>
                                                                <td><input type="hidden" value="0"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>

                                        </div>
                                    </fieldset>

                                    <fieldset class="yellow-fieldset template-orden margin-top-10 hidden">
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>Actividad:</label>
                                                <textarea class="form-control" id="txt_actividad" name="txt_actividad" rows="10"></textarea>
                                               {{--  <input type="text" class="form-control" id="txt_actividad" name="txt_actividad"> --}}
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha Inicio / Formato 24H:</label>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="datepicker form-control fechaInicio mant" id="txt_fechaInicio" name="txt_fechaInicio" onchange="fecha(this)" disabled="disabled" value="<?php echo date('Y-m-d')?>">
                                                    </div>
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="numeric" class="form-control horaInicio" id="txt_horaInicio" name="txt_horaInicio" onchange="CalcularHrs(this)" data-mask>
                                                    </div>                                                      
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha Final / Formato 24H:</label>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="datepicker form-control fechaFin mant" id="txt_fechaFin" name="txt_fechaFin" disabled="disabled" value="<?php echo date('Y-m-d')?>">
                                                    </div>
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="numeric" class="form-control horaFin" id="txt_horaFin" name="txt_horaFin" onchange="CalcularHrs(this)" data-mask>
                                                    </div>                                                      
                                                </div>
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Tiempo Transcurrido:</label>
                                                <input type="text" class="form-control ttranscurrido" id="txt_ttranscurrido" name="txt_ttranscurrido" readonly="readonly">
                                            </div>
                                            <div class="col-md-1 form-group visible-lg visible-md">
                                                <span id="btnDelete" name="btnDelete" class="btn btn-danger  btn-sm btnDelete" style="margin-top: 36%;"><i class="glyphicon glyphicon-remove"></i></span>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <div class="col-md-10 form-group">
                                                    <label>Actividad Asignada:</label>
                                                    <input type="hidden" id="txt_actividad_asignado_id" name="txt_actividad_asignado_id" readonly="">
                                                    <input type="text" class="form-control" id="txt_actividad_asignado" name="txt_actividad_asignado" disabled="">
                                                </div>
                                                <div class="col-md-1 form-group">
                                                <label>-</label>
                                                <span class="btn btn-primary" data-toggle="modal" data-target="#actiasignadaModal"  id="btn_buscar" onclick="MostrarActividad(this)">
                                                            <i class="fa fa-search fa-lg"></i>
                                                </span>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                <label>-</label>
                                                <span class="btn btn-danger" onclick="BorrarAsignado(this)" id="btn_borrar">
                                                            <i class="fa fa-eraser fa-lg"></i>
                                                </span>
                                                </div>

                                            </div>
                                            <div class="col-md-5 form-group">
                                                <div class="col-md-8 form-group">
                                                <label>Documentos:</label>
                                                <form name="form_ddocumento" id="form_ddocumento" enctype="”multipart/form-data”">
                                                    <table id="t_ddocumento" class="table table-bordered">
                                                        <thead class="bg-teal disabled color-palette">
                                                            <tr>
                                                                <th>N°</th>
                                                                <th>Documento</th>
                                                                <th><span class="btn btn-default btn-xs" data-toggle="modal" data-target="#docdigitalModal"  data-form="this" onClick='MostrarDocumentos(this);' id="btn_list_digital" data-texto="txt_codigo"    data-id="txt_doc_digital_id"><i class="glyphicon glyphicon-file"></i></span></th> 
                                                            </tr> 
                                                        </thead> 
                                                        <tbody id="tb_ddocumento"> 
                                                            <tr style="display: none">
                                                                <td><input type="hidden" value="0"></td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                <label>Cantidad:</label>
                                                <input type="text" class="form-control mant" id="txt_cantidad" name="txt_cantidad" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group validoarchivo">
                                                <label>Archivos:</label>
                                                <form name="form_darchivo" id="form_darchivo" enctype="”multipart/form-data”">
                                                    <table id="t_darchivo" class="table table-bordered">
                                                        <thead class="bg-aqua disabled color-palette">
                                                            <tr>
                                                                <th>Archivo</th>
                                                                <th>
                                                                    <a class="btn btn-default btn-xs" onclick="AgregarD(this)"><i class="fa fa-plus fa-lg"></i></a>
                                                                </th> 
                                                            </tr> 
                                                        </thead> 
                                                        <tbody id="tb_darchivo"> 
                                                            <tr style="display: none">
                                                                <td><input type="hidden" value="0"></td>
                                                                <td><input type="hidden" value="0"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="col-md-1 col-sm-12 col-xs-12 form-group visible-sm visible-xs">
                                                <span id="btnDelete" name="btnDelete" class="btn btn-danger  btn-sm btnDelete" style="width: 100%">Eliminar</span>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <button id="btnAdd" class="btn btn-yellow" style="width: 100%;margin-top:10px" type="button"><span class="glyphicon glyphicon-plus"></span> AGREGAR </button>
                            </div>
                        
                        <div class="col-md-12">
                            <br><br><br>
                        </div>            

                    <div class="col-md-12">
                        <div class="box-header table-responsive">
                            <center><h3><b>Mis actividades registradas el día de hoy: <?php echo date('Y-m-d') ?> </b></h3></center>
                        </div>
                        <div class="box-body table-responsive">
                             <form id="form_produccion" name="form_produccion" method="post">
                            <table id="t_produccion" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th> 
                                        <th>Actividad</th>
                                        <th>Fecha Inicio</th>
                                        <th>Hora Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Hora Fin</th>
                                        <th>Tiempo Transcurrido</th>
                                        <th>[]</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_produccion">
                                </tbody>
                            </table>
                             </form>
                        </div>
                    </div>

              
                    
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
    @include( 'admin.produccion.form.confirmacion' )
    @include( 'admin.mantenimiento.form.docdigitalcompleto' )
    @include( 'admin.produccion.form.actividadesasignadas' )
@stop
