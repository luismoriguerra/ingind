<script type="text/javascript">
var Bandeja={
      FechaActual:function(evento){
        $.ajax({
            url         : 'ruta/fechaactual',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {estado:1},
            beforeSend : function() {
            },
            success : function(obj) {
                $("#txt_fecha").val(obj.fecha);
            },
            error: function(){
            }
        });
    },
    guardarInmueble:function(){
        var datos=$("#FormInventario").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        console.log(datos);
        $.ajax({
            url         : 'inmueble/createinmueble',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#FormInventario input[type='hidden'],#FormInventario input[type='text'],#form_asignarGestion select,#FormInventario textarea").not('.mant').val("");
                    $('#FormInventario select').multiselect('refresh'); 
                    msjG.mensaje('success',obj.msj,4000);
                    Bandeja.CargarInmueble();  
                }
                else{
                    alert(obj.msj);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
    CargarInmueble:function(){
        $.ajax({
            url         : 'inmueble/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
//            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){  
                    HTMLcargarinmueble(obj.datos);
                    
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
