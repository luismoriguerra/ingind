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
    @include( 'admin.reporte.js.produccionusu_ajax' )
    @include( 'admin.reporte.js.produccionusu' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Producciòn de Usuarios
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Usuarios</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label class="control-label">Area:</label>
                                <select class="form-control" name="slct_area_id" id="slct_area_id" multiple>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="Mostrar">
                            </div>
                        </div>
                    </div>
                </fieldset>
                  <form name="form_persona_detalle" id="form_persona_detalle" method="POST" action="">
                                    <div id="bandeja_detalle" class="row form-group" style="display:none;">
                                        <div class="col-sm-12">
                                            <h3><span id="txt_titulo2">Usuario</span>
                                            <small>
                                                <i class="fa fa-angle-double-right fa-lg"></i>
                                                <span id="texto_fecha_creacion2">:</span>
                                            </small>
                                            </h3>
                                        </div>
                                        <div class="col-sm-12">                                          
                                            <div class="col-md-4 col-sm-4">
                                                <label class="control-label">Nombre:</label>
                                                <input type="text" class="form-control" id="txt_persona" readonly>
                                            </div>
                                             <div class="col-md-4 col-sm-4">
                                                <label class="control-label">Rango de Fechas:</label>
                                                <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                                             </div>
                                             <div class="col-md-2 col-sm-2">                            
                                                <label class="control-label" style="color: white">aaaaa</label>
                                                <input type="button" class="btn btn-info" id="generar" name="generar" value="Productividad">
                                             </div>
                                        </div>
                                        <div class="col-md-12">
                                             <div class="col-md-2">
                                                <label class="control-label" style="color: white">aaaaa</label>
                                                <button type="button"  class="btn btn-primary" id="regresar" name="regresar" value="Regresar" onClick='Regresar();'>regresar</button>
                                             </div>
                                        </div>
                  </form>
            </div><!-- /.box -->
            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte" style="display:none;">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_reporte" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Paterno</th>
                                        <th>Materno</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Dni</th>
                                        <th>Fecha Nacimiento</th>
                                        <th>Sexo</th>
                                        <th>Estado</th>
                                        <th>Area</th>
                                        <th>Cargo</th>
                                        <th>Cargo</th>
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
