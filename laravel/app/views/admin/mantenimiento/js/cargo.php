<script type="text/javascript">
$(document).ready(function() {  
    Cargos.CargarCargos(activarTabla);

    $('#cargoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        var cargo_id = button.data('id'); //extrae el id del atributo data
        var data = {cargo_id: cargo_id};
        var ids = [1,2];//por ejemplo seleccionando 2 valores
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Cargo');
        $('#form_cargos [data-toggle="tooltip"]').css("display","none");
        $("#form_cargos input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            slctGlobal.listarSlct('opcion','slct_opciones','simple',null,null);
            slctGlobal.listarSlct('menu','slct_menus','simple',null,null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_cargos #slct_estado').val(1); 
            $('#form_cargos #txt_nombre').focus();          
        }
        else{
            slctGlobal.listarSlct('opcion','slct_opciones','simple',null,null);//ids debe seleccionar algunos
            slctGlobal.listarSlct('menu','slct_menus','simple',null,null);//ids debe seleccionar algunos
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_cargos #txt_nombre').val( $('#t_cargos #nombre_'+button.data('id') ).text() );
            $('#form_cargos #slct_estado').val( $('#t_cargos #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_cargos").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#cargoModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
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
</script>