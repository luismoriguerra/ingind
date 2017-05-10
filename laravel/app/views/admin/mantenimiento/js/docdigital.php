<script>
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var cabeceraG1=[]; // Cabecera del Datatable
var columnDefsG1=[]; // Columnas de la BD del datatable
var targetsG1=-1; // Posiciones de las columnas del datatable
$(document).ready(function() {
    

    var idG={   persona_c        :'onBlur|Creador|#DCE6F1', //#DCE6F1
                persona_u        :'onBlur|Actualizó|#DCE6F1', //#DCE6F1
                titulo      :'onBlur|Título|#DCE6F1', //#DCE6F1
                asunto        :'onBlur|Asunto|#DCE6F1', //#DCE6F1
                a        :'1|Fecha Creación|#DCE6F1', //#DCE6F1
                plantilla        :'onBlur|Plantilla|#DCE6F1', //#DCE6F1
                b        :'1|Editar|#DCE6F1', //#DCE6F1
                c        :'1|Vista Previa|#DCE6F1', //#DCE6F1
                d        :'1|Vista Impresión|#DCE6F1', //#DCE6F1
                
//                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'docdigitales','t_docdigitales');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
//    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_docdigitales','fa-edit');
//    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
//    targetsG=resG[1]; // registra el contador actualizado


    var idG1={  persona_c        :'onBlur|Creador|#DCE6F1', //#DCE6F1
                persona_u        :'onBlur|Actualizó|#DCE6F1', //#DCE6F1
                titulo      :'onBlur|Título|#DCE6F1', //#DCE6F1
                asunto        :'onBlur|Asunto|#DCE6F1', //#DCE6F1
                created_at        :'onBlur|Fecha Creación|#DCE6F1', //#DCE6F1
                plantilla        :'onBlur|Plantilla|#DCE6F1', //#DCE6F1
                c        :'1|Vista Previa|#DCE6F1', //#DCE6F1
             };

    var resG1=dataTableG.CargarCab(idG1);
    cabeceraG1=resG1; // registra la cabecera
    var resG1=dataTableG.CargarCol(cabeceraG1,columnDefsG1,targetsG1,1,'docdigitales_relaciones','t_docdigitales_relaciones');
    columnDefsG1=resG1[0]; // registra las columnas del datatable
    targetsG1=resG1[1]; // registra los contadores

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
       if(MostrarOcultarModalfecha==2){
        MostrarAjax('docdigitales');
        $("#docdigitalModal").modal('show');}

    });
    
        $('.fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: true,
        showDropdowns: true
    });
});

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==1){
        return row.nemonico+"<input type='hidden' name='txt_imagen' value='"+row.imagen+"'><input type='hidden' name='txt_imagenc' value='"+row.imagenc+"'><input type='hidden' name='txt_imagenp' value='"+row.imagenp+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==4){
        return row.created_at+"<br><span onclick='FlotanteFecha(1); return false;' class='btn btn-warning' data-toggle='modal' data-target='#fechaModal' data-documento='"+row.titulo+"' data-id='"+row.id+"' data-fecha='"+row.created_at+"' id='btn_buscar_docs'>"+
                                                    '<i class="fa fa-pencil fa-xs"></i>'+
                                                '</span>';
    }
    if(typeof(fn)!='undefined' && fn.col==6){
        if(row.tipo==1){
            return "<a class='btn btn-primary btn-sm' onclick='editDocDigital("+row.id+",1); return false;' data-titulo='Editar'><i class='glyphicon glyphicon-pencil'></i> </a>";
        }
        if(row.tipo==2){
            return "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",4,0); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A4</i> </a>"+
                   "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",5,0); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A5</i> </a>";
        }
    }
    if(typeof(fn)!='undefined' && fn.col==7){
        return "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",4,0); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A4</i> </a>"+
                   "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",5,0); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A5</i> </a>";
    }
    if(typeof(fn)!='undefined' && fn.col==8){
       if($.trim(row.ruta) != 0  || $.trim(row.rutadetallev) != 0){
           return "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",4,1); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A4</i> </a>"+
                  "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",5,1); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A5</i> </a>";
       }else{
            return "";
       }
    }

}

MostrarAjax=function(t){
    if( t=="docdigitales" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'documentodig','cargarcompleto',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
    if( t=="docdigitales_relaciones" ){
        if( columnDefsG1.length>0 ){
            dataTableG.CargarDatos(t,'documentodig','cargarcompleto',columnDefsG1);
        }
        else{
            alert('Faltas datos');
        }
    }
}

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
        html+="<td>"+data.created_at+"<br><span onclick='FlotanteFecha(2); return false;' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#fechaModal' data-documento='"+data.titulo+"' data-id='"+data.id+"' data-fecha='"+data.created_at+"' id='btn_buscar_docs'>"+
                                                    '<i class="fa fa-pencil"></i>'+
                                                '</span>';
        html+="</td>";
        html+="<td>"+data.plantilla+"</td>";

        if(data.estado == 1){
            html+="<td><a class='btn btn-primary btn-sm' onclick='editDocDigital("+data.id+"); return false;' data-titulo='Editar'><i class='glyphicon glyphicon-pencil'></i> </a></td>";
            html+="<td><a class='btn btn-default btn-sm' onclick='openPlantilla("+data.id+",4,0); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A4</i> </a><br>"+
                   "<a class='btn btn-default btn-sm' onclick='openPlantilla("+data.id+",5,0); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A5</i> </a></td>";
            if($.trim(data.ruta) != 0 || $.trim(data.rutadetallev)!= 0){
                html+="<td><a class='btn btn-default btn-sm' onclick='openPlantilla("+data.id+",4,1); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A4</i> </a>"+
                       "<a class='btn btn-default btn-sm' onclick='openPlantilla("+data.id+",5,1); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A5</i> </a></td>";
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

MostrarDocumentos=function(tipo){
    
    if(tipo==1){
           $('#form_docdigitales_relaciones').hide();
           $('#form_docdigitales').show();
           $("#t_docdigitales").dataTable();
           MostrarAjax('docdigitales');
    }
    if(tipo==2){
           $('#form_docdigitales').hide();
           $('#form_docdigitales_relaciones').show();
           $("#t_docdigitales_relaciones").dataTable();
           MostrarAjax('docdigitales_relaciones'); 
    }
};

FlotanteFecha=function(flotante){
    if(flotante==1){
    $("#docdigitalModal").modal('hide');
    MostrarOcultarModalfecha=2;}
    else {
      MostrarOcultarModalfecha=1;  
    }

};

</script>
