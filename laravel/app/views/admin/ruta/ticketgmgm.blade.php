<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.ruta.js.ticketgmgm_ajax' )
    @include( 'admin.ruta.js.ticketgmgm' )
    
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            BANDEJA DE INCIDENCIAS
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Tramite</a></li>
            <li class="active">Bandeja de Incidencias</li>
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
                            <form id="form_ticketgmgms" name="form_ticketgmgms" method="POST" action="">
                            <input class='form-control mant' type='hidden' id="usuario" name="usuario" value='1'>
                            <div class="box-body table-responsive">
                                <table id="t_ticketgmgms" class="table table-bordered table-striped">
                                    <thead>
                                    <tr><th colspan="13" style="text-align:center;background-color:#A7C0DC;"><h2>Incidencias</h2></th></tr>
                                        <tr>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                       
                                    </tfoot>
                                </table>
                                <a class='btn btn-primary btn-sm' class="btn btn-primary" 
                                data-toggle="modal" data-target="#ticketgmgmModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                                <a class='btn btn-primary btn-sm' class="btn btn-primary"
                                data-toggle="modal" data-target="#ticketsHistoricoModal" data-titulo="Incidencias Históricos" onClick='Mostrartickets();'><i class="fa fa-search fa-lg"></i>&nbsp;Incidencias Históricos</a>
                            </div><!-- /.box-body -->
                             </form>
                        </div><!-- /.box -->
                        <!-- Finaliza contenido -->
                    </div>
                </div>
            </section><!-- /.content -->
    @stop

    @section('formulario')
         @include( 'admin.ruta.form.ticketgmgm' )
         @include( 'admin.ruta.form.soluciongmgm' )
         @include( 'admin.ruta.form.ticketscompleto' )
      
    @stop
