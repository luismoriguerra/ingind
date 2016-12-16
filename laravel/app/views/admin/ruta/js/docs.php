<script type="text/javascript">
var textoIdG='';
var documentoIdIG='';
$(document).ready(function() {
     $('#t_docs').dataTable();
    $('#docsModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      textoIdG= button.data('texto');
      documentoIdIG= button.data('id');
        Docs.mostrar();
    });

    $('#docsModal').on('hide.bs.modal', function (event) {
        $("#t_docs>tbody").html('');
    });
});

cargarNroDoc=function(docu,id){
    $("#"+textoIdG).val(docu);
    $("#"+documentoIdIG).val(id);
    
};

mostrarHTML=function(datos){
    $('#t_docs').dataTable().fnDestroy();
    $("#t_docs>tbody").html('');
    $("#t_docs>tbody").html(datos);
    $("#t_docs").dataTable({
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
