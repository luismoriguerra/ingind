<script type="text/javascript">
$(document).ready(function() {
    $("#enviar").click(function (){
        data={idarea:1};
        Accion.mostrar(data);
    });
});
mostrarHTML=function(datos){

    $("#qr").html(datos);

};
</script>
