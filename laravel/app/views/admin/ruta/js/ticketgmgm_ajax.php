<script type="text/javascript">
var Ticketgmgms={
    AgregarEditarTicket:function(AE){
        var datos = $("#form_ticketgmgms_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "ticket/editar" : "ticket/crear";

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
                    MostrarAjax('ticketgmgms');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#ticketgmgmModal .modal-footer [data-dismiss="modal"]').click();

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
    
    CargarTickets:function(evento){
        $.ajax({
            url         : 'ticket/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
                

            },
            success : function(obj) {
                if(obj.rst==1){
                    MostrarAjax('ticketgmgms');
          
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },

    CambiarEstadoTickets: function(){ //atendido a solucion
        
        var datos = $("#form_soluciongmgm_modal").serialize().split("txt_").join("").split("slct_").join("");
            $.ajax({
            url         : 'ticket/cambiarestado',
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
                    MostrarAjax('ticketgmgms');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#soluciongmgmModal .modal-footer [data-dismiss="modal"]').click();

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

      CambiarEstadoTickets_Pendiente: function(id, AD){ //pendiete a atendido
        $("#form_ticketgmgms_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_ticketgmgms_modal").append("<input type='hidden' value='"+AD+"' name='estado_ticket'>");
        var datos = $("#form_ticketgmgms_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'ticket/cambiarestado',
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
                    MostrarAjax('ticketgmgms');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#ticketgmgmModal .modal-footer [data-dismiss="modal"]').click();
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

    EliminarTicket:function(data){
        $.ajax({
            url         : 'ticket/cambiarestadoticket',
            type        : 'POST',
            cache       : false,
            data        : data,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    MostrarAjax('ticketgmgms');
                }  
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
};


</script>
