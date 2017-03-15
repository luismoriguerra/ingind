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
<!--    @include( 'admin.ruta.js.ruta_ajax' )-->
    @include( 'admin.ruta.js.clasitipotramite' )
    @include( 'admin.ruta.js.clasitipotramite_ajax' )
    @include( 'admin.mantenimiento.js.clasificadortramite' )
    @include( 'admin.mantenimiento.js.clasificadortramite_ajax' )

@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mantenimiento
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Mantenimiento</li>
        </ol>
    </section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs logo modal-header">
                <li class="logo tab_1 active">
                    <a href="#tab_1" data-toggle="tab">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-cloud fa-lg"></i> </button>
                        Tipo Trámite
                    </a>
                </li>
                <li class="logo tab_2">
                    <a href="#tab_2" data-toggle="tab">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-cloud fa-lg"></i> </button>
                        Clasificador Trámite
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1" onclick="ActPest(1);">
                     <form id="form_estrat_pei" name="form_estrat_pei" method="POST" action="">
                    <div class="form-group">
                        <div class="box-header table-responsive">
                            <div class="col-xs-12">
                                <h3>
                                    Mantenimiento de Tipo Trámite 
                                </h3>                           
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="t_estrat_pei" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre</th>
                                        <th>[]</th>
                                        <th>[]</th>
                                    </tr>
<!--                                    <tr><th colspan="12" style="text-align:center;background-color:#A7C0DC;"><h2><spam id="txt_titulo">Contrataciones</spam></h2></th></tr>-->

                                </thead>
                                <tbody id="tb_estrat_pei">
                                </tbody>

                            </table>
                            <a class="btn btn-primary"
                               data-toggle="modal" data-target="#tipotramiteModal" data-titulo="Nueva"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#tipotramiteModal" data-titulo="Editar"></a>

                        </div><!-- /.box-body -->
                    </div>
                </form>

                </div>
                <div class="tab-pane" id="tab_2" onclick="ActPest(2);">
                     <form id="form_clasificadortramites" name="form_clasificadortramites" method="POST" action="">
                        <div class="box-body table-responsive">
                            <table id="t_clasificadortramites" class="table table-bordered table-hover">
                                <thead>
                                <tr><th colspan="5" style="text-align:center;background-color:#A7C0DC;"><h2>Clasificador Tramite</h2></th></tr>
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                            <a class="btn btn-primary"
                            data-toggle="modal" data-target="#clasificadortramitesModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar_clasificador" data-toggle="modal" data-target="#clasificadortramitesModal" data-titulo="Editar"></a>
                        </div><!-- /.box-body -->
                        </form>
                  <br>
                <form id="form_costo_personal" name="form_costo_personal" method="POST" action="">
                    <div class="form-group" style="display: none">
                        <div class="box-header table-responsive">
                            <div class="col-xs-12">
                                <h3>
                                    Mantenimiento de Requisitos |
                                    <small>Nombre de Trámite:  <label type="text" id="txt_titulo"></label></small>
                                </h3>                           
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="t_costo_personal" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>[]</th>
                                        <th>[]</th>
                                    </tr>
<!--                                    <tr><th colspan="12" style="text-align:center;background-color:#A7C0DC;"><h2><spam id="txt_titulo">Contrataciones</spam></h2></th></tr>-->

                                </thead>
                                <tbody id="tb_costo_personal">
                                </tbody>

                            </table>
                            <a class="btn btn-primary"
                               data-toggle="modal" data-target="#requisitoModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#requisitoModal" data-titulo="Editar"></a>
                            <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                                <i class="fa fa-remove fa-lg"></i>&nbsp;Cerrar
                            </a>

                        </div><!-- /.box-body -->
                    </div>
                </form>
          
                </div>
            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->

        <form name="form_ruta_flujo" id="form_ruta_flujo" style="display:none" method="POST" action="">
            <div class="row form-group">
                <div class="col-sm-12">
                    <h1><span id="txt_titulo">Nueva Ruta</span>
                    <small>
                        <i class="fa fa-angle-double-right fa-lg"></i>
                        <span id="texto_fecha_creacion">Fecha Creación:</span>
                        <span id="fecha_creacion"></span>
                    </small>
                    </h1>
                </div>
                <div class="col-sm-12">
                    <div class="col-sm-4">
                        <label class="control-label">Dueño del Proceso:</label>
                        <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label class="control-label">Proceso:</label>
                        <input class="form-control" type="text" id="txt_proceso" name="txt_proceso" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label class="control-label">Area del Dueño del Proceso:</label>
                        <input class="form-control" type="text" id="txt_area" name="txt_area" readonly>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-12">
                    <div class="box-body">
                        <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                            <thead> 
                                <tr class="head">
                                    <th style="width:250px !important;min-width: 200px !important;" >
                                    </th>
                                    <th class="eliminadetalleg" style="min-width:1000px important!;">[]</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="body">
                                    <td>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr><th colspan="2">
                                                </th></tr>
                                                <tr class="head">
                                                    <th>#</th>
                                                    <th>Area</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tb_rutaflujodetalleAreas">
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="head">
                                    <th>#</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12">
                    <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                        <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                    </a>
                </div>
            </div>
        </form>
    </section><!-- /.content -->

@stop
@section('formulario')
    @include( 'admin.mantenimiento.form.tipotramite' )
    @include( 'admin.ruta.form.requisito' )
    @include( 'admin.mantenimiento.form.clasificadortramite' )
@stop
