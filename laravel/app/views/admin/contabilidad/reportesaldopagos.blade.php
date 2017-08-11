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
    @include( 'admin.contabilidad.js.reportesaldopagos_ajax' )
    @include( 'admin.contabilidad.js.reportesaldopagos' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CONSOLIDADO DE SALDOS POR PAGAR A PROVEEDORES
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Saldos por Pagar a Proveedores</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <form id="form_reporte" name="form_reporte" method="post">
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-3 text-center">
                                <label class="control-label text-right">Rango de Fechas</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                  <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                                </div>
                            </div>
                            <div class="col-sm-3 text-center">
                              <label class="control-label">&nbsp;Ruc Proveedor</label>
                              <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></span>
                                <input type="text" class="form-control" placeholder="RUC" name="txt_ruc" id="txt_ruc">
                              </div>
                            </div>
                            
                            <div class="col-sm-1" style="padding:24px">
                                <span class="btn btn-primary btn-md" id="generar" name="generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                                {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                            </div>
                            <div class="col-sm-1" style="padding:24px">
                                {{-- <span class="btn btn-success btn-md" id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt"></i> Export</span> --}}
                                <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div><!-- /.box -->
            </form>

            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte" style="display:none;">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_reporte" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>RUC</th>
                                        <th>PROVEEDOR</th>
                                        <th>EXPEDIENTE</th>
                                        <th>TOTAL G.C</th>
                                        <th>TOTAL G.D</th>
                                        <th>TOTAL G.G</th>
                                        <th>DEVENGADO POR PAGAR</th>
                                        <th>COMPROMISO POR PAGAR</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_reporte">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
            <!-- Finaliza contenido -->

        </div>
    </section><!-- /.content -->
@stop
