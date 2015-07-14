<script type="text/javascript">
$(document).ready(function() {
    slctGlobal.listarSlct('lista/tipovizualizacion','slct_tipo_visualizacion','multiple',null,null);
    $('#slct_tipo_visualizacion').change(function() {
        FiltrarBandeja( $('#slct_tipo_visualizacion').val());
    });
    Bandeja.mostrar();
});
FiltrarBandeja=function(values){
    var form = new FormData();
    //form.append('param',values);
    if (values !== null) {
        for (var i = 0; i < values.length; i++) {
            form.append(String(i),values[i]);
        }
    }
    Bandeja.mostrar(form);

};
activarTabla=function(){
    $("#t_reporte").dataTable(); // inicializo el datatable  
};
activar=function(id,ruta_detalle_id){//establecer como visto
    Bandeja.CambiarEstado(ruta_detalle_id, id,1);
};
desactivar=function(id,ruta_detalle_id){//establecer como no visto
    Bandeja.CambiarEstado(ruta_detalle_id, id,2);
};
HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $.each(datos,function(index,data){
        html+="<tr>"+
            "<td>"+data.id_union+"</td>"+
            "<td>"+data.tiempo+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.norden+"</td>"+
            "<td>"+data.fecha_tramite+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.respuesta+' '+data.respuestad+"</td>"+
            "<td>"+data.observacion+"</td>"+
            "<td>"+data.tipo_solicitante+"</td>"+
            "<td>"+data.solicitante+"</td>";
            if (data.id==='') {
                data.id='0';
            }
            if(data.id==1){//est visto
                //el boton debera cambiar  a no visto
                estado='<span id="'+data.ruta_detalle_id+'" onClick="desactivar('+data.id+','+data.ruta_detalle_id+')" class="btn btn-success">Visto</span>';
            } else {
                estado='<span id="'+data.ruta_detalle_id+'" onClick="activar('+data.id+','+data.ruta_detalle_id+')" class="btn btn-danger">No visto</span>';
            }
        html+="<td>"+estado+"</td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#reporte").show();
    activarTabla();
};
</script>
