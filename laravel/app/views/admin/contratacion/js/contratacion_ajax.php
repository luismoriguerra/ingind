<script type="text/javascript">
var Contrataciones={
    AgregarEditarContratacion:function(AE){
        var datos = $("#form_contrataciones_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "contratacion/editar" : "contratacion/crear";

        $.ajax({
            url         : accion,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();
                if(obj.rst==1){
                    MostrarAjax('contrataciones');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#contratacionModal .modal-footer [data-dismiss="modal"]').click();

                } else {
                    var cont = 0;

                    $.each(obj.msj, function(index, datos){
                        cont++;
                         if(cont==1){
                            alert(datos[0]);
                       }

                    });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });

    },
    CargarContrataciones:function(evento){
        $.ajax({
            url         : 'contratacion/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                var html="";
                var estadohtml="";
                if(obj.rst==1){
                    $.each(obj.datos,function(index,data){
                        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
                        if(data.estado==1){
                            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
                        }

                        html+="<tr>"+
                            "<td id='nombre_"+data.id+"'>"+data.nombre+"</td>"+
                            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#contratacionModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

                        html+="</tr>";
                    });
                }
                $("#tb_contrataciones").html(html); 
                evento();  
            },
            error: function(){
            }
        });
    },
     CargarDetalleContrataciones:function( data ){
        $.ajax({
            url         : 'contratacion/listardetallecontratacion',
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
                    mostrarHTML(obj.datos);
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
      CambiarEstadoContrataciones: function(id, AD){
        $("#form_contrataciones_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_contrataciones_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos = $("#form_contrataciones_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'contratacion/cambiarestado',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                     MostrarAjax('contrataciones');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#contrataciondetalleModal .modal-footer [data-dismiss="modal"]').click();
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
    AgregarEditarDetalleContratacion:function(AE){
        var datos = $("#form_detalle_contrataciones_modal").serialize().split("txt_").join("").split("slct_").join("");
        var id_contratacion=$("#form_detalle_contrataciones_modal #txt_contratacion_id").val();
        var accion = (AE==1) ? "contratacion/editardetalle" : "contratacion/creardetalle";
        
        $.ajax({
            url         : accion,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();
                if(obj.rst==1){
                    CargarDetalleContratacion(id_contratacion);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#contrataciondetalleModal .modal-footer [data-dismiss="modal"]').click();

                } else {
                    var cont = 0;

                    $.each(obj.msj, function(index, datos){
                        cont++;
                         if(cont==1){
                            alert(datos[0]);
                       }

                    });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });

    },
    CambiarEstadoDetalleContrataciones: function(id){
        $("#form_detalle_contrataciones_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        var id=$("#form_detalle_contrataciones_modal #txt_contratacion_id").val();
        var datos = $("#form_detalle_contrataciones_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'contratacion/cambiarestadodetalle',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    CargarDetalleContratacion(id);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#contrataciondetalleModal .modal-footer [data-dismiss="modal"]').click();
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
    Confirmardetalle: function(id){
        $("#form_detalle_contrataciones_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        var id_contratacion=$("#form_detalle_contrataciones_modal #txt_contratacion_id").val();
        var datos = $("#form_detalle_contrataciones_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'contratacion/confirmardetalle',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    CargarDetalleContratacion(id_contratacion);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#contrataciondetalleModal .modal-footer [data-dismiss="modal"]').click();
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
            
    Denegardetalle: function(id){
        $("#form_detalle_contrataciones_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        var id_contratacion=$("#form_detalle_contrataciones_modal #txt_contratacion_id").val();
        var datos = $("#form_detalle_contrataciones_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'contratacion/denegardetalle',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    CargarDetalleContratacion(id_contratacion);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#contrataciondetalleModal .modal-footer [data-dismiss="modal"]').click();
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
            
    Confirmar: function(id){
        $("#form_contrataciones_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        var datos = $("#form_contrataciones_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'contratacion/confirmar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    MostrarAjax("contrataciones");
                    msjG.mensaje('success',obj.msj,4000);
                    $('#contratacionModal .modal-footer [data-dismiss="modal"]').click();
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
    Denegar: function(id){
        $("#form_contrataciones_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        var datos = $("#form_contrataciones_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'contratacion/denegar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    MostrarAjax("contrataciones");
                    msjG.mensaje('success',obj.msj,4000);
                    $('#contratacionModal .modal-footer [data-dismiss="modal"]').click();
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
};
</script>
