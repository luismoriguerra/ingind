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
    }
}