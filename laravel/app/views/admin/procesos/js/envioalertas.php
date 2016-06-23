<script type="text/javascript">
$(document).ready(function() {
    $("#enviar").click(function (){
        var data={draw:1,start:0,length:5,tiempo_final:0}
        Accion.mostrar(mostrarHTML,data);
    });
});
mostrarHTML=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        html+="<tr>";
        html+="</tr>";
    });
    $("#t_reporte").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"]],
        }
    ); 
    $("#reporte").show();
};
</script>
