<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::style('lib/datetime/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    {{ HTML::script('lib/datetime/js/bootstrap-datetimepicker.min.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.ruta.js.cartainicio_ajax' )
    @include( 'admin.ruta.js.cartainicio' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Crear Carta de Inicio
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Ruta</a></li>
        <li class="active">Carta de Inicio</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- Inicia contenido -->
            <div class="box">
                <form name="form_asignar" id="form_asignar" method="POST" action="">
                    <div class="row form-group" id="tabla_relacion">
                        <div class="col-sm-12">
                            <div class="box-body table-responsive">
                                <table id="t_carta" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Carta</th>
                                            <th>Objetivo</th>
                                            <th>Entregable</th>
                                            <th> [ ] </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_carta">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Carta</th>
                                            <th>Objetivo</th>
                                            <th>Entregable</th>
                                            <th> [ ] </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <a class="btn btn-primary btn-sm" id="btn_nuevo">
                                <i class="fa fa-save fa-lg"></i>&nbsp;Nuevo
                            </a>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="row form-group" id="cartainicio" style="display:none">
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label class="control-label title">Carta N° : <input id="txt_nro_carta" name="txt_nro_carta" type="text"></label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-10">
                                <label class="control-label">Objetivo del Proyecto:</label>
                                <textarea class="form-control" id="txt_objetivo" name="txt_objetivo"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-10">
                                <label class="control-label">Entregables del Proyecto:</label>
                                <textarea class="form-control" id="txt_entregable" name="txt_entregable"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-10">
                                <label class="control-label">Alcance del Proyecto:</label>
                                <textarea class="form-control" id="txt_alcance" name="txt_alcance"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <label class="control-label">Recursos (No humanos):</label>
                                <a class="btn btn-success btn-sm">
                                    <i class="fa fa-plus fa-lg"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row form-group" id="tabla_recursos">
                            <div class="col-sm-12">
                                <div class="box-body table-responsive">
                                    <table id="t_recursos" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Descripción</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#asignarModal">
                                    <i class="fa fa-save fa-lg"></i>&nbsp;Nuevo
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <label class="control-label">Métricos:</label>
                                <a class="btn btn-success btn-sm">
                                    <i class="fa fa-plus fa-lg"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row form-group" id="tabla_metricos">
                            <div class="col-sm-12">
                                <div class="box-body table-responsive">
                                    <table id="t_metricos" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Métrico</th>
                                                <th>Actual</th>
                                                <th>Objetivo</th>
                                                <th>Comentario</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#asignarModal">
                                    <i class="fa fa-save fa-lg"></i>&nbsp;Nuevo
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <label class="control-label">Desglose de Carta de Inicio N°:</label>
                                <a class="btn btn-success btn-sm">
                                    <i class="fa fa-plus fa-lg"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row form-group" id="tabla_metricos">
                            <div class="col-sm-12">
                                <div class="box-body table-responsive">
                                    <table id="t_metricos" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Actividad</th>
                                                <th>Responsable</th>
                                                <th>Area</th>
                                                <th>Recursos</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin</th>
                                                <th>Hora Inicio</th>
                                                <th>Hora Fin</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#asignarModal">
                                    <i class="fa fa-save fa-lg"></i>&nbsp;Nuevo
                                </a>
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