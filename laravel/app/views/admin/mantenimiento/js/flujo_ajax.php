<script type="text/javascript">
var Flujos={
    AgregarEditarFlujo:function(AE){
        var datos=$("#form_flujos").serialize().split("txt_").join("").split("slct_").join("");
        var accion="flujo/crear";
        if(AE==1){
            accion="flujo/editar";
        }

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

                    Flujos.CargarFlujos(htmlCargarFlujos);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#flujoModal .modal-footer [data-dismiss="modal"]').click();
                }
                else{ 
                    $.each(obj.msj,function(index,datos){                        
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');                                         
                    });     
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },
    CargarFlujos:function(evento){
        $.ajax({
            url         : 'flujo/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {usuario:2},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                evento(obj);
            },
            error: function(){
                $(".overlay,.loading-img").remove();
            }
        });
    },
    ListarAreas:function(area){
        $.ajax({
            url         : 'ruta_detalle/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {usuario:2},
            beforeSend : function() {
                
            },
            success : function(obj) {
                var html="<option value=''> Seleccione </option>";
                if(obj.rst==1){
                    $.each(obj.datos,function(index,data){
                        html+='<option value="'+data.id+'">'+data.nombre+'</option>';
                    });
                }
                 $("#"+area).html(html); 
            },
            error: function(){
            }
        });
    },
    ListarCategorias:function(categoria){
        $.ajax({
            url         : 'categoria/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {estado:1},
            beforeSend : function() {
                
            },
            success : function(obj) {
                var html="<option value=''> Seleccione </option>";
                if(obj.rst==1){
                    $.each(obj.datos,function(index,data){
                        html+='<option value="'+data.id+'">'+data.nombre+'</option>';
                    });
                }
                 $("#"+categoria).html(html); 
            },
            error: function(){
            }
        });
    },
    CambiarEstadoFlujos:function(id,AD){
        $("#form_flujos").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_flujos").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_flujos").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'flujo/cambiarestado',
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
                    Flujos.CargarFlujos(htmlCargarFlujos);
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#flujoModal .modal-footer [data-dismiss="modal"]').click();
                }
                else{ 
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');
                    });     
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    }
};
</script>
