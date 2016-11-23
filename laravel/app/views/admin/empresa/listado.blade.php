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
            <div>
                <ul id="myTab" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a  href="#mis">Mis empresas</a>
                    </li>
                    <li role="presentation">
                        <a  href="#afiliadas">Empresas Afiliadas</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="mis">
                    <div class="box box-solid">
                    <div id="misempresas">
                        <spinner id="spinner-box" :size="size" :fixed="fixed" v-show="loaded" text="Espere un momento por favor"></spinner>
                        <div class="alert alert-success" transition="success" v-if="success">@{{ msj }} </div>

                        <div class="form-group">
                            <div class="row form-group form-inline">
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <button type="button" class="btn btn-primary btn-sm"  @click="New">Nuevo</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="control-group pull-right">
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
                                api-url="empresa"
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
                            <div class="control-group pull-right">
                                <select class="form-control input-sm" v-model="perPage">
                                    <option value=5>5</option>
                                    <option value=10>10</option>
                                    <option value=15>15</option>
                                    <option value=20>20</option>
                                    <option value=25>25</option>
                                </select>
                            </div>
                        </div>
                        @include( 'admin.empresa.form.listado' ) 
                    </div>
                    <div id="personas">
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
                    </div>

                    </div><!-- /.box -->
                </div>



                <div class="tab-pane fade" id="afiliadas">
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
                                detail-row-component="my-detail-row"
                                detail-row-id="id"
                                detail-row-transition="expand"
                                row-class-callback="rowClassCB"
                            ></vuetable>
                            <div class="control-group pull-right">
                                <select class="form-control input-sm" v-model="perPage">
                                    <option value=5>5</option>
                                    <option value=10>10</option>
                                    <option value=15>15</option>
                                    <option value=20>20</option>
                                    <option value=25>25</option>
                                </select>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </div>
    </div>
    @include( 'admin.empresa.js.misempresas' )
    @include( 'admin.empresa.js.afiliadas' )
    @include( 'admin.empresa.js.personas_misempresas' )
</section><!-- /.content -->
@stop

