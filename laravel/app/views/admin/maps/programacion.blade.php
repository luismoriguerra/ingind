<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    <!-- {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }} -->

    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
    {{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
    {{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}
    
    {{ HTML::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyCxS6Bw_xqMl2zaSOgplzZtzhgx6L8QYkY') }}
    {{ HTML::script('lib/gmaps.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.maps.js.activarutas_ajax' )
    @include( 'admin.maps.js.activarutas' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
<style type="text/css">
.table_nv {
    overflow:hidden;
    border:1px solid #fefefe;
    background:#fefefe;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:5px;
    -moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
    -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
}
th, td {padding:18px 28px 18px; text-align:center; /*border-color: #666666 !important;*/ }
th {padding-top:22px; text-shadow: 0px 0px 1px #fff; background:#e8eaeb;}
td {border-top:1px solid #fefefe; border-right:1px solid #fefefe;}
tr.odd-row td {background:#f6f6f6;}
td.first, th.first {text-align:left}
td.last {border-right:none;}

td {
    background: -moz-linear-gradient(100% 25% 90deg, #fefefe, #f9f9f9);
    background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f9f9f9), to(#fefefe));
}
tr.odd-row td {
    background: -moz-linear-gradient(100% 25% 90deg, #f6f6f6, #f1f1f1);
    background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f1f1f1), to(#f6f6f6));
}

tr:first-child th.first {
    -moz-border-radius-topleft:5px;
    -webkit-border-top-left-radius:5px; /* Saf3-4 */
}
tr:first-child th.last {
    -moz-border-radius-topright:5px;
    -webkit-border-top-right-radius:5px; /* Saf3-4 */
}
tr:last-child td.first {
    -moz-border-radius-bottomleft:5px;
    -webkit-border-bottom-left-radius:5px; /* Saf3-4 */
}
tr:last-child td.last {
    -moz-border-radius-bottomright:5px;
    -webkit-border-bottom-right-radius:5px; /* Saf3-4 */
}


/* GOOGLE MAPS */
#map{
  display: block;
  width: 98%;
  height: 500px;
  margin: 0 auto;
  -moz-box-shadow: 0px 5px 20px #ccc;
  -webkit-box-shadow: 0px 5px 20px #ccc;
  box-shadow: 0px 5px 20px #ccc;
}
#map.large{
  height:500px;
}

.overlay{
  display:block;
  text-align:center;
  color:#fff;
  font-size:60px;
  line-height:80px;
  opacity:0.8;
  background:#4477aa;
  border:solid 3px #336699;
  border-radius:4px;
  box-shadow:2px 2px 10px #333;
  text-shadow:1px 1px 1px #666;
  padding:0 4px;
}

.overlay_arrow{
  left:50%;
  margin-left:-16px;
  width:0;
  height:0;
  position:absolute;
}
.overlay_arrow.above{
  bottom:-15px;
  border-left:16px solid transparent;
  border-right:16px solid transparent;
  border-top:16px solid #336699;
}
.overlay_arrow.below{
  top:-15px;
  border-left:16px solid transparent;
  border-right:16px solid transparent;
  border-bottom:16px solid #336699;
}

</style>

    <section class="content-header">
        <h1>
            Rutas activas proceso Desmonte
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Rutas Activas</li>
        </ol>
    </section>

      <!-- Main content -->
      <section class="content">
          <!-- Inicia contenido -->
          <div class="box">
              <form id="form_reporte" name="form_reporte" method="post">

                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                                <div class="col-sm-3"></div>
                               
                                <div class="col-sm-2 text-center">
                                    <label class="control-label">Fecha Inicial</label>
                                    <div class="input-group">
                                      <span id="spn_fecha_ini" class="input-group-addon" style="cursor: pointer;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                      <input type="text" class="form-control fecha" placeholder="AAAA/MM/DD" id="fecha_ini" name="fecha_ini" readonly/>
                                    </div>
                                </div>
                              
                                <div class="col-sm-2 text-center">
                                    <label class="control-label">Fecha Final</label>
                                    <div class="input-group">
                                      <span id="spn_fecha_fin" class="input-group-addon" style="cursor: pointer;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                      <input type="text" class="form-control fecha" placeholder="AAAA/MM/DD" id="fecha_fin" name="fecha_fin" readonly/>
                                    </div>
                                </div>

                                <div class="col-sm-1" style="padding:24px; ">
                                    <span class="btn btn-primary btn-md" id="generar" name="generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                                </div>
                                <!--
                                <div class="col-sm-1" style="padding:24px;">                                    
                                    <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='#'><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                </div>
                                -->
                            </div>
                    </div>                    
                </fieldset>
              
              
                  <div class="row form-group" id="reporte" >
                    <div class="col-sm-12">
                      <div class="box-body table-responsive">
                         <table id="t_ordenest" class="table table-bordered table_nv">
                            <thead>                             
                              <tr class="active" style="font-size: 12px;">
                                  <th style="background-color: #357ca5; color: #fff;" width="3%">#</th>
                                  <th style="background-color: #357ca5; color: #fff;" width="14%">COMUNICADO</th>
                                  <th style="background-color: #357ca5; color: #fff;" width="7%">FECHA TRAMITE</th>
                                  <th style="background-color: #357ca5; color: #fff;" width="7%">FECHA INICIO</th>
                                  <th style="background-color: #357ca5; color: #fff;" width="7%">TIPO</th>
                                  <th style="background-color: #357ca5; color: #fff;" width="5%">VIAPREDIO</th>
                                  <th style="background-color: #357ca5; color: #fff;" width="6%">LATITUD</th>
                                  <th style="background-color: #357ca5; color: #fff;" width="6%">LONGITUD</th>                                  
                               </tr>
                            </thead>
                            <tbody id="tb_ordenest">
                            </tbody>
                         </table>
                        </div>
                    </div>
                 </div>                 
              </form>

              
              <div id="map"></div>
      </div>
      <!-- Finaliza contenido -->

  </section><!-- /.content -->
  
  <script type="text/javascript">
  /*
    var map;
    $(document).ready(function(){
      map = new GMaps({
        el: '#map',
        lat: -12.043333,
        lng: -77.028333
      });

      map.addMarker({
        lat: -12.043333,
        lng: -77.03,
        title: 'Lima',
        infoWindow: {
          content: '<p>HTML LIMA</p>'
        }
      });

      map.addMarker({
        lat: -12.042,
        lng: -77.028333,
        title: 'Marker with InfoWindow',
        infoWindow: {
          content: '<p>HTML Content</p>'
        }
      });
    });
  */
  </script>
@stop
@section('formulario')
@stop
