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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.min.js') }}
    {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.2/vue-resource.min.js') }}
    {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue-strap/1.0.11/vue-strap.min.js') }}
    <script src="http://pajhome.org.uk/crypt/md5/2.2/md5-min.js"></script>


    <script src="/js/vue-table.js"></script>





@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Lista de empresas
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Empresa</a></li>
        <li class="active">Lista de empresas</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    
    <div class="row form-group">
        <div class="col-sm-12">
                <div  id="misempresas">
                    <spinner id="spinner-box" :size="size" :fixed="fixed" v-show="loaded" text="Espere un momento por favor"></spinner>
                    <div class="box box-solid">
                        <div class="alert alert-success" transition="success" v-if="success">@{{ msj }} </div>

                        <div class="form-group">
                            <div class="row form-group form-inline">
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <label class="control-label">Buscar:</label>
                                        <input v-model="searchFor" class="form-control input-sm" @keyup.enter="setFilter">
                                        <button class="btn btn-primary btn-sm" @click="setFilter">Go</button>
                                        <button class="btn btn-default btn-sm" @click="resetFilter">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <vuetable v-ref:vuetable id="empresas"
                                api-url="empresapersona/index"
                                data-path="data"
                                pagination-path=""
                                :fields="fields"
                                :sort-order="sortOrder"
                                :multi-sort="multiSort"
                                table-class="table table-bordered table-striped table-hover"
                                ascending-icon="glyphicon glyphicon-chevron-up"
                                descending-icon="glyphicon glyphicon-chevron-down"
                                pagination-class=""
                                pagination-info-class=""
                                pagination-component-class=""
                                :pagination-component="paginationComponent"
                                :item-actions="itemActions"
                                :append-params="moreParams"
                                :per-page="perPage"
                                wrapper-class="vuetable-wrapper"
                                table-wrapper=".vuetable-wrapper"
                                loading-class="loading"
                                row-class-callback="rowClassCB"
                            ></vuetable>
                        </div>
                        <div class="form-group">
                            <div class="row form-group form-inline">
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <button type="button" class="btn btn-primary btn-sm"  @click="New">Nueva Empresa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include( 'admin.empresa.form.mdi' ) 
                    </div><!-- /.box -->
                </div>
                <div id="afiliadas">
                    <spinner id="spinner-box" :size="size" :fixed="fixed" v-show="loaded" text="Espere un momento por favor"></spinner>
                    <div class="box box-solid">
                        <div class="alert alert-success" transition="success" v-if="success">@{{ msj }} </div>

                        <div class="form-group">
                            <div class="row form-group form-inline">
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <label class="control-label">Buscar:</label>
                                        <input v-model="searchFor" class="form-control input-sm" @keyup.enter="setFilter">
                                        <button class="btn btn-primary btn-sm" @click="setFilter">Go</button>
                                        <button class="btn btn-default btn-sm" @click="resetFilter">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <vuetable v-ref:vuetable
                                api-url="empresapersona/afiliados"
                                data-path="data"
                                pagination-path=""
                                :fields="fields"
                                :sort-order="sortOrder"
                                :multi-sort="multiSort"
                                table-class="table table-bordered table-striped table-hover"
                                ascending-icon="glyphicon glyphicon-chevron-up"
                                descending-icon="glyphicon glyphicon-chevron-down"
                                pagination-class=""
                                pagination-info-class=""
                                pagination-component-class=""
                                :pagination-component="paginationComponent"
                                :item-actions="itemActions"
                                :append-params="moreParams"
                                :per-page="perPage"
                                wrapper-class="vuetable-wrapper"
                                table-wrapper=".vuetable-wrapper"
                                loading-class="loading"
                                detail-row-component="my-detail-row"
                                detail-row-id="id"
                                detail-row-transition="expand"
                                row-class-callback="rowClassCB"
                            ></vuetable>
                        </div>
                        <div class="form-group">
                            <div class="row form-group form-inline">
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <button class="btn btn-primary btn-sm" :disabled="empresaSelec.id? false:true" data-toggle="modal" data-target="#personasModal">
                                            Agregar Personal @{{empresaSelec.nombre_comercial}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include( 'admin.empresa.form.personas' ) 
                    </div><!-- /.box -->
                </div>
            
        </div>
    </div>
    @include( 'admin.empresa.js.mdimisempresas' )
    @include( 'admin.empresa.js.mdiafiliadas' )
</section><!-- /.content -->
@stop

