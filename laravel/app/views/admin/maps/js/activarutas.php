<script type="text/javascript">
$(document).ready(function() {

    //$("[data-toggle='offcanvas']").click();

    $(".fecha").datetimepicker({
        format: "yyyy/mm/dd",
        language: 'es',
        showMeridian: false,
        time: false,
        minView: 3,
        startView: 2, // 1->hora, 2->dia , 3->mes
        autoclose: true,
        todayBtn: false
    });

    $('#div_detalle').hide();

    $('#spn_fecha_ini').click(function(){
        $('#fecha_ini').focus();
    });
    $('#spn_fecha_fin').click(function(){
        $('#fecha_fin').focus();
    });

    $("#generar").click(function (){
        if( $.trim($("#fecha_ini").val())!=='' &&
            $.trim($("#fecha_fin").val())!=='')
        {
            dataG = $('#form_reporte').serialize().split("txt_").join("").split("slct_").join("");
            Reporte.MostrarReporte(dataG);
        }
        else
        {
            swal("Mensaje", "Por favor ingrese las fechas de busqueda!");
        }
    });

    $("#limpiar").click(function (){
        $('#form_reporte input').not('.checkbox').val('');
        
        $("#tb_ordenest").html('');
        $('#div_detalle').hide();
        $("#tb_deta").html(html);
    });

    $(document).on('click', '#btnexport', function(event) {
        if( $.trim($("#fecha_ini").val())!=='' &&
            $.trim($("#fecha_fin").val())!=='')
        {
            var fecha_ini = $("#fecha_ini").val();
            var fecha_fin = $("#fecha_fin").val();
            var area = $("#slct_area_ws").val();

            if(area != '0')
                area = '&area='+area;
            else
                area = '';

            swal({   
                    title: "Reporte de Personal",   
                    text: "Por favor espere mientras carga el Reporte...",   
                    timer: 5000,   
                    showConfirmButton: false 
            });
            //$(this).attr('href','reportepersonal/exportreportepersonal'+'?fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+area);
            window.location = 'reportepersonal/exportreportepersonal'+'?fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+area;

        }else{
            swal("Mensaje", "Por favor ingrese las fechas de busqueda!");
            event.preventDefault();
        }
    });

    
});


HTMLMostrarReporte=function(data){    
    $('#t_ordenest').dataTable().fnDestroy();

    if(data.datos.length > 0){
        
        var latitud = '';
        var longitud = '';
        $.each(data.lat_lng,function(index,d){
            latitud = d.latitud;    // Obtiene máxima Latitud
            longitud = d.longitud;  // Obtiene máxima Longitud
        });

        // Gmaps
        var map;
        map = new GMaps({
            el: '#map',
            lat: latitud,
            lng: longitud
        });
        // --

        var html = '';
        var conten_market = '';
        var icon_mk = '';
        var btn_f_progra = '';
        $.each(data.datos,function(index,d){
                
            html+="<tr style='font-size: 12px;'>"+
                    '<td width="3%">'+d.id+'</td>'+
                    "<td width='14%'>"+d.id_union+"</td>"+
                    "<td width='7%'>"+d.fecha_tramite+"</td>"+
                    "<td width='7%'>"+d.fecha_inicio+"</td>"+
                    "<td width='5%'>"+d.tipo+"</td>"+
                    "<td width='6%'>"+d.viapredio+"</td>"+
                    "<td width='6%'>"+d.latitud+"</td>"+
                    "<td width='6%'>"+d.longitud+"</td>";
            html+="</tr>";

            if($.trim(d.fecha_programada) == 0) {
                btn_f_progra = 'insertar';
                icon_mk = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
            } else {
                btn_f_progra = 'modificar';
                icon_mk = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'; //purple-dot.png, yellow-dot.png, green-dot.png
            }
            
            // Gmaps
            conten_market = '<div style="text-align:center; width: 100%;"><h3>'+d.tipo+'</h3>'+
                                  '<p>'+d.direccion+'</p>'+
                              '</div>'+
                              '<div style="width: 100%;">'+
                                '<div style="text-align:center; width: 45%; float: left;">'+
                                  '<a href="'+d.foto+'" target="_blank"><img src="'+d.foto+'" width="90"/></a>'+
                                '</div>'+
                                '<div style="text-align:center; width: 55%; float: right;">'+
                                  '<p><strong>Fecha inicio:</strong> '+d.fecha_inicio+'</p>'+
                                  '<p><strong>Fec. programada</strong> </br> <input type="date" id="txt_fecha_programada'+d.id+'" name="txt_fecha_programada'+d.id+'" value="'+d.fecha_programada+'" style="cursor: pointer;"></p>';
                if(btn_f_progra == 'insertar')
                    conten_market += "<p><input type='button' style='background-color: #1A6FA5; color: white; padding: 4px 11px; border: 0px;' name='btnguardarMaps' id='btnguardarMaps' onclick=\"guardarDesmonte("+d.ruta_id+", "+d.id+", "+d.carga_incidencia_id+", '"+d.fecha_inicio+"');\" value='Guardar'></p>";
                else // modificar
                    conten_market += "<p><input type='button' style='background-color: #e48317; color: white; padding: 4px 11px; border: 0px; name='btnguardarMaps' id='btnguardarMaps' onclick=\"modificarDesmonte("+d.rdm_id+", "+d.ruta_id+", "+d.id+", "+d.carga_incidencia_id+", '"+d.fecha_inicio+"');\" value='Modificar'></p>";
                
                conten_market += '</div>'+
                              '</div>';            

            map.addMarker({
                icon: icon_mk,
                lat: d.latitud,
                lng: d.longitud,
                title: d.direccion,
                infoWindow: {
                  //content: '<p><strong>'+d.tipo+'</strong></br><img src="http://www.muniindependencia.gob.pe/sicmovil/fotoed/29447.jpg" border="0" width="60"></p>'
                  content : conten_market
                }
            });
            // --
        });

        $("#tb_ordenest").html(html);
        $("#t_ordenest").dataTable();

        // --
    }else{
        $("#tb_ordenest").html("");
        $("#tb_regimen").html("");
    }
};


guardarDesmonte=function(ruta_id, ruta_detalle_id, carga_incidencia_id, fecha_inicio){
    //alert($("#txt_fecha_programada"+ruta_detalle_id).val());
    var fecha_programada = $("#txt_fecha_programada"+ruta_detalle_id).val();
    if(fecha_programada == '') {
        swal("Mensaje", "Por favor ingrese la fecha Programada!");
    } else {
        var dataG={ ruta_id : ruta_id, 
                    ruta_detalle_id : ruta_detalle_id,
                    carga_incidencia_id : carga_incidencia_id,
                    fecha_inicio : fecha_inicio,
                    fecha_programada : fecha_programada };
        Reporte.grabarRutaDetaMaps(dataG);

        $("#generar").click();
    }
    
};

modificarDesmonte=function(id, ruta_id, ruta_detalle_id, carga_incidencia_id, fecha_inicio){
    var fecha_programada = $("#txt_fecha_programada"+ruta_detalle_id).val();
    if(fecha_programada == '') {
        swal("Mensaje", "Por favor ingrese la fecha Programada!");
    } else {
        var dataG={ id : id,
                    ruta_id : ruta_id, 
                    ruta_detalle_id : ruta_detalle_id,
                    carga_incidencia_id : carga_incidencia_id,
                    fecha_inicio : fecha_inicio,
                    fecha_programada : fecha_programada };
        Reporte.modificarRutaDetaMaps(dataG);

        $("#generar").click();
    }
};

</script>
