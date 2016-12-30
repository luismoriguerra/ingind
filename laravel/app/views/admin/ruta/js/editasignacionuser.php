<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var DocumentosG={id:0,nombre:"",estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
    var idG={   id_union        :'onBlur|Nombre del Documento|#DCE6F1', //#DCE6F1
                fecha_tramite        :'onBlur|Fecha Tramite|#DCE6F1', //#DCE6F1
                usuario        :'onBlur|Usuario|#DCE6F1',
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
            dataTableG.CargarDatos(t,'tabla_relacion','tramitesuser',columnDefsG);
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
</script>
