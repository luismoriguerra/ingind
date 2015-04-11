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
    
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{ HTML::style('lib/startbootstrap/bower_components/metisMenu/dist/metisMenu.min.css') }}
    {{ HTML::style('lib/startbootstrap/dist/css/sb-admin-2.css') }}
    {{ HTML::style('lib/startbootstrap/bower_components/morrisjs/morris.css') }}
    {{ HTML::style('lib/startbootstrap/bower_components/font-awesome/css/font-awesome.min.css') }}
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reporte de Ruta por Tramite
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Reporte</a></li>
                        <li class="active">Reporte de Ruta por Tramite</li>
                    </ol>
                </section>

                <!-- Main content -->
                <!-- Main content -->
                <section class="content">
                    <form name="form_movimiento" id="form_movimiento" method="post" action="reporte/movimiento" enctype="multipart/form-data">
                        <fieldset>
                            <div class="row form-group" id="div_fecha">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <select class="form-control" name="slct_flujos" id="slct_flujos">
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                                    </div>
                                    
                                </div>
                            </div>
                        </fieldset>
                        
                    </form>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary" id="generar_movimientos" name="generar_movimientos">
                                Mostrar
                            </button>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table id="t_reporte" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>software</th>
                                    <th>Persona</th>
                                    <th>Area</th>
                                    <th>Fecha Inicio</th>
                                    <th>0</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th> [ ] </th>
                                </tr>
                            </thead>
                            <tbody id="tb_reporte">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>software</th>
                                    <th>Persona</th>
                                    <th>Area</th>
                                    <th>Fecha Inicio</th>
                                    <th>0</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th> [ ] </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <ul class="list-group" id="t_reporteDetalle"></ul>


                    <div id="page-wrapper">
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Area Chart Example
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div id="morris-area-chart"></div>
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                </section><!-- /.content -->


    {{ HTML::script('lib/startbootstrap/bower_components/metisMenu/dist/metisMenu.min.js') }}
    {{ HTML::script('lib/startbootstrap/bower_components/raphael/raphael-min.js') }}
    {{ HTML::script('lib/startbootstrap/bower_components/morrisjs/morris.min.js') }}


    @include( 'admin.reporte.js.ruta_tramite_ajax' )
    @include( 'admin.reporte.js.ruta_tramite' )
@stop