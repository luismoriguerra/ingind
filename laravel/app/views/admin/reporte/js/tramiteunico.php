<script type="text/javascript">

$(document).ready(function(){
    $("[data-toggle='offcanvas']").click();
    var data = {estado:1};
    var ids = [];
    $("#btn_close").click(Close);

    slctGlobal.listarSlct2('rol','slct_rol_modal',data);
    slctGlobal.listarSlct2('verbo','slct_verbo_modal',data);
    slctGlobal.listarSlct2('documento','slct_documento_modal',data);

    $("#generar_1").click(function (){
        reportet();
    });
});

valida=function(nro){
    var r=true;
    if( nro==1 ){
        if( $.trim( $("#txt_tramite_1").val() )=='' ){
            alert('Ingrese Trámite a buscar');
            $("#txt_tramite_1").focus();
            r=false;
        }
    }
    return r;
}

reportet=function(){
        $("#btn_close").click();
    if( valida(1) ){
        var datos=$("#form_1").serialize().split("txt_").join("").split("slct_").join("");
        Tramite.mostrar( datos,HTMLreportet,'t' );
        $("#reported_tab_"+Pest).hide();
    }
}

detalle=function(ruta_id, boton){
    $("#btn_close").click();
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";

    $("#form_"+Pest).append("<input type='hidden' id='txt_ruta_id' name='txt_ruta_id' value='"+ruta_id+"'>");
    var datos=$("#form_"+Pest).serialize().split("txt_").join("").split("slct_").join("");
    $("#form_"+Pest+" #txt_ruta_id").remove();
    Tramite.mostrar( datos,HTMLreported,'d' );
};

HTMLreportet=function(datos){
    var btnruta='';
    var html="";

    $("#t_reportet_tab_"+Pest).dataTable().fnDestroy();
    $("#t_reportet_tab_"+Pest+" tbody").html('');
    /*******************DETALLE****************************/
    $("#t_reported_tab_"+Pest).dataTable().fnDestroy();
    $("#t_reported_tab_"+Pest+" tbody").html('');
    /******************************************************/

    $.each(datos,function(index,data){
        btnruta='<a onclick="cargarRutaId('+data.ruta_flujo_id+',2,'+data.id+')" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>';
        html+="<tr>"+
            "<td>"+data.tramite+"</td>"+
            "<td>"+data.tipo_persona+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.sumilla+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+$.trim(data.ult_paso).split(",")[0]+"</td>"+
            "<td>"+data.total_pasos+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.ok+"</td>"+
            "<td>"+data.error+"</td>"+
            "<td>"+data.corregido+"</td>"+
            '<td><a onClick="detalle('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a> '+btnruta+'</td>';
        html+="</tr>";
    });

    $("#t_reportet_tab_"+Pest+" tbody").html(html);
    $("#t_reportet_tab_"+Pest).dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
    $("#reportet_tab_"+Pest).show();
};

HTMLreported=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//rojo
    var alertCorregido ='warning';//ambar
    var alerta='';
    var estado_final='';

    $("#t_reported_tab_"+Pest+" tbody").html('');
    $("#t_reported_tab_"+Pest).dataTable().fnDestroy();

    $.each(datos,function(index,data){
        if (data.alerta=='0') alerta=alertOk;
        if (data.alerta=='1') alerta=alertError;
        if (data.alerta=='2') alerta=alertCorregido;

        
        estado_final='Pendiente';
        if(data.dtiempo_final!=''){
            if(data.alerta=='0'){
                estado_final='Concluido';
            }
            else if(data.alerta=='1' && data.alerta_tipo=='1'){
                estado_final='A Destiempo';
            }
            else if(data.alerta=='1' && data.alerta_tipo=='2'){
                estado_final='Lo He Detenido a Destiempo';
            }
            else if(data.alerta=='1' && data.alerta_tipo=='3'){
                estado_final='Lo He Detenido';
            }
            else if(data.alerta=='2'){
                estado_final='Lo He Detenido R.';
            }
        }

        html+="<tr class='"+alerta+"'>"+
                "<td>"+data.norden+"</td>"+
                "<td>"+data.area+"</td>"+
                "<td>"+data.tiempo+': '+data.dtiempo+"</td>"+
                "<td>"+data.fecha_inicio+"</td>"+
                "<td>"+data.dtiempo_final+"</td>"+
                "<td>"+estado_final+"</td>"+
                "<td>"+data.verbo2.split("|").join("<br>")+"</td>"+
                "<td>"+data.ordenv.split("|").join("<br>")+"</td>";
        html+=  "</tr>";

    });

    $("#t_reported_tab_"+Pest+" tbody").html(html);
    $("#t_reported_tab_"+Pest).dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
    $("#reported_tab_"+Pest).show();
}


</script>
