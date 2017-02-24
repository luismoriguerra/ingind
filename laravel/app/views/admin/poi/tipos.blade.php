<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}

    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}

    {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}

    
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.poi.js.tipos_ajax' )
    @include( 'admin.poi.js.tipos' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mantenimiento de Tipos
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Tipos</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Filtros</h3>
                        </div><!-- /.box-header -->
                        <form id="form_tipos" name="form_tipos" method="POST" action="">
                        <div class="box-body table-responsive">
                            <table id="t_tipos" class="table table-bordered table-hover">
                                <thead>
                                <tr><th colspan="2" style="text-align:center;background-color:#A7C0DC;"><h2>Tipos</h2></th></tr>
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                            <a class="btn btn-primary"
                            data-toggle="modal" data-target="#tipoModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#tipoModal" data-titulo="Editar"></a>
                        </div><!-- /.box-body -->
                        </form>
                        <br>
                        <form id="form_subtipo" name="form_subtipo" method="POST" action="">
                    <div class="form-group" style="display: none">
                        <div class="box-header table-responsive">
                            <div class="col-xs-12">
                                <h3>
                                    Mantenimiento de Sub Tipo |
                                    <small>Tipo:  <label type="text" id="txt_titulo"></label></small>
                                </h3>                           
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="t_subtipo" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre</th>
                                        <th>Costo Actual</th>
                                        <th>Tamaño</th>
                                        <th>Color</th>
                                        <th>[]</th>
                                        <th>[]</th>
                                    </tr>
<!--                                    <tr><th colspan="12" style="text-align:center;background-color:#A7C0DC;"><h2><spam id="txt_titulo">Contrataciones</spam></h2></th></tr>-->

                                </thead>
                                <tbody id="tb_subtipo">
                                </tbody>

                            </table>
                            <a class="btn btn-primary"
                               data-toggle="modal" data-target="#subtipoModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#subtipoModal" data-titulo="Editar"></a>
                            <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                                <i class="fa fa-remove fa-lg"></i>&nbsp;Cerrar
                            </a>

                        </div><!-- /.box-body -->
                    </div>
                </form>
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.poi.form.tipo' )
     @include( 'admin.poi.form.subtipo' )
@stop
