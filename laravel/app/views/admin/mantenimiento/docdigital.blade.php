<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::script('lib/ckeditor/ckeditor.js') }}
    {{ HTML::style('css/admin/plantilla.css') }}
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
     {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}

    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}

<!--    {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}-->

    {{ HTML::script('lib/jquery-bootstrap-validator/bootstrapValidator.min.css') }}
    {{ HTML::script('lib/jquery-bootstrap-validator/bootstrapValidator.min.js') }}

<!--{{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}-->
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.mantenimiento.js.docdigital_ajax' )
    @include( 'admin.mantenimiento.js.docdigital' )
    @include( 'admin.mantenimiento.js.docdigitalform' )

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
                            <h3 class="box-title">Documentos del <?php $fin=date("Y-m-d"); $inicio=strtotime('-15 day', strtotime($fin)) ; echo $inicio = date('Y-m-d', $inicio); ?> al <?php echo $fin ?> y por Asignar a un trámite</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <div class="text-center">
                                <a class='btn btn-success btn-sm' class="btn btn-primary"
                            data-toggle="modal" data-target="#NuevoDocDigital" data-titulo="Nuevo" onclick="Plantillas.CargarAreas();NuevoDocumento();"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            </div>
                            <table id="t_doc_digital" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Creador</th>
                                        <th style="width: 30%">Actualizó</th>
                                        <th style="width: 30%">Titulo</th>
                                        <th style="width: 30%">Asunto</th>
                                        <th style="width: 30%">Fecha Creación</th>
                                        <th style="width: 30%">Plantilla</th>
                                       {{--  <th style="width: 19%">Area Recepcion</th>
                                        <th style="width: 19">Persona Recepcion</th> --}}
                                        <th style="width: 5%">Editar</th>
                                        <th style="width: 5%">Vista Previa</th>
                                        <th style="width: 5%">Vista Impresión</th>
                                         <th style="width: 5%">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_doc_digital">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width: 30%">Creador</th>
                                        <th style="width: 30%">Actualizó</th>
                                        <th style="width: 30%">Titulo</th>
                                        <th style="width: 30%">Asunto</th>
                                        <th style="width: 30%">Fecha Creación</th>
                                        <th style="width: 30%">Plantilla</th>
                        {{--                 <th style="width: 19%">Area Recepcion</th>
                                        <th style="width: 19">Persona Recepcion</th> --}}
                                         <th style="width: 5%">Editar</th>
                                        <th style="width: 5%">Vista Previa</th>
                                        <th style="width: 5%">Vista Impresión</th>
                                        <th style="width: 5%">Eliminar</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <a class='btn btn-success btn-sm' class="btn btn-primary"
                            data-toggle="modal" data-target="#NuevoDocDigital" data-titulo="Nuevo" onclick="Plantillas.CargarAreas();NuevoDocumento();"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a class='btn btn-primary btn-sm' class="btn btn-primary"
                            data-toggle="modal" data-target="#docdigitalModal" data-titulo="Documentos Históricos" onClick='MostrarDocumentos(1);'><i class="fa fa-search fa-lg"></i>&nbsp;Documentos Históricos</a>
                            <?php if(Auth::user()->vista_doc==1){ ?>
                            <a class='btn btn-info btn-sm' class="btn btn-primary"
                            data-toggle="modal" data-target="#docdigitalModal" data-titulo="Documentos Relacionados al Área" onClick='MostrarDocumentos(2);'><i class="fa fa-search fa-lg"></i>&nbsp;Documentos Relacionados al Área</a>    
                            <?php } ?>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.mantenimiento.form.docdigital' )
     @include( 'admin.mantenimiento.form.editarfechadoc' )
     @include( 'admin.mantenimiento.form.docdigitalcompleto' )
@stop
