<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable

//var RolsG={id:0,nombre:"",estado:1}; // Datos Globales
var textoDocumentoG;
////var textoIdDocumentoG;


$(document).ready(function() {
    $('#docsModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      
      textoDocumentoG= button.data('texto');  
      //textoIdDocumentoG= button.data('id');

      $("#"+textoDocumentoG).removeAttr("readonly");
      $("#"+textoDocumentoG).attr("readonly",'true');
      $("#"+textoDocumentoG).val("");
      
      var modal = $(this); //captura el modal
      //Asignar.Plataforma(PlataformaHTML);
      //$('#t_tramites_plataforma').dataTable().fnDestroy();
        var idG={   titulo        :'onBlur|Titulo|#DCE6F1', //#DCE6F1
                    asunto        :'onBlur|Asunto|#DCE6F1', //#DCE6F1
                    created_at   :'onChange|Fecha Creación|#DCE6F1|fechaG', //#DCE6F1
                    id        :'1|[]|#DCE6F1', //#DCE6F1
                 };

        var resG=dataTableG.CargarCab(idG);
        cabeceraG=resG; // registra la cabecera
        var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'docs','t_docs');
        columnDefsG=resG[0]; // registra las columnas del datatable
        targetsG=resG[1]; // registra los contadores
        
        $('.fechaG').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });
        MostrarAjax('docs');
    });

    $('#docsModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      $("#t_docs>thead>tr:eq(1),#t_docs>tfoot>tr:eq(0)").html('');
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

CargarDoc=function(id_documento,titulo){
    //$("#"+textoIdDocumentoG).val($.trim(id_documento));
    
    $("#"+textoDocumentoG).val($.trim(titulo));
    
    $("#docsModal .modal-footer>button").click();
};

</script>
