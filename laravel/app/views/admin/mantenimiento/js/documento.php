<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var DocumentosG={id:0,nombre:"",area:"", posicion:"", posicion_fecha:"", estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_area,#slct_posicion,#slct_posicion_fecha,#slct_estado','simple');

    var idG={   nombre           :'onBlur|Nombre del Documento|#DCE6F1', //#DCE6F1
                areas            :'4|Nombre del Area|#DCE6F1||area', //#DCE6F1
                posiciones       :'4|Posicion|#DCE6F1||posicion', //#DCE6F1
                posiciones_fecha :'4|Posicion Fecha|#DCE6F1||posicion_fecha', //#DCE6F1
                estado           :'2|Estado|#DCE6F1', //#DCE6F1

             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'documentos','t_documentos');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_documentos','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('documentos');


    $('#documentoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Documento');
      $('#form_documentos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_documentos_modal input[type='hidden']").remove();
        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_documentos_modal #slct_estado').val(1);
            $('#form_documentos_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_documentos_modal #txt_nombre').val( DocumentosG.nombre );
            $('#form_documentos_modal #slct_area').val( DocumentosG.area );
            $('#form_documentos_modal #slct_posicion').val( DocumentosG.posicion );
            $('#form_documentos_modal #slct_posicion_fecha').val( DocumentosG.posicion_fecha );
            $('#form_documentos_modal #slct_estado').val( DocumentosG.estado );
            $("#form_documentos_modal").append("<input type='hidden' value='"+DocumentosG.id+"' name='id'>");
        }
             $('#form_documentos_modal select').multiselect('rebuild');
    });

    $('#documentoModal').on('hide.bs.modal', function (event) {
       $('#form_documentos_modal input').val('');
       $('#form_documentos_modal select').val('');

     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    DocumentosG.id=id;
    DocumentosG.nombre=$(tr).find("td:eq(0)").text();
    DocumentosG.area=$(tr).find("td:eq(1) input[name='slct_area']").val();
    DocumentosG.posicion=$(tr).find("td:eq(2) input[name='slct_posicion']").val();
    DocumentosG.posicion_fecha=$(tr).find("td:eq(3) input[name='slct_posicion_fecha']").val();
    DocumentosG.estado=$(tr).find("td:eq(4)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="documentos" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'documento','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==1){
        return row.areas+"<input type='hidden'name='slct_area' value='"+row.area+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==2){
        return row.posiciones+"<input type='hidden'name='slct_posicion' value='"+row.posicion+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==3){
        return row.posiciones_fecha+"<input type='hidden'name='slct_posicion_fecha' value='"+row.posicion_fecha+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==4){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}


activarTabla=function(){
    $("#t_documentos").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Documentos.CambiarEstadoDocumentos(id, 1);
};
desactivar = function(id){
    Documentos.CambiarEstadoDocumentos(id, 0);
};
Editar = function(){
    if(validaDocumentos()){
        Documentos.AgregarEditarDocumento(1);
    }
};
Agregar = function(){
    if(validaDocumentos()){
        Documentos.AgregarEditarDocumento(0);
    }
};

validaDocumentos = function(){
    var r=true;
    if( $("#form_documentos_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre del Documento");
        r=false;
    }
    else if( $("#form_documentos_modal #slct_area").val()=='' ){
        alert("Seleccione Area");
        r=false;
    }
    else if( $("#form_documentos_modal #slct_posicion").val()=='' ){
        alert("Seleccione Posicion");
        r=false;
    }
    else if( $("#form_documentos_modal #slct_posicion_fecha").val()=='' ){
        alert("Seleccione Posicion Fecha");
        r=false;
    }
    return r;
};
</script>
