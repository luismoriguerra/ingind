<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::script('lib/ckeditor/ckeditor.js') }}
    {{ HTML::style('css/admin/plantilla.css') }}
    {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.0/locale/es.js') }}
    {{ HTML::style('/lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('/lib/daterangepicker/js/daterangepicker_single.js') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.mantenimiento.js.documentoword_ajax' )
    @include( 'admin.mantenimiento.js.documentoword' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mantenimiento de Documento
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Documentos</li>
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
                        <div class="box-body table-responsive">
                            <table id="t_plantilla" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Asunto</th>
                                        <th>Fecha</th>
                                        <th> [ ] </th>
                                    </tr>
                                </thead>
                                <tbody id="tb_plantilla">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Asunto</th>
                                        <th>Fecha</th>
                                        <th> [ ] </th>
                                    </tr>
                                </tfoot>
                            </table>

                            <a class='btn btn-primary btn-sm' class="btn btn-primary"
                            data-toggle="modal" data-target="#documentoModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.mantenimiento.form.documentoword' )
@stop