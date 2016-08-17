<script type="text/javascript">
$(document).ready(function() {  
    Flujos.CargarFlujos(htmlCargarFlujos);
    Flujos.ListarAreas('slct_area_id');

    Flujos.ListarCategorias('slct_categoria_id');
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
            $('#form_flujos #slct_categoria_id').val( '');
            $('#form_flujos #slct_estado').val(1); 
            $('#form_flujos #slct_tipo').val(''); 
            $('#form_flujos #slct_area_id').val(""); 
            $('#form_flujos #txt_nombre').focus();
        }
        else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_flujos #txt_nombre').val( $('#t_flujos #nombre_'+button.data('id') ).text() );
            $('#form_flujos #slct_categoria_id').val( $('#t_flujos #categoria_'+button.data('id') ).attr("data-categoria") );
            $('#form_flujos #slct_estado').val( $('#t_flujos #estado_'+button.data('id') ).attr("data-estado") );
            $('#form_flujos #slct_tipo').val( $('#t_flujos #tipo_'+button.data('id') ).attr("data-tipo") );
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
            estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
            if(data.estado==1){
                estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
            }

            html+="<tr>"+
                "<td id='nombre_"+data.id+"'>"+data.nombre+"</td>"+
                "<td id='categoria_"+data.id+"' data-categoria='"+data.categoria_id+"'>"+data.categoria+"</td>"+
                "<td id='area_"+data.id+"' data-area='"+data.area_id+"'>"+data.area+"</td>"+
                "<td id='tipo_"+data.id+"' data-tipo='"+data.tipo_flujo_id+"'>"+data.tipo_flujo+"</td>"+
                "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#flujoModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

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
    a[2]=true;

    if($("#slct_categoria_id").val()==""){
        a[2]=false;
        $('#error_categoria').attr('data-original-title','Seleccione Categoria');
        $('#error_categoria').css('display','');
    }
    if($("#slct_area_id").val()==""){
        a[1]=false;
        $('#error_area').attr('data-original-title','Seleccione Area');
        $('#error_area').css('display','');
    }

    if($("#slct_tipo").val()==""){
        a[2]=false;
        $('#error_tipo').attr('data-original-title','Seleccione Tipo');
        $('#error_tipo').css('display','');
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
