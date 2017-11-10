<script type="text/javascript">
var FichaProceso={
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
    guardarFichaProceso:function(){
        var datos=$("#form_ficha").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'fichaproceso/create',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#form_ficha input[type='hidden'],#form_ficha input[type='text'],#form_ficha textarea").not('.mant').val("");
                    msjG.mensaje('success',obj.msj,4000);
                    FichaProceso.CargarFichaProceso();  
                    var data={micro:1,pasouno:1,tipo_flujo:1,soloruta:1};
                    FichaProceso.CargarProceso(data); 
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
    CargarFichaProceso:function(){
        $.ajax({
            url         : 'fichaproceso/cargar',
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
                    HTMLcargarFichaProceso(obj.datos);
                    
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
    CargarProceso:function(dataG){
        $.ajax({
            url         : 'flujo/listarproceso2',
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
                    HTMLcargarProceso(obj.datos);
                    
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
