<script type="text/javascript">
var slctGlobal={
    /**
     * mostrar un mulselect
     * @param:
     * 1 controlador..nombre del controlador   modulo
     * 2 slct         nombre del multiselect   slct_modulos
     * 3 tipo         simple o multiple
     * 4 valarray     valores que se seleccionen
     * 5 data         valores a enviar por ajax
     * 6 afectado     si es afectado o no (1,0)
     * 7 afectados    a quien afecta (slct_submodulos)
     * 8 slct_id      identificador que se esta afectando ('M')
     * 9 slctant
     * 10 slctant_id
     * 11 funciones   evento a ejecutar al hacer hacer changed
     *
     * @return string
     */
    listarSlct:function(controlador,slct,tipo,valarray,data,afectado,afectados,slct_id,slctant,slctant_id){
        $.ajax({
            url         : controlador+'/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {                
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){                    
                    htmlListarSlct(obj,slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id);
                }  
                //$(".overlay,.loading-img").remove();
            },
            error: function(){
                //$(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    listarSlct2:function(controlador,slct,data){
        $.ajax({
            url         : controlador+'/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {                
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    html='<option value="">Seleccione</option>';
                    $.each(obj.datos,function(index,data){
                            html += "<option value=\"" + data.id + "\" >" + data.nombre + "</option>";
                    }); 
                    $("#"+slct).html(html);
                }  
                //$(".overlay,.loading-img").remove();
            },
            error: function(){
                //$(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    }
};
</script>
