<script type="text/javascript">
var ProgramacionG={id:0,direccion:"",fecha_programada:"",vehiculo_id:0,persona_id:0,persona:""}; // Datos Globales
var TipoCargaPersona=0;
var CargarTexto='';
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
    
    $("#guardar_masivo").click(function (){
            Reporte.modificarProgramacionmasivo();
    });

    $("#limpiar").click(function (){
        $('#form_reporte input').not('.checkbox').val('');
        
        $("#tb_ordenest").html('');
        $('#div_detalle').hide();
        $("#tb_deta").html(html);
    });
    
    $('#programacionModal').on('show.bs.modal', function (event) {
        var modal=$(this);
        modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
        $("#form_programacion_modal").append("<input type='hidden' value='"+ProgramacionG.id+"' name='id'>");
        $('#form_programacion_modal #txt_direccion').val( ProgramacionG.direccion );
        $('#form_programacion_modal #txt_programada').val( ProgramacionG.fecha_programada );
        $('#form_programacion_modal #txt_persona_id').val( ProgramacionG.persona_id );
        $('#form_programacion_modal #slct_vehiculo').val( ProgramacionG.vehiculo_id );
        $('#form_programacion_modal #txt_persona').val( ProgramacionG.persona );
    });

    $('#programacionModal').on('hide.bs.modal', function (event) {
         $('#form_areas_modal input').val('');
    });
    
    $(document).on('click', '#btnPersona', function(event) {
            TipoCargaPersona=0;
            Reporte.GetPersons({'apellido_nombre':1},HTMLPersonas);
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
                    "<td width='6%'><input type='hidden' value='"+d.rdm_id+"' name='id[]'><select class='form-control slct_vehiculo' name='slct_vehiculo[]' id='slct_vehiculo'>"+
                    "</select></td>"+
                    "<td width='6%'><input type='hidden' class='form-control' name='txt_persona_id[]' id='txt_persona_id' readonly=''>"+
                    "<input type='text' class='form-control' name='txt_persona' id='txt_persona' disabled=''>"+
                    "<button type='button' class='btn btn-info' onClick='btnPersona_masivo(this)'>Buscar Persona</button></td>";
            html+="</tr>";

            if($.trim(d.vehiculo_id) == '' || $.trim(d.persona_id) == '') {
                btn_f_progra = 'insertar';
                icon_mk = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
            } else {
                btn_f_progra = 'modificar';
                icon_mk = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'; //purple-dot.png, yellow-dot.png, green-dot.png
            }
            
            // Gmaps
//            conten_market = '<div style="text-align:center; width: 100%;"><h3>'+d.tipo+'</h3>'+
//                                  '<p>'+d.direccion+'</p>'+
//                              '</div>'+
//                              '<div style="width: 100%;">'+
//                                '<div style="text-align:center; width: 45%; float: left;">'+
//                                  '<a href="'+d.foto+'" target="_blank"><img src="'+d.foto+'" width="90"/></a>'+
//                                '</div>'+
//                                '<div style="text-align:center; width: 55%; float: right;">'+
////                                  '<p><strong>Fecha inicio:</strong> '+d.fecha_inicio+'</p>'+
//                                  '<p><strong>Fecha programada:</strong> '+d.fecha_programada+'</p>'+
//                                  '<p><strong>Vehiculo:</strong><select class="form-control" id="slct_vehiculo" name="slct_vehiculo">'+vehiculos+'</select></p>';
//                                  '<p><strong>Fec. programada</strong> </br> <input type="date" id="txt_fecha_programada'+d.id+'" name="txt_fecha_programada'+d.id+'" value="'+d.fecha_programada+'" style="cursor: pointer;"></p>';
//                if(btn_f_progra == 'insertar')
//                    conten_market += "<p><input type='button' style='background-color: #1A6FA5; color: white; padding: 4px 11px; border: 0px;' name='btnguardarMaps' id='btnguardarMaps' onclick=\"guardarDesmonte("+d.ruta_id+", "+d.id+", "+d.carga_incidencia_id+", '"+d.fecha_inicio+"');\" value='Guardar'></p>";
//                else // modificar
//                    conten_market += "<p><input type='button' style='background-color: #e48317; color: white; padding: 4px 11px; border: 0px; name='btnguardarMaps' id='btnguardarMaps' onclick=\"modificarDesmonte("+d.rdm_id+", "+d.ruta_id+", "+d.id+", "+d.carga_incidencia_id+", '"+d.fecha_inicio+"');\" value='Modificar'></p>";
//                
//                conten_market += '</div>'+
//                              '</div>';            

            map.addMarker({
                icon: icon_mk,
                lat: d.latitud,
                lng: d.longitud,
                title: d.direccion,
//                infoWindow: {
//                  //content: '<p><strong>'+d.tipo+'</strong></br><img src="http://www.muniindependencia.gob.pe/sicmovil/fotoed/29447.jpg" border="0" width="60"></p>'
////                  content : conten_market
//                },
                click: function (e) {
                    Detalle(d.rdm_id,d.direccion,d.fecha_programada,d.persona_id,d.vehiculo_id,d.persona);
                },
            });
            // --
        });
        
        $("#tb_ordenest").html(html);
        $("#t_ordenest").dataTable();
        Reporte.listarvehiculo();
        // --
    }else{
        $("#tb_ordenest").html("");
        $("#tb_regimen").html("");
    }
};

