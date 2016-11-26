<script type="text/javascript">
$(document).ready(function() {
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
            "<td>"+data.tareas+"</td>";
        html+="</tr>";
    });
    $("#tb_produccion").html(html);
    $("#t_produccion").dataTable(
    ); 
    $("#produccion").show();

};

HTMLproduccion=function(datos){
    var html="";
    $.each(datos,function(index,data){
      html+="<table class='table table-bordered'><tr><td><b>Total de Tareas Realizadas</b></td><td>"+data.tareas+"</td></tr>";
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
    //var appp = $("tr td")[0].innerHTML;
    //var apmm = $("tr td")[1].innerHTML;
    //var nombree = $("tr td")[2].innerHTML;
    $("#txt_persona").attr("value",app+" "+apm +" "+ nombre);
    $("#usuario_id").attr("value",id);
    
};

Regresar=function(){
    
    $('#reporte').show();
    $('fieldset').show();
     $("#produccion").hide();
    $('#bandeja_detalle').hide();
    
};
eventoSlctGlobalSimple=function(slct,valores){
};
</script>
