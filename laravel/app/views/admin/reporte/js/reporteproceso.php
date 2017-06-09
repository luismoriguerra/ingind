<script type="text/javascript">

$(document).ready(function() {
    
    $(".fechas").datetimepicker({
        format: "yyyy-mm",
        language: 'es',
        showMeridian: false,
        time:false,
        minView:3,
        autoclose: true,
        todayBtn: false
    });
    
    slctGlobal.listarSlct('area','slct_area_id','multiple',null,{estado:1,personal:1});

    $("#generar").click(function (){
        var area_id = $('#slct_area_id').val();
        $('#area_id').val(area_id);
        var fecha_ini=$('#fecha_ini').val();
        var fecha_fin=$('#fecha_fin').val();
        
            if($.trim(area_id)!==''){
                if ( fecha_ini!=="" && fecha_fin!=="" && (fecha_ini<=fecha_fin)) {
                    var  dataG = {area_id:area_id.join(','),fecha_ini:fecha_ini,fecha_fin:fecha_fin};
                    Proceso.CuadroProceso(dataG);

                } else {
                    alert("Seleccione Fecha correctamente");
                }
            } else {  
                alert("Seleccione Área"); 
            }
    });
   
    $("#btnexport").click(GeneraHref);

});

GeneraHref=function(){
        var area_id = $('#slct_area_id').val();
        $('#area_id').val(area_id);
        var fecha_ini=$('#fecha_ini').val();
        var fecha_fin=$('#fecha_fin').val();
        
        if($.trim(area_id)!==''){
        $("#btnexport").removeAttr('href');
        if ( fecha_ini!=="" && fecha_fin!=="" && (fecha_ini<=fecha_fin)) {
            data = {fecha_fin:fecha_fin,fecha_ini:fecha_ini,area_id:$("#slct_area_id").val().join(',')};
            window.location='reporte/exportcuadroproceso?fecha_ini='+data.fecha_ini+'&fecha_fin='+data.fecha_fin+'&area_id='+data.area_id;
        } else {
            alert("Seleccione Fecha correctamente");
        }}
        else {  alert("Seleccione Área"); }
}

HTMLCProceso=function(datos,cabecera){
    var html="";var html_cabecera="";
    var alerta_tipo= '';
    $('#t_proceso').dataTable().fnDestroy();
    pos=0;
    html_cabecera+="<tr>"+
             "<th colspan='3'></th>";
    var n=0;
    $.each(cabecera,function(index,cabecera){
       html_cabecera+="<th>"+cabecera+"</th>";
       n++;
    });
    
    html_cabecera+="<th colspan='2'>TOTAL</th>";
    html_cabecera+="</tr>";
    
    html_cabecera+="<tr>"+
             "<th>N°</th>"+
             "<th>Area</th>"+
             "<th>Proceso</th>";
    var n=0;
    
    $.each(cabecera,function(index,cabecera){
       html_cabecera+="<th >N° T.</th>";
       n++;
    });

    html_cabecera+="<th>N° T. Total</th>";
    html_cabecera+="</tr>";
    
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+pos+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.proceso+"</td>";
        var i;
        for(i=1;i<=n;i++){ 
            html+='<td>'+$.trim(data['r'+i])+'</td>';
        }
        
        html+='<td>'+data.rt+"</td>";
    });

    html+="</tr>";
    $("#tb_proceso").html(html);
    $("#tt_proceso").html(html_cabecera);
    $("#t_proceso").dataTable(
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
        html+="<tr>"+
            "<td>"+pos+"</td>"+
           "<td>"+data.actividad+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.dtiempo_final+"</td>"+
            "<td>"+Math.abs(data.ot_tiempo_transcurrido) + " min"+"</td>"+
             "<td>"+horas + ":" + min +"</td>";
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




</script>
