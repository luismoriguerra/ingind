<script type="text/javascript">
var Flujos={
    AgregarEditarFlujos:function(AE){
        var datos=$("#form_flujos_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "flujo/editar" : "flujo/crear";

        /*var accion="flujo/crear";
        if(AE==1){
            accion="flujo/editar";}*/
        

        $.ajax({
            url         : accion,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
           /* success : function(obj) {        

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
            }*/
            success : function(obj) {
                $(".overlay, .loading-img").remove();
                if(obj.rst==1){
                    MostrarAjax('flujos');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#flujoModal .modal-footer [data-dismiss="modal"]').click();

                } else {
                    $.each(obj.msj, function(index, datos){
                        $("#error_"+index).attr("data-original-title", datos);
                        $('#error_'+index).css('display','');
                    });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
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
        $("#form_flujos_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_flujos_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_flujos_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'flujo/cambiarestado',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {                
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            /*success : function(obj) {
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
            }*/
             success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    MostrarAjax('flujos');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#flujoModal .modal-footer [data-dismiss="modal"]').click();
                } else {
                    $.each(obj.msj, function(index, datos) {
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');
                    });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },

    ObtenerRolUser:function(){
        $.ajax({
            url         : 'flujo/roluser',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {},
            success : function(obj) {
                if(obj.rst==1)
                {
                    if(obj.datos == 1){
                        $("#div_categoria_user").html('').hide();
                        $("#div_categoria_master").show();                        
                    }else{
                        $("#div_categoria_master").html('').hide();
                        var html_slct = '<input type="hidden" name="txt_categoria_id" id="txt_categoria_id" value="'+obj.data_cat[0].id+'">'+
                                        '<input type="text" class="form-control" name="txt_categoria" id="txt_categoria" value="'+obj.data_cat[0].nombre+'" disabled>';
                        $("#div_categoria_user").html(html_slct).show();
                    }
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
            }
        });
    },

};
</script>
