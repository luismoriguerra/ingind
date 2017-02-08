<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var DetalleG={id:0,proceso:"",area:"",tarea:"",verbo:"",documento:"",observacion:"",nroacti:"",updated_at:""}; // Datos Globales

var cabeceraG1=[]; // Cabecera del Datatable
var columnDefsG1=[]; // Columnas de la BD del datatable
var targetsG1=-1; // Posiciones de las columnas del datatable
var DetalleG1={id:0,proceso:"",area:"",id_union:"",sumilla:"",fecha:""}; // Datos Globales

$(document).ready(function() {
    
     /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var idG={   proceso        :'0|Proceso|#DCE6F1', //#DCE6F1
                area        :'0|Área|#DCE6F1', //#DCE6F1
                tarea        :'0|Tarea|#DCE6F1', //#DCE6F1
                verbo        :'0|Verbo|#DCE6F1', //#DCE6F1
                documento        :'0|Documento Generado|#DCE6F1', //#DCE6F1
                observacion        :'0|Observación|#DCE6F1', //#DCE6F1
                nroacti        :'0|N° de Actividad|#DCE6F1', //#DCE6F1
                updated_at        :'0|Fecha|#DCE6F1' //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,0,'detalles','t_detalles');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    
    slctGlobalHtml('slct_estado','simple');
    var idG1={   proceso        :'0|Proceso|#DCE6F1', //#DCE6F1
                area        :'0|Área|#DCE6F1', //#DCE6F1
                id_union        :'0|Nombre|#DCE6F1', //#DCE6F1
                sumilla        :'0|Sumilla|#DCE6F1', //#DCE6F1
                fecha        :'0|Fecha|#DCE6F1'
             };

    var resG1=dataTableG.CargarCab(idG1);
    cabeceraG1=resG1; // registra la cabecera
    var resG1=dataTableG.CargarCol(cabeceraG1,columnDefsG1,targetsG1,0,'detalles_tramite','t_detalles_tramite');
    columnDefsG1=resG1[0]; // registra las columnas del datatable
    targetsG1=resG1[1]; // registra los contadores
   

    
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
         showDropdowns: true
    });
    var dataG = {estado:1};
    var data = {estado:1};
    var ids = [];
/*    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);*/
    slctGlobal.listarSlct('area','slct_area_id','multiple',null,{estado:1,areagestionall:1});
    $("#generar_area").click(function (){
        area_id = $('#slct_area_id').val();
        if ($.trim(area_id)!=='') {
            data = {area_id:area_id};
            Usuario.mostrar(data);
        } else {
            alert("Seleccione Área");
        }
    });
    
    
      $("#generar").click(function (){
        usuario_id = $('#usuario_id').val();
        var fecha=$("#fecha").val();
        if ( fecha!=="") {
                dataG = {usuario_id:usuario_id,fecha:fecha,area_id:$('#slct_area_id').val()};
                Usuario.CargarProduccion(dataG);
                Usuario.CargarProduccionArea(dataG);
                Usuario.CargarProduccionTramiteAsignado(dataG);
                Usuario.CargarProduccionTramiteAsignadoTotal(dataG);
                Usuario.OrdenesTrabajo(dataG);
        } else {
            alert("Seleccione Fecha");
        }
    });
   
    $("#btnexport").click(GeneraHref);
 

});

GeneraHref=function(){
    var fecha=$("#fecha").val();
        $("#btnexport").removeAttr('href');
        if ( fecha!=="") {
            data = {fecha:fecha,usuario_id:$("#usuario_id").val()};
            window.location='reporte/exportordentbyperson?fecha='+data.fecha+'&usuario_id='+data.usuario_id;
        }else{
            alert('selecciona un rango de fechas');
        }
    /*    else if ( fecha!=="" ) {
            data = {fecha:fecha};
            window.location='reporte/exportdocplataforma'+'?nro='+Math.random(1000)+'&fecha='+data.fecha;
        } */
}

MostrarAjax=function(t){ 
    if( t=="detalles" ){
       
        if( columnDefsG.length>0 ){
            
            dataTableG.CargarDatos(t,'reporte','detalleproduccion',columnDefsG);
        }
       
        else{
            alert('Faltan datos');
        }
    }
  
};

MostrarAjax1=function(t){ 
    if( t=="detalles_tramite" ){
   
        if( columnDefsG1.length>0 ){
            
            dataTableG.CargarDatos(t,'reporte','producciontramiteasignadodetalle',columnDefsG1);
        }
        else{
            alert('Faltan datos');
        }
    }
  
};

HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr id="+data.norden+">"+
            "<td>"+data.paterno+"</td>"+
            "<td>"+data.materno+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.email+"</td>"+
            "<td>"+data.dni+"</td>"+
            "<td>"+data.fecha_nacimiento+"</td>"+
            "<td>"+data.sexo+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.rol+"</td>"+
            "<td><span onClick='MostrarUsuario("+data.norden+");' class='btn btn-success'>Productividad</span></td>";
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

HTMLproxarea=function(datos){
  var html="";
    
    var alerta_tipo= '';
    $('#t_produccion').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.tareas+"</td>"+
            "<td align='center'><span data-toggle='modal' onClick='MostrarDetalle("+data.id+");' data-id='' data-target='#produccionusuModal' class='btn btn-info'>Detalle</span></td>"+
            "<td align='center'><a class='btn btn-success btn-md' onClick='ExportDetalle("+data.id+");' id='btnexport_"+data.id+"' name='btnexport' href='' target=''><i class='glyphicon glyphicon-download-alt'></i> Export</i></a></td>";
        html+="</tr>";
    });
    $("#tb_produccion").html(html);
    $("#t_produccion").dataTable(
    ); 
    $(".nav-tabs-custom").show();

};

