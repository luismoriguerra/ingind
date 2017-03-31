<script type="text/javascript">
$(document).ready(function() {  
    Cargos.cargarCategorias({estado:1});

    $('#nuevoBien').on('show.bs.modal', function (event) {
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
            $('#form_bienes #slct_estado').val(1); 
            $('#form_bienes #txt_nombre').focus();
        }
        else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_bienes #txt_nombre').val(button.data('nombre'));
            $('#form_bienes #txt_observ').val(button.data('observacion'));
            $('#form_bienes #slct_estado').val(button.data('estado'));
            $("#form_bienes").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }
    });

    $('#nuevoBien').on('hide.bs.modal', function (event) {
        var modal = $(this); //captura el modal
        modal.find('.modal-body input').val(''); // busca un input para copiarle texto
       $("#form_bienes input[type='hidden'],#form_bienes input[type='text'],#form_bienes select,#form_bienes textarea").not('.mant').val("");
    });
});

activarTabla=function(){
    $("#t_cargos").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaCargos()){
        Cargos.AgregarEditarCargo(1);
    }
};

activar=function(id){
    Cargos.CambiarEstadoCargos(id,1);
};
desactivar=function(id){
    Cargos.CambiarEstadoCargos(id,0);
};

Agregar=function(){
    if($('#txt_nombre').val() == ''){
        alert('Ingrese Nombre de la Categoria');
    }else if($('#txt_observ').val() == ''){
        alert('Escriba una observacion');
    }else{
        Cargos.AgregarEditarCargo(0);
    }
};

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
HTMLCargarBien=function(datos){
    var html="";
    $('#t_cargos').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr>"+
            "<td >"+data.nombre+"</td>"+
            "<td id='observ_"+data.observacion+"'>"+data.observacion+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#nuevoBien" data-id="'+data.id+'" data-nombre="'+data.nombre+'" data-estado="'+data.estado+'" data-observacion="'+data.observacion+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#tb_cargos").html(html); 
    activarTabla();
};
</script>

