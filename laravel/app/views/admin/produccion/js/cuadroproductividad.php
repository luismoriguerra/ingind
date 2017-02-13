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
    var fecha=$("#fecha").val();
        $("#btnexport").removeAttr('href');
        if ( fecha!=="") {
            data = {fecha:fecha,area_id:$("#slct_area_id").val().join(',')};
            window.location='reporte/exportordentbyarea?fecha='+data.fecha+'&area_id='+data.area_id;
        }else{
            alert('selecciona un rango de fechas');
        }
    /*    else if ( fecha!=="" ) {
            data = {fecha:fecha};
            window.location='reporte/exportdocplataforma'+'?nro='+Math.random(1000)+'&fecha='+data.fecha;
        } */
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
        var hora = data['h'+i].substring(0,5);
        }
        html+="<td>"+$.trim(data['f'+i])+"</td>"+
            "<td>"+$.trim(hora)+"</td>";
        }
        var h_total = data.h_total.substring(0,5);
        html+="<td>"+data.f_total+"</td>";
        html+="<td>"+h_total+"</td>";

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
HTMLproducciontapersonalxarea=function(datos){
  var html="";
    
    var alerta_tipo= '';
    $('#t_tramite_asignado').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        var nombre=data.nombre; var area=data.area;
        var c='';var ca='';
        if(data.area_id!==null && data.id===null){nombre='Sub Total:'; c='<b>'; ca='<b>';}
        if(data.area_id===null && data.id===null){nombre='Total:'; c='<b>'; ca='<b>';}
        if(data.area_id===null && data.id===null){area='';}
        pos++;
        html+="<tr>"+
            "<td>"+pos+'<input type="hidden" name="area_id" value="'+data.area_id+'"></td>'+
            "<td>"+c+area+ca+"</td>"+
            "<td>"+c+nombre+ca+"</td>"+
            "<td>"+c+data.tareas+ca+"</td>"+
            "<td align='center'><span data-toggle='modal' onClick='DetalleProducciontapersonalxarea("+data.id+","+data.area_id+");' data-id='' data-target='#produccionperxareaModal' class='btn btn-info'>Detalle</span></td>"+
            "<td align='center'><a class='btn btn-success btn-md' onClick='ExportProducciontapersonalxarea("+data.id+","+data.area_id+");' id='btnexport_"+data.area_id+"' name='btnexport'><i class='glyphicon glyphicon-download-alt'></i> Export</i></a></td>";
        html+="</tr>";
    });
    $("#tb_tramite_asignado").html(html);
    $("#t_tramite_asignado").dataTable(
             {
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 100,
        }
    ); 
    $(".nav-tabs-custom").show();

};

HTMLprotramiteasignado=function(datos){
  var html="";
    
    var alerta_tipo= '';
    $('#t_tramite_asignado').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.tareas+"</td>"+
            "<td align='center'><span data-toggle='modal' onClick='MostrarDetalleTramite("+data.id+");' data-id='' data-target='#produccionusuModal' class='btn btn-info'>Detalle</span></td>"+
            "<td align='center'><a class='btn btn-success btn-md' onClick='ExportDetalleTramite("+data.id+");' id='btnexport1_"+data.id+"' name='btnexport1' href='' target=''><i class='glyphicon glyphicon-download-alt'></i> Export</i></a></td>";
        html+="</tr>";
    });
    $("#tb_tramite_asignado").html(html);
    $("#t_tramite_asignado").dataTable(
    ); 
    $(".nav-tabs-custom").show();

};


ActPest=function(nro){
    Pest=nro;
};


activarTabla=function(){
    $("#t_detalles").dataTable(); // inicializo el datatable    
};
eventoSlctGlobalSimple=function(slct,valores){
};



HTMLOrdenesTrabajo=function(datos){
  if(datos.length > 0){
    var alerta_tipo= '';
    $('#t_ordenest').dataTable().fnDestroy();
    pos=0;
    var html ='';
    var totalh = 0;
    $.each(datos,function(index,data){
        pos++;
        totalh+=parseInt(Math.abs(data.total));
        var horas = Math.floor( data.total / 60);
        var min = data.total % 60;

        html+="<tr>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.cantidad+"</td>"+
            "<td>"+Math.abs(data.total) + " min"+"</td>"+
            "<td>"+horas + ":" + min +"</td>";
        html+="</tr>";
    });
    $("#tb_ordenest").html(html);
    $("#t_ordenest").dataTable(
    );

    var horastotal = Math.floor( totalh / 60);
    var mintotal = totalh % 60;
    $("#txt_totalh").val(horastotal + " : " + mintotal);
  }else{
    $("#tb_ordenest").html('');
  }
};


</script>
