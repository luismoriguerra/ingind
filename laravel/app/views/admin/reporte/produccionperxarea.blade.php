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
    @include( 'admin.reporte.js.produccionperxarea_ajax' )
    @include( 'admin.reporte.js.produccionperxarea' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Producciòn de Personal por Área
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
                            <div class="col-sm-4"><input type="hidden" id="area_id" name="area_id">
                                <label class="control-label">Area:</label>
                                <select class="form-control" name="slct_area_id[]" id="slct_area_id" multiple>
                                </select>
                            </div>
                             <div class="col-md-4 col-sm-4">
                                                <label class="control-label">Rango de Fechas:</label>
                                                <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                            </div>
                                             <div class="col-md-1 col-sm-1">                            
                                                <label class="control-label" style="color: white">aaaaa</label>
                                                <input type="button" class="btn btn-info" id="generar" name="generar" value="Productividad">
                                             </div>
                                            <div class="col-md-1 col-sm-2" style="padding:24px">
                                                <a class='btn btn-success btn-md' id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt"></i> Export Actividades</i></a>
                                            </div>
<!--                            <div class="col-sm-2">
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="generar_area" name="generar_area" value="Mostrar">
                            </div>-->
                        </div>
                    </div>
                </fieldset>
            
             
           <div class="nav-tabs-custom" style="display:none;">
            <ul class="nav nav-tabs logo modal-header">
                <li class="logo tab_1 active">
                    <a href="#tab_1" data-toggle="tab">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-cloud fa-lg"></i> </button>
                        Tareas Realizadas
                    </a>
                </li>
                <li class="logo tab_2">
                    <a href="#tab_2" data-toggle="tab">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-cloud fa-lg"></i> </button>
                        Trámites Asignados
                    </a>
                </li>
                 <li class="logo tab_3">
                    <a href="#tab_3" data-toggle="tab">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-cloud fa-lg"></i> </button>
                        Actividades Personales
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1" onclick="ActPest(1);">
                    <form id="form_produccion" name="form_produccion" method="post">
                          <div class="row form-group" id="produccion" >
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_produccion" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th> <th>Area</th>
                                        <th>Nombre del Proceso</th>
                                        <th>Cantidad de Tareas Realizadas</th>
                                        <th>[]</th>
                                        <th>[]</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_produccion">
                                </tbody>
                            </table>
                        </div>
                    </div>
                   <div class="col-sm-12">
                    <br>
                </div>
                <div class="col-sm-12">
                    <div id="div_total_produccion" >
                    
                </div>
                </div>
                  
                </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab_2" onclick="ActPest(2);">
                    <form id="form_2" name="form_2" method="post">
                           <div class="row form-group" id="tramite_asignado" >
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_tramite_asignado" class="table table-bordered">
                                <thead>
                                    <tr><th>N°</th> <th>Area</th>
                                        <th>Nombre del Proceso</th>
                                        <th>Cantidad de Trámites Asignados</th>
                                        <th>[]</th>
                                        <th>[]</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_tramite_asignado">
                                </tbody>
                            </table>
                        </div>
                    </div>
                   <div class="col-sm-12">
                    <br>
                </div>
                <div class="col-sm-12">
                    <div id="div_total_tramite_asignado" >
                    
                </div>
                </div>
                  
                </div>
                    </form>
                </div>

                <div class="tab-pane" id="tab_3" onclick="ActPest(3);">
                    <form id="form_3" name="form_3" method="post">
                        <div class="row form-group" id="tramite_asignado" >
                            <div class="col-sm-12 hidden">
                                <div class="box-body table-responsive">
                                    <table id="t_tramite_asignado" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nombre del Proceso</th>
                                                <th>Cantidad de Trámites Asignados</th>
                                                <th>[]</th>
                                                <th>[]</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tb_tramite_asignado">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    <div class="col-sm-12">
                        <div class="col-sm-2" style="padding-top: 5px">
                            <span>Tiempo Total: </span>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="txt_totalh" name="txt_totalh" readonly="readonly">
                        </div>
                    <br>
                    </div>
                    <div class="col-sm-12">
                      <div class="box-body table-responsive">
                         <table id="t_ordenest" class="table table-bordered">
                            <thead>
                                 <tr>
                                     <th>Area</th>
                                     <th>Persona</th>
                                     <th>Cantidad</th>
                                     <th>Total Min</th>
                                     <th>Formato</th>
                                 </tr>
                            </thead>
                            <tbody id="tb_ordenest">
                            </tbody>
                         </table>
                        </div>
                    </div>
                  
                </div>
                    </form>
                </div>

             
            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom --> 
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
    

@stop
@section('formulario')
     @include( 'admin.reporte.form.produccionperxarea' )
@stop
