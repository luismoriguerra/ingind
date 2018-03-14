<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
@parent
{{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
{{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
{{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
{{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
{{ HTML::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyCxS6Bw_xqMl2zaSOgplzZtzhgx6L8QYkY') }}
{{ HTML::script('lib/gmaps.js') }}

@include( 'admin.js.slct_global_ajax' )
@include( 'admin.js.slct_global' )
@include( 'admin.procesos.js.qr_ajax' )
@include( 'admin.procesos.js.qr' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        CODIGO QR
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Reporte</a></li>
        <li class="active">CODIGO QR</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <form method="post" id="geocoding_form">
        <label for="address">Address:</label>
        <div class="input">
            <input type="text" id="address" name="address" />
            <input type="submit" class="btn" value="Search" />
        </div>
    </form>
    <div id="map" style="width: 400px;height: 400px"></div>
    <div class="span3">
        <h3>Puntos</h3>
        <ul id="markers-with-coordinates">
        </ul>
    </div>
    <script>
        map = new GMaps({
            el: '#map',
            lat: -12.043333,
            lng: -77.028333
        });
        $('#geocoding_form').submit(function (e) {
            e.preventDefault();
            direccion = $('#address').val().trim();
            GMaps.geocode({
                address: direccion,
                callback: function (results, status) {
                    if (status == 'OK') {
                        var latlng = results[0].geometry.location;
                        map.setCenter(latlng.lat(), latlng.lng());
                        map.addMarker({
                            lat: latlng.lat(),
                            lng: latlng.lng(),
                            title: direccion,
                            infoWindow: {
                                content: '<b>' + direccion + '</b><br><button onClick="deleteMarkers()">Eliminar Marcador</button>'
                            },
                        });
                      //  $('#markers-with-coordinates').append('<li><a href="#" class="pan-to-marker" data-marker-lat="' + latlng.lat() + '" data-marker-lng="' + latlng.lng() + '">' + direccion + '</a></li>');

                    }
                }
            });
        });

        GMaps.on('marker_added', map, function (marker) {
            $('#markers-with-coordinates').append('<li><a href="#" class="pan-to-marker" data-marker-lat="' + marker.getPosition().lat() + '" data-marker-lng="' + marker.getPosition().lng() + '">' + marker.title + '</a></li>');
        });

        $(document).on('click', '.pan-to-marker', function (e) {
            e.preventDefault();
            var lat = $(this).data('marker-lat');
            var lng = $(this).data('marker-lng');
            map.setCenter(lat, lng);
        });

    </script>
</section><!-- /.content -->
@stop