HTMLproduccion=function(datos){
    var html="";
    $.each(datos,function(index,data){
      html+="<table class='table table-bordered'><tr><td><b>Total de Tareas Realizadas</b></td><td>"+data.tareas+"</td><td align='center'><span data-toggle='modal' onClick='MostrarDetalle();' data-id='' data-target='#produccionusuModal' class='btn btn-info'>Detalle Total</span></td><td align='center'><a class='btn btn-success btn-md' onClick='ExportDetalleTotal();' id='btnexport_'  href='' target=''><i class='glyphicon glyphicon-download-alt'></i> Export</i></a></td></tr>";
    });
    
    $("#div_total_produccion").html(html);
  
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

HTMLprotramiteasignadototal=function(datos){
    var html="";
    $.each(datos,function(index,data){
      html+="<table class='table table-bordered'><tr><td><b>Total de Trámites asignados</b></td><td>"+data.tareas+"</td><td align='center'><span data-toggle='modal' onClick='MostrarDetalleTramite();' data-id='' data-target='#produccionusuModal' class='btn btn-info'>Detalle Total</span></td><td align='center'><a class='btn btn-success btn-md' onClick='ExportDetalleTramiteTotal();' id='btnexport1_'  href='' target=''><i class='glyphicon glyphicon-download-alt'></i> Export</i></a></td></tr>";
    });
    
    $("#div_total_tramite_asignado").html(html);
  
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
        totalh+=parseInt(Math.abs(data.ot_tiempo_transcurrido));

        var horas = Math.floor( data.ot_tiempo_transcurrido / 60);
        var min = data.ot_tiempo_transcurrido % 60;

        html+="<tr>"+
            "<td>"+data.actividad+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.dtiempo_final+"</td>"+
            "<td>"+Math.abs(data.ot_tiempo_transcurrido) + " min"+"</td>"+
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


MostrarUsuario=function(id){


    $('#reporte').hide();
    $('fieldset').hide();
    $('#bandeja_detalle').show();
    var app = document.getElementById(id).getElementsByTagName('td')[0].innerHTML;
    var apm = document.getElementById(id).getElementsByTagName('td')[1].innerHTML;
    var nombre = document.getElementById(id).getElementsByTagName('td')[2].innerHTML;
    $("#txt_persona").attr("value",app+" "+apm +" "+ nombre);
    $("#usuario_id").attr("value",id);
    
};

MostrarDetalle=function(id){
     usuario_id = $('#usuario_id').val();
     var fecha=$("#fecha").val();
     $("#form_detalles #txt_usuario_id").attr("value",'');
     $("#form_detalles #txt_proceso_id").attr("value",'');
     $("#form_detalles #txt_fecha").attr("value",'');
     $("#form_detalles #txt_usuario_id").attr("value",usuario_id);
     $("#form_detalles #txt_proceso_id").attr("value",id);
     $("#form_detalles #txt_fecha").attr("value",fecha);
//    dataG = {usuario_id:usuario_id,fecha:fecha,proceso_id:id};
    $("#t_detalles").dataTable(); 
    
    $('#form_detalles_tramite').hide();
    $('#form_detalles').show();
     MostrarAjax('detalles'); 
};

MostrarDetalleTramite=function(id){
     usuario_id = $('#usuario_id').val();
     var fecha=$("#fecha").val();
     $("#form_detalles_tramite #txt_usuario_id").attr("value",'');
     $("#form_detalles_tramite #txt_proceso_id").attr("value",'');
     $("#form_detalles_tramite #txt_fecha").attr("value",'');
     $("#form_detalles_tramite #txt_usuario_id").attr("value",usuario_id);
     $("#form_detalles_tramite #txt_proceso_id").attr("value",id);
     $("#form_detalles_tramite #txt_fecha").attr("value",fecha);
//    dataG = {usuario_id:usuario_id,fecha:fecha,proceso_id:id};
    $("#t_detalles_tramite").dataTable(); 
    
    $('#form_detalles_tramite').show();
    $('#form_detalles').hide();
    
     MostrarAjax1('detalles_tramite'); 
};

ExportDetalle=function(id){
     usuario_id = $('#usuario_id').val();
     var fecha=$("#fecha").val();
     $("#btnexport_"+id+"").attr('href','reporte/exportdetalleproduccion'+'?fecha='+fecha+'&proceso_id='+id+'&usuario_id='+usuario_id);   
};

ExportDetalleTotal=function(){
     usuario_id = $('#usuario_id').val();
     var fecha=$("#fecha").val();
     $("#btnexport_").attr('href','reporte/exportdetalleproduccion'+'?fecha='+fecha+'&usuario_id='+usuario_id);   
};

ExportDetalleTramite=function(id){
     usuario_id = $('#usuario_id').val();
     var fecha=$("#fecha").val();
     $("#btnexport1_"+id+"").attr('href','reporte/exportproducciontramiteasignadodetalle'+'?fecha='+fecha+'&proceso_id='+id+'&usuario_id='+usuario_id);   
};
ExportDetalleTramiteTotal=function(){
     usuario_id = $('#usuario_id').val();
     var fecha=$("#fecha").val();
     $("#btnexport1_").attr('href','reporte/exportproducciontramiteasignadodetalle'+'?fecha='+fecha+'&usuario_id='+usuario_id);   
};
ActPest=function(nro){
    Pest=nro;
};

Regresar=function(){
    
    $('#reporte').show();
    $('fieldset').show();
     $(".nav-tabs-custom").hide();
    $('#bandeja_detalle').hide();
    
};
activarTabla=function(){
    $("#t_detalles").dataTable(); // inicializo el datatable    
};
eventoSlctGlobalSimple=function(slct,valores){
};
</script>
