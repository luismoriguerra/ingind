<script type="text/javascript">
$(document).ready(function() {  
    Cargos.cargarBienes({area:1});

    function initDatePicker(){
        $('#txt_fechaadquisicion,#txt_fechaalerta').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            multidate: 1,
            todayHighlight:true,
        })
    }
    initDatePicker();
    slctGlobal.listarSlctFuncion('biencategoria','cargar','slct_categoria','simple',null,{estado:1});


    $(document).on('change', '#slct_alerta', function(event) {
        if($(this).val() == 1){
            $(".motivoAlerta").removeClass('hidden');
        }else{
            $(".motivoAlerta").addClass('hidden');
        }
    });

    $(document).on('click', '.btnNuevo', function(event) {
        event.preventDefault();
        var ref = $(this).attr('modal-siguiente');
        $("#AvisoModal").modal('hide');
        $("#"+ref).modal('show');
    });


    $(document).on('click', '.editBien', function(event) {
        $("#btnAccion").text('Actualizar');
        $("#btnAccion").attr('onClick','EditarBien();');
        Cargos.cargarBienes({id:$(this).attr('data-id')},1);
    });

    $(document).on('click', '.nuevaCaracteristica', function(event) {
        $("#btnAccion2").text('Guardar');
        $("#btnAccion2").attr('onClick','AgregarCaracteristica();');
    });

    $(document).on('click', '.editCaracteristica', function(event) {
        $("#btnAccion2").text('Actualizar');
        $("#btnAccion2").attr('onClick','EditarCaracteristica();');
    });


    $('#accionBien').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        id = button.data('id'); //extrae el id del atributo data

        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Bien');
        $('#form_bienes [data-toggle="tooltip"]').css("display","none");
        $("#form_bienes input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
        }
    });

    $('#accionBien').on('hide.bs.modal', function (event) {
/*        var modal = $(this); //captura el modal
        modal.find('.modal-body input').val(''); // busca un input para copiarle texto*/
      /* $("#form_AccionBien input[type='hidden'],#form_AccionBien input[type='text'],#form_AccionBien select,#form_AccionBien textarea").not('.mant').val("");*/
    });



    $('#nuevaCaracteristica').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        id = button.data('id'); //extrae el id del atributo data
        
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text('Bien - Caracteristica');
        
        if(titulo=='Editar'){
           /* modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarCaracteristica();');*/

            $('#form_nuevaCaracteristica #txt_nombre').val(button.data('nombre'));
            $('#form_nuevaCaracteristica #txt_valor').val(button.data('valor'));
            $('#form_nuevaCaracteristica #txt_observ').val(button.data('observacion'));
            $('#form_nuevaCaracteristica #slct_alerta').val(button.data('alerta'));

            var fechaAd = new Date(button.data('fecha'));
            var month = fechaAd.getMonth()+1;
            if(fechaAd){
                $('#form_nuevaCaracteristica #txt_fechaalerta').val(fechaAd.getFullYear()+"-"+month+"-"+fechaAd.getDate());
            }else{
                $('#form_nuevaCaracteristica #txt_fechaalerta').val('');
            }

            $('#form_nuevaCaracteristica #txt_motivoalerta').val(button.data('razon'));

            if(button.data('alerta') == 1){
                 $(".motivoAlerta").removeClass('hidden');
            }else{
                 $(".motivoAlerta").addClass('hidden');
            }
            $("#form_nuevaCaracteristica").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }
    });

    $('#nuevaCaracteristica').on('hide.bs.modal', function (event) {
/*        var modal = $(this); //captura el modal
        modal.find('.modal-body input').val(''); // busca un input para copiarle texto
       $("#form_nuevaCaracteristica input[type='text'],#form_nuevaCaracteristica select,#form_nuevaCaracteristica textarea").not('.mant').val("");*/
    });



    $('#nuevoEvento').on('show.bs.modal', function (event) {
        $("#slct_categoriaevent").multiselect('destroy');
        slctGlobal.listarSlctFuncion('Categoriaevento','cargar','slct_categoriaevent','simple',null,{estado:1});
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        id = button.data('id'); //extrae el id del atributo data

        var modal = $(this); //captura el modal
        modal.find('.modal-title').text('Evento - Caracteristica');
        $('#form_nuevoEvento [data-toggle="tooltip"]').css("display","none");
        $("#form_nuevoEvento input[type='hidden']").remove();

        if(titulo=='Nuevo'  || typeof titulo == 'undefined'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarEvento();');
        }
    });

    $('#nuevoEvento').on('hide.bs.modal', function (event) {
        var modal = $(this); //captura el modal
        modal.find('.modal-body input').val(''); // busca un input para copiarle texto
       $("#form_nuevoEvento #slct_categoriaevent,#form_nuevoEvento #txt_observ").not('.mant').val("");
    });
});


