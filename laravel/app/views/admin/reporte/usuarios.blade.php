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
    @include( 'admin.reporte.js.usuarios_ajax' )
    @include( 'admin.reporte.js.usuarios' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Usuarios
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
                            <div class="col-md-1 col-sm-2" style="padding:24px">
                                <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div><!-- /.box -->


            <div class="box-body table-responsive">
                <ul class="nav nav-tabs">
                    <li class="active"><a id="op_1" data-toggle="tab" href="#home">LISTADO</a></li>
                    <li><a id="op_2" data-toggle="tab" href="#menu1">REPORTE QR</a></li>
                </ul>             

                <div class="tab-content">
                <div id="home" class="tab-pane fade in active" style="background-color: #fff;">
                  </br>
                        <div class="" style="">
                            <div class="row form-group" id="reporte" style="display:none;">
                                <div class="col-sm-12">
                                    <div class="box-body table-responsive">
                                        <table id="t_reporte" class="table table-bordered" style="width: 99%;">
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
                                                </tr>
                                            </thead>
                                            <tbody id="tb_reporte">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>                
                        </div><!-- /.box -->
                </div>
                <div id="menu1" class="tab-pane fade" style="background-color: #fff;">
                  </br>
                        <div class="" style="">
                            <button type="button" id="btnprintuserall" name="btnprintuserall" class="btn btn-primary" style="margin-left: 15px;"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> VISUALIZAR LISTA</button>
                            <div class="row" id="reporte2" style="display:none;">                                
                            </div>                
                        </div><!-- /.box -->
                </div>                
              </div>
            </div>



            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->



<div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fileModalLabel">Subir imagen del cargo.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" action="" method="POST" id="xFrm">
          <input type="file" id="cargo_comprobante" name="cargo_comprobante">
          <input type="hidden" id="file_dni" name="file_dni">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" onClick="sendImage();" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
 

<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showModalLabel">Soporte de nota de cargo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
          <img id="imgSw" src="" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@stop
