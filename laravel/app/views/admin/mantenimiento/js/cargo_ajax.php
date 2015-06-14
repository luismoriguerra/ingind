<script type="text/javascript">
var cargo_id, menus_selec=[], CargoObj;
var Cargos={
    AgregarEditarCargo:function(AE){
        $("#form_cargos input[name='menus_selec']").remove();
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
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
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
                slctGlobal.listarSlct('menu','slct_menus','simple');//para que cargue antes el menu
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
    },
    CargarOpciones:function(cargo_id){
        //getOpciones
        $.ajax({
            url         : 'cargo/cargaropciones',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {cargo_id:cargo_id},
            async       : false,
            beforeSend : function() {
                
            },
            success : function(obj) {
                //CARGAR opciones
                if(obj.datos[0].DATA !== null){
                    var menus = obj.datos[0].DATA.split("|"); 

                    var html="";

                    $.each(menus, function(i,opcion){
                        var data = opcion.split("-");

                        html+="<li class='list-group-item'><div class='row'>";
                        html+="<div class='col-sm-4' id='menu_"+data[0]+"'><h5>"+$("#slct_menus option[value=" +data[0] +"]").text()+"</h5></div>";
                        var opciones = data[1].split(",");
                        html+="<div class='col-sm-6'><select class='form-control' multiple='multiple' name='slct_opciones"+data[0]+"[]' id='slct_opciones"+data[0]+"'></select></div>";
                        var envio = {menu_id: data[0]};
                        slctGlobal.listarSlct('opcion','slct_opciones'+data[0],'multiple',opciones,envio);

                        html+='<div class="col-sm-2">';
                        html+='<button type="button" id="'+data[0]+'" Onclick="EliminarOpcion(this)" class="btn btn-danger btn-sm" >';
                        html+='<i class="fa fa-minus fa-sm"></i> </button></div>';
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
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    }
};
</script>
