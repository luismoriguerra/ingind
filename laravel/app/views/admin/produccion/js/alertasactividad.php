<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var DetalleG={id:0,proceso:"",area:"",tarea:"",verbo:"",documento:"",observacion:"",nroacti:"",updated_at:""}; // Datos Globales

var cabeceraG1=[]; // Cabecera del Datatable
var columnDefsG1=[]; // Columnas de la BD del datatable
var targetsG1=-1; // Posiciones de las columnas del datatable
var DetalleG1={id:0,proceso:"",area:"",id_union:"",sumilla:"",fecha:""}; // Datos Globales

$(document).ready(function() {

    function initDatePicker(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            multidate: 1,
            todayHighlight:true,
            onSelect: function (date, el) {
            }
        })
    }
    initDatePicker();

  /*  $('#fechaExonerar').on('hide.bs.modal', function (event) {
        $("#form_exoneracion input[type='hidden'],#form_exoneracion input[type='text'],#form_exoneracion select,#form_exoneracion textarea").not('.mant').val("");
        $('#form_exoneracion select').multiselect('refresh');  
    });*/
     /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var idG={   proceso        :'0|Proceso|#DCE6F1', //#DCE6F1
                area        :'0|Área|#DCE6F1', //#DCE6F1
                tarea        :'0|Tarea|#DCE6F1', //#DCE6F1
                verbo        :'0|Verbo|#DCE6F1', //#DCE6F1
                documento        :'0|Documento Generado|#DCE6F1', //#DCE6F1
                observacion        :'0|Observación|#DCE6F1', //#DCE6F1
                nroacti        :'0|N° de Actividad|#DCE6F1', //#DCE6F1
                updated_at        :'0|Fecha|#DCE6F1' //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,0,'detalles','t_detalles');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    
    slctGlobalHtml('slct_estado','simple');
    var idG1={   proceso        :'0|Proceso|#DCE6F1', //#DCE6F1
                area        :'0|Área|#DCE6F1', //#DCE6F1
                id_union        :'0|Nombre|#DCE6F1', //#DCE6F1
                sumilla        :'0|Sumilla|#DCE6F1', //#DCE6F1
                fecha        :'0|Fecha|#DCE6F1'
             };

    var resG1=dataTableG.CargarCab(idG1);
    cabeceraG1=resG1; // registra la cabecera
    var resG1=dataTableG.CargarCol(cabeceraG1,columnDefsG1,targetsG1,0,'detalles_tramite','t_detalles_tramite');
    columnDefsG1=resG1[0]; // registra las columnas del datatable
    targetsG1=resG1[1]; // registra los contadores
   

    
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
         showDropdowns: true
    });
    var dataG = {estado:1};
    var data = {estado:1};
    var ids = [];
/*    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);*/
    slctGlobal.listarSlct('area','slct_area_id','multiple',null,{estado:1});
    $("#generar_area").click(function (){
        area_id = $('#slct_area_id').val();
        if ($.trim(area_id)!=='') {
            data = {area_id:area_id};
            Usuario.mostrar(data);
        } else {
            alert("Seleccione Área");
        }
    });
    
        $("#i_area").click(function (){
        area_id = $('#slct_area_id').val();
        if ($.trim(area_id)!=='') {
            data = {area_id:area_id,estado:0};
            var c=confirm("¿Está seguro de Inactivar Notificaciones de Actividades para la(s) Áreas seleccionadas?");
            if (c){
             Usuario.CambiarAlertaActividadArea(data);}
        } else {
            alert("Seleccione Área");
        }
    });
    
    $("#a_area").click(function (){
        area_id = $('#slct_area_id').val();
        if ($.trim(area_id)!=='') {
           data = {area_id,estado:1};
            var c=confirm("¿Está seguro de Activar Notificaciones de Actividades para la(s) Áreas seleccionadas?");
            if (c){
             Usuario.CambiarAlertaActividadArea(data);}
        } else {
            alert("Seleccione Área");
        }
    });

    $("#btnexport").click(GeneraHref);
 

});

GeneraHref=function(){
    var fecha=$("#fecha").val();
        $("#btnexport").removeAttr('href');
        if ( fecha!=="") {
            data = {fecha:fecha,usuario_id:$("#usuario_id").val()};
            window.location='reporte/exportordentbyperson?fecha='+data.fecha+'&usuario_id='+data.usuario_id;
        }else{
            alert('selecciona un rango de fechas');
        }
    /*    else if ( fecha!=="" ) {
            data = {fecha:fecha};
            window.location='reporte/exportdocplataforma'+'?nro='+Math.random(1000)+'&fecha='+data.fecha;
        } */
}



HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        var fechaini = '';
        var fechafin = '';

        if(data.fechaini){
            fechaini=data.fechaini;
        }
        if(data.fechafin){
             fechafin=data.fechafin;
        }

        html+="<tr id="+data.norden+">"+
            "<td>"+data.paterno+"</td>"+
            "<td>"+data.materno+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.dni+"</td>"+
            "<td><span id='"+data.norden+"' onClick='exonerar(this)' data-estado='"+data.envio_actividad+"' class='btn btn-warning'>Exonera</span></td>";
           /* "<td><input type='text' name='txt_fechaini' id='txt_fechaini' class='form-control datepicker txt_fechaini' personaid='"+data.norden+"' Onchange='registerDate(this)' value='"+fechaini+"'/></td>"+
            "<td><input type='text' name='txt_fechafin' id='txt_fechafin' class='form-control datepicker txt_fechafin' personaid='"+data.norden+"' Onchange='registerDate(this)' value='"+fechafin+"'/></td>";*/
        if(data.envio_actividad==0){    
        html+='<td><span id="'+data.norden+'" onClick="activar('+data.norden+')" data-estado="'+data.envio_actividad+'" class="btn btn-danger">Actividad</span></td>';
        }if(data.envio_actividad==1){
        html+='<td><span id="'+data.norden+'" onClick="desactivar('+data.norden+')" data-estado="'+data.envio_actividad+'" class="btn btn-success">Actividad</span></td>';
        }
        html+="</tr>";
    });
    $("#tb_reporte").html(html);

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        multidate: 1,
        todayHighlight:true,
    });

    $("#t_reporte").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"],[2, "asc"]],
        }
    ); 
    $("#reporte").show();
};

exonerar = function(obj){
    Usuario.getExoneracion({persona_id:obj.getAttribute('id')});
    $('#txt_idpersona2').val(obj.getAttribute('id'));
    $("#fechaExonerar").modal('show');
}

/*add new verb to generate*/
Addtr = function(e){
    e.preventDefault();
    var template = $("#t_exoneracion").find('.trNuevo').clone().removeClass('trNuevo').removeClass('hidden');
    $("#t_exoneracion tbody").append(template);

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        multidate: 1,
        todayHighlight:true,
    });
}
/*end add new verb to generate*/

/*delete tr*/
Deletetr = function(object){
    object.parentNode.parentNode.remove();
}
/*end delete tr*/

HTMLExoneraciones = function(data){
        var html = '';
        $.each(data,function(index,el){
            html+='<tr>';
            html+=' <td>'+el.fecha_ini_exonera+'</td>';
            html+=' <td>'+el.fecha_fin_exonera+'</td>';
            html+=' <td>'+el.observacion+'</td>';

            if(el.estado == 1){
                html+=' <td><span id="btnDelete" name="btnDelete" class="btn btn-danger  btn-sm btnDelete" onclick="deleteExonera(this,'+el.id+')"><i class="glyphicon glyphicon-remove"></i></span></td>';
            }else{
                html+=' <td></td>';
            }
          
            html+='</tr>';            
        });
        $("#tb_exoneracion").html(html);
}

deleteExonera = function(obj,idexoneracion){
    Usuario.DeleteExonera({id:idexoneracion},obj);
}

registerDate = function(obj){
    var idpersona = obj.getAttribute('personaid');

    if(obj.value != '' && idpersona !=''){
        var data = {};
        data.idpersona = idpersona;
        if (obj.classList.contains('txt_fechaini')) {
            data.fechaini = obj.value;
        }
        if (obj.classList.contains('txt_fechafin')) {
            data.fechafin = obj.value;
        }
        Usuario.ExoneraPersona(data);
    }else{
        alert('Error!');
    }
}

ActPest=function(nro){
    Pest=nro;
};

activar=function(id){
    Usuario.CambiarAlertaActividad(id,1);
};

desactivar=function(id){
    Usuario.CambiarAlertaActividad(id,0);
};

activarTabla=function(){
    $("#t_detalles").dataTable(); // inicializo el datatable    
};
eventoSlctGlobalSimple=function(slct,valores){
};


saveVerbo = function(obj){
    var tr = obj.parentNode.parentNode;
    var fechaini = $(tr).find('.txt_fechaini').val();
    var fechafin =$(tr).find('.txt_fechafin').val();
    var observ = $(tr).find('.txt_observacion').val();
    if(fechaini != '' && fechafin != ''){
        var data = {'fechaini':fechaini,'fechafin':fechafin,'observ':observ,'idpersona':$("#txt_idpersona2").val()};
         Usuario.ExoneraPersona(data);
    }else{
        alert('complete datos');
    }
/*    if($(".txt_fechaini").val()== ""){
        alert('seleccione fecha inicio');
    }else if($(".txt_fechafin").val()== ""){
         alert('seleccione fecha fin');
    }else{
        Usuario.ExoneraPersona();        
    }*/
}


</script>
