<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}

    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}

    {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ HTML::script('lib/jquery-form/jquery-form.js') }} 

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    
 
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->    
     <section class="content-header">
        <h1>
            GOOGLE MAPS
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Google Maps</li>
        </ol>
    </section>

    <style>
      #map {
        height: 400px;
        width: 100%;
      } 
    </style>

    <!-- <div id="map"></div> -->


    <section class="content-header">
        <h1>
            GMAPS
            <small> </small>
        </h1>
    </section>
    <div id="map"></div>
    <script type="text/javascript">
    	
    	var map;
		function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
		  center: {lat: -11.9972306, lng: -77.05471349999999},
		  zoom: 18
		});
		}
		

		/*
	    var map;
	    $(document).ready(function(){
	      map = new GMaps({
	        el: '#map',
	        lat: -12.043333,
	        lng: -77.028333,
	        zoomControl : true,
	        zoomControlOpt: {
	            style : 'SMALL',
	            position: 'TOP_LEFT'
	        },
	        panControl : false,
	        streetViewControl : false,
	        mapTypeControl: false,
	        overviewMapControl: false
	      });
	    });
		*/
	  </script>

@stop

