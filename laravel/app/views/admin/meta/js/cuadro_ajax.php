<script type="text/javascript">
var Consulta, ConsultaDetalle, ConsultaDetalle2;
var Usuario={
    mostrar:function( data){
        $.ajax({
            url         : 'metacuadro/listarmetacuadro',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    HTMLreporte(obj.datos);
                    Consulta=obj;
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
    
    Crear:function(form,AD){
        var accion = (AD==1) ? "metacuadro/create" : "metacuadro/createdoc";
        $.ajax({
            url         : accion,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : form,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success: function(obj) {
                if(obj.rst==1){
                    msjG.mensaje('success', obj.msj, 6000);
                    meta = $('#slct_meta').val();
                    data = {meta:meta}; 
                    Usuario.mostrar(data);
//                    limpiar();
                } else {
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');
                    });
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(obj) {
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger', 'ocurrio un error al registrar', 6000);
                //alert('no se cargo archivo');
            }
        });
    },
    
        Eliminar:function(data,AD){
        var accion = (AD==1) ? "metacuadro/eliminar" :  "metacuadro/eliminardoc";
        $.ajax({
            url         : accion,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success: function(obj) {
                if(obj.rst==1){
                    msjG.mensaje('warning', obj.msj, 6000);
//                    limpiar();
                } else {
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');
                    });
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(obj) {
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger', 'ocurrio un error al registrar', 6000);
                //alert('no se cargo archivo');
            }
        });
    },
       
        Cargar:function(evento,campos,data = ''){
        $.ajax({
            url         : 'documentodig/cargar',
            type        : 'POST',
            cache       : false,
            data : data,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    evento(obj.datos,campos);
                   /* PlantillaObj=obj.datos;*/
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    
    MostrarTramites:function( dataG){
        $.ajax({
            url         : 'reportef/tramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    HTMLCargaTramites(obj.datos);
                    
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

};
</script>
