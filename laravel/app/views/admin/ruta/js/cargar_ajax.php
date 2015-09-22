<script type="text/javascript">
var Cargar={
    asignacion:function(){
    var formData = new FormData($("#form_file")[0]);

        $.ajax({
            url: 'cargar/asignacion',
            type: 'POST',
            data: formData,
            async: true,
            beforeSend : function() {
                    $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
                },
            success: function (obj) {
            $(".overlay,.loading-img").remove();
                    if(obj.rst==1){
                        $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                            '<i class="fa fa-check"></i>'+
                                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                            '<b>'+obj.msj+'</b>'+
                                        '</div>');
                        Leer(obj.existe);
                    }
                    else{ 
                        $.each(obj.msj,function(index,datos){
                            $("#error_"+index).attr("data-original-title",datos);
                            $('#error_'+index).css('display','');
                        });
                    }
            },
            error: function () {
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
};
</script>
