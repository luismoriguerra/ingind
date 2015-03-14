<script type="text/javascript">
temporalBandeja=0;
$(document).ready(function() {
    Ruta.CargarRuta(HTMLCargarRuta);

    $('#rutaflujoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        var id = button.data('id'); //extrae el id del atributo data
        var modal = $(this); //captura el modal

        modal.find('.modal-title').text(titulo+' Ruta');
        $('#form_rutaflujo [data-toggle="tooltip"]').css("display","none");
        $("#form_rutaflujo input[type='hidden']").remove();
        
        if(titulo=='Nuevo') {
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_rutaflujo #slct_estado').val(1);
            $('#form_rutaflujo #slct_flujo').focus();
        }
        else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_rutaflujo #txt_nombre').val( $('#t_rutaflujo #nombre_'+button.data('id') ).text() );
            $('#form_rutaflujo #txt_responsable').val( $('#t_rutaflujo #responsable_'+button.data('id') ).text() );
            $('#form_rutaflujo #slct_estado').val( $('#t_rutaflujo #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_rutaflujo").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }
    });

    $('#rutaflujoModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

HTMLCargarRuta=function(datos){
    var html="";
    var cont=0;
     $('#t_rutaflujo').dataTable().fnDestroy();

    $.each(datos,function(index,data){
    cont++;
    html+="<tr>"+
        "<td>"+cont+"</td>"+
        "<td>"+data.flujo+"</td>"+
        "<td>"+data.persona+"</td>"+
        "<td>"+data.area+"</td>"+
        "<td>"+data.ok+"</td>"+
        "<td>"+data.error+"</td>"+
        "<td>"+data.dep+"</td>"+
        "<td>"+data.fruta+"</td>"+
        '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rutaflujoModal" data-id="'+data.id+'"><i class="fa fa-edit fa-lg"></i> </a>'+
            '<a class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

    });
    $("#tb_rutaflujo").html(html); 
    $("#t_rutaflujo").dataTable();
}
</script>
