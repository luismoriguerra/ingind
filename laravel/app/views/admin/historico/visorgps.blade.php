<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    @include( 'admin.historico.js.bandeja_ajax' )
    @include( 'admin.historico.js.visorgps_ajax' )
    @include( 'admin.historico.js.visorgps' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<style>
    .left {float: left;}
.right {float: right;}

.clearer {
	clear: both;
	display: block;
	font-size: 0;
	height: 0;
	line-height: 0;
}

/*
	Misc
------------------------------------------------------------------- */

.hidden {display: none;}


/*
	Example specifics
------------------------------------------------------------------- */

/* Layout */

#center-wrapper {
	margin: 0 auto;
	width: 920px;
}


/* Content & sidebar */

#mymap,#sidebar {
	text-align: center;
	border: 1px solid;
        height: 600px;
}

#sidebar {
        text-align: left;
	background-color: #DEF;
	border-color: #BCD;
	display: none;
        overflow: auto;
}
#mymap {
	background-color: #EFE;
	border-color: #CDC;
	width: 98%;
}

.use-sidebar #mymap {width: 69%;}
.use-sidebar #sidebar {
	display: block;
	width: 27%;
}

.sidebar-at-left #sidebar {margin-right: 1%;}
.sidebar-at-right #sidebar {margin-left: 1%;}

.sidebar-at-left #mymap, .use-sidebar.sidebar-at-right #sidebar, .sidebar-at-right #separator {float: right;}
.sidebar-at-right #mymap, .use-sidebar.sidebar-at-left #sidebar, .sidebar-at-left #separator {float: left;}

#separator {
	background-color: #EEE;
	border: 1px solid #CCC;
	display: block;
	outline: none;
	width: 1%;
}
.use-sidebar #separator {
	background: url('img/separator/vertical-separator.gif') repeat-y center top;
	border-color: #FFF;
}
#separator:hover {
	border-color: #ABC;
	background: #DEF;
}

</style>

<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=drawing"></script>
<script src="js/geo/geo.functions.js"></script>
<script src="js/utils.js"></script>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visor GPS
                    <small> </small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                    <li><a href="#">Historico</a></li>
                    <li class="active">Bandeja de Gestión</li>
                </ol>
            </section>
            
            <section>
                
            </section>
            
            <!-- Main content -->
            <section class="content">
                
                <form name="form_visorgps" id="form_visorgps" method="post" action="">
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <select class="form-control" name="slct_zonal[]" id="slct_zonal" multiple="multiple">
                                    <option selected="true">LIM</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="slct_actividad[]" id="slct_actividad" multiple="multiple"></select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="slct_estado[]" id="slct_estado" multiple="multiple">
                                    <option value="-1">Temporal</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="fecha_estado" id="fecha_estado" placeholder="fecha inicio">
                            </div>
                            <div class="col-sm-2">
                                <input type="button" class="form-control btn-danger" value="Limpiar TMP" id="btn_limpiar_tmp" name="btn_limpiar_tmp">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <select class="form-control" name="slct_empresa[]" id="slct_empresa"></select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="slct_celula[]" id="slct_celula"></select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="slct_quiebre[]" id="slct_quiebre" multiple="multiple"></select>
                            </div>
                            <div class="col-sm-2">
                                <input type="button" class="form-control" value="Buscar" name="btn_buscar" id="btn_buscar">
                            </div>
                            <div class="col-sm-2">
                                <input type="button" class="form-control btn-danger" value="Limpiar mapa" id="btn_limpiar_todo" name="btn_limpiar_todo">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-default" id="show_traffic" name="show_traffic">Mostrar tr&aacute;fico</button>
                            </div>
                        </div>
                    </div>
                    
                    
                </form>

                <div class="use-sidebar sidebar-at-left" id="main">

                    <div id="mymap">Content</div>

                    <div id="sidebar">
                        <button type="button" class="btn btn-default" name="btn_show_tec" id="btn_show_tec">
                            <i class="fa fa-users"></i> Tec.
                        </button>
                        <button type="button" class="btn btn-default" name="btn_show_pdt" id="btn_show_pdt">
                            <i class="fa fa-clock-o"></i> Pdte.
                        </button>
                        <button type="button" class="btn btn-default" name="btn_show_coo" id="btn_show_coo">
                            <i class="fa fa-phone"></i> Coord.
                        </button>
                        <!--
                        <button type="button" class="btn btn-default" name="btn_show_tmp" id="btn_show_tmp">
                            <i class="fa fa-warning"></i> Temp.
                        </button>
                        -->
                        <div id="tec-list"></div>
                    </div>

                    <a href="#" id="separator"></a>

                    <div class="clearer">&nbsp;</div>

                </div>

            </section><!-- /.content -->
@stop
