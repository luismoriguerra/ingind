<script type="text/javascript">
$(document).ready(function() {
    
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);
    $("#generar_movimientos").click(function (){
        flujo_id = $('#slct_flujo_id').val();
        area_id = $('#slct_area_id').val();
        var fecha=$("#fecha").val();
        if ( flujo_id!=="") {
            if ( area_id!=="") {
                //Rutas.mostrar(flujo_id, fecha);
                //enviar y generar reporte
            } else
                alert("Seleccione Area");
        }
        else
            alert("Seleccione Tramite");
        
    });
});
mostrarRutaFlujo=function(){
    $("#form_ruta_detalle>.form-group").css("display","none");
    /*var flujo_id=$.trim($("#slct_flujo_id").val());
    var area_id=$.trim($("#slct_area_id").val());

    if( flujo_id!='' && area_id!='' ){
        var datos={ flujo_id:flujo_id,area_id:area_id };
        $("#tabla_ruta_detalle").css("display","");
        Validar.mostrarRutaDetalle(datos,mostrarRutaDetalleHTML);
    }*/
};
</script>