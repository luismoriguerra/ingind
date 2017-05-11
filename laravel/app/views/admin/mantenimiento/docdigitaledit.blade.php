<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::script('lib/ckeditor/ckeditor.js') }}
    {{ HTML::style('css/admin/plantilla.css') }}
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.mantenimiento.js.docdigital_ajax' )
    @include( 'admin.mantenimiento.js.docdigitaledit' )


@stop
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Editar Título de Documento
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mis Documentos Digitales</li>
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
                        <form id="form_docdigitales" name="form_docdigitales" method="POST" action="">
                            <input type="hidden" id="tipo" name="tipo" value="1">
                        <div class="box-body table-responsive">
                            <table id="t_docdigitales" class="table table-bordered table-striped">
                                <thead>
                                <tr><th colspan="9" style="text-align:center;background-color:#A7C0DC;"><h2>Documentos Digitales</h2></th></tr>
                                    <tr>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                   
                                </tfoot>
                            </table>
<!--                            <a class='btn btn-primary btn-sm' class="btn btn-primary" 
                            data-toggle="modal" data-target="#areaModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#areaModal" data-titulo="Editar"></a>-->
                        </div><!-- /.box-body -->
                         </form>
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.mantenimiento.form.editartitulodoc' )
<!--     @include( 'admin.mantenimiento.form.editarfechadoc' )-->
@stop
