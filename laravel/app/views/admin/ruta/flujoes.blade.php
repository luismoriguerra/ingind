<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.mantenimiento.js.flujoss_ajax' )
    @include( 'admin.mantenimiento.js.flujoes' )
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
                        <form id="form_flujos" name="form_flujos" method="POST" action="">
                        <div class="box-body table-responsive">
                            <table id="t_flujos" class="table table-bordered table-hover">
                                <thead>
                                <tr><th colspan="6" style="text-align:center;background-color:#A7C0DC;"><h2>Editar Procesos</h2></th></tr>
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                            
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#flujoModal" data-titulo="Editar"></a>
                        </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.ruta.form.flujos' )
@stop
