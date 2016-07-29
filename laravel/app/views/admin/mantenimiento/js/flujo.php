<script type="text/javascript">
$(document).ready(function() {  
    Flujos.CargarFlujos(htmlCargarFlujos);
    Flujos.ListarAreas('slct_area_id');

    $('#flujoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Proceso');
      $('#form_flujos [data-toggle="tooltip"]').css("display","none");
      $("#form_flujos input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_flujos #slct_estado').val(1); 
            $('#form_flujos #slct_area_id').val(""); 
            $('#form_flujos #txt_nombre').focus();
        }
        else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_flujos #txt_nombre').val( $('#t_flujos #nombre_'+button.data('id') ).text() );
            $('#form_flujos #slct_estado').val( $('#t_flujos #estado_'+button.data('id') ).attr("data-estado") );
            $('#form_flujos #slct_area_id').val( $('#t_flujos #area_'+button.data('id') ).attr("data-area") );
            $("#form_flujos").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#flujoModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

htmlCargarFlujos=function(obj){
    var html="";
    var estadohtml="";

    $('#t_flujos').dataTable().fnDestroy();
    if(obj.rst==1){
        $.each(obj.data,function(index,data){
            estadohtml='Inactivo';
            if(data.estado==1){
                estadohtml='Activo';
            }

            html+="<tr>"+
                "<td id='nombre_"+data.id+"'>"+data.nombre+"</td>"+
                "<td id='area_"+data.id+"' data-area='"+data.area_id+"'>"+data.area+"</td>"+
                "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                '<td> &nbsp; </td>';

            html+="</tr>";
        });                    
    }      
    $("#tb_flujos").html(html); 
    $("#t_flujos").dataTable();
}

activarTabla=function(){
 // inicializo el datatable    
};

Editar=function(){
    if(validaFlujos()){
        Flujos.AgregarEditarFlujo(1);
    }
};

activar=function(id){
    Flujos.CambiarEstadoFlujos(id,1);
};
desactivar=function(id){
    Flujos.CambiarEstadoFlujos(id,0);
};

Agregar=function(){
    if(validaFlujos()){
        Flujos.AgregarEditarFlujo(0);
    }
};

validaFlujos=function(){
    $('#form_flujos [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","nombre","");
    a[1]=true;

    if($("#slct_area_id").val()==""){
        a[1]=false;
        $('#error_area').attr('data-original-title','Seleccione Area');
        $('#error_area').css('display','');
    }
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
