<script type="text/javascript">
var CargoObj;
var Verbos={
    AgregarEditarProveedor:function(AE){
        var datos = $("#form_proveedores_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "proveedor/editar" : "proveedor/crear";

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
                    MostrarAjax('proveedores');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#proveedorModal .modal-footer [data-dismiss="modal"]').click();

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
    CambiarEstadoProveedor: function(id, AD){
        $("#form_proveedores_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_proveedores_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos = $("#form_proveedores_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'proveedor/cambiarestado',
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
                    MostrarAjax('proveedores');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#proveedorModal .modal-footer [data-dismiss="modal"]').click();
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



// -- GASTOS
var Cargos={
    AgregarEditar:function(AE, name_frmG, name_controllerG){
        var datos = $("#form_"+name_frmG+"_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? name_controllerG+"/editar" : name_controllerG+"/crear";

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
                    $('#t_'+name_frmG).dataTable().fnDestroy();
                    
                    Cargos.CargarCargos(activarTablaG);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#btn-cerrar-modi-gastos').click();

                }else{ 
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
    CargarCargos:function(evento){
        var datos = $("#form_"+name_frmG).serialize().split("txt_").join("").split("slct_").join("");

        $.ajax({
            url         : name_controllerG+'/cargargastos',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargarCargo(obj.datos);
                    CargoObj=obj.datos;
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
    }
    // --
};

</script>
