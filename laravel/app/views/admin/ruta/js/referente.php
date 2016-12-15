<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
//id_referido,ruta_id,tabla_relacion_id,ruta_detalle_id
//var RolsG={id:0,nombre:"",estado:1}; // Datos Globales
var textoReferenteG;

var textoIdReferidoG;
var textoIdRutaG;
var textoIdTablaRelacionG;
var textoIdRutaDetalleG;

$(document).ready(function() {
    $('#referenteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      
      textoReferenteG= button.data('texto');
      
      textoIdReferidoG= button.data('idreferido');
      textoIdRutaG= button.data('idruta');
      textoIdTablaRelacionG= button.data('idtablarelacion');
      textoIdRutaDetalleG= button.data('idrutadetalle');
      
      var modal = $(this); //captura el modal
      //Asignar.Plataforma(PlataformaHTML);
      //$('#t_tramites_plataforma').dataTable().fnDestroy();
        var idG={   referido        :'onBlur|Referido|#DCE6F1', //#DCE6F1
                    fecha_hora_referido   :'onChange|Fecha Referido|#DCE6F1|fechaG', //#DCE6F1
                    id        :'1|[]|#DCE6F1', //#DCE6F1
                 };

        var resG=dataTableG.CargarCab(idG);
        cabeceraG=resG; // registra la cabecera
        var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'referente','t_referente');
        columnDefsG=resG[0]; // registra las columnas del datatable
        targetsG=resG[1]; // registra los contadores
        
        $('.fechaG').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });
        //MostrarAjax('referente');
    });

    $('#referenteModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      $("#t_referente>thead>tr:eq(1),#t_referente>tfoot>tr:eq(0)").html('');
        cabeceraG=[]; // Cabecera del Datatable
        columnDefsG=[]; // Columnas de la BD del datatable
        targetsG=-1; // Posiciones de las columnas del datatable
    });
    //$("#t_referente").dataTable();
});

//GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
//  
//    if(typeof(fn)!='undefined' && fn.col==2){
//        var estadohtml='';
//        estadohtml='<span id="'+row.id+'" onClick="CargarReferente(\''+row.id+'\',\''+row.referido+'\',\''+row.fecha_hora_referido+'\',\''+row.ruta_id+'\')" class="btn btn-success"><i class="fa fa-lg fa-check"></i></span>';
//        return estadohtml;
//    }
//};
//MostrarAjax=function(t){
//    if( t=="plataforma" ){
//        if( columnDefsG.length>0 ){
//            dataTableG.CargarDatos(t,'tabla_relacion','plataforma',columnDefsG);
//        }
//        else{
//            alert('Faltas datos');
//        }
//    }
//}

/*PlataformaHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
     $('#t_tramites_plataforma').dataTable().fnDestroy();

    $.each(datos,function(index,data){
    cont++;
    html+="<tr>"+
        "<td>"+data.tramite+"</td>"+
        "<td>"+data.fecha_inicio+"</td>"+
        "<td>"+data.proceso+"</td>"+
        '<td>'+
            '<a onclick="CargarTramitePlataforma('+"'"+data.tramite+"'"+');" class="btn btn-success btn-sm"><i class="fa fa-check-square fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

    });
    $("#t_tramites_plataforma tbody").html(html); 
    $("#t_tramites_plataforma").dataTable();
}*/

CargarReferente=function(id_referido,ruta_id,tabla_relacion_id,ruta_detalle_id,referido,fecha){
    $("#"+textoIdReferidoG).val($.trim(id_referido));
    $("#"+textoIdRutaG).val($.trim(ruta_id));
    $("#"+textoIdTablaRelacionG).val($.trim(tabla_relacion_id));
    $("#"+textoIdRutaDetalleG).val($.trim(ruta_detalle_id));
    
    $("#"+textoReferenteG).val($.trim(referido));
    
    $("#referenteModal .modal-footer>button").click();
};

BorrarReferido=function(){
    
    $("#"+textoIdReferidoG).val('');
    $("#"+textoIdRutaG).val('');
    $("#"+textoIdTablaRelacionG).val('');
    $("#"+textoIdRutaDetalleG).val('');
    
    $("#"+textoReferenteG).val('');
    

};
</script>
