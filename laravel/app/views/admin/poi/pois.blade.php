<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}

    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}

    {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}

    
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.poi.js.pois_ajax' )
    @include( 'admin.poi.js.pois' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mantenimiento de POI
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Contrataciones</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Filtros</h3>
                        </div><!-- /.box-header -->
                        <form id="form_pois" name="form_pois" method="POST" action="">
                        <div class="box-body table-responsive">
                            <table id="t_pois" class="table table-bordered table-hover">
                                <thead>
                                <tr><th colspan="14" style="text-align:center;background-color:#A7C0DC;"><h2>Plan Operativo Institucional</h2></th></tr>
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                            <a class="btn btn-primary"
                            data-toggle="modal" data-target="#poiModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#poiModal" data-titulo="Editar"></a>
                        </div><!-- /.box-body -->
                        </form>
                        <br>
                       <form id="form_costo_personal" name="form_costo_personal" method="POST" action="">
                           <div class="form-group" style="display: none">
                               <div class="box-header table-responsive"><center><h3>Objetivo General: <label type="text" id="txt_titulo"></label></h3></h3></center></div>
                        <div class="box-body table-responsive">
                            <table id="t_costo_personal" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Rol</th>
                                        <th>Modalidad</th>
                                        <th>Monto</th>
                                        <th>Estimación</th>
                                        <th>Essalud</th>
                                        <th>SubTotal</th>
                                        <th>[]</th>
                                        <th>[]</th>
                                    </tr>
<!--                                    <tr><th colspan="12" style="text-align:center;background-color:#A7C0DC;"><h2><spam id="txt_titulo">Contrataciones</spam></h2></th></tr>-->
                       
                                </thead>
                                <tbody id="tb_costo_personal">
                                </tbody>
                          
                            </table>
                            <a class="btn btn-primary"
                            data-toggle="modal" data-target="#costopersonalModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#costopersonalModal" data-titulo="Editar"></a>
                            <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                                                <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                                            </a>

                        </div><!-- /.box-body -->
                           </div>
                        </form>
                       <hr>
                       <form id="form_estrat_pei" name="form_estrat_pei" method="POST" action="">
                           <div class="form-group" style="display: none">
                               <div class="box-header table-responsive"><center><h3>Objetivo General: <label type="text" id="txt_titulo"></label></h3></h3></center></div>
                        <div class="box-body table-responsive">
                            <table id="t_estrat_pei" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Descripción</th>
                                        <th>[]</th>
                                        <th>[]</th>
                                    </tr>
<!--                                    <tr><th colspan="12" style="text-align:center;background-color:#A7C0DC;"><h2><spam id="txt_titulo">Contrataciones</spam></h2></th></tr>-->
                       
                                </thead>
                                <tbody id="tb_estrat_pei">
                                </tbody>
                          
                            </table>
                            <a class="btn btn-primary"
                            data-toggle="modal" data-target="#estratpeiModal" data-titulo="Nueva"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#estratpeiModal" data-titulo="Editar"></a>
                            <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                                                <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                                            </a>

                        </div><!-- /.box-body -->
                           </div>
                        </form>
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.poi.form.poi' )
     @include( 'admin.poi.form.costo_personal')
      @include( 'admin.poi.form.estrat_pei' )

@stop
