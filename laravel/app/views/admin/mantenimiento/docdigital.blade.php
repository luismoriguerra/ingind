<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::script('lib/ckeditor/ckeditor.js') }}
    {{ HTML::style('css/admin/plantilla.css') }}
    {{ HTML::style('http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css') }}
    {{ HTML::script('http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.mantenimiento.js.docdigital_ajax' )
    @include( 'admin.mantenimiento.js.docdigital' )

@stop
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Generar Documentos
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
                        <div class="box-body table-responsive">
                            <table id="t_doc_digital" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Titulo</th>
                                        <th style="width: 30%">Asunto</th>
                                        <th style="width: 30%">Plantilla</th>
                                       {{--  <th style="width: 19%">Area Recepcion</th>
                                        <th style="width: 19">Persona Recepcion</th> --}}
                                        <th style="width: 5%">Editar</th>
                                        <th style="width: 5%">Vista Previa</th>
                                         <th style="width: 5%">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_doc_digital">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width: 30%">Titulo</th>
                                        <th style="width: 30%">Asunto</th>
                                        <th style="width: 30%">Plantilla</th>
                        {{--                 <th style="width: 19%">Area Recepcion</th>
                                        <th style="width: 19">Persona Recepcion</th> --}}
                                         <th style="width: 5%">Editar</th>
                                        <th style="width: 5%">Vista Previa</th>
                                        <th style="width: 5%">Eliminar</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <a class='btn btn-success btn-sm' class="btn btn-primary"
                            data-toggle="modal" data-target="#NuevoDocDigital" data-titulo="Nuevo" onclick="Plantillas.CargarAreas(HTMLAreas);"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.mantenimiento.form.docdigital' )
@stop
