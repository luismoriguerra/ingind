<script type="text/javascript">
$(document).ready(function() {
    Flujo_tr.CargarFlujo_tr(activarTabla);

    $('#flujo_trModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Flujo');
        $('#form_flujo_tr [data-toggle="tooltip"]').css("display","none");
        $("#form_flujo_tr input[type='hidden']").remove();
        
        if(titulo=='Nuevo') {
            Flujo_tr.cargarFlujos('nuevo',null);
            Flujo_tr.cargarTiempos('nuevo',null);
            Flujo_tr.cargarTipoRespuestas('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_flujo_tr #slct_estado').val(1);
            $('#form_flujo_tr #txt_nombre').focus();
        }
        else {
            flujo_id=$('#t_flujo_tr #flujo_id_'+button.data('id') ).attr('flujo_id');
            tiempo_id=$('#t_flujo_tr #tiempo_id_'+button.data('id') ).attr('tiempo_id');
            tipo_respuesta_id=$('#t_flujo_tr #tipo_respuesta_id_'+button.data('id') ).attr('tipo_respuesta_id');
            Flujo_tr.cargarFlujos('editar',flujo_id);
            Flujo_tr.cargarTiempos('editar',tiempo_id);
            Flujo_tr.cargarTipoRespuestas('editar',tipo_respuesta_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_flujo_tr #txt_dtiempo').val( $('#t_flujo_tr #dtiempo_'+button.data('id') ).text() );
            $('#form_flujo_tr #slct_estado').val( $('#t_flujo_tr #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_flujo_tr").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#flujo_trModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_flujo_tr").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaFlujo_tr()){
        Flujo_tr.AgregarEditarFlujo_tr(1);
    }
};

activar=function(id){
    Flujo_tr.CambiarEstadoFlujo_tr(id,1);
};

desactivar=function(id){
    Flujo_tr.CambiarEstadoFlujo_tr(id,0);
};

Agregar=function(){
    if(validaFlujo_tr()){
        Flujo_tr.AgregarEditarFlujo_tr(0);
    }
};

validaFlujo_tr=function(){
    $('#form_flujo_tr [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","dtiempo","");
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