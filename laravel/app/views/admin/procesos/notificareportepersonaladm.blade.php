<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.procesos.js.notificareportepersonaladm_ajax' )
    @include( 'admin.procesos.js.notificareportepersonaladm' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ENVIO DE NOTIFICACIONES REPORTE PERSONAL ADM
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Notificaciones de Personal ADM</li>
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
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="enviar" name="enviar" value="Enviar a Trabajador">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="enviarjefe" name="enviarjefe" value="Enviar Resumen a Jefe">
                            </div>
                        </div>
                    </div>
                </fieldset>         
            </div><!-- /.box -->
            <div class="box-body">
                <div class="col-sm-12">
                    <table id="t_reporte" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Titulo</th>
                                <th>Area</th>
                                <th>Persona</th>
                                <th>Email</th>
                                <th>Email mdi</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box -->
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
