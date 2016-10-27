var Login={
    IniciarLogin:function(){
        var datos=$("#logForm").serialize();
        var url_login=$("#logForm").attr("action");
        $.ajax({
            url         : url_login,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {                
                $(".load").show();   
            },
            success : function(obj) {
                $(".load").hide();
                
                if(obj.rst==1 && obj.estado==1){
                    window.location='admin.inicio';
                }
                else if(obj.rst==1){
                    MostrarMensaje(obj.msj);
                }
                else if(obj.rst==2){
                    MostrarMensaje(obj.msj);
                }                
            },
            error: function(){
                $(".load").hide();
            }
        });
    },
    Register:function(){
        var datos=$("#registerForm").serialize();//.split("_register").join("");
        var url=$("#registerForm").attr("action");
        $.ajax({
            url         : url,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $(".load").show();
            },
            success : function(obj) {
                $(".load").hide();
                
                if(obj.rst==1 && obj.estado==1){
                    window.location='admin.inicio';
                }
                else if(obj.rst==1){
                    MostrarMensaje(obj.msj);
                }
                else if(obj.rst==2){
                    MostrarMensaje(obj.msj);
                }
            },
            error: function(){
                $(".load").hide();
            }
        });
    },
    EnviarEmail:function(){
        var datos=$("#sendEmail").serialize();//.split("_register").join("");
        var url=$("#sendEmail").attr("action");
        $.ajax({
            url         : url,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $(".load").show();
            },
            success : function(obj) {
                $(".load").hide();
                if (obj.error) {
                    MostrarMensaje(obj.error);
                }
                if (obj.status) {
                    MostrarMensaje(obj.status,'ok');
                }
            },
            error: function(){
                $(".load").hide();
            }
        });
    },
    ResetPass:function(){
        var datos=$("#sendReset").serialize();//.split("_register").join("");
        var url=$("#sendReset").attr("action");
        $.ajax({
            url         : url,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $(".load").show();
            },
            success : function(obj) {
                $(".load").hide();
                if (obj.rst==1) {
                    window.location='/';
                }
                if (obj.error) {
                    MostrarMensaje(obj.error);
                }
            },
            error: function(){
                $(".load").hide();
            }
        });
    },
};