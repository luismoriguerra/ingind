<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var DetalleG={id:0,proceso:"",area:"",tarea:"",verbo:"",documento:"",observacion:"",norden:"",updated_at:""}; // Datos Globales

$(document).ready(function() {
    
     /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var idG={   proceso        :'onBlur|Proceso|#DCE6F1', //#DCE6F1
                area        :'onBlur|area|#DCE6F1', //#DCE6F1
                tarea        :'onBlur|tarea|#DCE6F1', //#DCE6F1
                verbo        :'onBlur|verbo|#DCE6F1', //#DCE6F1
                documento        :'0onBlur|documento|#DCE6F1', //#DCE6F1
                observacion        :'onBlur|observacion|#DCE6F1', //#DCE6F1
                norden        :'onBlur|norden|#DCE6F1', //#DCE6F1
                updated_at        :'onBlur|updated_at|#DCE6F1' //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'detalles','t_detalles');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
   

    
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var dataG = {estado:1};
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);
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
                dataG = {usuario_id:usuario_id,fecha:fecha};
                Usuario.CargarProduccion(dataG);
                Usuario.CargarProduccionArea(dataG);
       
        } else {
            alert("Seleccione Fecha");
        }
    });
   
 

});

MostrarAjax=function(t){ 
    if( t=="detalles" ){
       
        if( columnDefsG.length>0 ){
            
            dataTableG.CargarDatos(t,'reporte','detalleproduccion',columnDefsG);
        }
        else{
            alert('Faltan datos');
        }
    }
}

HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr id="+data.id+">"+
            "<td>"+data.paterno+"</td>"+
            "<td>"+data.materno+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.email+"</td>"+
            "<td>"+data.dni+"</td>"+
            "<td>"+data.fecha_nacimiento+"</td>"+
            "<td>"+data.sexo+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.cargo+"</td>"+
            "<td><span onClick='MostrarUsuario("+data.id+");' class='btn btn-success'>Productividad</span></td>";
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
            "<td><span data-toggle='modal' onClick='MostrarDetalle("+data.id+");' data-id='' data-target='#produccionusuModal' class='btn btn-info'>Detalle</span></td>";
        html+="</tr>";
    });
    $("#tb_produccion").html(html);
    $("#t_produccion").dataTable(
    ); 
    $(".nav-tabs-custom").show();

};

HTMLdetalleproduccion=function(datos){
  var html="";
    
    var alerta_tipo= '';
    $('#t_detalle_area').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.tarea+"</td>"+
            "<td>"+data.verbo+"</td>"+
            "<td>"+data.documento+"</td>"+
            "<td>"+data.observacion+"</td>"+
            "<td>"+data.norden+"</td>"+
            "<td>"+data.updated_at+"</td>";
        html+="</tr>";
    });
    $("#tb_detalle_area").html(html);
    $("#t_detalle_area").dataTable(
    ); 


};

HTMLproduccion=function(datos){
    var html="";
    $.each(datos,function(index,data){
      html+="<table class='table table-bordered'><tr><td><b>Total de Tareas Realizadas</b></td><td>"+data.tareas+"</td><td><span data-toggle='modal' onClick='MostrarDetalle();' data-id='' data-target='#produccionusuModal' class='btn btn-info'>Detalle Total</span></td></tr>";
    });
    
    $("#div_total_produccion").html(html);
  
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
//     usuario_id = $('#usuario_id').val();
//     var fecha=$("#fecha").val();
//    dataG = {usuario_id:usuario_id,fecha:fecha,proceso_id:id};
    $("#t_detalles").dataTable(); 
     MostrarAjax('detalles');
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
