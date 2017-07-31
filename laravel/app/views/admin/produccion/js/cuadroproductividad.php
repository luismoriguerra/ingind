<script type="text/javascript">

$(document).ready(function() {

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
         showDropdowns: true
    });
    var dataG = {estado:1};
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('area','slct_area_id','multiple',null,{estado:1,areagestionall:1,personal:1});
/*    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);*/

      $("#generar").click(function (){
        area_id = $('#slct_area_id').val();
        $('#area_id').val(area_id);
        var fecha=$("#fecha").val();
        if($.trim(area_id)!==''){
        if ( fecha!=="") {
                dataG = {area_id:area_id.join(','),fecha:fecha};
                Usuario.CuadroProductividadActividad(dataG);

        } else {
            alert("Seleccione Fecha");
        }}
        else {  alert("Seleccione Área"); }
    });
   
    $("#btnexport").click(GeneraHref);

});

GeneraHref=function(){
        area_id = $('#slct_area_id').val();
        $('#area_id').val(area_id);
        var fecha=$("#fecha").val();
        if($.trim(area_id)!==''){
        $("#btnexport").removeAttr('href');
        if ( fecha!=="") {
            data = {fecha:fecha,area_id:$("#slct_area_id").val().join(',')};
            window.location='reporte/exportdiarioactividades?fecha='+data.fecha+'&area_id='+data.area_id;
        } else {
            alert("Seleccione Fecha");
        }}
        else {  alert("Seleccione Área"); }
}

HTMLCPActividad=function(datos,cabecera,validar){
  var html="";var html_cabecera="";
    var alerta_tipo= '';
    $('#t_produccion').dataTable().fnDestroy();
    pos=0;
    html_cabecera+="<tr>"+
             "<th colspan='3'></th>";
    var n=0;
    $.each(cabecera,function(index,cabecera){

       html_cabecera+="<th colspan='2'>"+cabecera+"</th>";
       n++;
    });
    html_cabecera+="<th colspan='2'>TOTAL</th>";
    html_cabecera+="</tr>";
    
     html_cabecera+="<tr>"+
             "<th>N°</th>"+
             "<th>Area</th>"+
             "<th>Persona</th>";
    var n=0;
    $.each(cabecera,function(index,cabecera){

       html_cabecera+="<th >N° Act</th>";
       html_cabecera+="<th >T. Horas</th>";
       n++;
    });
    html_cabecera+="<th>N° Acti. Total</th>"+
                    "<th>Total de Horas</th>";
    html_cabecera+="</tr>";
    
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+pos+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.persona+"</td>";
        var i;
        for(i=1;i<=n;i++){ 
        var hora = data['h'+i];
        if(data['h'+i]!=null){
         hora = data['h'+i].substring(0,5);
        }
        
        if(data['v'+i]>=360 || data.envio_actividad==0 || data['e'+i]>=1){
         var style=';background-color:#7BF7AE';
        }
        else if(data['v'+i]>0 && data['v'+i]<360 && data.envio_actividad==1){
         var style=';background-color:#FFA027';
        }
        else if(data['v'+i]==0 && data.envio_actividad==1){
            var style=';background-color:#FE4E4E';   
        }
        if((validar[i-1]==6 || validar[i-1]==0) && (data.envio_actividad!=0 && data['e'+i]!=1)){
            var style=';background-color:#ffff66';   
        }
        html+='<td style="cursor:pointer'+style+'" onclick="Detalle(\''+$.trim(data['id'+i])+'\',\''+data.envio_actividad+'\',\''+data['e'+i]+'\')">'+$.trim(data['f'+i])+'</td>'+
            '<td style="cursor:pointer'+style+'" onclick="Detalle(\''+$.trim(data['id'+i])+'\',\''+data.envio_actividad+'\',\''+data['e'+i]+'\')">'+$.trim(hora)+"</td>";
        }
        var h_total = data.h_total.substring(0,5);
        html+='<td style="cursor:pointer" onclick="Detalle(\''+$.trim(data.id_total)+'\',\''+data.envio_actividad+'\')">'+data.f_total+"</td>";
        html+='<td style="cursor:pointer" onclick="Detalle(\''+$.trim(data.id_total)+'\',\''+data.envio_actividad+'\')">'+h_total+"</td>";

    });

    html+="</tr>";
    $("#tb_produccion").html(html);
    $("#tt_produccion").html(html_cabecera);
    $("#t_produccion").dataTable(
             {
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 10,
        }
    ); 


};




ActPest=function(nro){
    Pest=nro;
};


activarTabla=function(){
    $("#t_detalles").dataTable(); // inicializo el datatable    
};
eventoSlctGlobalSimple=function(slct,valores){
};

Detalle=function(id,envio_actividad,exonera){
        var dataG=[];
        dataG = {id:id};
        Usuario.MostrarActividades(dataG,envio_actividad,exonera)
        $('#actividadModal').modal('show');
};

HTMLCargaActividades=function(datos,envio_actividad,exonera){
    var html ='';
    var alerta_tipo= '';
    $("#exonera").text("");
    $("#fechas").text("");
    $('#form_actividad #t_actividad').dataTable().fnDestroy();
    pos=0;
    

    $.each(datos,function(index,data){
        pos++;
        var horas = Math.floor( data.ot_tiempo_transcurrido / 60);
        var min = data.ot_tiempo_transcurrido % 60;
        if(data.archivo!=null){
            var archivo=data.archivo.split(',');
        }else {archivo='';}
        if(data.documento!=null){
        var documento=data.documento.split(',');
        } else {documento='';}
        if(data.n_documento!=null){
        var n_documento=data.n_documento.split(',');
        }else {n_documento='';}
        html+="<tr>"+
            "<td>"+pos+"</td>"+
           "<td>"+data.actividad+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.dtiempo_final+"</td>"+
            "<td>"+Math.abs(data.ot_tiempo_transcurrido) + " min"+"</td>"+
            "<td>"+horas + ":" + min +"</td>"+
            "<td>"+data.cantidad+"</td>"+
            "<td>";
            for(i=0;i<documento.length;i++){
            html+="<a target='_blank' href='documentodig/vista/" + documento[i] + "/4/0'>" + n_documento[i] + "</a><br>";
            }
        html+= "</td>"+
            "<td>";
            for(i=0;i<archivo.length;i++){
            html+="<a target='_blank' href='file/actividad/" +archivo[i]+"'>" +archivo[i]+ "</a><br>";
            }
        html+= "</td>";
        html+="</tr>";
    });
    
    MostrarMensajes(envio_actividad,exonera);
    $("#form_actividad #tb_actividad").html(html);
    $("#form_actividad #t_actividad").dataTable(
                         {
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 10,
        }
    );


};

MostrarMensajes=function(envio_actividad,exonera){

        if(envio_actividad==0){
       $("#exonera").text("Se encuentra exonerado todos los días");
        }
        else if(exonera!=0 && typeof (exonera)!='undefined'){
         var dataG=[];
        dataG = {id:exonera};
         Usuario.MostrarTextoFecha(dataG);     
        }
};


</script>
