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
    slctGlobal.listarSlct('area','slct_area_id','multiple',null,{estado:1,areagestionall:1});
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

HTMLCPActividad=function(datos,cabecera){
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
        html+='<td style="cursor:pointer" onclick="Detalle(\''+$.trim(data['id'+i])+'\')">'+$.trim(data['f'+i])+'</td>'+
            '<td style="cursor:pointer" onclick="Detalle(\''+$.trim(data['id'+i])+'\')">'+$.trim(hora)+"</td>";
        }
        var h_total = data.h_total.substring(0,5);
        html+='<td style="cursor:pointer" onclick="Detalle(\''+$.trim(data.id_total)+'\')">'+data.f_total+"</td>";
        html+='<td style="cursor:pointer" onclick="Detalle(\''+$.trim(data.id_total)+'\')">'+h_total+"</td>";

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

Detalle=function(id){
        var dataG=[];
        dataG = {id:id};
        Usuario.MostrarActividades(dataG)
        $('#actividadModal').modal('show');
};

HTMLCargaActividades=function(datos){var html ='';

    var alerta_tipo= '';
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
    $("#form_actividad #tb_actividad").html(html);
    $("#form_actividad #t_actividad").dataTable(
                         {
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 10,
        }
    );


};


</script>
