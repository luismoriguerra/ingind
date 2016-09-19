<script type="text/javascript">
$(document).ready(function() {
    $('#plataformaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var modal = $(this); //captura el modal
      Asignar.Plataforma(PlataformaHTML);
    });

    $('#plataformaModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
    });
    $("#t_tramites_plataforma").dataTable();
});

PlataformaHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
     $('#t_tramites_plataforma').dataTable().fnDestroy();

    $.each(datos,function(index,data){
    cont++;
    html+="<tr>"+
        "<td>"+data.tramite+"</td>"+
        "<td>"+data.fecha_inicio+"</td>"+
        "<td>"+data.proceso+"</td>"+
        '<td>'+
            '<a onclick="CargarTramitePlataforma('+"'"+data.tramite+"'"+');" class="btn btn-success btn-sm"><i class="fa fa-check-square fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

    });
    $("#t_tramites_plataforma tbody").html(html); 
    $("#t_tramites_plataforma").dataTable();
}

CargarTramitePlataforma=function(id){
    $("#txt_codigo").val(id);
    $("#plataformaModal .modal-footer>button").click();
    alert('Si modifica el trámite de plataforma seleccionado será considerado como un trámite nuevo');
}

</script>
