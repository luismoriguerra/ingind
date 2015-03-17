<script type="text/javascript">
var Cargos={
    AgregarEditarCargo:function(AE){
        $("#form_cargos").append("<input type='hidden' value='"+menus_selec+"' name='menus_selec'>");
        var datos=$("#form_cargos").serialize().split("txt_").join("").split("slct_").join("");
        var accion="cargo/crear";
        if(AE==1){
            accion="cargo/editar";
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
                    $('#t_cargos').dataTable().fnDestroy();

                    Cargos.CargarCargos(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#cargoModal .modal-footer [data-dismiss="modal"]').click();
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
    CargarCargos:function(evento){
        $.ajax({
            url         : 'cargo/cargar',
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
                            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cargoModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

                        html+="</tr>";
                    });
                }
                $("#tb_cargos").html(html); 
                evento();
                $(".overlay,.loading-img").remove();

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
    CargarOpciones:function(cargo_id){
        //getOpciones
        $.ajax({
            url         : 'cargo/cargaropciones',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {cargo_id:cargo_id},
            beforeSend : function() {
                
            },
            success : function(obj) {
                //CARGAR opciones
                if(obj.datos[0].DATA !== null){
                    var menus = obj.datos[0].DATA.split("|"); 

                    var html="";

                    $.each(menus, function(i,opcion){
                        var data = opcion.split("-");

                        html+="<li class='list-group-item'><div class='row'>"+
                            "<div class='col-sm-4' id='menu_"+data[0]+"'><h5>"+$("#slct_menus option[value=" +data[0] +"]").text()+"</h5></div>";

                        $("#opcion_"+data[0]+" option").attr("selected",false);

                        var opciones = data[1].split(",");

                        html+="<div class='col-sm-6' opciones='"+opciones+"' ><select class='form-control' multiple='multiple' name='slct_opciones"+data[0]+"[]' id='slct_opciones"+data[0]+"'></select></div>";
                        var envio = {menu_id: data[0]};
                        slctGlobal.listarSlct('opcion','slct_opciones'+data[0],'multiple',opciones,envio);

                        html+='<div class="col-sm-2"><button type="button" id="'+data[0]+'" Onclick="EliminarSubmodulo(this)" class="btn btn-danger btn-sm" ><i class="fa fa-minus fa-sm"></i> </button></div>';

                        html+="</div></li>";
                        menus_selec.push(data[0]);
                    });
                $("#t_opcionCargo").html(html); 

                }
            },
            error: function(){
            }
        });
    },
    CambiarEstadoCargos:function(id,AD){
        $("#form_cargos").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_cargos").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_cargos").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'cargo/cambiarestado',
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
                    $('#t_cargos').dataTable().fnDestroy();
                    Cargos.CargarCargos(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#cargoModal .modal-footer [data-dismiss="modal"]').click();
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