<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ HTML::style('lib/datepicker.css') }}
    {{ HTML::script('lib/bootstrap-datepicker.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.vehiculo.js.bien_ajax' )
    @include( 'admin.vehiculo.js.bien' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Bienes Registro
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Cargos</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Bienes Area
                            <a class='btn btn-success btn-xs' class="btn btn-primary" 
                            data-toggle="modal" data-target="#accionBien" data-titulo="Nuevo" style="color: white;"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="t_cargos" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Descripcion</th>
                                        <th>Categoria</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Nro Interno</th>
                                        <th>Serie</th>
                                        <th>Ubicacion</th>
                                        <th>Fecha_adquision</th>
                                        <th>estado</th>
                                        <th> [ ] </th>
                                        <th> [ ] </th>
                                    </tr>
                                </thead>
                                <tbody id="tb_cargos">
                                </tbody>
                            </table>
                            
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>

                <div class="col-xs-12 caracteristica hidden">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title2">Detalles  <a class='btn btn-success btn-xs nuevaCaracteristica' class="btn btn-primary" 
                            data-toggle="modal" data-target="#nuevaCaracteristica" data-titulo="Nuevo" style="color: white;"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="t_caracteristica" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Descripcion</th>
                                        <th>Observacion</th>
                                        <th>Valor</th>
                                        <th>Alerta</th>
                                        <th>Alerta Razon</th>
                                        <th>Alerta Fecha</th>
                                        <th> [ ] </th>
                                        <th> [ ] </th>
                                         <th> [ ] </th>
                                    </tr>
                                </thead>
                                <tbody id="tb_caracteristica">
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>


                <div class="col-xs-12 evento hidden">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title2">Evento  <a class='btn btn-success btn-xs' class="btn btn-primary" 
                            data-toggle="modal" data-target="#nuevoEvento" data-titulo="Nuevo" style="color: white;"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="t_evento" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Categoria</th>
                                        <th style="width: 70%">Descripcion</th>
                                        <th style="width: 10%">Confirmacion</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_evento">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Categoria</th>
                                        <th>Descripcion</th>
                                        <th>Confirmacion</th>
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
     @include( 'admin.vehiculo.form.accionbien' )
     @include( 'admin.vehiculo.form.nuevaCaracteristica' )
     @include( 'admin.vehiculo.form.nuevoEvento' )
      @include( 'admin.vehiculo.form.aviso' )
@stop