seleccionado = function(obj){
    if(obj){
        var tbody = obj.parentNode.parentNode.parentNode.getAttribute('id');
        var tr = document.querySelectorAll("#" + tbody + " tr");
        for (var i = 0; i < tr.length; i++) {
            tr[i].setAttribute("style","background-color:#f9f9f9;");
        }
        obj.parentNode.parentNode.setAttribute("style","background-color:#9CD9DE;");
    }
}

aviso = function(msj,modalSiguiente){
    $("#spanMensaje").text(msj);
    $("#AvisoModal").modal('show');
    $(".btnNuevo").attr('modal-siguiente',modalSiguiente);
}

activarTabla=function(){
    $("#t_cargos").dataTable(); // inicializo el datatable    
};

EditarBien=function(){
    Cargos.AgregarEditarCargo(1);
};

activar=function(id){
    Cargos.CambiarEstadoCargos(id,1);
};
desactivar=function(id){
    Cargos.CambiarEstadoCargos(id,0);
};

activarB = function(id){
    Cargos.CambiarEstadoB({'id':id,'estado':1});
};

desactivarB = function(id){
    Cargos.CambiarEstadoB({'id':id,'estado':0});
};

activarC = function(id){
    Cargos.CambiarEstadoC({'id':id,'estado':1});
};

desactivarC = function(id){
    Cargos.CambiarEstadoC({'id':id,'estado':0});
};

Agregar=function(){
    if($("#txt_nombre").val() == ""){
        alert('Registre Nombre');
    }else if($("#slct_categoria").val() == ""){
        alert('Seleccione Categoria');
    }else if($("#txt_nroInterno").val() == ""){
        alert('Registre Nro Interno');
    }else if($("#txt_fechaadquisicion").val() == ""){
        alert('Seleccione Fecha de Adquision');
    }else{
        Cargos.AgregarEditarCargo(0);        
    }
};

AgregarCaracteristica = function(){
    Cargos.AgregarEditarBienCaracteristica(0);
}

EditarCaracteristica=function(){
    Cargos.AgregarEditarBienCaracteristica(1);
};

AgregarEvento = function(){
    Cargos.AgregarEditarEvento(0);
}

AgregarOpcion=function(){
    //añadir registro "opcion" por usuario
    var menu_id=$('#slct_menus option:selected').val();
    var menu=$('#slct_menus option:selected').text();
    var buscar_menu = $('#menu_'+menu_id).text();
    if (menu_id!=='') {
        if (buscar_menu==="") {

            var html='';
            html+="<li class='list-group-item'><div class='row'>";
            html+="<div class='col-sm-4' id='menu_"+menu_id+"'><h5>"+menu+"</h5></div>";

            html+="<div class='col-sm-6'>";
            html+="<select class='form-control' multiple='multiple' name='slct_opciones"+menu_id+"[]' id='slct_opciones"+menu_id+"'></select></div>";
            var envio = {menu_id: menu_id};

            html+='<div class="col-sm-2">';
            html+='<button type="button" id="'+menu_id+'" Onclick="EliminarOpcion(this)" class="btn btn-danger btn-sm" >';
            html+='<i class="fa fa-minus fa-sm"></i> </button></div>';
            html+="</div></li>";

            $("#t_opcionCargo").append(html);
            slctGlobal.listarSlct('opcion','slct_opciones'+menu_id,'multiple',null,envio);
            menus_selec.push(menu_id);
        } else 
            alert("Ya se agrego este menu");
    } else 
        alert("Seleccione Menu");

};
EliminarOpcion=function(obj){
    //console.log(obj);
    var valor= obj.id;
    obj.parentNode.parentNode.parentNode.remove();
    var index = menus_selec.indexOf(valor);
    menus_selec.splice( index, 1 );
};
validaCargos=function(){
    $('#form_cargos [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","nombre","");
    var rpta=true;

    for(i=0;i<a.length;i++){
        if(a[i]===false){
            rpta=false;
            break;
        }
    }
    return rpta;
};

valida=function(inicial,id,v_default){
    var texto="Seleccione";
    if(inicial=="txt"){
        texto="Ingrese";
    }

    if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
        $('#error_'+id).attr('data-original-title',texto+' '+id);
        $('#error_'+id).css('display','');
        return false;
    }   
};

confirmar = function(idevento,estado){
    Cargos.ComfirmarEvento({id:idevento,estado:estado});
}

caracteristicaBien = function (obj){
    var id= obj.getAttribute('id-bien');
    $("#txt_idbien").val(id);
    Cargos.Biencaracteristica({idbien:id});
}

eventosCaracteristica = function(obj){
    var id= obj.getAttribute('id-caracteristica');
    $("#txt_idcaracteristica").val(id);
    Cargos.EventoCaracteristica({idcaracteristica:id});
}

