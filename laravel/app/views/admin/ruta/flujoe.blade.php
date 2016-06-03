<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent

    @include( 'admin.mantenimiento.js.flujo_ajax' )
    @include( 'admin.mantenimiento.js.flujoe' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Editar Procesos
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Editar Procesos</li>
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
                            <table id="t_flujos" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Categoria</th>
                                        <th>Area</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th> [ ] </th>
                                    </tr>
                                </thead>
                                <tbody id="tb_flujos">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Categoria</th>
                                        <th>Area</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th> [ ] </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.ruta.form.flujo' )
@stop
