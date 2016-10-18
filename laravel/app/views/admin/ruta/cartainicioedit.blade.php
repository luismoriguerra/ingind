<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.ruta.js.cartainicio_ajax' )
    @include( 'admin.ruta.js.cartainicioedit' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Editar Carta de Inicio
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Ruta</a></li>
        <li class="active">Carta de Inicio</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- Inicia contenido -->
            <div class="box">
                <form name="form_carta" id="form_carta" method="POST" action="">
                    <div class="row form-group" id="tabla_relacion">
                        <div class="col-sm-12">
                            <div class="box-body table-responsive">
                                <table id="t_carta" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Carta</th>
                                            <th>Objetivo</th>
                                            <th>Entregable</th>
                                            <th>[ ]</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_carta">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Carta</th>
                                            <th>Objetivo</th>
                                            <th>Entregable</th>
                                            <th>[ ]</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div style="display:none">
                    <select id="slct_tipo_recurso_id"></select>
                    <select id="slct_tipo_actividad_id"></select>
                    <select id="slct_persona_id"></select>
                    </div>

                    <!--data show in edit -->
                    <div class="row form-group" id="cartainicio" style="display:none">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <div class="box box-solid bg-blue">Carta N° :</div>
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control" data-text="Ingrese Nro Carta" data-type="txt" id="txt_nro_carta" name="txt_nro_carta" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <div class="box box-solid bg-blue">Proceso :</div>
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control" id="txt_flujo" name="txt_flujo" type="text" readonly>
                                <input type="hidden" id="txt_flujo_id" name="txt_flujo_id" value="">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <label class="box box-solid bg-blue">Objetivo del Proyecto:</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea class="form-control col-sm-12" data-text="Ingrese Objetivo del Proyecto" data-type="txt" id="txt_objetivo" name="txt_objetivo"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <label class="box box-solid bg-blue">Entregables del Proyecto:</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea class="form-control col-sm-12" data-text="Ingrese Entregables del Proyecto" data-type="txt" id="txt_entregable" name="txt_entregable"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <label class="box box-solid bg-blue">Alcance del Proyecto:</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea class="form-control col-sm-12" data-text="Ingrese Alcance del Proyecto" data-type="txt" id="txt_alcance" name="txt_alcance"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                                <label class="box box-solid bg-blue">
                                <a id="btn_recursos_0" onclick="AddTr(this.id,0);" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus fa-lg"></i>
                                </a>
                                Recursos (No humanos):
                                </label>
                        </div>
                        <div class="row form-group" id="tabla_recursos">
                            <div class="col-sm-12">
                                <div class="box-body ">
                                    <table id="t_recursos" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Tipo Recurso</th>
                                                <th>Descripción</th>
                                                <th>Cantidad</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                                <label class="box box-solid bg-blue">
                                <a id="btn_metricos_1" onclick="AddTr(this.id,0);" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus fa-lg"></i>
                                </a>
                                Métricos:
                                </label>
                        </div>
                        <div class="row form-group" id="tabla_metricos">
                            <div class="col-sm-12">
                                <div class="box-body ">
                                    <table id="t_metricos" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Métrico</th>
                                                <th>Actual</th>
                                                <th>Objetivo</th>
                                                <th>Comentario</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                                <label class="box box-solid bg-blue">
                                <a id="btn_desgloses_2" onclick="AddTr(this.id,0);" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus fa-lg"></i>
                                </a>
                                Desglose de Carta de Inicio N°:
                                </label>
                                <label>
                                Fecha de Inicio:
                                </label>
                                <input type="text" name="txt_fecha_inicio" id="txt_fecha_inicio" onChange="CargarFechas();" readonly>
                        </div>
                        <div class="row form-group" id="tabla_desgloses">
                            <div class="col-sm-12">
                                <div class="box-body ">
                                    <table id="t_desgloses" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Tipo Actividad</th>
                                                <th>Actividad</th>
                                                <th style="width:300px !important;">Responsable - Area</th>
                                                <th>Recursos</th>
                                                <th style="width:106px !important;">Fecha Inicio</th>
                                                <th style="width:106px !important;">Fecha Fin</th>
                                                <th style="width:70px !important;">Hora Inicio</th>
                                                <th style="width:70px !important;">Hora Fin</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <a class="btn btn-primary btn-sm" id="btn_guardar">
                                <i class="fa fa-save fa-lg"></i>&nbsp;Guardar
                            </a>
                        </div>
                    </div>
                    <!-- end data show in edit -->

                    <!-- structure to show in copy -->

                    <!-- end structure to show in copy -->

                </form>
            </div><!-- /.box -->
            <!-- Finaliza contenido -->
        </div>
    </div>
</section><!-- /.content -->
@stop
