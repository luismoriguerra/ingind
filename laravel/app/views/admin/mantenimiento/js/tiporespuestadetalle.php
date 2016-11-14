<script type="text/javascript">
$(document).ready(function() {
    Detalles.CargarDetalles(activarTabla);

    $('#detalleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        //var detalle_id = button.data('id'); //extrae el id del atributo data
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Detalle');
        $('#form_detalles [data-toggle="tooltip"]').css("display","none");
        $("#form_detalles input[type='hidden']").remove();

        
        if(titulo=='Nuevo') {
            Detalles.cargarTipoRespuesta('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_detalles #slct_estado').val(1);
            $('#form_detalles #txt_nombre').focus();

            var data = {estado:1};
            $('#slct_tiporespuesta_id').multiselect('destroy');
            slctGlobal.listarSlct('tiporespuesta','slct_tiporespuesta_id','simple',null,data);
        }
        else {
            tiporespuesta_id=$('#t_detalles #tiporespuesta_id_'+button.data('id') ).attr('tiporespuesta_id');
            var ids = [];
            ids.push(tiporespuesta_id);
            var data = {estado:1};
            $('#slct_tiporespuesta_id').multiselect('destroy');
            slctGlobal.listarSlct('tiporespuesta','slct_tiporespuesta_id','simple',ids,data,1);

            Detalles.cargarTipoRespuesta('editar',tiporespuesta_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_detalles #txt_nombre').val( $('#t_detalles #nombre_'+button.data('id') ).text() );
            $('#form_detalles #slct_estado').val( $('#t_detalles #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_detalles").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
            /*$("#slct_tiporespuesta_id>option[value="+button.data('id')+"]").prop('selected',true);*/
        }

    });

    $('#detalleModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_detalles").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaDetalles()){
        Detalles.AgregarEditarDetalles(1);
    }
};

activar=function(id){
    Detalles.CambiarEstadoDetalles(id,1);
};

desactivar=function(id){
    Detalles.CambiarEstadoDetalles(id,0);
};

Agregar=function(){
    if(validaDetalles()){
        Detalles.AgregarEditarDetalles(0);
    }
};

validaDetalles=function(){
    $('#form_detalles [data-toggle="tooltip"]').css("display","none");
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