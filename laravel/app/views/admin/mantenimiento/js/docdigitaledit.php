<script>
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
$(document).ready(function() {
        /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    var idG={   persona_c        :'onBlur|Creador|#DCE6F1', //#DCE6F1
                persona_u        :'onBlur|Actualizó|#DCE6F1', //#DCE6F1
                titulo      :'onBlur|Título|#DCE6F1', //#DCE6F1
                asunto        :'onBlur|Asunto|#DCE6F1', //#DCE6F1
                created_at        :'onBlur|Fecha Creación|#DCE6F1', //#DCE6F1
                plantilla        :'onBlur|Plantilla|#DCE6F1', //#DCE6F1
                b        :'1|Editar|#DCE6F1', //#DCE6F1

             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'docdigitales','t_docdigitales');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
//    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_docdigitales','fa-edit');
//    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
//    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('docdigitales');
    
    $('#tituloModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var tipo_envio = button.data('tipoenvio'); // extrae del atributo data-
      var documento = button.data('documento'); // extrae del atributo data-
      var ruta = button.data('ruta'); // extrae del atributo data-
      var rutadetallev = button.data('rutadetallev'); // extrae del atributo data-
      var id = button.data('id'); // extrae del atributo data-

        var titulo = documento.split("-");
        document.querySelector("#lblDocumento").innerHTML= titulo[0]+"- Nº ";
        $('#form_titulos_modal #txt_titulo').val($.trim($.trim( titulo[1] ).substring(2)));
        var area=' ';
        for(i=2;i<titulo.length;i++){
            area+="-"+titulo[i];
        }
        document.querySelector("#lblArea").innerHTML=area;    
        
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text('Editar Título');
      $('#form_titulos_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_titulos_modal input[type='hidden']").remove();

            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarTitulo();');

            
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

MostrarAjax=function(t){
    if( t=="docdigitales" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'documentodig','cargarcompleto',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==6){
        return "<span class='btn btn-warning' data-toggle='modal' data-target='#tituloModal' data-documento='"+row.titulo+"' data-id='"+row.id+"' data-ruta='"+row.ruta+"' data-rutadetallev='"+row.rutadetallev+"' data-tipoenvio='"+row.tipo_envio+"' id='btn_buscar_docs'>"+
                                                    '<i class="fa fa-pencil fa-xs"></i>'+
                                                '</span>';
    }
}

activarTabla=function(){
    $("#t_doc_digital").dataTable();
};



//HTMLCargar=function(datos){
//    var html="";
//    $('#t_doc_digital').dataTable().fnDestroy();
//    var eye = "";
//    $.each(datos,function(index,data){
//
//        if($.trim(data.ruta) == 0 && $.trim(data.rutadetallev) == 0){
//            html+="<tr class='danger'>";
//        }else{
//            html+="<tr class='success'>";
//        }
//        html+="<td>"+data.persona_c+"</td>";
//        html+="<td>"+data.persona_u+"</td>";
//        html+="<td>"+data.titulo+"</td>";
//        html+="<td>"+data.asunto+"</td>";
//        html+="<td>"+data.created_at+"</td>";
//        html+="<td>"+data.plantilla+"</td>";
//        if(data.estado == 1){
//            html+="<td><br><span class='btn btn-warning' data-toggle='modal' data-target='#tituloModal' data-documento='"+data.titulo+"' data-id='"+data.id+"' data-ruta='"+data.ruta+"' data-rutadetallev='"+data.rutadetallev+"' id='btn_buscar_docs'>"+
//                                                    '<i class="fa fa-pencil fa-xs"></i>'+
//                                                '</span></td>';
//
//        }
//
//        html+="</tr>";
//    });
//    $("#tb_doc_digital").html(html);
//    activarTabla();
//};

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

function addZeros (n, length)
{
    var str = (n > 0 ? n : -n) + "";
    var zeros = "";
    for (var i = length - str.length; i > 0; i--)
        zeros += "0";
    zeros += str;
    return n >= 0 ? zeros : "-" + zeros;
}

</script>
