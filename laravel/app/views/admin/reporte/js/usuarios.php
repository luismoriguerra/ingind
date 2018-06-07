<script type="text/javascript">
$(document).ready(function() {
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('areauser','slct_area_id','multiple',ids,data);
    $("#generar").click(function (){
        area_id = $('#slct_area_id').val();
        if ($.trim(area_id)!=='') {
            data = {area_id:area_id};
            Usuario.mostrar(data);
            $('#op_2').text('CARGANDO..');
            Usuario.mostrarReporte2(data);
        } else {
            alert("Seleccione Área");
        }
    });

     $("#btnprintuserall").click(function (){
        area_id = $('#slct_area_id').val();
        if ($.trim(area_id)!=='') {
            openPlantillaArea(area_id,4,0);
        } else {
            alert("Seleccione Área");
        }
    });
});

$(document).on('click', '#btnexport', function(event) {
    var area=$("#slct_area_id").val();
    if ( area!=="") {
            $(this).attr('href','reporte/exportusuarios'+'?area_id='+$("#slct_area_id").val().join("','")+'&export=1');
    } else {
            alert("Seleccione area");
    }
});


HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+data.paterno+"</td>"+
            "<td>"+data.materno+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.email+"</td>"+
            "<td>"+data.dni+"</td>"+
            "<td>"+data.fecha_nacimiento+"</td>"+
            "<td>"+data.sexo+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.area+"</td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#t_reporte").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"],[2, "asc"]],
        }
    ); 
    $("#reporte").show();
};


HTMLreporte2=function(datos, qr){    
    var html="";    
    var alerta_tipo= '';
    var pos=0;
    $.each(datos,function(index,data){
        pos++;

        if(data.estado == 'Activo') {
            class_estado = 'label label-success';
            text_estado = 'ACTIVO';
        } else {
            class_estado = 'label label-danger';
            text_estado = 'INACTIVO';
        }
        
        var img_qr = Usuario.obtenerQRUser(data.area_id, data.dni,4,0); // Obtengo los QR por User

        html+='<div class="col-md-12">';        
            html+='<div class="col-md-5">'+
                    '<h3>'+data.nombre+' '+data.paterno+' '+data.materno+'</h3>'+
                    //'<h3>'+data.paterno+' '+data.materno+'</h3>'+
                    '<h5><span class="label label-default">&nbsp;E-mail&nbsp;</span> '+data.email+'</h5>'+
                    '<h5><span class="label label-default">&nbsp;DNI&nbsp;</span> '+data.dni+'</h5>';
            html+="</div>";
            html+='<div class="col-md-4 text-center">'+
                    '<h4>'+data.area+'</h4>'+
                    '<p><span class="'+class_estado+'" style="padding: 8px; font-size: 12px;">'+text_estado+'</span></p>';
            html+="</div>";
            html+='<div class="col-md-3 text-center">'+
                    '<p id="uqr'+data.dni+'">'+img_qr+'</p>'+
                    '<p><a class="btn btn-danger btn-xs" href="#" onclick="openPlantilla('+data.area_id+',\''+data.dni+'\',4,0); return false;" data-titulo="Previsualizar"><i class="fa fa-print"></i>&nbsp;PRINT</a></p>';
            html+="</div>";

        html+='</div>';
    });
    $("#reporte2").html(html);
    $("#reporte2").show();
    $('#op_2').text('OPCION 2')
};

openPlantilla=function(area_id,dni,tamano,tipo){
    window.open("documentodig/vistauserqr/"+area_id+"/"+dni+"/"+tamano+"/"+tipo,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};

openPlantillaArea=function(area_id,tamano,tipo){
    window.open("documentodig/vistatodosuserqr/"+area_id+"/"+tamano+"/"+tipo,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=1200,height=700");
};


eventoSlctGlobalSimple=function(slct,valores){
};
</script>
