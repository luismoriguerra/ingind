<script type="text/javascript">
var Tickets={
    AgregarEditarTicket:function(AE){
        var datos = $("#form_tickets_modal").serialize().split("txt_").join("").split("slct_").join("");
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
                    MostrarAjax('tickets');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#ticketModal .modal-footer [data-dismiss="modal"]').click();

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
                    MostrarAjax('ticket');
          
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
      CambiarEstadoTickets: function(id, AD){
        $("#form_tickets_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_tickets_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos = $("#form_tickets_modal").serialize().split("txt_").join("").split("slct_").join("");
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
                    MostrarAjax('tickets');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#ticketModal .modal-footer [data-dismiss="modal"]').click();
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
    }
};
</script>
