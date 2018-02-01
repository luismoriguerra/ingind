<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
//var RolsG={id:0,nombre:"",estado:1}; // Datos Globales
var textoIdFG='';
var textoFG='';
var textoAreaIdFG='';
var textoEventoFG='';
$(document).ready(function() {
    
    $('#procesoModal').on('show.bs.modal', function (event) {
       $("#form_proceso input[type='hidden']").remove();
       $("#form_proceso").append('<input type="hidden" name="txt_soloruta" value="1">');
       $("#form_proceso").append('<input type="hidden" name="txt_tipo_flujo"value="1">');
       $("#form_proceso").append('<input type="hidden" name="txt_pasouno" value="1">');
        $("#form_proceso").append('<input type="hidden" name="txt_nomicro" value="1">');
      var button = $(event.relatedTarget); // captura al boton
      textoFG= button.data('texto');
      textoIdFG= button.data('id');
      textoAreaIdFG= button.data('idarea');
      textoEventoFG='';
      if(typeof(button.data('evento'))!=='undefined'){
          textoEventoFG= button.data('evento');
      }
      
      var modal = $(this); //captura el modal
      //Asignar.Plataforma(PlataformaHTML);
      //$('#t_tramites_plataforma').dataTable().fnDestroy();
        var idG={   nombre        :'onBlur|Proceso|#DCE6F1', //#DCE6F1
                    id        :'1|[]|#DCE6F1', //#DCE6F1
                 };

        var resG=dataTableG.CargarCab(idG);
        cabeceraG=resG; // registra la cabecera
        var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'proceso','t_proceso');
        columnDefsG=resG[0]; // registra las columnas del datatable
        targetsG=resG[1]; // registra los contadores
//        
//
//        $('.fechaG').daterangepicker({
//            format: 'YYYY-MM-DD',
//            singleDatePicker: true,
//            showDropdowns: true
//        });
          MostrarAjax('proceso');  
    });

    $('#procesoModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      $("#t_proceso>thead>tr:eq(1),#t_proceso>tfoot>tr:eq(0)").html('');
        cabeceraG=[]; // Cabecera del Datatable
        columnDefsG=[]; // Columnas de la BD del datatable
        targetsG=-1; // Posiciones de las columnas del datatable
    });
    $("#t_tramites_plataforma").dataTable();
});

CargarProceso=function(flujo_id,flujo,area_id,area){
    $("#"+textoFG).val(flujo+" - "+area);
    $("#"+textoIdFG).val(flujo_id);
    $("#"+textoAreaIdFG).val(area_id);
    
    if(textoEventoFG!=''){
        eventoFG(textoEventoFG);
    }
    $("#procesoModal .modal-footer>button").click();
};

</script>
