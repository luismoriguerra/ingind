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
    @include( 'admin.reporte.js.bandejatramite_ajax' )
    @include( 'admin.reporte.js.bandejatramite' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<style type="text/css">
    /*
    Component: Mailbox
*/
.mailbox .table-mailbox {
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
.mailbox .table-mailbox tr.unread > td {
  background-color: rgba(0, 0, 0, 0.05);
  color: #000;
  font-weight: 600;
}
.mailbox .table-mailbox tr > td > .fa.fa-star,
.mailbox .table-mailbox tr > td > .fa.fa-star-o,
.mailbox .table-mailbox tr > td > .glyphicon.glyphicon-star,
.mailbox .table-mailbox tr > td > .glyphicon.glyphicon-star-empty {
  color: #f39c12;
  cursor: pointer;
}
.mailbox .table-mailbox tr > td.small-col {
  width: 30px;
}
.mailbox .table-mailbox tr > td.name {
  width: 150px;
  font-weight: 600;
}
.mailbox .table-mailbox tr > td.time {
  text-align: right;
  width: 100px;
}
.mailbox .table-mailbox tr > td {
  white-space: nowrap;
}
.mailbox .table-mailbox tr > td > a {
  color: #444;
}
@media screen and (max-width: 767px) {
  .mailbox .nav-stacked > li:not(.header) {
    float: left;
    width: 50%;
  }
  .mailbox .nav-stacked > li:not(.header).header {
    border: 0!important;
  }
  .mailbox .search-form {
    margin-top: 10px;
  }
}
</style>
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Vista de estados de los trámites por área
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Vista de estados de los trámites por área</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->

            <div class="mailbox row">
                <div class="col-md-12">
                    <div class="row pad">
                        <div class="col-sm-6">
                            <label style="margin-right: 10px;">
                                <input type="checkbox" id="check-all"/>
                            </label>
                            <!-- Action button -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Mark as read</a></li>
                                    <li><a href="#">Mark as unread</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Move to junk</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Delete</a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-sm-6 search-form">
                            <form action="#" class="text-right">
                                <div class="input-group">
                                    <input type="text" class="form-control input-sm" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button type="submit" name="q" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.row -->

                    <div class="table-responsive">
                        <!-- THE MESSAGES -->
                        <table class="table table-mailbox" id="t_reporte">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Tramite</th>
                                    <th>Tiempo</th>
                                    <th>Fecha Inicio</th>
                                    <th>Orden</th>
                                    <th>Fecha tramite</th>
                                    <th>Nombre</th>
                                    <th>Respuesta</th>
                                    <th>observacion</th>
                                    <th>Tipo solicitante</th>
                                    <th>Solicitante</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="tb_reporte">
                                
                                
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.col (RIGHT) -->
            </div>
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
