<script type="text/javascript">

    var preventSubmit = function(event) {
        if(event.keyCode == 13) {
            event.preventDefault();
            setTimeout(function(){reportet();},100);
            return false;
        }
    }


$(document).ready(function(){
    $("[data-toggle='offcanvas']").click();
        $("#txt_tramite").keypress(preventSubmit);
    var data = {estado:1};
    var ids = [];

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
        if( $.trim( $("#txt_tramite").val() )=='' ){
            alert('Ingrese Trámite a buscar');
            $("#txt_tramite").focus();
            r=false;
        }
    }
    return r;
}

reportet=function(){
    if( valida(1) ){
        var datos=$("#form_tramiteunico").serialize().split("txt_").join("").split("slct_").join("");
        Tramite.mostrar( datos,HTMLreportet,'t' );
    }
}

detalle=function(ruta_id, boton){
    $("#btn_close").click();
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";

    $("#form_tramiteunico").append("<input type='hidden' id='txt_ruta_id' name='txt_ruta_id' value='"+ruta_id+"'>");
    var datos=$("#form_tramiteunico").serialize().split("txt_").join("").split("slct_").join("");
    $("#form_tramiteunico #txt_ruta_id").remove();
    Tramite.mostrar( datos,HTMLreported,'d' );
};

HTMLreportet=function(datos){
    var btnruta='';
    var html="";

    $("#t_reportet_tab_1").dataTable().fnDestroy();
    $("#t_reportet_tab_1 tbody").html('');
    /*******************DETALLE****************************/
    $("#t_reported_tab_1").dataTable().fnDestroy();
    $("#t_reported_tab_1 tbody").html('');
    /******************************************************/

    $.each(datos,function(index,data){
        btnruta='<a onclick="cargarRutaId('+data.ruta_flujo_id+',2,'+data.id+')" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>';
        btnexpediente='<a onclick="expedienteUnico('+data.id+')" class="btn btn-default btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>';
        clases1="class='success'";
        clases2="";
        if(data.detalle!=''){
            clases1="";
            clases2="class='success'";
        }
        html+="<tr>"+
            "<td "+clases1+">"+data.tramite+"</td>"+
            "<td "+clases2+">"+data.detalle+"</td>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+$.trim(data.sumilla)+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            '<td><a onClick="detalle('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a> '+btnruta+btnexpediente+'</td>';
        html+="</tr>";
    });

    $("#t_reportet_tab_1 tbody").html(html);
    $("#t_reportet_tab_1").dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
    $("#reportet_tab_1").show();
};

HTMLreported=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//rojo
    var alertCorregido ='warning';//ambar
    var alerta='';
    var estado_final='';

    $("#t_reported_tab_1 tbody").html('');
    $("#t_reported_tab_1").dataTable().fnDestroy();

    $.each(datos,function(index,data){
        if (data.alerta=='0') alerta=alertOk;
        if (data.alerta=='1' || data.condicion>1) alerta=alertError;
        if (data.alerta=='2' || data.condicion==1) alerta=alertCorregido;

        
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
                "<td>"+data.ordenv.split("|").join("<br>")+"</td>"+
                "<td>"+data.retorno+"</td>"; // SE AÑADIO
        html+=  "</tr>";

    });

    $("#t_reported_tab_1 tbody").html(html);
    $("#t_reported_tab_1").dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
    $("#reported_tab_1").show();
}


</script>
