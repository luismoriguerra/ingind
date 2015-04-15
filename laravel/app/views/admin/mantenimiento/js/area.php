<script type="text/javascript">
$(document).ready(function() {  
    Areas.CargarAreas(activarTabla);

    $('#areaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Area');
      $('#form_areas [data-toggle="tooltip"]').css("display","none");
      $("#form_areas input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_areas #slct_estado').val(1); 
            $('#form_areas #txt_nombre').focus();
        }
        else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_areas #txt_nombre').val( $('#t_areas #nombre_'+button.data('id') ).text() );
            $('#form_areas #txt_id_int').val( $('#t_areas #id_int_'+button.data('id') ).text() );
            $('#form_areas #txt_id_ext').val( $('#t_areas #id_ext_'+button.data('id') ).text() );
            $('#form_areas #slct_estado').val( $('#t_areas #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_areas").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#areaModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_areas").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaAreas()){
        Areas.AgregarEditarArea(1);
    }
};

activar=function(id){
    Areas.CambiarEstadoAreas(id,1);
};
desactivar=function(id){
    Areas.CambiarEstadoAreas(id,0);
};

Agregar=function(){
    if(validaAreas()){
        Areas.AgregarEditarArea(0);
    }
};

validaAreas=function(){
    $('#form_areas [data-toggle="tooltip"]').css("display","none");
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
