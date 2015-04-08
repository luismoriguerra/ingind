<script type="text/javascript">
$(document).ready(function() {
    Submodulos.CargarSubmodulos(activarTabla);

    $('#submoduloModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        //var submodulo_id = button.data('id'); //extrae el id del atributo data
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Submodulo');
        $('#form_submodulos [data-toggle="tooltip"]').css("display","none");
        $("#form_submodulos input[type='hidden']").remove();
        
        if(titulo=='Nuevo') {
            Submodulos.cargarModulos('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_submodulos #slct_estado').val(1);
            $('#form_submodulos #txt_nombre').focus();
        }
        else {
            modulo_id=$('#t_submodulos #modulo_id_'+button.data('id') ).attr('modulo_id');
            Submodulos.cargarModulos('editar',modulo_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_submodulos #txt_nombre').val( $('#t_submodulos #nombre_'+button.data('id') ).text() );
            $('#form_submodulos #txt_path').val( $('#t_submodulos #path_'+button.data('id') ).text() );
            $('#form_submodulos #slct_estado').val( $('#t_submodulos #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_submodulos").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#submoduloModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_submodulos").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaSubmodulos()){
        Submodulos.AgregarEditarSubmodulos(1);
    }
};

activar=function(id){
    Submodulos.CambiarEstadoSubmodulos(id,1);
};

desactivar=function(id){
    Submodulos.CambiarEstadoSubmodulos(id,0);
};

Agregar=function(){
    if(validaSubmodulos()){
        Submodulos.AgregarEditarSubmodulos(0);
    }
};

validaSubmodulos=function(){
    $('#form_submodulos [data-toggle="tooltip"]').css("display","none");
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