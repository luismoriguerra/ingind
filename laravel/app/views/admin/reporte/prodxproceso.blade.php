<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    <script src="lib/jquery-ui-1.11.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="lib/jquery-ui-1.11.2/jquery-ui.min.css">

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.reporte.js.prodxproceso_ajax' )
    @include( 'admin.reporte.js.prodxproceso' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Produccion por proceso
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Cant. Documentos Generados por área</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Reporte Detalle</a></li>
                <li><a href="#tabs-2">Reporte Consolidado</a></li> 
            </ul>
            <div id="tabs-1">
                <div class="box">
                    <fieldset>
                        <div class="row form-group" >
                            <div class="col-sm-12">
                                <div class="col-md-4 col-sm-4">
                                    <label class="control-label">Area:</label>
                                    <select class="form-control" name="slct_area_id" id="slct_area_id" multiple>
                                    </select>
                                </div>
                                  <div class="col-md-4 col-sm-4">
                                    <label class="control-label">Cargo:</label>
                                    <select class="form-control" name="slct_cargo" id="slct_cargo">
                                        <option value="">Todo</option>
                                        <option value="1">Dueño de Proceso</option>
                                        <option value="2">Involucrado</option>
                                    </select>
                                </div>
                         {{--        <div class="col-md-4 col-sm-4">
                                    <label class="control-label">Rango de Fechas:</label>
                                    <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                                </div> --}}
                                <div class="col-md-1 col-sm-2" style="padding:24px">
                                    <span class="btn btn-primary btn-md" id="generar" name="generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                                    {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                                </div>
                                <div class="col-md-1 col-sm-2" style="padding:24px">
                                    {{-- <span class="btn btn-success btn-md" id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt"></i> Export</span> --}}
                                    <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                    {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div><!-- /.box -->
                <div class="box">
                            <form id="form_documentos" name="form_documentos" method="POST" action="">
                            <div class="box-body table-responsive">
                                <table id="t_documentos" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td colspan="4" style="text-align: center">PROCESO-AREA</td>
                                        <td colspan="3" style="text-align: center">ACTIVIDAD</td>
                                        <td colspan="5" style="text-align: center">DATOS ADICIONALES</td>
                                    </tr>
                                    <tr>
                                        <th style="">AREA</th>
                                        <th style="">PROCESO</th>
                                        <th style="">TIEMPO TOTAL</th>
                                        <th style="">NRO ASIGNACIONES</th>
                                        <th style="">Nº</th>
                                        <th style="">TIEMPO</th>
                                        <th style="">AREA</th>
                                        <th style="">Nº ACCIONES</th>
                                        <th style="">% TIEMPO TOTAL</th>
                                        <th style="">% TIEMPO ACTIVIDAD</th>
                                        <th style="">ULT.USUARIO ACTUALIZO</th>
                                        <th style="">ULT.FECHA ACTUALIZO</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr></tr>
                                    </tfoot>
                                </table>
                              {{--   <a class="btn btn-primary"
                                data-toggle="modal" data-target="#documentoModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                                <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#documentoModal" data-titulo="Editar"></a> --}}
                            </div><!-- /.box-body -->
                            </form>
                        </div><!-- /.box -->
                </div>
                <div id="tabs-2">
                    <form id="form_crear" name="form_crear" method="POST" action="">
                    <input type="hidden" name="estado" value="1">
                        <select style="display:none" class="form-control" name="slct_estados" id="slct_estados">
                            <option value>.::TODOS::.</option>
                            <option value="1">Producción</option>
                            <option value="2">Pendiente</option>
                        </select>
                        <input type="hidden" id="tipo_flujo" name="tipo_flujo" value="1">
                        <div class="box-body table-responsive">
                            <table id="t_crear" class="table table-bordered table-hover">


                               <thead>

                                    <tr>

                                    <th colspan="5" style="text-align:center;background-color:#A7C0DC;"><h2>Ruta del Proceso - Trámite</h2></th>

                                    </tr>
                                    <tr></tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr></tr>
                                    </tfoot>
                                </table>
                        </div><!-- /.box-body -->
                    </form>
                </div>

            </div><!--fin tab 2 -->
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
