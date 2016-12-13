<script type="text/javascript">
var textoIdG='';
$(document).ready(function() {
     $('#t_indedocs').dataTable();
    $('#indedocsModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      textoIdG= button.data('texto');
        Indedocs.mostrar();
    });

    $('#indedocsModal').on('hide.bs.modal', function (event) {
        $("#t_indedocs>tbody").html('');
    });
});

cargarNroDoc=function(docu,id){
    $("#"+textoIdG).val(docu);
    $("#txt_documento_id").val(id);
    
};

mostrarHTML=function(datos){
    $('#t_indedocs').dataTable().fnDestroy();
    $("#t_indedocs>tbody").html(datos);
    $("#t_indedocs").dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
};
</script>
