<script type="text/javascript">
var textoIdG='';
var documentoIdIG='';
$(document).ready(function() {
          $('#fechaI').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });
        
     $('#t_indedocs').dataTable();
     Indedocs.listar();
    $('#indedocsModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      textoIdG= button.data('texto');
      documentoIdIG= button.data('id');
      console.log($(event.relatedTarget).parent().parent());
      $("#"+textoIdG).removeAttr("readonly");
      $("#"+textoIdG).attr("readonly",'true');
      $("#"+textoIdG).val("");
    });

    $('#indedocsModal').on('hide.bs.modal', function (event) {
        $("#t_indedocs>tbody").html('');
        $("#mensaje").html('');
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
    if(datos==="<h3 style='color:blue'><center>IndeDocs no disponible. Usar el Lápiz para digitar manualmente el Documento</center></h3>"){
    $("#mensaje").html(datos);}
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
