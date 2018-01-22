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
    @include( 'admin.meta.js.cuadro_ajax' )
    @include( 'admin.meta.js.cuadro' )
    @include( 'admin.reporte.js.totaltramites_ajax' )
    @include( 'admin.reporte.js.totaltramites' )
    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.meta.js.docdigital' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gestion por Resultados
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
                                <label class="control-label">Proyecto:</label>
                                <select class="form-control" name="slct_meta" id="slct_meta"multiple="">
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="generar_area" name="generar_area" value="Mostrar">
                            </div>
                        </div>
                    </div>
                </fieldset>
            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte" >
                    <div class="col-sm-12">
<!--                        <div class="box-body table-responsive">-->
                            <table id="t_reporte" class="table table-bordered2" >
                                <thead>
                                    <tr>
                                        <th colspan="4" style="text-align:center; background-color:#FCD790; width: 30%;">Proyecto</th>
                                        <th colspan="2" style="text-align:center; background-color:#F5DF9D; width: 30%;">Plan de Trabajo</th>
                                        <th colspan="6" style="text-align:center; background-color:#DEFAFA; width: 40%;">Avances</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:center;background-color:#FCD790; width: 10%;">Meta</th>
                                        <th style="text-align:center;background-color:#FCD790; width: 10%;">Actividad</th>
                                        <th style="text-align:center;background-color:#FCD790; width: 20%;">Descripción</th>
                                        <th style="text-align:center;background-color:#FCD790; width: 5%;">Fecha</th>
                                        <th style="text-align:center;background-color:#F5DF9D; width: 20%;">Paso</th>
                                        <th style="text-align:center;background-color:#F5DF9D; width: 5%;">Fecha</th>
                                        <th style="text-align:center;background-color:#DEFAFA; width: 10%;">Informe Quincenal</th>
                                        <th style="text-align:center;background-color:#DEFAFA; width: 10%;">Avance de Paso</th>
                                        <th style="text-align:center;background-color:#DEFAFA; width: 10%;">Avance de Descripción</th>
                                        <th style="text-align:center;background-color:#DEFAFA; width: 10%;">Avance de Actividad</th>
                                        <th style="text-align:center;background-color:#DEFAFA; width: 10%;">Proceso</th>
                                        <th style="text-align:center;background-color:#DEFAFA; width: 5%;">Avance de Meta</th>
                                      
                                    </tr>
                                </thead>
                                <tbody id="tb_reporte">
                                </tbody>
                            </table>
<!--                        </div>-->
                    </div>
                </div>
              
               
                
                
                
            </div><!-- /.box -->
            </div><!-- /.box -->


            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
    

@stop

@section('formulario')
     @include( 'admin.ruta.form.ListdocDigital' )
     @include( 'admin.meta.form.docdigital' )
     @include( 'admin.meta.form.tramite' )
     @include( 'admin.ruta.form.ruta' )
@stop