poblateInfo = function(datos){
    if(datos.length > 0){
        var fechaAd = new Date(datos[0].fecha_adquisicion);
        var month = fechaAd.getMonth()+1;
        $('#form_AccionBien #txt_nombre').val(datos[0].descripcion);
        $('#form_AccionBien #slct_categoria').val(datos[0].bienes_categoria_id);
        $('#form_AccionBien #slct_categoria').multiselect('refresh');
        $('#form_AccionBien #txt_marca').val(datos[0].marca);
        $('#form_AccionBien #txt_modelo').val(datos[0].modelo);
        $('#form_AccionBien #txt_nroInterno').val(datos[0].nro_interno);
        $('#form_AccionBien #txt_serie').val(datos[0].serie);
        $('#form_AccionBien #txt_ubicacion').val(datos[0].ubicacion);
        $("#form_AccionBien #txt_fechaadquisicion").val(fechaAd.getFullYear()+"-"+month+"-"+fechaAd.getDate());
        $("#form_AccionBien").append("<input type='hidden' value='"+datos[0].id+"' name='id'>");
    }
}

HTMLCaracteristicasBien = function (datos){
    var html="";
    $('#t_caracteristica').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activarC('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivarC('+data.id+')" class="btn btn-success">Activo</span>';
        }

        alerta = (data.alerta == 1 ) ? 'SI' : 'NO';
        razon = (typeof data.alerta_razon == 'object' ) ? '' : data.alerta_razon;
        alerta_fecha = (typeof data.alerta_fecha == 'object') ? '' : data.alerta_fecha;


        html+="<tr>"+
            "<td >"+data.descripcion+"</td>"+
            "<td >"+data.observacion+"</td>"+
            "<td >"+data.valor+"</td>"+
            "<td >"+alerta+"</td>"+
            "<td >"+razon+"</td>"+
            "<td >"+alerta_fecha+"</td>"+
            "<td >"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm editCaracteristica" data-toggle="modal" data-target="#nuevaCaracteristica" data-id="'+data.id+'" data-nombre="'+data.descripcion+'" data-estado="'+data.estado+'" data-valor="'+data.valor+'" data-alerta="'+data.alerta+'" data-fecha="'+alerta_fecha+'" data-razon="'+razon+'" data-observacion="'+data.observacion+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>'+
            '<td><span class="btn btn-primary btn-sm" id-caracteristica="'+data.id+'" onclick="seleccionado(this),eventosCaracteristica(this)"><i class="glyphicon glyphicon-th-list"></i></span></td>';
        html+="</tr>";
    });
    $("#tb_caracteristica").html(html); 
    $('#t_caracteristica').dataTable();
}

HTMLCaracteristicaEventos = function (datos){
    RolIdG='<?php echo Auth::user()->rol_id; ?>';
    var html="";
    $('#t_evento').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        var estadohtml = '';
        if(RolIdG == 8 || RolIdG == 9){
            estadohtml='<span id="'+data.id+'" onClick="confirmar('+data.id+',1)" class="btn btn-danger">Por Confirmar</span>';
            if(data.confirmacion==1){
                estadohtml='<span id="'+data.id+'" onClick="confirmar('+data.id+',0)" class="btn btn-success">Confirmado</span>';
            }            
        }else{
            estadohtml='Por confirmar';
            if(data.confirmacion==1){
                estadohtml='Comfirmado';
            }       
        }

        html+="<tr>"+
            "<td >"+data.nombre+"</td>"+
            "<td >"+data.descripcion+"</td>"+
            "<td >"+estadohtml+"</td>";
        html+="</tr>";
    });
    $("#tb_evento").html(html); 
    $('#t_evento').dataTable();
}

HTMLCargarBienes=function(datos){
    var html="";
    $('#t_cargos').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activarB('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivarB('+data.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr>"+
            "<td >"+data.descripcion+"</td>"+
            "<td >"+data.nombre+"</td>"+
            "<td >"+data.marca+"</td>"+
            "<td >"+data.modelo+"</td>"+
            "<td >"+data.nro_interno+"</td>"+
            "<td >"+data.serie+"</td>"+
            "<td >"+data.ubicacion+"</td>"+
            "<td >"+data.fecha_adquisicion+"</td>"+
            "<td >"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm editBien" data-toggle="modal" data-target="#accionBien" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>'+
             '<td><span class="btn btn-primary btn-sm" id-bien="'+data.id+'" onclick="seleccionado(this),caracteristicaBien(this)"><i class="glyphicon glyphicon-th-list"></i></span></td>';
        html+="</tr>";
    });
    $("#tb_cargos").html(html); 
    $('#t_cargos').dataTable();
};
</script>

