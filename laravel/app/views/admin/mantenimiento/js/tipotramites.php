    <script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var TipoTramitesG={id:0,nombre:"",estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
   
    slctGlobalHtml('slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre TipoTramite|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'tipotramites','t_tipotramites');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_tipotramites','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('tipotramites');
    

    $('#tipotramiteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' TipoTramite');
      $('#form_tipotramites_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tipotramites_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tipotramites_modal #slct_estado').val(1);
            $('#form_tipotramites_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_tipotramites_modal #txt_nombre').val( TipoTramitesG.nombre );
            $('#form_tipotramites_modal #slct_estado').val( TipoTramitesG.estado );
            $("#form_tipotramites_modal").append("<input type='hidden' value='"+TipoTramitesG.id+"' name='id'>");
        }
             $('#form_tipotramites_modal select').multiselect('rebuild');
    });

    $('#tipotramiteModal').on('hide.bs.modal', function (event) {
       $('#form_tipotramites_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TipoTramitesG.id=id;
    TipoTramitesG.nombre=$(tr).find("td:eq(0)").text();
    TipoTramitesG.estado=$(tr).find("td:eq(1)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="tipotramites" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'tipotramite','cargar',columnDefsG);
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
    $("#t_tipotramites").dataTable(); // inicializo el datatable    
};

activar = function(id){
    TipoTramites.CambiarEstadoTipoTramites(id, 1);
};
desactivar = function(id){
    TipoTramites.CambiarEstadoTipoTramites(id, 0);
};
Editar = function(){
    if(validaTipoTramites()){
        TipoTramites.AgregarEditarTipoTramite(1);
    }
};
Agregar = function(){
    if(validaTipoTramites()){
        TipoTramites.AgregarEditarTipoTramite(0);
    }
};

validaTipoTramites = function(){
    var r=true;
    if( $("#form_tipotramites_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de TipoTramite");
        r=false;
    }
    return r;
};
</script>