<script type="text/javascript">
$(document).ready(function() {
    Opciones.CargarOpciones(activarTabla);

    $('#opcionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Opcion');
        $('#form_opciones [data-toggle="tooltip"]').css("display","none");
        $("#form_opciones input[type='hidden']").remove();
        
        if(titulo=='Nuevo') {
            Opciones.cargarMenus('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_opciones #slct_estado').val(1);
            $('#form_opciones #txt_nombre').focus();
        }
        else {
            menu_id=$('#t_opciones #menu_id_'+button.data('id') ).attr('menu_id');
            Opciones.cargarMenus('editar',menu_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_opciones #txt_nombre').val( $('#t_opciones #nombre_'+button.data('id') ).text() );
            $('#form_opciones #txt_ruta').val( $('#t_opciones #ruta_'+button.data('id') ).text() );
            $('#form_opciones #slct_estado').val( $('#t_opciones #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_opciones").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#opcionModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_opciones").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaOpciones()){
        Opciones.AgregarEditarOpciones(1);
    }
};

activar=function(id){
    Opciones.CambiarEstadoOpciones(id,1);
};

desactivar=function(id){
    Opciones.CambiarEstadoOpciones(id,0);
};

Agregar=function(){
    if(validaOpciones()){
        Opciones.AgregarEditarOpciones(0);
    }
};

validaOpciones=function(){
    $('#form_opciones [data-toggle="tooltip"]').css("display","none");
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