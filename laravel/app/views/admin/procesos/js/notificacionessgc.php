<script type="text/javascript">
$(document).ready(function() {
    $("#enviar").click(function (){
        data={idarea:1};
        Accion.mostrar(data);
    });
});
mostrarHTML=function(datos){
    $('#t_reporte').dataTable().fnDestroy();
    $("#t_reporte>tbody").html(datos);
    $("#t_reporte").dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
};
</script>
