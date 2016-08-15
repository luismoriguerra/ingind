<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var TipoActividadsG={id:0,nombre:"",estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre TipoActividad|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'tipoactividads','t_tipoactividads');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_tipoactividads','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('tipoactividads');


    $('#tipoactividadModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' TipoActividad');
      $('#form_tipoactividads_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tipoactividads_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tipoactividads_modal #slct_estado').val(1);
            $('#form_tipoactividads_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_tipoactividads_modal #txt_nombre').val( TipoActividadsG.nombre );
            $('#form_tipoactividads_modal #slct_estado').val( TipoActividadsG.estado );
            $("#form_tipoactividads_modal").append("<input type='hidden' value='"+TipoActividadsG.id+"' name='id'>");
        }
             $('#form_tipoactividads_modal select').multiselect('rebuild');
    });

    $('#tipoactividadModal').on('hide.bs.modal', function (event) {
       $('#form_tipoactividads_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TipoActividadsG.id=id;
    TipoActividadsG.nombre=$(tr).find("td:eq(0)").text();
    TipoActividadsG.estado=$(tr).find("td:eq(1)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="tipoactividads" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'tipoactividad','cargar',columnDefsG);
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
    $("#t_tipoactividads").dataTable(); // inicializo el datatable    
};

activar = function(id){
    TipoActividads.CambiarEstadoTipoActividads(id, 1);
};
desactivar = function(id){
    TipoActividads.CambiarEstadoTipoActividads(id, 0);
};
Editar = function(){
    if(validaTipoActividads()){
        TipoActividads.AgregarEditarTipoActividad(1);
    }
};
Agregar = function(){
    if(validaTipoActividads()){
        TipoActividads.AgregarEditarTipoActividad(0);
    }
};
validaTipoActividads = function(){
    var r=true;
    if( $("#form_tipoactividads_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de TipoActividad");
        r=false;
    }
    
    return r;
};
</script>
