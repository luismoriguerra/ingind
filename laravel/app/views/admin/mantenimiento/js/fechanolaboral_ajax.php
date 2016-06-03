<script type="text/javascript">

var CategoriaObj;

var FechaNolaborable = {

    CargarFechas: function(evento){

        $('#calendar').fullCalendar( 'refetchEvents' );

    },
    AgregarEditarFecha: function(AE){

        var datos = $("#form_fechanolaborable").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "fechanolaborable/editar" : "fechanolaborable/crear";

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

                    FechaNolaborable.CargarFechas();

                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');

                    $('#fechanolaborableModal .modal-footer [data-dismiss="modal"]').click();

                } else {
                    $.each(obj.msj, function(index, datos){
                        $("#error_"+index).attr("data-original-title", datos);
                        $('#error_'+index).css('display','');
                    });
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
    }

};

</script>