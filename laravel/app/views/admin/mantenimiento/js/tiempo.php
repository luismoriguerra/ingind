<script type="text/javascript">
$(document).ready(function() {  
    Tiempos.CargarTiempos(activarTabla);

    $('#softwareModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Tiempo');
      $('#form_tiempos [data-toggle="tooltip"]').css("display","none");
      $("#form_tiempos input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tiempos #slct_estado').val(1); 
            $('#form_tiempos #txt_nombre').focus();
        }
        else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_tiempos #txt_nombre').val( $('#t_tiempos #nombre_'+button.data('id') ).text() );
            $('#form_tiempos #txt_apocope').val( $('#t_tiempos #apocope_'+button.data('id') ).text() );
            $('#form_tiempos #txt_minutos').val( $('#t_tiempos #minutos_'+button.data('id') ).text() );
            $('#form_tiempos #slct_estado').val( $('#t_tiempos #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_tiempos").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#softwareModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_tiempos").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaTiempos()){
        Tiempos.AgregarEditarTiempo(1);
    }
};

activar=function(id){
    Tiempos.CambiarEstadoTiempos(id,1);
};
desactivar=function(id){
    Tiempos.CambiarEstadoTiempos(id,0);
};

Agregar=function(){
    if(validaTiempos()){
        Tiempos.AgregarEditarTiempo(0);
    }
};

validaTiempos=function(){
    $('#form_tiempos [data-toggle="tooltip"]').css("display","none");
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