<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::script('js/jquery.form.js') }}
    @include( 'admin.mantenimiento.js.llamadaatencion_ajax' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mantenimiento de Llamada de Atención
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Llamada de Atención</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Número maximo de llamada de atención:</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <form id="form_numeromaximo" name="form_numeromaximo" action="" method="post">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label class="control-label">Número Máximo
                                                <a id="error_numeromaximo" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ingrese Número Máximo">
                                                <i class="fa fa-exclamation"></i>
                                                </a>
                                            </label>
                                            <input type="text" class="form-control" placeholder="Ingrese Número Máximo" name="txt_numeromaximo" id="txt_numeromaximo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" id="editar_numeromaximo">Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop
