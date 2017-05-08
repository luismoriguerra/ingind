<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::style('lib/datetime/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    {{ HTML::script('lib/datetime/js/bootstrap-datetimepicker.min.js') }}
    <script src="lib/jquery-ui-1.11.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="lib/jquery-ui-1.11.2/jquery-ui.min.css">

  {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
  
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.ruta.js.asignar_ajax' )
    @include( 'admin.ruta.js.asignar' )
    @include( 'admin.ruta.js.plataforma' )
    
    @include( 'admin.ruta.js.indedocs' )
    @include( 'admin.ruta.js.indedocs_ajax' )
    
    @include( 'admin.ruta.js.proceso' )
    @include( 'admin.ruta.js.referente' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Asignar Trámite al Proceso
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Ruta</a></li>
                        <li class="active">Asignar</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Inicia contenido -->
                            <div class="box">
                                <div id="tabs">
                                    <ul>
                                        <li><a href="#tabs-1">Asignación Proceso</a></li>
                                        <li><a href="#tabs-2">Asignación Gestión</a></li> 
                                    </ul>
                                    <div id="tabs-1">
                                        <form name="form_asignar" id="form_asignar" method="POST" action="">
                                            <div class="row form-group" >
                                                <div class="col-sm-12">
                                                    <div class="col-sm-3">
                                                        <label class="control-label">Fecha Inicio de la Gestión:</label>
                                                        <input type="text" class="form-control" name="txt_fecha_inicio" id="txt_fecha_inicio" readOnly>
                                                    </div>
                                                     <div class="col-sm-8">
                                                        <label class="control-label">Proceso:</label>
                                                        <input type="hidden" id="txt_flujo2_id" name="txt_flujo2_id">
                                                         <input type="hidden" id="txt_area2_id" name="txt_area2_id">
                                                        <input class="form-control" id="txt_proceso" name="txt_proceso" type="text"  value="" readonly="">
                                                        
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <br>
                                                        <span class="btn btn-primary" data-toggle="modal" data-target="#procesoModal" data-texto="txt_proceso" data-id="txt_flujo2_id" data-idarea="txt_area2_id" data-evento="cargarRutaFlujo" id="btn_buscar">
                                                            <i class="fa fa-search fa-lg"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="col-sm-4">
                                                        <label class="control-label">Nro Trámite:</label>
                                                        <input class="form-control" id="txt_codigo" name="txt_codigo" type="text"  readonly="">
                                                        <input id="txt_documento_id" name="txt_documento_id" type="hidden"  value="">
                                                    </div>
                                                    <div class="col-sm-2">
                                                         <br>
                                                        <span class="btn btn-primary" data-toggle="modal" data-target="#indedocsModal" data-texto="txt_codigo" data-id="txt_documento_id" id="btn_buscar_indedocs">
                                                            <i class="fa fa-search fa-lg"></i>
                                                        </span>
                                                        <span class="btn btn-warning" data-toggle="modal" onclick="Liberar('txt_codigo','txt_documento_id')" id="btn_borrar">
                                                            <i class="fa fa-pencil fa-lg"></i>
                                                        </span>
                                                    </div>
                                                  
                                                  
                                                    <div class="col-sm-4">
                                                        <input type="hidden" name="txt_referido_id" id="txt_referido_id">
                                                        <input type="hidden" name="txt_ruta_id" id="txt_ruta_id">
                                                        <input type="hidden" name="txt_rutadetalle_id" id="txt_rutadetalle_id">
                                                        <input type="hidden" name="txt_tablarelacion_id" id="txt_tablarelacion_id">
                                                        <label class="control-label"> Referente:</label>
                                                        <input class="form-control" id="txt_referente" name="txt_referente" type="text" placeholder="Ing. Trámite Ref." readonly="">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <br>
                                                        <span class="btn btn-primary" data-toggle="modal" data-target="#referenteModal" data-texto="txt_referente" data-idreferido="txt_referido_id" data-idruta="txt_ruta_id" data-idtablarelacion="txt_tablarelacion_id" data-idrutadetalle="txt_rutadetalle_id" id="btn_buscar_referente">
                                                            <i class="fa fa-search fa-lg"></i>
                                                        </span>

                                                        <span class="btn btn-danger" data-toggle="modal" onclick="BorrarReferido()" id="btn_borrar">
                                                            <i class="fa fa-eraser fa-lg"></i>
                                                        </span>
                                                    </div>
                                                  
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="col-sm-3">
                                                        <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#plataformaModal" id="btn_verificar">
                                                            <i class="fa fa-search fa-lg"></i>&nbsp;Verificar Trámites Pendientes de Plataforma
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                      <div class="col-sm-6">
                                                        <input class='form-control mant' type="hidden" name="slct_tipo_persona" id="slct_tipo_persona" value="3">
                                                        <input class='form-control mant' type="hidden" name="slct_area_p_id" id="slct_area_p_id" value="<?php echo Auth::user()->area_id; ?>">
                                                        <label class="control-label"> Area Interna:</label>
                                                        <input class='form-control' id='nombre_area_usuario' name='nombre_area_usuario' value='<?php echo Auth::user()->areas->nombre; ?>' readOnly=''>
                          
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="control-label"> Ingresar Sumilla:</label>
                                                        <textarea class="form-control" id="txt_sumilla" name="txt_sumilla"></textarea>
                                                    </div>
                                                   
                                                </div>
                                               
                                            </div>

                                            
                                            <div class="row form-group" id="tabla_relacion" style="display:none;">
                                                <div class="col-sm-12">
                                                    <div class="box-body table-responsive">
                                                        <table id="t_tablarelacion" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Software</th>
                                                                    <th>Código</th>
                                                                    <th> [ ] </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tb_tablarelacion">
                                                                
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Software</th>
                                                                    <th>Código</th>
                                                                    <th> [ ] </th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <a class="btn btn-primary btn-sm" onclick="CerrarTablaRelacion();" id="btn_cerrar_tabla_relacion">
                                                        <i class="fa fa-remove fa-lg"></i>&nbsp;Cerrar
                                                    </a>
                                                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#asignarModal">
                                                        <i class="fa fa-save fa-lg"></i>&nbsp;Nuevo
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row form-group" id="tabla_ruta_flujo" style="display:none;">
                                                <div class="col-sm-12">
                                                    <div class="box-body table-responsive">
                                                        <table id="t_ruta_flujo" class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Proceso</th>
                                                                    <th>Area</th>
                                                                    <th>Dueño del Proceso</th>
                                                                    <th>Nro Trámite Ok</th>
                                                                    <th>Nro Trámite Error</th>
                                                                    <th>Fecha Creación</th>
                                                                    <th> [ ] </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tb_ruta_flujo">
                                                                
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Proceso</th>
                                                                    <th>Area</th>
                                                                    <th>Dueño del Proceso</th>
                                                                    <th>Nro Trámite Ok</th>
                                                                    <th>Nro Trámite Error</th>
                                                                    <th>Fecha Creación</th>
                                                                    <th> [ ] </th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <a class="btn btn-primary btn-sm" id="btn_guardar_todo">
                                                        <i class="fa fa-save fa-lg"></i>&nbsp;Guardar
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="tabs-2" >
                                        <form name="form_asignarGestion" id="form_asignarGestion" method="POST" action="">
                                            <div class="row form-group" >
                                                <div class="col-sm-12 form-group">
                                                    <div class="col-sm-6">
                                                        <label class="control-label">Fecha Inicio de la Gestión:</label>
                                                        <input type="text" class="form-control" name="txt_fecha_inicio2" id="txt_fecha_inicio2" readonly="">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input class='form-control mant' type="hidden" name="slct_tipo_persona2" id="slct_tipo_persona2" value="3">
                                                                <label class="control-label"> Area Interna:</label>
                                                                <input class='form-control mant' type='hidden' id="slct_area_p_id2" name="slct_area_p_id2" value='<?php echo Auth::user()->area_id; ?>'>
                                                                <input class='form-control' id='nombre_area_usuario2' name='nombre_area_usuario2' value='<?php echo Auth::user()->areas->nombre; ?>' readOnly=''>

                                                    </div>
<!--                                                        <div class="col-sm-3 juridica" style="display:none">
                                                            <label class="control-label"> RUC:</label>
                                                            <input class="form-control" type="text" id="placeholder" name="txt_ruc2" placeholder='RUC'>
                                                        </div>
                                                        <div class="col-sm-3 juridica org" style="display:none">
                                                            <label class="control-label"> Razon social:</label>
                                                            <input class="form-control" type="text" id="txt_razon_social2" name="txt_razon_social2" placeholder='Razon Social'>
                                                        </div>

                                                        <div class="col-sm-12 natural" style="display:none">
                                                            <div class="col-sm-3">
                                                                <label class="control-label"> Paterno:</label>
                                                                <input class="form-control" type="text" id="txt_paterno2" name="txt_paterno2" placeholder='Paterno'>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label class="control-label"> Materno:</label>
                                                                <input class="form-control" type="text" id="txt_materno2" name="txt_materno2" placeholder='Materno'>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label class="control-label"> Nombre:</label>
                                                                <input class="form-control" type="text" id="txt_nombre2" name="txt_nombre2" placeholder='Nombre'>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 area" style="display:none">
                                                            <div class="col-sm-3">
                                                                <label class="control-label"> Area Interna:</label>
                                                                <select class="form-control" type="text" id="slct_area_p_id2" name="slct_area_p_id2">
                                                                <option value="">.:Seleccione:.</option>
                                                                </select>
                                                            </div>
                                                        </div>-->
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <div class="col-sm-4">
                                                        <label class="control-label">Nro Trámite:</label>
                                                        <input class="form-control" id="txt_codigo2" name="txt_codigo2" type="text"  readonly="">
                                                        <input id="txt_documento_id2" name="txt_documento_id2" type="hidden"  value="">
                                                        
                                                    </div>
                                                     <div class="col-sm-2">
                                                         <br>
                                                        <span class="btn btn-primary" data-toggle="modal" data-target="#indedocsModal" data-texto="txt_codigo2" data-id="txt_documento_id2" id="btn_buscar_indedocs">
                                                            <i class="fa fa-search fa-lg"></i>
                                                        </span>
                                                        <span class="btn btn-warning" data-toggle="modal" onclick="Liberar('txt_codigo2','txt_documento_id2')" id="btn_borrar">
                                                            <i class="fa fa-pencil fa-lg"></i>
                                                        </span>
                                                    </div>
                                                  
                                                  
                                                    <div class="col-sm-4">
                                                        <input type="hidden" name="txt_referido_id2" id="txt_referido_id2">
                                                        <input type="hidden" name="txt_ruta_id2" id="txt_ruta_id2">
                                                        <input type="hidden" name="txt_rutadetalle_id2" id="txt_rutadetalle_id2">
                                                        <input type="hidden" name="txt_tablarelacion_id2" id="txt_tablarelacion_id2">
                                                        <label class="control-label"> Referente:</label>
                                                        <input class="form-control" id="txt_referente2" name="txt_referente2" type="text" placeholder="Ing. Trámite Ref." readonly="">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <br>
                                                        <span class="btn btn-primary" data-toggle="modal" data-target="#referenteModal" data-texto="txt_referente2" data-idreferido="txt_referido_id2" data-idruta="txt_ruta_id2" data-idtablarelacion="txt_tablarelacion_id2" data-idrutadetalle="txt_rutadetalle_id2" id="btn_buscar_referente">
                                                            <i class="fa fa-search fa-lg"></i>
                                                        </span>

                                                        <span class="btn btn-danger" data-toggle="modal" onclick="BorrarReferido()" id="btn_borrar">
                                                            <i class="fa fa-eraser fa-lg"></i>
                                                        </span>
                                                    </div>
                                                  
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <div class="col-sm-6">
                                                        <label class="control-label"> Ingresar Sumilla:</label>
                                                        <textarea class="form-control" id="txt_sumilla2" name="txt_sumilla2"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <div class="col-sm-3">
                                                        <label class="control-label"> Nº de Areas:</label>
                                                        <input class="form-control" type="text" id="txt_numareas" name="txt_numareas" placeholder='Numero Areas' onkeyup="cargarTabla()" maxlength="2" onkeypress="return validaNumeros(event);">
                                                        <div class="radio">
                                                            <label style="margin-left:-12px">
                                                                <input class="chk form-control" type="checkbox" name="chk_todasareas" id="chk_todasareas" value="tareas"> Todas Las Areas                                                                
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="Allareas hidden">
                                                            <select id="areasTodas" name="areasTodas" multiple></select>                                                           
                                                        </div>
                                                        <label class="control-label"> Nº de Días:</label>
                                                        <input class="form-control mant" type="text" id="txt_tiempo" name="txt_tiempo" placeholder='Cantidad Dias' value="1" disabled onkeyup="cargarTiempo(this)" onkeypress="return validaNumeros(event);" maxlength="2">                                                                                                             <div class="radio">
                                                            <label>
                                                                <input class="chk form-control" type="checkbox" name="chk_etiempo" id="chk_etiempo" value="etiempo"> Edit Tiempo                                                                
                                                            </label>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="col-sm-6">
                                                        <label class="control-label">Tipo Envio:</label>
                                                        <select class="form-control" id="select_tipoenvio" name="select_tipoenvio">
                                                            <option value="">.:Seleccione:.</option>
                                                            <option value="1">Con Retorno</option>
                                                            <option value="2">Sin Retorno</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 tablaSelecAreaTiempo hidden">
                                                    <div>
                                                        <table id="t_numareas" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 50%">Area</th>
                                                                    <th style="width: 50%">Tiempo(Dias)</th>
                                                                    <th style="width: 50%"><a data-toggle="popover" data-placement="top" data-content="Seleccione Areas de Copia"><span class="btn btn-warning btn-sm"><i class="fa fa-exclamation"></i></span></a></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tb_numareas">
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                                    <a class="btn btn-primary btn-sm" id="btn_guardar_todo2">
                                                                <i class="fa fa-save fa-lg"></i>&nbsp;Guardar
                                                    </a>
                                            </div>


                                            
                                        </form>
                                    </div>
                                </div>

                                

                                <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="">
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <h1><span id="txt_titulo">Nueva Ruta</span>
                                            <small>
                                                <i class="fa fa-angle-double-right fa-lg"></i>
                                                <span id="texto_fecha_creacion">Fecha Creación:</span>
                                                <span id="fecha_creacion"></span>
                                            </small>
                                            </h1>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-4">
                                                <label class="control-label">Dueño del Proceso:</label>
                                                <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Proceso:</label>
                                                <input class="form-control" type="text" id="txt_proceso_1" name="txt_proceso_1" readonly>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Area del Dueño del Proceso:</label>
                                                <input class="form-control" type="text" id="txt_area" name="txt_area" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <div class="box-body table-responsive">
                                                <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                                                    <thead> 
                                                        <tr class="head">
                                                            <th style="width:250px !important;min-width: 200px !important;" >
                                                            </th>
                                                            <th class="eliminadetalleg" style="min-width:1000px !important;">[]</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="body">
                                                            <td>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr><th colspan="2">
                                                                        </th></tr>
                                                                        <tr class="head">
                                                                            <th>#</th>
                                                                            <th>Area</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tb_rutaflujodetalleAreas">
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="head">
                                                            <th>#</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                                                <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.box -->
                            <!-- Finaliza contenido -->
                        </div>
                    </div>

                </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.ruta.form.asignar' )
     @include( 'admin.ruta.form.ruta' )
     @include( 'admin.ruta.form.plataforma' )
     @include( 'admin.ruta.form.indedocs' )
     @include( 'admin.ruta.form.proceso' )
     @include( 'admin.ruta.form.referente' )
@stop
