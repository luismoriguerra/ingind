<script>
$(document).ready(function() {
    Plantillas.Cargar(HTMLCargar);
    
    $('#fechaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var documento = button.data('documento'); // extrae del atributo data-
      var fecha = button.data('fecha'); // extrae del atributo data-
      var id = button.data('id'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text('Editar Fecha');
      $('#form_fechas_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_fechas_modal input[type='hidden']").remove();

            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarFecha();');

            $('#form_fechas_modal #txt_documento').val(documento);
             $('#form_fechas_modal #txt_fecha').val(fecha);
            $("#form_fechas_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        
    });

    $('#fechaModal').on('hide.bs.modal', function (event) {
       $('#form_fechas_modal textarea').val('');

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

activar=function(id){
    Plantillas.CambiarEstado(id);
};

desactivar=function(id){
    Plantillas.CambiarEstado(id,0);
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
        html+="<td>"+data.created_at+"<br><span class='btn btn-warning' data-toggle='modal' data-target='#fechaModal' data-documento='"+data.titulo+"' data-id='"+data.id+"' data-fecha='"+data.created_at+"' id='btn_buscar_docs'>"+
                                                    '<i class="fa fa-pencil fa-xs"></i>'+
                                                '</span>';
        html+="</td>";
        html+="<td>"+data.plantilla+"</td>";

        if(data.estado == 1){
            html+="<td><a class='btn btn-primary btn-sm' onclick='editDocDigital("+data.id+"); return false;' data-titulo='Editar'><i class='glyphicon glyphicon-pencil'></i> </a></td>";
            html+="<td><a class='btn btn-default btn-sm' onclick='openPrevisualizarPlantilla("+data.id+",1); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'></i> </a></td>";
            if($.trim(data.ruta) != 0 || $.trim(data.rutadetallev)!= 0){
                html+="<td><a class='btn btn-default btn-sm' onclick='openImprimirPlantilla("+data.id+",2); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'></i> </a></td>";
                html+="<td></td>";
            }else{
                html+="<td></td>";
                html+= "<td><a class='btn btn-danger btn-sm' onclick='deleteDocumento("+data.id+"); return false;' data-titulo='Eliminar'><i class='glyphicon glyphicon-trash'></i> </a></td>";
            }
            
        }else{
            html+="<td><a class='btn btn-primary btn-sm' style='opacity:0.5'><i class='glyphicon glyphicon-pencil'></i> </a></td>";
            html+="<td><a class='btn btn-default btn-sm' style='opacity:0.5'><i class='fa fa-eye fa-lg'></i> </a></td>";
            html+="<td><a class='btn btn-default btn-sm' style='opacity:0.5'><i class='fa fa-eye fa-lg'></i> </a></td>";
            html+= "<td><a class='btn btn-danger btn-sm' style='opacity:0.5'><i class='glyphicon glyphicon-trash'></i> </a></td>";
        }

        html+="</tr>";
    });
    $("#tb_doc_digital").html(html);
    activarTabla();
};

deleteDocumento = function(id){
    var c= confirm("¿Está seguro de eliminar documento?");
    if(c){
    Plantillas.EliminarDocumento({'estado':0,'id':id});    }
};

EditarFecha = function(){
    if(validaFechas()){
        Plantillas.AgregarEditarFecha(1);
    }
};

validaFechas = function(){
    var r=true;
    if( $("#form_fechas_modal #txt_fecha").val()=='' ){
        alert("Ingrese Fecha");
        r=false;
    }
    
    if( $("#form_fechas_modal #txt_comentario").val()=='' ){
        alert("Ingrese Razón de Cambio");
        r=false;
    }
    return r;
};
</script>
