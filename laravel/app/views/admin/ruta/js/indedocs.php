<script type="text/javascript">
var textoIdG='';
var documentoIdIG='';
$(document).ready(function() {
     $('#t_indedocs').dataTable();
     Indedocs.listar();
    $('#indedocsModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      textoIdG= button.data('texto');
      documentoIdIG= button.data('id');
      $("#"+textoIdG).removeAttr("readonly");
      $("#"+textoIdG).attr("readonly",'true');
    });

    $('#indedocsModal').on('hide.bs.modal', function (event) {
        $("#t_indedocs>tbody").html('');
    });
});

cargarNroDoc=function(docu,id){
    $("#"+textoIdG).val(docu);
    $("#"+documentoIdIG).val(id);
    
};

mostrarListaHTML=function(datos){
    $("#form_indedocs #slct_tipo_documento").append(datos);
    slctGlobalHtml("form_indedocs #slct_tipo_documento","simple");
}

mostrarHTML=function(datos){
    $('#t_indedocs').dataTable().fnDestroy();
    $("#t_indedocs>tbody").html('');
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
