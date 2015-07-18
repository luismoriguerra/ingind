<script type="text/javascript">
var Editar={
    mostrarRutaDetalleAlerta:function(datos,evento){
        $.ajax({
            url         : 'ruta_detalle/cargarrdv',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    evento(obj.datos);
                }  
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    CrearRuta:function(evento){
        //var datos=$("#form_ruta").serialize().split("txt_").join("").split("slct_").join("");
        /*var areasG=[]; // texto area
        var areasGId=[]; // id area
        var theadArea=[]; // cabecera area
        var tbodyArea=[]; // cuerpo area
        var tfootArea=[]; // pie area

        var tiempoGId=[]; // id posicion del modal en base a una area.
        var tiempoG=[];
        var verboG=[];
        var posicionDetalleVerboG=0;*/
        var accion="ruta_flujo/creardos";
        datos=  {
                areasG:areasG.join("*"), 
                areasGId:areasGId.join("*"),
                theadArea:theadArea.join("*"),
                tfootArea:tfootArea.join("*"),
                tbodyArea:tbodyArea.join("*"),

                tiempoGId:tiempoGId.join("*"),
                tiempoG:tiempoG.join("*"),
                verboG:verboG.join("*"),
                flujo_id:$("#slct_flujo_id").val(),
                area_id:$("#slct_area_id").val(),
                ruta_flujo_id: $("#txt_ruta_flujo_id_modal").val(),
                iniciara: $("#txt_iniciara").val(),
                ruta_id:$("#txt_ruta_id").val(),
                ruta_detalle_id:$("#txt_ruta_detalle_id").val(),
                estado_final:$("#slct_estado_final").val(),
                crear_nuevo:$("#slct_crear_nuevo").val(),

                };
        $.ajax({
            url         : accion,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {                
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {                
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    $("#txt_ruta_flujo_id_modal").remove();
                    $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+obj.ruta_flujo_id+'">');
                    $("#txt_titulo").text("Act. Ruta");
                    $("#texto_fecha_creacion").text("Fecha Actualización:");
                    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
                    evento();
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#rolModal .modal-footer [data-dismiss="modal"]').click();
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
}
</script>
