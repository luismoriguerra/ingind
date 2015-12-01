<script type="text/javascript">
$(document).ready(function() {  
    TipoActividades.CargarTipoActividades(activarTabla);

    $('#tipoActividadModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Tipo Actividad');
      $('#form_tipo_actividad [data-toggle="tooltip"]').css("display","none");
      $("#form_tipo_actividad input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tipo_actividad #slct_estado').val(1); 
            $('#form_tipo_actividad #txt_nombre').focus();
        }
        else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_tipo_actividad #txt_nombre').val( $('#t_tipo_actividad #nombre_'+button.data('id') ).text() );
            $('#form_tipo_actividad #slct_estado').val( $('#t_tipo_actividad #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_tipo_actividad").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#tipoActividadModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_tipo_actividad").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaTipoActividades()){
        TipoActividades.AgregarEditarTipoActividad(1);
    }
};

activar=function(id){
    TipoActividades.CambiarEstadoTipoActividades(id,1);
};
desactivar=function(id){
    TipoActividades.CambiarEstadoTipoActividades(id,0);
};

Agregar=function(){
    if(validaTipoActividades()){
        TipoActividades.AgregarEditarTipoActividad(0);
    }
};

validaTipoActividades=function(){
    $('#form_tipo_actividad [data-toggle="tooltip"]').css("display","none");
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
