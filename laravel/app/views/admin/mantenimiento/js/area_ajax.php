<script type="text/javascript">
var area_id, AreaObj;
var Areas={
    AgregarEditarArea:function(AE){
        //var formData = new FormData($("#form_areas")[0]); 
        //$("#form_areas input[name='h_imagenp']").remove();
        //$("#form_areas").append("<input type='hidden' value='"+$("#imagenp")[0]+"' name='h_imagenp'>");

        var datos=$("#form_areas").serialize().split("txt_").join("").split("slct_").join("");
        var accion="area/crear";
        if(AE==1){
            accion="area/editar";
            $('#form_imagen_').ajaxForm(options).submit();
            $('#form_imagenp').ajaxForm(options).submit();
            $('#form_imagenc').ajaxForm(options).submit();
        }
        var options = { 
            beforeSubmit:   beforeSubmit(),
            success:        success(),
            dataType: 'json' 
        };
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
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    if(AE==0){//subir imagenes despues de crear el area
                        var area_id=obj.area_id
                        $('#upload_id').val(area_id);
                        $('#upload_idc').val(area_id);
                        $('#upload_idp').val(area_id);
                        $('#form_imagen_').ajaxForm(options).submit();
                        $('#form_imagenc').ajaxForm(options).submit();
                        $('#form_imagenp').ajaxForm(options).submit();
                    }
                    $('#t_areas').dataTable().fnDestroy();

                    Areas.CargarAreas(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');

                    $('#areaModal .modal-footer [data-dismiss="modal"]').click();

                }
                else{ 
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
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
        
    },
    CargarAreas:function(evento){
        $.ajax({
            url         : 'area/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargarArea(obj.datos);
                    AreaObj = obj.datos;
                }
                $(".overlay,.loading-img").remove();
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
    CambiarEstadoAreas:function(id,AD){
        $("#form_areas").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_areas").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_areas").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'area/cambiarestado',
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
                    $('#t_areas').dataTable().fnDestroy();
                    Areas.CargarAreas(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#areaModal .modal-footer [data-dismiss="modal"]').click();
                }
                else{ 
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
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
