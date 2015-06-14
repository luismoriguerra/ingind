<script type="text/javascript">
var Usuario={
    MisDatos:function(){
        var datos=$("#form_misdatos").serialize().split("txt_").join("").split("slct_").join("");
        var accion="usuario/misdatos";

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
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $("#txt_password,#txt_newpassword,#txt_confirm_new_password").val('');
                }
                else{
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display',''); 
                        $("#txt_"+index+",#slct_"+index).focus();
                    });
                }
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
    EliminarContacto:function(id){
        $("#form_contactos").append("<input type='hidden' value='"+id+"' name='id'>");
        var datos=$("#form_contactos").serialize().split("txt_").join("").split("slct_").join("");
        var accion="usuario/eliminarcontacto";

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
                    $('#t_contactos').dataTable().fnDestroy();

                    Usuario.CargarContactos(activarTabla);

                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>'); 
                    $('#contactoModal .modal-footer [data-dismiss="modal"]').click();
                }
                else{
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display',''); 
                        $("#txt_"+index+",#slct_"+index).focus();
                    });
                }
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
    CargarContactos:function(evento){
        $.ajax({
            url         : 'usuario/cargarcontactos',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                
            },
            success : function(obj) {
                var html="";
                var estadohtml="";
                if(obj.rst==1){
                    $.each(obj.datos,function(index,data){
                        estadohtml='<span id="'+data.id+'" class="label label-warning"><?=trans("greetings.pendiente"); ?></span>';
                        if(data.estado==1){
                            estadohtml='<span id="'+data.id+'" class="label label-success"><?=trans("greetings.confirmado"); ?></span>';
                        }

                        html+="<tr>"+
                            "<td id='email_"+data.id+"'>"+data.email+"</td>"+
                            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                            '<td><a onClick="Eliminar('+data.id+');" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-lg"></i> </a></td>';
                        html+="</tr>";
                    });
                }
                $("#tb_contactos").html(html); 
                evento();  
            },
            error: function(){
            }
        });
    },
    cargarEmpresa:function(accion,empresa_id){
        $.ajax({
            url         : 'empresa/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            success : function(obj) {
                if(obj.rst==1){
                    $('#slct_empresa_id').html('');
                    $.each(obj.datos,function(index,data){
                        $('#slct_empresa_id').append('<option value='+data.id+'>'+data.nombre+'</option>');
                    });
                    if (accion==='nuevo')
                        $('#slct_empresa_id').append('<option selected>--- Elige Empresa ---</option>');
                    else
                       $('#slct_empresa_id').val( empresa_id );
                } 
            }
        });
    },
    cargarEmpresas:function(accion,usuario_id){
        $.ajax({
            url         : 'empresa/listarxusuario',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {'usuario_id':usuario_id},
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargarEmpresas(obj,accion);
                }
            }
        });
    },
    cargarPerfiles:function(accion,perfil_id){
        $.ajax({
            url         : 'perfil/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            success : function(obj) {
                if(obj.rst==1){
                    $('#slct_perfil_id').html('');
                    $.each(obj.datos,function(index,data){
                        $('#slct_perfil_id').append('<option value='+data.id+'>'+data.nombre+'</option>');
                    });
                    if (accion==='nuevo')
                        $('#slct_perfil_id').append('<option selected>--- Elige perfil ---</option>');
                    else
                       $('#slct_perfil_id').val( perfil_id );
                } 
            }
        });
    },
    CargarQuiebres:function(accion, usuario_id){
        if (accion==='editar') {
            url='quiebre/listarxusuario';
        } else { //nuevo
            url='quiebre/listar';
        }

        $.ajax({
            url         : url,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {'usuario_id':usuario_id},
            success : function(obj) {
                if(obj.rst==1){
                    HTMLListarSlct(obj,accion);
                }
            }
        });
    },
    AgregarEditarUsuario:function(AE){
        var datos=$("#form_usuarios").serialize().split("txt_").join("").split("slct_").join("");
        var accion="usuario/crear";
        if(AE==1){
            accion="usuario/editar";
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
                    $('#t_usuarios').dataTable().fnDestroy();

                    Usuario.CargarUsuarios(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#usuarioModal .modal-footer [data-dismiss="modal"]').click();
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
    CargarUsuarios:function(evento){
        $.ajax({
            url         : 'usuario/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargarUsuario(obj.datos);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
            }
        });
    },
    AgregarContacto:function(){
        var datos=$("#form_contactos").serialize().split("txt_").join("").split("slct_").join("");
        var accion="usuario/crearcontacto";

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
                    $('#t_contactos').dataTable().fnDestroy();

                    Usuario.CargarContactos(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#contactoModal .modal-footer [data-dismiss="modal"]').click();
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
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
};
</script>
