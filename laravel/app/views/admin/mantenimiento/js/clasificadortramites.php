<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var ClasificadorTramitesG={id:0,            
            area,
            tipo_tramite,
            nombre:"",
            estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobal.listarSlctFuncion('area','listar','slct_area_id','simple',null,data);
    slctGlobal.listarSlctFuncion('tipo_tramite','listar','slct_tipo_tramite_id','simple',null,data);
    slctGlobalHtml('slct_estado','simple');
    var idG={   
                area        :'onBlur|Area |#DCE6F1',
                tipo_tramite        :'onBlur|Tipo Tramite|#DCE6F1',
                nombre        :'onBlur|Nombre ClasificadorTramite|#DCE6F1',
                estado        :'2|Estado|#DCE6F1',
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'clasificadortramites','t_clasificadortramites');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_clasificadortramites','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('clasificadortramites');


    $('#verboModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' ClasificadorTramite');
      $('#form_clasificadortramites_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_clasificadortramites_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_clasificadortramites_modal #slct_estado').val(1);
            $('#form_clasificadortramites_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_clasificadortramites_modal #txt_area').val( ClasificadorTramitesG.area );
             $('#form_clasificadortramites_modal #txt_tipo_tramite').val( ClasificadorTramitesG.tipo_tramite );
            $('#form_clasificadortramites_modal #txt_nombre').val( ClasificadorTramitesG.nombre );
            $('#form_clasificadortramites_modal #slct_estado').val( ClasificadorTramitesG.estado );
            $("#form_clasificadortramites_modal").append("<input type='hidden' value='"+ClasificadorTramitesG.id+"' name='id'>");
        }
             $('#form_clasificadortramites_modal select').multiselect('rebuild');
    });

    $('#verboModal').on('hide.bs.modal', function (event) {
       $('#form_clasificadortramites_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    ClasificadorTramitesG.id=id;
    ClasificadorTramitesG.area=$(tr).find("td:eq(0)").text();
    ClasificadorTramitesG.tipo_tramite=$(tr).find("td:eq(1)").text();
    ClasificadorTramitesG.nombre=$(tr).find("td:eq(2)").text();
    ClasificadorTramitesG.estado=$(tr).find("td:eq(3)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="clasificadortramites" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'clasificadortramite','cargar',columnDefsG);
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
    $("#t_clasificadortramites").dataTable(); // inicializo el datatable    
};

activar = function(id){
    ClasificadorTramites.CambiarEstadoClasificadorTramites(id, 1);
};
desactivar = function(id){
    ClasificadorTramites.CambiarEstadoClasificadorTramites(id, 0);
};
Editar = function(){
    if(validaClasificadorTramites()){
        ClasificadorTramites.AgregarEditarClasificadorTramite(1);
    }
};
Agregar = function(){
    if(validaClasificadorTramites()){
        ClasificadorTramites.AgregarEditarClasificadorTramite(0);
    }
};

validaClasificadorTramites = function(){
    var r=true;
    if( $("#form_clasificadortramites_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de ClasificadorTramite");
        r=false;
    }
    return r;
};
</script>