<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    {{ HTML::script('lib/input-mask/js/jquery.inputmask.js') }}
    {{ HTML::script('lib/input-mask/js/jquery.inputmask.date.extensions.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.ruta.js.crear' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Crear Ruta
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Ruta</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Inicia contenido -->
                            <div class="box">                                
                                <div class="box-body table-responsive">
                                    <table id="t_rutaflujo" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo Flujo</th>
                                                <th>Area</th>
                                                <th>Creador</th>
                                                <th># Ok</th>
                                                <th># Error</th>
                                                <th>Depende</th>
                                                <th>Fecha Creación</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tb_rutaflujo">
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo Flujo</th>
                                                <th>Area</th>
                                                <th>Creador</th>
                                                <th># Ok</th>
                                                <th># Error</th>
                                                <th>Depende</th>
                                                <th>Fecha Creación</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <a class='btn btn-primary btn-sm' id="btn_nuevo">
                                        <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo
                                    </a>
                                </div><!-- /.box-body -->
                                <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="">
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <h1><span id="txt_titulo">Nueva Ruta</span>
                                            <small>
                                                <i class="fa fa-angle-double-right fa-lg"></i>
                                                Fecha Creación:
                                                <span id="fecha_creacion"></span>
                                            </small>
                                            </h1>
                                            <small>
                                                <a class="btn btn-primary btn-sm">
                                                    <i class="fa fa-plus-square fa-lg"></i>
                                                </a>
                                            </small>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-2">
                                                <label class="control-label">Tipo Flujo:</label>
                                                <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Area:</label>
                                                <select class="form-control" name="slct_area_id" id="slct_area_id">
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Creador:</label>
                                                <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                                            </div>                                            
                                            <div class="col-sm-2">
                                                <label class="control-label"># Ok:</label>
                                                <input class="form-control" type="text" id="txt_ok" name="txt_ok" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label"># Error:</label>
                                                <input class="form-control" type="text" id="txt_error" name="txt_error" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <a class="btn btn-default btn-sm" id="btn_close">
                                                <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                                            </a>
                                            <a class="btn btn-primary btn-sm" id="btn_guardar">
                                                <i class="fa fa-save fa-lg"></i>&nbsp;Guardar
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="head">
                                                            <th>#</th>
                                                            <th>Listado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_rutaflujodetalle">
                                                        <tr class="body">
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="head">
                                                            <th>#</th>
                                                            <th>Listado</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.box -->
                            <!-- Finaliza contenido -->
                        </div>
                    </div>

                </section><!-- /.content -->
@stop
