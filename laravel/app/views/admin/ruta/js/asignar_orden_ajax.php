<script type="text/javascript">
var Asignar={
    FechaActual:function(){
        $.ajax({
            url         : 'ruta/fechaactual',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {estado:1},
            beforeSend : function() {
            },
            success : function(obj) {
                if( $("#txt_fecha_inicio").val()=='' ){
                    $("#txt_fecha_inicio").val(obj.fecha);
                }
            },
            error: function(){
            }
        });
    },
    ListarPersona:function(evento,datos){
        $.ajax({
            url         : 'persona/cargarp',
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
    Relacion:function(evento){
        $.ajax({
            url         : 'tabla_relacion/relacionunico',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {estado:1},
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
    mostrarRutaFlujo:function(datos,evento){
        $.ajax({
            url         : 'tabla_relacion/rutaflujo',
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
    guardarRelacion:function(){
        var datos=$("#form_tabla_relacion").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'tabla_relacion/guardar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {                
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $('#asignarModal .modal-footer [data-dismiss="modal"]').click();
                    SeleccionRelacion(obj.id,obj.codigo);
                    Asignar.Relacion(RelacionHTML);
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
        var datos=$("#form_asignar").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
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
                    $("#form_asignar input[type='hidden']").remove();
                    $("#form_asignar").append('<input type="hidden" value="CI-" name="txt_ci" id="txt_ci">');
                    $("#form_asignar").append('<input type="hidden" name="txt_id_responsable" id="txt_id_responsable">');
                    $("#form_asignar").append('<input type="hidden" name="txt_id_autoriza" id="txt_id_autoriza" value="<?php echo Auth::user()->id; ?>">');
                    $(".natural, .juridica, .area").css("display","none");
                    $("#form_asignar input[type='text'],#form_asignar textarea,#form_asignar #slct_flujo2_id,#form_asignar #slct_area2_id,#form_asignar #slct_area_p2_id,#form_asignar #slct_rol2_id").val("");
                    $("#txt_paterno_autoriza").val("<?php echo Auth::user()->paterno; ?>");
                    $("#txt_materno_autoriza").val("<?php echo Auth::user()->materno; ?>");
                    $("#txt_nombre_autoriza").val("<?php echo Auth::user()->nombre; ?>");
                    $('#form_asignar #slct_flujo2_id,#form_asignar #slct_area2_id,#form_asignar #slct_area_p2_id,#form_asignar #slct_rol2_id').multiselect('refresh');
                    var datos={union:1,area_id:AreaIdG};
                    Carta.CargarCartas(HTMLCargarCartas,datos);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                }
                else{
                    alert(obj.msj);
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
