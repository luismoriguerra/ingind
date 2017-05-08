<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::script('lib/ckeditor/ckeditor.js') }}
    {{ HTML::style('css/admin/plantilla.css') }}
    {{ HTML::script('lib/jquery-bootstrap-validator/bootstrapValidator.min.css') }}
    {{ HTML::script('lib/jquery-bootstrap-validator/bootstrapValidator.min.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.mantenimiento.js.plantilladocumento_ajax' )
    @include( 'admin.mantenimiento.js.plantilladocumento' )

@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Plantillas para Documentos
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Plantillas para Documentos</li>
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
                                        <th style="width: 25%">Nombre</th>
                                        <th style="width: 25%">Tipo Documento</th>
                                        <th style="width: 25%">Area</th>
                                        <th style="width: 10%">Estado</th>
                                        <th style="width: 10%">Edit</th>
                                        <th style="width: 10%">Vista Previa</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_plantilla">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo Documento</th>
                                        <th>Area</th>
                                        <th>Estado</th>
                                        <th>Edit</th>
                                        <th>Vista Previa</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <a class='btn btn-primary btn-sm' class="btn btn-primary"
                            data-toggle="modal" data-target="#plantillaModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.mantenimiento.form.plantilladoc' )
@stop
