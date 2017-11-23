<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var tablaActividad='';
var campos='';
$(document).ready(function() {
    
    $('#docdigitalModal').on('show.bs.modal', function (event) {
        
        var button = $(event.relatedTarget); // captura al boton
        var text = $.trim(button.data('texto'));
        var id = $.trim(button.data('id'));
        var avance_id = $.trim(button.data('avanceid'));
        var tipo_id = $.trim(button.data('tipoid'));
        var fecha_id = $.trim(button.data('fechaid'));
        var form = $.trim(button.data('form'));
        var camposP = {'nombre': text, 'id': id, 'avance_id': avance_id, 'form': form, 'tipo_id': tipo_id, 'fecha_id': fecha_id};
        campos=camposP;
      var button = $(event.relatedTarget); // captura al boton
      
      var modal = $(this); //captura el modal
      //Asignar.Plataforma(PlataformaHTML);
      //$('#t_tramites_plataforma').dataTable().fnDestroy();
        var idG={ 
                    titulo        :'onBlur|Titulo|#DCE6F1', //#DCE6F1
                    asunto        :'onBlur|asunto|#DCE6F1',
                    plantilla        :'onBlur|plantilla|#DCE6F1',
                    a        :'1|[]|#DCE6F1', //#DCE6F1
                    b        :'1|[]|#DCE6F1', //#DCE6F1
                 };

        var resG=dataTableG.CargarCab(idG);
        cabeceraG=resG; // registra la cabecera
        var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'docdigital','t_docdigital');
        columnDefsG=resG[0]; // registra las columnas del datatable
        targetsG=resG[1]; // registra los contadores
        
        MostrarAjax('docdigital');
    });

    $('#docdigitalModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      $("#t_docdigital>thead>tr:eq(1),#t_docdigital>tfoot>tr:eq(0)").html('');
        cabeceraG=[]; // Cabecera del Datatable
        columnDefsG=[]; // Columnas de la BD del datatable
        targetsG=-1; // Posiciones de las columnas del datatable
    });
//    $("#t_docdigital").dataTable();
});

MostrarAjax=function(t){
    if( t=="docdigital" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'documentodig','cargarcompleto',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
};
GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==4){
        if($.trim(row.ruta) != 0  || $.trim(row.rutadetallev) != 0){
           return "<a class='btn btn-success btn-sm' c_fecha_id='" + campos.fecha_id + "' c_tipo_id='" + campos.tipo_id + "' c_avance_id='" + campos.avance_id + "' c_form='" + campos.form + "' c_text='" + campos.text + "' c_id='" + campos.id + "'  id='" + row.id + "' title='" + row.titulo + "' onclick='SelectDocDig(this)'><i class='glyphicon glyphicon-ok'></i> </a>";
       }else{
            return "";
       }
    }
    if(typeof(fn)!='undefined' && fn.col==3){
       if($.trim(row.ruta) != 0  || $.trim(row.rutadetallev) != 0){
           return "<a class='btn btn-primary btn-sm' id='" + row.id + "' onclick='openPlantilla(this,0,4,1)'><i class='fa fa-eye'></i> </a>";
       }else{
            return "";
       }
    }

};
SelectDocDig = function (obj, id) {
    var id = obj.getAttribute('id');
    var nombre = obj.getAttribute('title');
    var form = obj.getAttribute('c_form');
    var avance_id = obj.getAttribute('c_avance_id');
    var tipo_id = obj.getAttribute('c_tipo_id');
    var fecha_id = obj.getAttribute('c_fecha_id');
    $("#docdigitalModal").modal('hide');

    var html = '';
    html += "<tr>" +
            "<td>#" ;
    if(tipo_id==5){
      html += "<input type='hidden' name='fecha_id[]' id='fecha_id' value='"+fecha_id+"'>" ;  
    }
    html += "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='" + tipo_id + "'>" +
            "<input type='hidden' name='avance_id[]' id='avance_id' value='" + avance_id + "'></td></td> " +
            "<input type='hidden' name='doc_id[]' id='doc_id' value='" + id + "'></td></td> " +
            "<td>";
    html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre"  name="pago_nombre[]" value="' + nombre + '">';
    html += "</td>" +
            '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">' +
            '<i class="fa fa-trash fa-lg"></i>' +
            '</a></td>';
    html += "</tr>";

    $(form).append(html);
};

openPlantilla=function(obj,id,tamano,tipo){
    var iddoc = id;
    if(id==0 || id ==''){
        iddoc=obj.getAttribute('id');
    }
    window.open("documentodig/vista/"+iddoc+"/"+tamano+"/"+tipo,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};
</script>
