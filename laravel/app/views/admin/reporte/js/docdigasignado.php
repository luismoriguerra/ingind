<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var DocumentosG={id:0,nombre:"",estado:1}; // Datos Globales
$(document).ready(function() {
        slctGlobalHtml('slct_docdig','simple');
        /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
            2: Descripción de cabecera
            3: Color Cabecera
        */
        var idG={   titulo        :'onBlur|Titulo|#DCE6F1', //#DCE6F1
                    asunto        :'onBlur|Asunto |#DCE6F1', //#DCE6F1
                    plantilla        :'onBlur|Plantilla|#DCE6F1',
                 };

        var resG=dataTableG.CargarCab(idG);
        cabeceraG=resG; // registra la cabecera
        var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'documentos','t_documentos');
        columnDefsG=resG[0]; // registra las columnas del datatable
        targetsG=resG[1]; // registra los contadores
        var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'openPrevisualizarPlantilla','t_documentos','fa fa-eye');
        columnDefsG=resG[0]; // registra la colunmna adiciona con boton
        targetsG=resG[1]; // registra el contador actualizado
        MostrarAjax('documentos');

    $(document).on('change', '#slct_docdig', function(event) {
        $("#txt_idtipo").val($(this).val());
        MostrarAjax('documentos');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    document.querySelector('#txt_nombret').value=$(tr).find("td:eq(0)").text();
    document.querySelector('#txt_fechatramite').value=$(tr).find("td:eq(1)").text();
    document.querySelector('#txt_id').value=id;
    $('#documentoModal').modal('show');
};

MostrarAjax=function(t){
    if( t=="documentos"){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'documentodig','docdigital',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==1){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

openPrevisualizarPlantilla=function(obj,id){
    window.open("documentodig/vistaprevia/"+id,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};


activarTabla=function(){
    $("#t_documentos").dataTable(); // inicializo el datatable    
};

Editar = function(){
    if(validaDocumentos()){
        tramite.AgregarEditarDocumento(1);
    }
};
Agregar = function(){
    if(validaDocumentos()){
        tramite.AgregarEditarDocumento(0);
    }
};
validaDocumentos = function(){
    var r=true;
    if( $("#form_tramite_modal #txt_nombret").val()=='' ){
        alert("Ingrese Nombre del Tramite");
        r=false;
    }
    return r;
};

Liberar=function(txt,id){
    $("#"+txt).removeAttr("readonly");
    $("#"+txt).val('');
    $("#"+id).val('');
    $("#"+txt).focus();
}
</script>
