<script type="text/javascript">
$(document).ready(function() {  
    Cargos.CargarCargos(activarTabla);

    $('#cargoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        cargo_id = button.data('id'); //extrae el id del atributo data
        //var data = {cargo_id: cargo_id};
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Cargo');
        $('#form_cargos [data-toggle="tooltip"]').css("display","none");
        $("#form_cargos input[type='hidden']").remove();


        slctGlobal.listarSlct('menu','slct_menus','simple');
        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_cargos #slct_estado').val(1); 
            $('#form_cargos #txt_nombre').focus();
        }
        else{
            Cargos.CargarOpciones(cargo_id); //no es multiselect
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_cargos #txt_nombre').val( CargoObj[cargo_id-1].nombre );
            $('#form_cargos #slct_estado').val( CargoObj[cargo_id-1].estado );
            $("#form_cargos").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }
        $( "#form_cargos #slct_estado" ).trigger('change');
        $( "#form_cargos #slct_estado" ).change(function() {
            if ($( "#form_cargos #slct_estado" ).val()==1) {
                $('fieldset').removeAttr('disabled');
            }
            else {
                $('fieldset').attr('disabled', 'disabled');
            }
        });

    });

    $('#cargoModal').on('hide.bs.modal', function (event) {
        var modal = $(this); //captura el modal
        modal.find('.modal-body input').val(''); // busca un input para copiarle texto
        $("#slct_menus").multiselect('destroy');
        $("#t_opcionCargo").html('');
        menus_selec=[];
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
    if(validaCargos()){
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
HTMLCargarCargo=function(datos){
    var html="";
    $('#t_cargos').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr>"+
            "<td >"+data.nombre+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cargoModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_cargos").html(html); 
    activarTabla();
};
</script>

