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
@include( 'admin.ruta.js.proceso' )
@include( 'admin.ruta.js.asignar_ajax' )
@include( 'admin.ruta.js.ruta_ajax' )
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
                                <tr><th colspan="7" style="text-align:center;background-color:#A7C0DC;"><h2>Clasificador Tramite</h2></th></tr>
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
                <form name="form_actividad" id="form_actividad" method="POST" action="" style="display: none">
                    <input class="form-control mant" type="hidden" name="id" id="id">
                    <div class="row form-group" >
                        <div class="box-header table-responsive">
                            <div class="col-xs-12">
                                <h3>
                                    Seleccionar Proceso |
                                    <small>Nombre de Trámite:  <label type="text" id="txt_titulo"></label></small>
                                </h3>                           
                            </div>
                        </div>
                        <div class="col-sm-12">

                            <div class="col-sm-8">
                                <label class="control-label">Proceso:</label>
                                <input type="hidden" id="txt_flujo2_id" name="txt_flujo2_id">
                                <input type="hidden" id="txt_area2_id" name="txt_area2_id">
                                <input class="form-control" id="txt_proceso" name="txt_proceso" type="text"  value="" readonly="">

                            </div>
                            <div class="col-sm-1">
                                <br>
                                <span class="btn btn-primary" data-toggle="modal" data-target="#procesoModal" data-texto="txt_proceso" data-id="txt_flujo2_id" data-idarea="txt_area2_id" data-evento="cargarRutaFlujo" id="btn_buscar">
                                    <i class="fa fa-search fa-lg"></i>
                                </span>
                            </div>
                        </div>

                    </div>


                    <div class="row form-group" id="tabla_ruta_flujo" style="display:none;">
                        <div class="col-sm-12">
                            <div class="box-body table-responsive">
                                <table id="t_ruta_flujo" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Proceso</th>
                                            <th>Area</th>
                                            <th>Dueño del Proceso</th>
<!--                                            <th>Nro Trámite Ok</th>
                                            <th>Nro Trámite Error</th>-->
                                            <th>Fecha Creación</th>
                                            <th> [ ] </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_ruta_flujo">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Proceso</th>
                                            <th>Area</th>
                                            <th>Dueño del Proceso</th>
<!--                                            <th>Nro Trámite Ok</th>
                                            <th>Nro Trámite Error</th>-->
                                            <th>Fecha Creación</th>
                                            <th> [ ] </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <a class="btn btn-primary btn-sm" id="btn_guardar_todo">
                                <i class="fa fa-save fa-lg"></i>&nbsp;Guardar
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->

</section><!-- /.content -->

@stop
@section('formulario')
@include( 'admin.mantenimiento.form.tipotramite' )
@include( 'admin.ruta.form.requisito' )
@include( 'admin.mantenimiento.form.clasificadortramite' )
@include( 'admin.ruta.form.proceso' )
@include( 'admin.ruta.form.rutaflujo' )
@include( 'admin.ruta.form.ruta' )
@stop
