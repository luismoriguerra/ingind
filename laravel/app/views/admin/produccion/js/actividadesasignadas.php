<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
//var RolsG={id:0,nombre:"",estado:1}; // Datos Globales
var tablaActividad='';
$(document).ready(function() {
    
    $('#actiasignadaModal').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget); // captura al boton
      
      var modal = $(this); //captura el modal
      //Asignar.Plataforma(PlataformaHTML);
      //$('#t_tramites_plataforma').dataTable().fnDestroy();
        var idG={ 
                    actividad        :'onBlur|Actividad|#DCE6F1', //#DCE6F1
                    categoria        :'onBlur|Categoria|#DCE6F1',
                    id        :'1|[]|#DCE6F1', //#DCE6F1
                 };

        var resG=dataTableG.CargarCab(idG);
        cabeceraG=resG; // registra la cabecera
        var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'actiasignada','t_actiasignada');
        columnDefsG=resG[0]; // registra las columnas del datatable
        targetsG=resG[1]; // registra los contadores
        
        MostrarAjax('actiasignada');
    });

    $('#actiasignadaModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      $("#t_actiasignada>thead>tr:eq(1),#t_actiasignada>tfoot>tr:eq(0)").html('');
        cabeceraG=[]; // Cabecera del Datatable
        columnDefsG=[]; // Columnas de la BD del datatable
        targetsG=-1; // Posiciones de las columnas del datatable
    });
//    $("#t_actiasignada").dataTable();
});

MostrarActividad=function(obj){
    var tabla=obj.parentNode.parentNode;
    var tr=$(tabla).children('div')[0];
    tablaActividad=tr;  
};

BorrarAsignado=function(obj){
    var tabla=obj.parentNode.parentNode;
    var tr=$(tabla).children('div')[0];
    $(tr).find('input:eq(1)').val('');
    $(tr).find('input:eq(0)').val('');
};

Contar=function(obj,tipo){
    if(tipo==1){
     var div=obj.parentNode.parentNode.parentNode;
     var cantidad=$(div).children('div')[1];
     var val=parseInt($(cantidad).find('input:eq(0)').val());
     $(cantidad).find('input:eq(0)').val(val+1);
    }
    if(tipo==2){
     var div=obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
     var cantidad=$(div).children('div')[1];
     var val=parseInt($(cantidad).find('input:eq(0)').val());
     $(cantidad).find('input:eq(0)').val(val-1);
    }
};

CargarActividad=function(id,actividad){
    $(tablaActividad).find('input:eq(1)').val(actividad);
    $(tablaActividad).find('input:eq(0)').val(id);
    $("#actiasignadaModal .modal-footer>button").click();
};

</script>
