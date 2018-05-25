<script type="text/javascript">
var Validar={
    mostrarRutaDetalle:function(datos,evento){
        $.ajax({
            url         : 'ruta_detalle/cargarrd',
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
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    mostrarTramite:function(datos,evento){
        $.ajax({
            url         : 'ruta_detalle/cargartramite',
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
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    mostrarTramiteXArea:function(datos,evento){
        $.ajax({
            url         : 'ruta_detalle/cargartramitexarea',
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
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    mostrarDetalle:function(datos,evento){
        $.ajax({
            url         : 'ruta_detalle/cargardetalle',
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
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    guardarArhivoDesmonte:function(evento,id, data){
        $.ajax({
            url         : 'ruta_detalle/actualizararchivodesmonte',
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
                    Close();
                    if(id!=null){
                        var rta_id= document.querySelector('#ruta_id').value;
                        evento(id,(rta_id) ? rta_id : '');
                    }
                    else if(evento!=null){
                        evento();
                    }
                    else{
                        Close(1);
                        Bandeja.MostrarAjax();
                    }
                    msjG.mensaje("success",obj.msj,5000);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
    eliminarArchivoDes:function(id, archivos){
        $.ajax({
            url         : 'ruta_detalle/eliminararchivodesmonte',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {id:id, archivos:archivos},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    msjG.mensaje("success",obj.msj,3000);
                }  
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    guardarValidacion:function(evento,id){
        var datos=$("#form_ruta_detalle").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'ruta_detalle/actualizar',
            type        : 'POST',
            cache       : false,
            async       : false,//no ejecuta otro ajax hasta q este termine
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    Close();
                    if(id!=null){
                        var rta_id= document.querySelector('#ruta_id').value;
                        evento(id,(rta_id) ? rta_id : '');
                    }
                    else if(evento!=null){
                        evento();
                    }
                    else{
                        Close(1);
                        Bandeja.MostrarAjax();
                    }
                    msjG.mensaje("success",obj.msj,5000);
                }  
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    ActualizarTramite:function(datos, valor){
        $.ajax({
            url         : 'ruta_detalle/actualizartramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    msjG.mensaje("success",obj.msj,3000);
                    if(valor == 1)
                        buscar();
                    else
                        buscarpa();
                    Close();
                }  
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    VerificarUltimopaso:function(datos){
        $.ajax({
            async       : false,
            url         : 'ruta_detalle/verificarultimopaso',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                ultimo=obj;
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
        return ultimo;
    }
}
</script>
