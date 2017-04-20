<script>
$(document).ready(function() {
    Plantillas.Cargar(HTMLCargar);
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
}
</script>
