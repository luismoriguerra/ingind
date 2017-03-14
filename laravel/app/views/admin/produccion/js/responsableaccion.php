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

    area_id='<?php echo Auth::user()->area_id; ?>';
    Usuario.mostrar({area_id:area_id});

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

    $('.datepicker').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
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
    slctGlobal.listarSlct('area','slct_area_id','multiple',null,{estado:1,areagestionall:1,responsable:1});
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
            "<td>"+data.dni+"</td>";

        if(data.responsable_asigt==0){    
            html+='<td><span id="'+data.norden+'" onClick="CambiarEstadoAsigt('+data.norden+',1)" data-estado="'+data.responsable_asigt+'" class="btn btn-danger">Inactivo</span></td>';
        }else{
            html+='<td><span id="'+data.norden+'" onClick="CambiarEstadoAsigt('+data.norden+',0)" data-estado="'+data.responsable_asigt+'" class="btn btn-success">Activo</span></td>';
        }

        if(data.responsable_dert==0){    
            html+='<td><span id="'+data.norden+'" onClick="CambiarEstadoDert('+data.norden+',1)" data-estado="'+data.responsable_dert+'" class="btn btn-danger">Inactivo</span></td>';
        }else{
            html+='<td><span id="'+data.norden+'" onClick="CambiarEstadoDert('+data.norden+',0)" data-estado="'+data.responsable_dert+'" class="btn btn-success">Activo</span></td>';
        }

        html+="</tr>";
    });
    $("#tb_reporte").html(html);

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        multidate: 1,
        todayHighlight:true,
         onSelect: function (date, el) {
        }
    });

    $("#t_reporte").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"],[2, "asc"]],
        }
    ); 
    $("#reporte").show();
};

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

CambiarEstadoAsigt = function(id,estado){
    Usuario.estadoAsigt({'id':id,'estado':estado});
}

CambiarEstadoDert = function(id,estado){
    Usuario.estadoDervt({'id':id,'estado':estado});
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
</script>
