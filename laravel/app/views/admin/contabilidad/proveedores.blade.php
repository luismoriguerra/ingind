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

    @include( 'admin.contabilidad.js.proveedores_ajax' )
    @include( 'admin.contabilidad.js.proveedores' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<style type="text/css">
    .columntext{
        width: 100px !important;
    }
</style>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mantenimiento de Proveedores
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Proveedores</li>
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
                        <form id="form_proveedores" name="form_proveedores" method="POST" action="">
                        <div class="box-body table-responsive">
                            <table id="t_proveedores" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <!-- <th colspan="3" style="text-align:center;background-color:#A7C0DC;"><h2>Proveedores</h2></th> -->
                                </tr>
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                            <a class="btn btn-primary"
                            data-toggle="modal" data-target="#proveedorModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#proveedorModal" data-titulo="Editar"></a>
                        </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->


        <!-- Proceso de Gastos! -->
        <section id="mante_gastos" class="content" style="display: none; margin-top: -30px;">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Filtro por Proveedor:</h3>
                        </div><!-- /.box-header -->
                        <form id="form_<?=name_frmG?>" name="form_<?=name_frmG?>" method="POST" action="">
                        <input type="hidden" value="" name="id_proveedor" id="id_proveedor"> 
                        <div class="box-body table-responsive">
                            <table id="t_<?=name_frmG?>" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <!-- 
                                        <th colspan="4" style="text-align:center;background-color:#A7C0DC;"><h2>Gastos</h2></th>
                                    -->
                                    </tr>
                                    <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr></tr>
                                </tfoot>
                            </table>
                        <!-- 
                            <a class="btn btn-primary"
                            data-toggle="modal" data-target="#<?=name_controllerG?>Modal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                        -->
                            <a style="display:none" id="BtnEditar2" data-toggle="modal" data-target="#<?=name_controllerG?>Modal" data-titulo="Editar"></a>
                        </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>
        </section><!-- /.content -->
@stop

@section('formulario')

    @include( 'admin.contabilidad.form.proveedor' )

    @include( 'admin.contabilidad.form.gastos' )
@stop