Editar=function(){
    if(validaProgramacion()){
        Reporte.modificarProgramacion();
    }
};

Detalle=function(id,direccion,fecha_programada,persona_id,vehiculo_id,persona){
    ProgramacionG.id=id;
    ProgramacionG.direccion=direccion;
    ProgramacionG.fecha_programada=fecha_programada;
    ProgramacionG.persona_id=persona_id;
    ProgramacionG.vehiculo_id=vehiculo_id;
    ProgramacionG.persona=persona;
    $("#programacionModal").modal("show");
}
mostrarListaHTML=function(datos){
    $(".slct_vehiculo").html("");
    $(".slct_vehiculo").append(datos);
//    slctGlobalHtml("form_programacion_modal #slct_vehiculo","simple");
}

HTMLPersonas = function(data){
     $('#t_persona').dataTable().fnDestroy();
    if(data.length > 1){
        var html = '';
        $.each(data,function(index, el) {
            html+='<tr id='+el.id+'>';
            html+='<td name="ruc">'+el.name+'</td>';
            html+='<td name="tipo_id">'+el.paterno+'</td>';
            html+='<td name="razon_social">'+el.materno+'</td>';
            html+='<td name="nombre_comercial">'+el.dni+'</td>';
            html+='<td name="direccion_fiscal">'+el.email+'</td>';
           /* html+='<td name="telefono">'+el.telefono+'</td>';*/
            html+='<td><span class="btn btn-primary btn-sm" id-user='+el.id+' onClick="selectUser(this)">Seleccionar</span></td>';
            html+='</tr>';
        });
        $('#tb_persona').html(html);
        $("#t_persona").dataTable(); 
        $('#selectPersona').modal('show'); 
    }else{
        $(".empresa").addClass('hidden');
        alert('Error');
    }
},
selectUser = function(obj){
    var iduser = obj.getAttribute('id-user');
    if(iduser){
        Reporte.GetPersonabyId({persona_id:iduser});
        $('#selectPersona').modal('hide');
    }else{
        alert('Seleccione persona');
    }
    },
poblateData = function(tipo,data){
    if(tipo== 'selectpersona'){
        if(TipoCargaPersona==0){
            $('#form_programacion_modal #txt_persona_id').val(data.id);
            $('#form_programacion_modal #txt_persona').val(data.nombre+" "+data.paterno+" "+data.materno);
        }else{
            var input=CargarTexto.parentNode;
            $(input).find("input[id='txt_persona_id']").val(data.id);
            $(input).find("input[id='txt_persona']").val(data.nombre+" "+data.paterno+" "+data.materno);
        }
    }

},
validaProgramacion=function(){
    var r=true;
    if( $("#form_programacion_modal #slct_vehiculo").val()=='' ){
        alert("Seleccione Vehiculo");
        return false;
    }
    if( $("#form_programacion_modal #txt_persona_id").val()=='' || $("#form_programacion_modal #txt_persona").val()=='' ){
        alert("Seleccione Persona");
        return false;
    }

    return r;
};

btnPersona_masivo= function(obj) {
        CargarTexto=obj;
        TipoCargaPersona=1;
        Reporte.GetPersons({'apellido_nombre':1},HTMLPersonas);
};
</script>
