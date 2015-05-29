<script type="text/javascript">
var persona_id, cargos_selec=[], PersonaObj;
var Persona={
    AgregarEditarPersona:function(AE){
        $("#form_personas input[name='cargos_selec']").remove();
        $("#form_personas").append("<input type='hidden' value='"+cargos_selec+"' name='cargos_selec'>");
        
        var datos=$("#form_personas").serialize().split("txt_").join("").split("slct_").join("");
        var accion="persona/crear";
        if(AE==1){
            accion="persona/editar";
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
                    $('#t_personas').dataTable().fnDestroy();

                    Persona.CargarPersonas(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#personaModal .modal-footer [data-dismiss="modal"]').click();
                    cargos_selec=[];
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
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.</b>'+
                                '</div>');
                //cargos_selec=[];
            }
        });
    },
    CargarPersonas:function(evento){
        $.ajax({
            url         : 'persona/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
                slctGlobal.listarSlct('cargo','slct_cargos','simple');//para que cargue antes el cargo
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargarPersona(obj.datos);
                    PersonaObj=obj.datos;
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                    '<i class="fa fa-ban"></i>'+
                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.</b>'+
                '</div>');
            }
        });
    },
    CargarAreas:function(persona_id){
        //getOpciones
        $.ajax({
            url         : 'persona/cargarareas',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {persona_id:persona_id},
            async       : false,
            beforeSend : function() {
                
            },
            success : function(obj) {
                //CARGAR areas
                if(obj.datos[0].DATA !== null){
                    var cargos = obj.datos[0].DATA.split("|"); 

                    var html="";

                    $.each(cargos, function(i,opcion){
                        var data = opcion.split("-");
                        html+="<li class='list-group-item'><div class='row'>";
                        html+="<div class='col-sm-4' id='cargo_"+data[0]+"'><h5>"+$("#slct_cargos option[value=" +data[0] +"]").text()+"</h5></div>";
                        var areas = data[1].split(",");
                        html+="<div class='col-sm-6'><select class='form-control' multiple='multiple' name='slct_areas"+data[0]+"[]' id='slct_areas"+data[0]+"'></select></div>";
                        //var envio = {cargo_id: data[0]};
                        var envio = {cargo_id: data[0],estado:1};
                        slctGlobal.listarSlct('area','slct_areas'+data[0],'multiple',areas,envio);

                        html+='<div class="col-sm-2">';
                        html+='<button type="button" id="'+data[0]+'" Onclick="EliminarArea(this)" class="btn btn-danger btn-sm" >';
                        html+='<i class="fa fa-minus fa-sm"></i> </button></div>';
                        html+="</div></li>";
                        cargos_selec.push(data[0]);
                    });
                    $("#t_cargoPersona").html(html); 
                }
            },
            error: function(){
            }
        });
    },
    CambiarEstadoPersonas:function(id,AD){
        $("#form_personas").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_personas").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_personas").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'persona/cambiarestado',
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
                    $('#t_personas').dataTable().fnDestroy();
                    Persona.CargarPersonas(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#personaModal .modal-footer [data-dismiss="modal"]').click();
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
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.</b>'+
                                '</div>');
            }
        });

    },
};
</script>
