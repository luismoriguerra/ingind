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
    getApertura:function(data,evento){
        $.ajax({
            url         : 'apertura/getapertura',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
            },
            success : function(obj) {
                if(obj.rst == 1){
                    evento(obj.datos);
                }
            },
            error: function(){
            }
        });
    },
    guardarApertura:function(){
        var datos=$("#FormApertura").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'apertura/createapertura',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#FormApertura input[type='hidden'],#FormApertura input[type='text'],#FormApertura select,#FormApertura textarea").val("");
                    $('#FormApertura select').multiselect('refresh'); 
                    $('#slct_local,#slct_estado').multiselect('refresh'); 
                    msjG.mensaje('success',obj.msj,4000);
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
    ActualizarApertura:function(){
        var datos=$("#FormAperturaActualizar").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'apertura/editapertura',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#FormAperturaActualizar input[type='hidden'],#FormAperturaActualizar input[type='text'],#FormAperturaActualizar select,#FormAperturaActualizar textarea").val("");
                    $('#FormAperturaActualizar select').multiselect('refresh');
                    $('.btnDesbloquear').removeClass('hidden');
                    $('.btnActualizar').addClass('hidden');
                    Bandeja.getApertura({'estado':1},HTMLApertura); 
                    bloquear();
                    msjG.mensaje('success',obj.msj,4000);
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
};
</script>
