<script type="text/javascript">
$(document).ready(function() {
    $('#btn_cargar').click(Cargar.asignacion);
});

Leer=function(datos){
    var html="";
    for(var i=0; i<datos.length; i++){
        html+='<tr>';
        html+='<td>'+datos[i]+'<td>';
        html+='</tr>';
    }
    $("#resultado").html(html);
};

</script>
