<script type="text/javascript">
var Bandeja={
    MostrarTramites:function(data,evento){
        $.ajax({
            url         : 'tramitec/listartramites',
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
                    evento(obj.datos);                    
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    MostrarAnexos:function(data,evento,$tipo_busqueda = ''){
        $.ajax({
            url         : 'anexo/anexosbytramite',
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
                    evento(obj.datos,$tipo_busqueda);                    
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    AnexoById:function(data,evento){
        $.ajax({
            url         : 'anexo/anexobyid',
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
                    evento(obj.datos);                    
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    deleteAnexo:function(data,evento){
        $.ajax({
            url         : 'anexo/destroy',
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
                    evento('',document.querySelector('#txt_idtramite').value);                    
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    TramiteById:function(data,evento){
        $.ajax({
            url         : 'tramitec/getbyid',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
              /*  $(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                    
                }
            },
            error: function(){
                /*$(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);*/
            }
        });
    },
    GetPersons:function(data,evento){
        $.ajax({
            url         : 'persona/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
            },
            success : function(obj) {
                if(obj.rst==1){
                    evento(obj.datos);
                    /*poblateData('persona',obj.datos[0]);*/
                }
            },
            error: function(){
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
};
</script>
