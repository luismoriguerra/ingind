<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var TiemposG={
        id:0,
        nombre:"",
        apocope:"",
        totalminutos:"",
        estado:1
        }; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre|#DCE6F1', //#DCE6F1
                apocope        :'onBlur|Nombre APOCOPE|#DCE6F1', //#DCE6F1
                totalminutos     :'onBlur|Tiempo|#DCE6F1',    
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'tiempos','t_tiempos');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_tiempos','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('tiempos');


    $('#tiempoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Tiempo');
      $('#form_tiempos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tiempos_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tiempos_modal #slct_estado').val(1);
            $('#form_tiempos_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_tiempos_modal #txt_nombre').val( TiemposG.nombre );
            $('#form_tiempos_modal #txt_apocope').val( TiemposG.apocope );
            $('#form_tiempos_modal #txt_totalminutos').val( TiemposG.totalminutos );
            $('#form_tiempos_modal #slct_estado').val( TiemposG.estado );
            $("#form_tiempos_modal").append("<input type='hidden' value='"+TiemposG.id+"' name='id'>");
        }
             $('#form_tiempos_modal select').multiselect('rebuild');
    });

    $('#tiempoModal').on('hide.bs.modal', function (event) {
       $('#form_tiempos_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TiemposG.id=id;
    TiemposG.nombre=$(tr).find("td:eq(0)").text();
    TiemposG.apocope=$(tr).find("td:eq(1)").text();
    TiemposG.totalminutos=$(tr).find("td:eq(2)").text();
    TiemposG.estado=$(tr).find("td:eq(3)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="tiempos" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'tiempo','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==3){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activarTabla=function(){
    $("#t_tiempos").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Tiempos.CambiarEstadoTiempos(id, 1);
};
desactivar = function(id){
    Tiempos.CambiarEstadoTiempos(id, 0);
};
Editar = function(){
    if(validaTiempos()){
        Tiempos.AgregarEditarTiempo(1);
    }
};
Agregar = function(){
    if(validaTiempos()){
        Tiempos.AgregarEditarTiempo(0);
    }
};
validaTiempos = function(){
    var r=true;
    if( $("#form_tiempos_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de Tiempo");
        r=false;
    }
    else if( $("#form_tiempos_modal #txt_apocope").val()=='' ){
        alert("Ingrese APOCOPE");
        r=false;
    }

    else if( $("#form_tiempos_modal #txt_totalminutos").val()=='' ){
        alert("Ingrese Minutos");
        r=false;
    }

    return r;
};
</script>