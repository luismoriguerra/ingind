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

    @include( 'admin.contratacion.js.contrataciondoc_ajax' )
    @include( 'admin.contratacion.js.contrataciondoc' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mantenimiento de Contrataciones
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Contrataciones</li>
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
                        <form id="form_contrataciones" name="form_contrataciones" method="POST" action="">
                            <input type="hidden" name="area_usuario" value="1">
                        <div class="box-body table-responsive">
                            <table id="t_contrataciones" class="table table-bordered table-hover">
                                <thead>
                                <tr><th colspan="14" style="text-align:center;background-color:#A7C0DC;"><h2>Contrataciones</h2></th></tr>
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                            <a style="display:none" class="btn btn-primary"
                            data-toggle="modal" data-target="#contratacionModal" data-titulo="Nueva"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#contratacionModal" data-titulo="Editar"></a>
                        </div><!-- /.box-body -->
                        </form>
                        <br>
                       <form id="form_detalle_contrataciones" name="form_detalle_contrataciones" method="POST" action="">
                           <div class="form-group" style="display: none">
                               <div class="box-header table-responsive"><center><h2 type="text" id="txt_titulo"></h2></center></div>
                        <div class="box-body table-responsive">
                            <table id="t_detalle_contrataciones" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Texto</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Fecha Aviso</th>
                                        <th>Monto</th>
                                        <th>Tipo</th>
                                        <th>Programación Aviso</th>
                                        <th>Fecha Conformidad</th>
                                        <th>Nro Doc</th>
                                        <th>[]</th>


                                    </tr>
<!--                                    <tr><th colspan="12" style="text-align:center;background-color:#A7C0DC;"><h2><spam id="txt_titulo">Contrataciones</spam></h2></th></tr>-->
                       
                                </thead>
                                <tbody id="tb_detalle_contrataciones">
                                </tbody>
                          
                            </table>
                            <a style="display:none" class="btn btn-primary"
                            data-toggle="modal" data-target="#contrataciondetalleModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#contrataciondetalleModal" data-titulo="Editar"></a>
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
     @include( 'admin.contratacion.form.contrataciondoc' )
     @include( 'admin.contratacion.form.detalle_contratacion_doc' )
@stop
