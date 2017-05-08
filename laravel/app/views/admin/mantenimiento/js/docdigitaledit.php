<script>
$(document).ready(function() {
    Plantillas.Cargar(HTMLCargar);
    
    $('#tituloModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var documento = button.data('documento'); // extrae del atributo data-
      var ruta = button.data('ruta'); // extrae del atributo data-
      var rutadetallev = button.data('rutadetallev'); // extrae del atributo data-
      var id = button.data('id'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text('Editar Título');
      $('#form_titulos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_titulos_modal input[type='hidden']").remove();

            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarTitulo();');

            $('#form_titulos_modal #txt_titulo').val(documento);
            $("#form_titulos_modal").append("<input type='hidden' value='"+id+"' name='id'>");
            $("#form_titulos_modal").append("<input type='hidden' value='"+ruta+"' name='ruta'>");
            $("#form_titulos_modal").append("<input type='hidden' value='"+rutadetallev+"' name='rutadetallev'>");
        
    });

    $('#tituloModal').on('hide.bs.modal', function (event) {
//       $('#form_fechas_modal textarea').val('');

    });
    
    $('.fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: true,
        showDropdowns: true
    });
});

activarTabla=function(){
    $("#t_doc_digital").dataTable();
};



HTMLCargar=function(datos){
    var html="";
    $('#t_doc_digital').dataTable().fnDestroy();
    var eye = "";
    $.each(datos,function(index,data){

        if($.trim(data.ruta) == 0 && $.trim(data.rutadetallev) == 0){
            html+="<tr class='danger'>";
        }else{
            html+="<tr class='success'>";
        }
        html+="<td>"+data.persona_c+"</td>";
        html+="<td>"+data.persona_u+"</td>";
        html+="<td>"+data.titulo+"</td>";
        html+="<td>"+data.asunto+"</td>";
        html+="<td>"+data.created_at+"</td>";
        html+="<td>"+data.plantilla+"</td>";
        if(data.estado == 1){
            html+="<td><br><span class='btn btn-warning' data-toggle='modal' data-target='#tituloModal' data-documento='"+data.titulo+"' data-id='"+data.id+"' data-ruta='"+data.ruta+"' data-rutadetallev='"+data.rutadetallev+"' id='btn_buscar_docs'>"+
                                                    '<i class="fa fa-pencil fa-xs"></i>'+
                                                '</span></td>';

        }

        html+="</tr>";
    });
    $("#tb_doc_digital").html(html);
    activarTabla();
};

EditarTitulo = function(){
    if(validaTitulos()){
        Plantillas.AgregarEditarTitulo(1);
    }
};

validaTitulos = function(){
    var r=true;
    if( $("#form_titulos_modal #txt_fecha").val()=='' ){
        alert("Ingrese Título");
        r=false;
    }
    return r;
};

</script>
