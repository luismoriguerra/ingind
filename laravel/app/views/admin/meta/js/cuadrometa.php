<script type="text/javascript">
$(document).ready(function() {
    var data = {estado:1};
    var ids = [];
//    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);
    slctGlobalHtml('slct_area_id','simple');
    $("#generar").click(function (){
        area_id = $('#slct_area_id').val();
        if ($.trim(area_id)!=='0') {
            data = {area_id:area_id};
            Usuario.mostrar(data);
        } else {
            alert("Seleccione Año");
        }
    });
});

$(document).on('click', '#btnexport', function(event) {
    var area=$("#slct_area_id").val();
    if ( area!=="") {
            $(this).attr('href','reporte/exportusuarios'+'?area_id='+$("#slct_area_id").val().join("','")+'&export=1');
    } else {
            alert("Seleccione area");
    }
});


HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+data.paterno+"</td>"+
            "<td>"+data.materno+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.email+"</td>"+
            "<td>"+data.dni+"</td>"+
            "<td>"+data.fecha_nacimiento+"</td>"+
            "<td>"+data.sexo+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.area+"</td>";
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

eventoSlctGlobalSimple=function(slct,valores){
};
</script>
