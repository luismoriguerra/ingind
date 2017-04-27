<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}

    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}

    {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ HTML::script('lib/jquery-form/jquery-form.js') }} 

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    
    @include( 'admin.mantenimiento.js.area_ajax' )
    @include( 'admin.mantenimiento.js.area' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mantenimiento de Areas
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Areas</li>
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
                        <form id="form_areas" name="form_areas" method="POST" action="">
                        <div class="box-body table-responsive">
                            <table id="t_areas" class="table table-bordered table-striped">
                                <thead>
                                <tr><th colspan="3" style="text-align:center;background-color:#A7C0DC;"><h2>Áreas</h2></th></tr>
                                    <tr>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                   
                                </tfoot>
                            </table>
                            <a class='btn btn-primary btn-sm' class="btn btn-primary" 
                            data-toggle="modal" data-target="#areaModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#areaModal" data-titulo="Editar"></a>
                        </div><!-- /.box-body -->
                         </form>
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.mantenimiento.form.area' )
@stop
