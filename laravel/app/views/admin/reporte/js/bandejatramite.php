<script type="text/javascript">
$(document).ready(function() {
    slctGlobal.listarSlct('lista/tipovizualizacion','slct_tipo_visualizacion','multiple',null,null);
    $('#slct_tipo_visualizacion').change(function() {
        FiltrarBandeja( $('#slct_tipo_visualizacion').val());
    });
    Bandeja.Mostrar();
});
FiltrarBandeja=function(values){
    var form = new FormData();
    //form.append('param',values);
    if (values !== null) {
        for (var i = 0; i < values.length; i++) {
            form.append(String(i),values[i]);
        }
    }
    Bandeja.Mostrar(form);

};
activarTabla=function(){
    $("#t_reporte").dataTable(); // inicializo el datatable  
};
activar=function(id,ruta_detalle_id,td){//establecer como visto
    Bandeja.CambiarEstado(ruta_detalle_id, id,1);
    //tambien debera cargar un detalle en la parte de abajo
    detalle(id,ruta_detalle_id,td);
};
desactivar=function(id,ruta_detalle_id,td){//establecer como no visto
    //Bandeja.CambiarEstado(ruta_detalle_id, id,2);
    detalle(id,ruta_detalle_id,td);
};
mostrarModal=function(id,ruta_detalle_id){//establecer como no visto
    //mostrar modal
    Bandeja.MostrarUsuarios(ruta_detalle_id);
    //$('#usuarios_vieron_tramite').modal('show');
};

detalle=function(id,ruta_detalle_id, tr){
    var tr = tr.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";

    var data ={ruta_detalle_id:ruta_detalle_id}
    Bandeja.MostrarDetalle(data);
};
HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $.each(datos,function(index,data){
        var ruta_detalle_id=data.ruta_detalle_id;
        var persona_visual=data.persona_visual;
        var estado;
        var id=data.id;
        if(data.id==1){//est visto
            //el boton debera cambiar  a no visto
            estado='onClick="desactivar('+id+','+ruta_detalle_id+',this)"';
            tr='<tr  data-toggle="tooltip" data-placement="top" title="Visto por: '+persona_visual+'" >';
            img='<td onClick="mostrarModal('+id+','+ruta_detalle_id+')" class="small-col"><i  class="fa fa-eye"></i></td>';

        } else {
            //unread
            estado='onClick="activar('+id+','+ruta_detalle_id+',this)"';
            tr='<tr class="unread">';
            img='<td class="small-col"><i  class="fa fa-ban"></i></td>';
        }

        html+=tr+
            //"<td class='small-col'></td>"+
            img+
            "<td "+estado+">"+data.id_union+"</td>"+
            "<td "+estado+">"+data.tiempo+"</td>"+
            "<td "+estado+">"+data.fecha_inicio+"</td>"+
            "<td "+estado+">"+data.norden+"</td>"+
            "<td "+estado+">"+data.fecha_tramite+"</td>"+
            "<td "+estado+">"+data.nombre+"</td>"+
            "<td "+estado+">"+data.respuesta+' '+data.respuestad+"</td>"+
            "<td "+estado+">"+data.observacion+"</td>"+
            "<td "+estado+">"+data.tipo_solicitante+"</td>"+
            "<td "+estado+">"+data.solicitante+"</td>";
            if (data.id==='') {
                data.id='0';
            }
        //html+="<td>"+estado+"</td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#reporte").show();
    activarTabla();
    $('[data-toggle="tooltip"]').tooltip();
};
HTMLreporteDetalle=function(datos){

    $("#form_ruta_detalle #txt_fecha_tramite").val(datos.fecha_tramite);
    $("#form_ruta_detalle #txt_sumilla").val(datos.sumilla);
    $("#form_ruta_detalle #txt_solicitante").val(datos.solicitante);

    $("#form_ruta_detalle #txt_flujo").val(datos.flujo);
    $("#form_ruta_detalle #txt_area").val(datos.area);
    $("#form_ruta_detalle #txt_id_doc").val(datos.id_doc);
    $("#form_ruta_detalle #txt_orden").val(datos.norden);
    $("#form_ruta_detalle #txt_fecha_inicio").val(datos.fecha_inicio);
    $("#form_ruta_detalle #txt_tiempo").val(datos.tiempo);

    $("#form_ruta_detalle>#txt_fecha_max").remove();
    $("#form_ruta_detalle").append("<input type='hidden' id='txt_fecha_max' name='txt_fecha_max' value='"+datos.fecha_max+"'>");

    $("#t_detalle_verbo").html("");
    var detalle="";
    var html="";
    var imagen="";
    var obs="";
    var cod="";
    var rol="";
    var verbo="";
    var documento="";
    var orden="";
    var archivo="";
        if ( datos.verbo!='' ) {
            detalle=datos.verbo.split("|");
            html="";
            for (var i = 0; i < detalle.length; i++) {

                imagen = "<i class='fa fa-check fa-lg'></i>";
                imagenadd = "<ul><li>"+detalle[i].split("=>")[4].split("^").join("</li><li>")+"</li></ul>";
                obs = detalle[i].split("=>")[5];
                rol = detalle[i].split("=>")[6];
                verbo = detalle[i].split("=>")[7];
                documento = detalle[i].split("=>")[8];
                orden = detalle[i].split("=>")[9];
                archivo="";
                denegar=false;
                html+=  "<tr>"+
                            "<td>"+orden+"</td>"+
                            "<td>"+detalle[i].split("=>")[3]+"</td>"+
                            "<td>"+rol+"</td>"+
                            "<td>"+verbo+"</td>"+
                            "<td>"+documento+"</td>"+
                            "<td>"+detalle[i].split("=>")[1]+"</td>"+
                            "<td id='td_"+detalle[i].split("=>")[0]+"'>"+imagenadd+"</td>"+
                            "<td>"+obs+"</td>"+
                            //"<td>"+archivo+"</td>"+
                            "<td>"+imagen+"</td>"+
                        "</tr>";
            }
            $("#t_detalle_verbo").html(html);
            
        }

    $("#reporte_detalle").show();
};
</script>
