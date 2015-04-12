<script type="text/javascript">
var Validar={
    Relacion:function(evento){

        $.ajax({
            url         : 'tabla_relacion/relacion',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
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
    mostrarRutaDetalle:function(datos,evento){

        $.ajax({
            url         : 'ruta_detalle/cargarrd',
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
    guardarAsignacion:function(){
        var datos=$("#form_validar").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'ruta/crear',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#tb_ruta_flujo").html("");
                    $("#form_validar input[type='hidden']").remove();
                    $("#form_validar input[type='text'],#form_validar select").val("");
                    $('#form_validar select').multiselect('refresh');
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
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
    }
}
</script>
