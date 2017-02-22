<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var TiposG={id:0,nombre:"",estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre Tipo|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'tipos','t_tipos');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_tipos','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('tipos');


    $('#tipoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Tipo');
      $('#form_tipos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tipos_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tipos_modal #slct_estado').val(1);
            $('#form_tipos_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_tipos_modal #txt_nombre').val( TiposG.nombre );
            $('#form_tipos_modal #slct_estado').val( TiposG.estado );
            $("#form_tipos_modal").append("<input type='hidden' value='"+TiposG.id+"' name='id'>");
        }
             $('#form_tipos_modal select').multiselect('rebuild');
    });

    $('#tipoModal').on('hide.bs.modal', function (event) {
       $('#form_tipos_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TiposG.id=id;
    TiposG.nombre=$(tr).find("td:eq(0)").text();
    TiposG.estado=$(tr).find("td:eq(1)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="tipos" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'poitipo','cargar',columnDefsG);
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
    $("#t_tipos").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Tipos.CambiarEstadoTipos(id, 1);
};
desactivar = function(id){
    Tipos.CambiarEstadoTipos(id, 0);
};
Editar = function(){
    if(validaTipos()){
        Tipos.AgregarEditarTipo(1);
    }
};
Agregar = function(){
    if(validaTipos()){
        Tipos.AgregarEditarTipo(0);
    }
};

validaTipos = function(){
    var r=true;
    if( $("#form_tipos_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de Tipo");
        r=false;
    }
    return r;
};
</script>