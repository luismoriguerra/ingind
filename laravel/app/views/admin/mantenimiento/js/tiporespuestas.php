<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var TipoRespuestasG={
        id:0,
        nombre:"",
        tiempo:"",
        estado:1
        }; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_tiempo,#slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre TipoRespuesta|#DCE6F1', 
                tiempo          :'3|Tiempo|#DCE6F1',
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'tiporespuestas','t_tiporespuestas');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_tiporespuestas','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('tiporespuestas');


    $('#tiporespuestaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' TipoRespuesta');
      $('#form_tiporespuestas_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tiporespuestas_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tiporespuestas_modal #slct_estado').val(1);
            $('#form_tiporespuestas_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_tiporespuestas_modal #txt_nombre').val( TipoRespuestasG.nombre );
            $('#form_tiporespuestas_modal #slct_tiempo').val( TipoRespuestasG.tiempo );
            $('#form_tiporespuestas_modal #slct_estado').val( TipoRespuestasG.estado );
            $("#form_tiporespuestas_modal").append("<input type='hidden' value='"+TipoRespuestasG.id+"' name='id'>");
        }
             $('#form_tiporespuestas_modal select').multiselect('rebuild');
    });

    $('#tiporespuestaModal').on('hide.bs.modal', function (event) {
       $('#form_tiporespuestas_modal input').val('');
       $('#form_tiporespuestas_modal #slct_tiempo').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TipoRespuestasG.id=id;
    TipoRespuestasG.nombre=$(tr).find("td:eq(0)").text();
    TipoRespuestasG.tiempo=$(tr).find("td:eq(1) input[name='txt_tiempo']").val();
    TipoRespuestasG.estado=$(tr).find("td:eq(2)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="tiporespuestas" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'tiporespuesta','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==1){
        return row.tiempo+"<input type='hidden'name='txt_tiempo' value='"+row.tiempo_id+"'>";
    }
    else if(typeof(fn)!='undefined' && fn.col==2){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activarTabla=function(){
    $("#t_tiporespuestas").dataTable(); // inicializo el datatable    
};

activar = function(id){
    TipoRespuestas.CambiarEstadoTipoRespuestas(id, 1);
};
desactivar = function(id){
    TipoRespuestas.CambiarEstadoTipoRespuestas(id, 0);
};
Editar = function(){
    if(validaTipoRespuestas()){
        TipoRespuestas.AgregarEditarTipoRespuesta(1);
    }
};
Agregar = function(){
    if(validaTipoRespuestas()){
        TipoRespuestas.AgregarEditarTipoRespuesta(0);
    }
};
validaTipoRespuestas = function(){
    var r=true;
    if( $("#form_tiporespuestas_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de TipoRespuesta");
        r=false;
    }
    else if( $("#form_tiporespuestas_modal #slct_tiempo").val()=='' ){
        alert("Seleccione Tiempo");
        r=false;
    }
    return r;
};
</script>