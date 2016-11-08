<script type="text/javascript">
var Bandeja={
    MostrarPreTramites:function(data,evento){
        $.ajax({
            url         : 'pretramite/listarpretramites',
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
    DetallePreTramite:function(data){
        $.ajax({
            url         : 'pretramite/anexosbytramite',
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
                    /*evento(obj.data);           */         
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    GetTipoSolicitante:function(data,evento){
        $.ajax({
            url         : 'tiposolicitante/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
                /*$(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                    
                }
            },
            error: function(){
            /*    $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    getEmpresasByPersona:function(data,evento){
        $.ajax({
            url         : 'pretramite/empresasbypersona',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
                /*$(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                    
                }
            },
            error: function(){
            /*    $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    getClasificadoresTramite:function(data,evento){
        $.ajax({
            url         : 'pretramite/clasificadorestramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
                /*$(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                    
                }
            },
            error: function(){
            /*    $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    getRequisitosbyclatramite:function(data,evento,tramite){
        $.ajax({
            url         : 'pretramite/requisitosbyctramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
                /*$(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos,tramite);                    
                }
            },
            error: function(){
            /*    $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    GuardarPreTramite:function(data,evento){
        var datos = {'info':data};
        $.ajax({
            url         : 'pretramite/create',
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
                    evento();                       
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    GetPreTramitebyid:function(data,evento){
        $.ajax({
            url         : 'pretramite/getbyid',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                /*$("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
               /* $(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                       
                }
            },
            error: function(){
               /* $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    }

};
</script>
