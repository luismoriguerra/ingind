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
@include( 'admin.ruta.js.informecartainicioedit' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Informe Carta de Inicio
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
                    <div class="row form-group" id="cartainicio" style="display:none">
                        <input type="hidden" data-type="text" id="txt_informe" name="txt_informe" value="1"/>
                       <div class="col-sm-6">
                           <div class="col-sm-12">
                               <div class="col-sm-2">
                                   <div class="box box-solid bg-blue">Carta N° :</div>
                               </div>
                               <div class="col-sm-3">
                                   <input class="form-control" data-text="Ingrese Nro Carta" data-type="txt" id="txt_nro_carta" name="txt_nro_carta" type="text" disabled>
                               </div>
                           </div>
                           <div class="col-sm-12">
                               <div class="col-sm-3">
                                   <label class="box box-solid bg-blue">Objetivo del Proyecto:</label>
                               </div>
                               <div class="col-sm-9">
                                   <textarea class="form-control" data-text="Ingrese Objetivo del Proyecto" data-type="txt" id="txt_objetivo" name="txt_objetivo" disabled></textarea>
                               </div>
                           </div>
                           <div class="col-sm-12">
                               <div class="col-sm-3">
                                   <label class="box box-solid bg-blue">Entregables del Proyecto:</label>
                               </div>
                               <div class="col-sm-9">
                                   <textarea class="form-control" data-text="Ingrese Entregables del Proyecto" data-type="txt" id="txt_entregable" name="txt_entregable" disabled></textarea>
                               </div>
                           </div>
                           <div class="col-sm-12">
                               <div class="col-sm-3">
                                   <label class="box box-solid bg-blue">Alcance del Proyecto:</label>
                               </div>
                               <div class="col-sm-9">
                                   <textarea class="form-control" data-text="Ingrese Alcance del Proyecto" data-type="txt" id="txt_alcance" name="txt_alcance" disabled></textarea>
                               </div>
                           </div>
                       </div>
                       <div class="col-sm-6">
                           <div class="col-sm-12">
                               <label class="box box-solid bg-blue">
                                  Evaluación de Resultado:
                               </label>
                           </div>
                           <div class="col-sm-12">

                               <div class="col-sm-12">
                                   <textarea class="form-control" data-text="Ingrese Objetivo del Proyecto" data-type="txt" id="txt_objetivo_inf" name="txt_objetivo_inf" ></textarea>
                               </div>
                           </div>
                           <div class="col-sm-12">

                               <div class="col-sm-12">
                                   <textarea class="form-control" data-text="Ingrese Entregables del Proyecto" data-type="txt" id="txt_entregable_inf" name="txt_entregable_inf" ></textarea>
                               </div>
                           </div>
                           <div class="col-sm-12">

                               <div class="col-sm-12">
                                   <textarea class="form-control" data-text="Ingrese Alcance del Proyecto" data-type="txt" id="txt_alcance_inf" name="txt_alcance_inf" ></textarea>
                               </div>
                           </div>
                       </div>
                        <div class="col-sm-12">
                            <label class="box box-solid bg-blue">
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
                                            <th>CUANTO SOBRÓ</th>
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
                                            <th>CUANTO SE ALCANZÓ </th>
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

                                Desglose de Carta de Inicio N°:
                            </label>
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
                                            <th>RESPONSABLE</th>
                                            <th>RECURSO </th>
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
                </form>
            </div><!-- /.box -->
            <!-- Finaliza contenido -->
        </div>
    </div>
</section><!-- /.content -->
@stop
