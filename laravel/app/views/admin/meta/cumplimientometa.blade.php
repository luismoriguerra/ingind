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
    @include( 'admin.meta.js.cumplimientometa_ajax' )
    @include( 'admin.meta.js.cumplimientometa' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            REPORTE DE CUMPLIMIENTO DE GESTION POR RESULTADO
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Proyecto</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-5">
                                <label class="control-label">Proyecto:</label>
                                <select class="form-control" name="slct_meta" id="slct_meta"multiple="">
                                </select>
                            </div>
                            <div class="col-sm-1" style="padding:24px">
                                <span class="btn btn-primary btn-md" id="generar" name="generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                                {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                            </div>
<!--                            <div class="col-sm-1" style="padding:24px">
                                {{-- <span class="btn btn-success btn-md" id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt"></i> Export</span> --}}
                                <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                            </div>-->
                        </div>
                    </div>
                </fieldset>
                <div class="box-body table-responsive">
                <div class="row form-group" id="reporte" style="display:none;">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_reporte" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Proyecto</th>
                                        <th>Actividad</th>
                                        <th>Vencimiento</th>
                                        <th>Cumplimiento</th>
                                        <th>Porcentaje Actividad</th>
                                        <th>Porcentaje Desglose</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_reporte">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div><!-- /.box -->
            </div><!-- /.box -->
            
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
