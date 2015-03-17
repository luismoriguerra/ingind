<script type="text/javascript">
var Cargos={
    AgregarEditarCargo:function(AE){
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
    AgregarOpcion:function(cargo_id,opcion_id){
        //alert(''+cargo_id+opcion_id+'');
        //enviar un ajax


        var opciones=$('#slct_opciones option:selected').text();
        var menu=$('#slct_menus option:selected').text();



        //estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        

        html="<tr>"+
            "<td>"+menu+"</td>"+
            "<td>"+opciones+"</td>"+
            /*"<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+*/
            '<td><a class="btn btn-danger btn-xs"><i class="fa fa-minus fa-xs"></i> </a></td>';

        html+="</tr>";

        
        $("#tb_opcionCargo").before(html);


    },
    CargarCargos:function(evento){
        $.ajax({
            url         : 'cargo/cargar',
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
            },
            error: function(){
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
                if(obj.datos[0].DATA != null){
                    var menus = obj.datos[0].DATA.split("|"); 
//0: "1-1,2,3"
//1: "2-5,6,7,11"
                    var html="";

                    $.each(menus, function(i,opcion){
                        //OBTENGO EL menus Y LOS opciones REGISTRADOS
                        var data = opcion.split("-");//1  -    1,2,3
                        //AGREGO EL menus EN HTML

                        //agregarSubmoduloHTML(data[0],$("#menus option[value=" +data[0] +"]").text());
                        //DESELECCIONO TODOS LOS opciones DE ESE opcion
                        //añadir modulos a la variable global

                        html+="<tr>"+
                            "<td id='menu_"+data[0]+"'>"+$("#slct_menus option[value=" +data[0] +"]").text()+"</td>";
                            
                            
                        

                        $("#opcion_"+data[0]+" option").attr("selected",false);
                        //OBTENDO LOS opciones REGISTRADOS EN ARRAY
                        var opciones = data[1].split(",");
                        /*$.each(opciones,function(i,e){
                            //SELECCIONO LOS opciones
                            $("#opcion_"+data[0]+" option[value="+ e+"]").attr("selected",true);
                        });*/



                        html+="<td id='opciones_"+opciones+"' ><select class='form-control' multiple='multiple' name='slct_opciones"+data[0]+"[]' id='slct_opciones"+data[0]+"'></select></td>";

                        slctGlobal.listarSlct('opcion','slct_opciones'+data[0],'multiple',opciones);
                        //cerrar div
                        html+='<td><a class="class="btn btn-danger btn-xs"" data-id="'+data.id+'" data-titulo="Eliminar"><i class="fa fa-minus fa-sm"></i> </a></td>';

                        html+="</tr>";
                        //REFRESCO EL MULTISELECT
                        $("#opcion_"+data[0]).multiselect("refresh");
                    });
                $("#tb_opcionCargo").html(html); 
                

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