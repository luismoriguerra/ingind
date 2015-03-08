<script type="text/javascript">
var Tecnicos={
    AgregarEditarTecnico:function(AE){
        var datos=$("#form_tecnicos").serialize().split("txt_").join("").split("slct_").join("");
        var accion="tecnico/crear";
        if(AE==1){
            accion="tecnico/editar";
        }

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
                    $('#t_tecnicos').dataTable().fnDestroy();

                    Tecnicos.CargarTecnicos(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#tecnicoModal .modal-footer [data-dismiss="modal"]').click();
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
                                        '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente. Si el problema persiste favor de comunicarse a ubicame@puedesencontrar.com</b>'+
                                    '</div>');
            }
        });
    },
    CargarCelulas:function(accion, tecnico_id){
        if (accion==='editar') {
            url='celula/listarxtecnico';
        } else { //nuevo
            url='celula/listar';
        }

        $.ajax({
            url         : url,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {'tecnico_id':tecnico_id},
            success : function(obj) {
                if(obj.rst==1){
                    HTMLListarSlct(obj,accion);
                }
            }
        });
    },
    CargarEmpresas:function(accion,empresa_id){
        $.ajax({
            url         : 'empresa/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            success : function(obj) {
                if(obj.rst==1){
                    $('#slct_empresas').html('');
                    $.each(obj.datos,function(index,data){
                        $('#slct_empresas').append('<option value='+data.id+'>'+data.nombre+'</option>');
                    });
                    if (accion==='nuevo')
                        $('#slct_empresas').append('<option selected>--- Elige Empresa ---</option>');
                    else
                       $('#slct_empresas').val( empresa_id );
                }
            }
        });
    },
    CargarTecnicos:function(evento){
        $.ajax({
            url         : 'tecnico/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargarTecnico(obj.datos);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
            }
        });
    },
    CambiarEstadoTecnicos:function(id,AD){
        $("#form_tecnicos").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_tecnicos").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_tecnicos").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'tecnico/cambiarestado',
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
                    $('#t_tecnicos').dataTable().fnDestroy();
                    Tecnicos.CargarTecnicos(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#tecnicoModal .modal-footer [data-dismiss="modal"]').click();
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
                                        '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente. Si el problema persiste favor de comunicarse a ubicame@puedesencontrar.com</b>'+
                                    '</div>');
            }
        });
    }
};
</script>