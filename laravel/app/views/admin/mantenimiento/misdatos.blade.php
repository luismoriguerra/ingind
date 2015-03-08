<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
@parent
    @include( 'admin.mantenimiento.js.misdatos' )
    @include( 'admin.mantenimiento.js.usuario_ajax' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        {{ trans('greetings.menu_info_actualizar') }}
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">{{ trans('greetings.menu_info') }}</a></li>
        <li class="active">{{ trans('greetings.menu_info_actualizar') }}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">                
            <!-- Inicia contenido -->
            <div class="row">

                <!-- form start -->
                <form role="form" method="post" action="" name="form_misdatos" id="form_misdatos">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <!-- <h3 class="box-title">Detalle</h3> -->
                            </div><!-- /.box-header -->

                            <div class="box-body">
                                <div class="form-group">
                                    <label>{{ trans('greetings.contraseña_nueva') }}:
                                        <a id="error_newpassword" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="">
                                            <i class="fa fa-exclamation"></i>
                                        </a>
                                    </label>
                                    <input type="password" class="form-control" id="txt_newpassword" name="txt_newpassword" placeholder="{{ trans('greetings.contraseña_nueva') }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('greetings.confirm_contraseña_nueva') }}:</label>
                                    <input type="password" class="form-control" id="txt_confirm_new_password" name="txt_confirm_new_password" placeholder="{{ trans('greetings.confirm_contraseña_nueva') }}">
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-asterisk"></i>&nbsp;{{ trans('greetings.ingrese_contraseña') }}:
                                        <a id="error_password" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="">
                                            <i class="fa fa-exclamation"></i>
                                        </a>
                                    </label>
                                    <input type="password" class="form-control" id="txt_password" name="txt_password" placeholder="{{ trans('greetings.ingrese_contraseña') }}">
                                </div>                                
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="button" class="btn btn-primary" id="btn_guardar"><i class='fa fa-save fa-lg'></i>&nbsp;&nbsp;{{ trans('greetings.save') }}</button>
                            </div>

                        </div>
                    </div><!--/.col (right) -->

                </form>
            </div>
            <!-- Finaliza contenido -->
        </div>
    </div>

</section><!-- /.content -->
@stop