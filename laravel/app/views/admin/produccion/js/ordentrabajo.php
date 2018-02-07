<script type="text/javascript">
var TablaDocumento; // Datos Globales
var cabeceraG1=[]; // Cabecera del Datatable
var columnDefsG1=[]; // Columnas de la BD del datatable
var targetsG1=-1; // Posiciones de las columnas del datatable
$(document).ready(function() {
    var idG1={  persona_c        :'onBlur|Creador|#DCE6F1', //#DCE6F1
                titulo      :'onBlur|Título|#DCE6F1', //#DCE6F1
                asunto        :'onBlur|Asunto|#DCE6F1', //#DCE6F1
                c        :'1|Vista Previa|#DCE6F1', //#DCE6F1
                d        :'1|Seleccionar|#DCE6F1', //#DCE6F1
             };

    var resG1=dataTableG.CargarCab(idG1);
    cabeceraG1=resG1; // registra la cabecera
    var resG1=dataTableG.CargarCol(cabeceraG1,columnDefsG1,targetsG1,1,'docdigitales_relaciones','t_docdigitales_relaciones');
    columnDefsG1=resG1[0]; // registra las columnas del datatable
    targetsG1=resG1[1]; // registra los contadores
    
    
    Area_id = '<?php echo Auth::user()->area_id; ?>';
    id = '<?php echo Auth::user()->id; ?>';
    Rol_id='<?php echo Auth::user()->rol_id; ?>';
    slctGlobal.listarSlctFuncion('area','personaarea','slct_personasA','simple',null,{area_id:Area_id,persona:id});
 
    if(Rol_id == 8 || Rol_id ==9){
        $(".selectbyPerson").removeClass('hidden');       
    }else{
        $(".selectbyPerson").addClass('hidden');
    }
     var dataG = [];
     dataG = {fecha:'<?php echo date("Y-m-d") ?>'};
     Asignar.CargarOrdenTrabajoDia(dataG);  
     
    var today = new Date();
                
    initDatePicker();
    initClockPicker();

    $(document).on('change','.clockpicker', function(event) {
        console.log('change');
    });

    // $('.clockpicker').change(function(e){
    //     console.log($(this));
    // });
    
    $(document).on('click', '#btnAdd', function(event) {
        event.preventDefault();
        var template = $(".ordenesT").find('.template-orden').clone().removeClass('template-orden').removeClass('hidden').addClass('valido');
        $(".ordenesT").append(template);
        initDatePicker();
        initClockPicker();
        $("#txt_ttotal").val(CalcGlobalH());
    }); 
    
    $(document).on('click', '.btnDeleteitem', function (event) {
            $(this).parent().parent().remove();
    });
    
    $(document).on('click', '.btnDelete', function(event) {
        $(this).parent().parent().parent().remove();
        initDatePicker();
        initClockPicker();
        $("#txt_ttotal").val(CalcGlobalH());
    }); 
    
    $('.fechaG').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: true,
        showDropdowns: true
    });
            
    });

function initClockPicker(){
    $('[data-mask]').inputmask("hh:mm", {
        placeholder: "HH:MM", 
        insertMode: false, 
        showMaskOnHover: false,
        hourFormat: 24
      }
   );
}

<?php  
    function inicio_fin_semana(){
    $fecha=date('Y-m-d');
    $diaInicio="Monday";
    $diaFin="Sunday";

    $strFecha = strtotime($fecha);

    $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
    $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));

    if(date("l",$strFecha)==$diaInicio){
        $fechaInicio= date("Y-m-d",$strFecha);
    }
    if(date("l",$strFecha)==$diaFin){
        $fechaFin= date("Y-m-d",$strFecha);
    }
    return Array("fechaInicio"=>$fechaInicio,"fechaFin"=>$fechaFin);
    }
    $fechas=inicio_fin_semana(); 
?>
var fecha_inicio='<?php echo $fechas['fechaInicio'];?>';
var fecha_fin='<?php echo $fechas['fechaFin'];?>';

function initDatePicker(){
    $('.fechaInicio').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        multidate: 1,
        todayHighlight:true,
        startDate: '<?php echo $fechas['fechaInicio'];?>',
        endDate:'<?php echo $fechas['fechaFin'];?>',
     /*  daysOfWeekDisabled: '0', //bloqueo domingos*/
        onSelect: function (date, el) {
        }
    })
}

fecha = function(obj,tipo){
    if(typeof (tipo)!='undefined'){
        var row = obj.parentNode.parentNode;
    }else {
      var row = obj.parentNode.parentNode.parentNode.parentNode;  
    }
    var valor =obj.value;

    $(row).find('.fechaFin').val(valor);
    }
    
/*add new verb to generate*/
Addtr = function(e){
    e.preventDefault();
    var template = $(".ordenesT").find('.template-orden').clone().removeClass('template-orden').removeClass('hidden');
    $(".ordenesT").append(template);
    initDatePicker();
    initClockPicker();
}
/*end add new verb to generate*/

/*end delete tr*/
var calcTotal = 0;
CalcularHrs = function(object,tipo){
    if(typeof (tipo)!='undefined'){
        var row = object.parentNode.parentNode;
    }else {
    var row = object.parentNode.parentNode.parentNode.parentNode;
    }
    var HoraInicio = $(row).find('.horaInicio')[0].value;
    var HoraFin = $(row).find('.horaFin')[0].value;


    if(HoraInicio != '' && HoraFin != ''){
        if(HoraInicio < HoraFin){
            var hi = new Date (new Date().toDateString() + ' ' + HoraInicio);
            var hf = new Date (new Date().toDateString() + ' ' + HoraFin);

                var interval = hf.getTime() - hi.getTime();
                calcTotal = calcTotal + interval;
                var hours = ((Math.floor(interval/1000/60/60))%24);
                var min = ((Math.floor(interval/1000/60))%60);
                $(row).find('.ttranscurrido').val(hours + ":" + min);
        }else{
            $(row).find('.horaFin')[0].value = '';
           alert('La hora Inicial ' + HoraInicio +' no puede ser mayor que la final! '+ HoraFin + ', siga el formato hh:mm'); 
        }
    }else{
       
    }
}

CalcGlobalH = function(){
    var calcGlobal=0;
    $(".valido .ttranscurrido").each(function(index, el) {
        var valor = $(el).val();
        if(valor){
            var minutos = parseInt(valor.split(':')[0] * 60) + parseInt(valor.split(':')[1]);
            calcGlobal+=minutos;
        }
    });

    var horas = Math.floor( calcGlobal / 60);
    var min = calcGlobal % 60;
    return horas + ':' + min;
}

mostrarConfirmacion = function(){
    var calcG = CalcGlobalH();
    $("#txt_ttotal").val(CalcGlobalH());
    $("#spanMensaje").text("Usted a generado " + calcG.split(':')[0] + "hora(s) con " + calcG.split(':')[1] + " minuto(s),Desea Guardar?");
    $("#ConfirmacionModal").modal('show');
}

guardarTodo = function(){
/*    var calcG = CalcGlobalH();
    $("#txt_ttotal").val(CalcGlobalH());
    $("#spanMensaje").text("Usted a generado" + calcG.split(':')[0] + "hora(s) con" + calcG.split(':')[1] + "minuto(s),Desea Guardar?");*/
/*    var r = confirm("Usted a generado" + calcG.split(':')[0] + "hora(s) con" + calcG.split(':')[1] + "minuto(s),Desea Guardar?");
    if (r == true) {*/
        var actividades = $(".valido textarea[id='txt_actividad']").map(function(){return $(this).val();}).get();
        var finicio = $(".valido input[id='txt_fechaInicio']").map(function(){return $(this).val();}).get();
        var ffin = $(".valido input[id='txt_fechaFin']").map(function(){return $(this).val();}).get();
        var hinicio = $(".valido input[id='txt_horaInicio']").map(function(){return $(this).val();}).get();
        var hfin = $(".valido input[id='txt_horaFin']").map(function(){return $(this).val();}).get();
        var cantidad = $(".valido input[id='txt_cantidad']").map(function(){return $(this).val();}).get();
        var actividad_asignada = $(".valido input[id='txt_actividad_asignado_id']").map(function(){return $(this).val();}).get();
        var ttranscurrido = $(".valido input[id='txt_ttranscurrido']").map(function(){return $(this).val();}).get();
        var persona = document.querySelector("#slct_personasA").value;
        
        var tbarchivo =[];
        var tablaarchivo = $(".valido table[id='t_darchivo']").map(function(){
//            console.log(this);
            tbarchivo =[];
            tbarchivo.push($(this).find("tbody tr").map(function(){
                            return $(this).find('input:eq(0)').val()+'|'+$(this).find('input:eq(1)').val();
                        }).get());
//            console.log(tbarchivo);
            return tbarchivo;
        }).get();

        var tbdocumento=[];
        var tabladocumento = $(".valido table[id='t_ddocumento']").map(function(){
            tbdocumento=[];
            tbdocumento.push( $(this).find("tbody tr").map(function(){
                return $(this).find('input:eq(0)').val();
            }).get());
          return tbdocumento;
        }).get();
    
        var data = [];
        var personaid = '';
        if(persona){
            personaid=persona;
        }

        var incompletas = [];
        var orden = 0;
        for(var i=0; i < actividades.length;i++){
            if(actividades[i].trim() != "" && finicio[i].trim() != "" && ffin[i].trim() != "" && hfin[i].trim()!="" && hinicio[i].trim()!=""){
                data.push({
                    'actividad' : actividades[i].trim(),
                    'finicio' : finicio[i],
                    'ffin' : ffin[i],
                    'hinicio' : hinicio[i],
                    'hfin' : hfin[i],
                    'ttranscurrido' : ttranscurrido[i],
                    'persona':personaid,
                    'cantidad':cantidad[i],
                    'actividadasignada':actividad_asignada[i],
                    'archivo':tablaarchivo[i],
                    'documento':tabladocumento[i],
                    'tipo':'1',
                });                    
            }else{
                orden = i + 1;
                incompletas.push(orden);
            }
        }

        if(incompletas.length > 0){
            alert('Complete los datos en su(s) actividad(es): '+incompletas.join(',') + ' o elimine,para poder completar su registro');          
        }else{
             Asignar.guardarOrdenTrabajo(data); 
             $("#ConfirmacionModal").modal('hide');
        }
/*    }*/
}

HTMLcargarordentrabajodia=function(datos){
  var html="";
    
    var alerta_tipo= '';
    $('#t_produccion').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        var fecha_inicio = data.fecha_inicio.split(' ');
        var dtiempo_final = data.dtiempo_final.split(' ');
        var hinicio = fecha_inicio[1].substring(0, 5);
        var hfin = dtiempo_final[1].substring(0, 5);
        var formato = data.formato.substring(0, 5);
        pos++;
        
        html+="<tr id="+data.norden+">"+
            "<td>"+pos+'</td>'+
            "<td>"+data.actividad+"</td>"+
            "<td><input type='text' class='datepicker form-control fechaInicio' id='txt_fechaInicio' name='txt_fechaInicio' disabled='disabled' onchange='fecha(this,2)' value='"+fecha_inicio[0]+"'></td>"+
            "<td><input type='numeric' class='form-control horaInicio' id='txt_horaInicio' name='txt_horaInicio' onchange='CalcularHrs(this,2)' value='"+hinicio+"' data-mask></td>"+
            "<td><input type='text' class='datepicker form-control fechaFin' id='txt_fechaFin' name='txt_fechaFin'  disabled='disabled' value='"+dtiempo_final[0]+"'></td>"+
            "<td><input type='numeric' class='form-control horaFin' id='txt_horaFin' name='txt_horaFin' onchange='CalcularHrs(this,2)' value='"+hfin+"' data-mask></td>"+
            "<td><input type='text' class='form-control ttranscurrido' id='txt_ttranscurrido' name='txt_ttranscurrido' value='"+formato+"' readonly='readonly'></td>";
       if(data.usuario_created_at==data.persona_id){
        html+="<td align='center'><span class='btn btn-success btn-md' onClick='EditarActividad("+data.norden+","+pos+")' > Editar</a></td>";
       }
       else {
        html+="<td align='center'></td>";   
       }
       html+="</tr>";
    });
    $("#tb_produccion").html(html);
    initClockPicker();
    initDatePicker();
    $("#t_produccion").dataTable(
             {
        "language": {
            "emptyTable": "Usted no ha registrado actividades el día de hoy"
            },
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 100,
        }
    ); 
  };  

EditarActividad=function(id,pos){
        
//     var finicio = document.getElementById(id).getElementsByTagName('td')[2].innerHTML;
//     var ffin = document.getElementById(id).getElementsByTagName('td')[4].innerHTML;
     var finicio = $('#'+id).find("input:eq(0)").val();     
     var ffin = $('#'+id).find("input:eq(2)").val();     
     hinicio=$('#'+id).find("input:eq(1)").val();     
     hfin=$('#'+id).find("input:eq(3)").val();
     ttranscurrido=$('#'+id).find("input:eq(4)").val();
     var dataG = [];
     dataG = {id:id,finicio:finicio,hinicio:hinicio,ffin:ffin,hfin:hfin,ttranscurrido:ttranscurrido};
     Asignar.EditarActividad(dataG,pos);  
    
};
MostrarDocumentos=function(obj){
    var tabla=obj.parentNode.parentNode.parentNode.parentNode;
            TablaDocumento=tabla;
           $('#form_docdigitales').hide();
           $('#form_docdigitales_relaciones').show();
           $("#t_docdigitales_relaciones").dataTable();
           MostrarAjax('docdigitales_relaciones'); 
    
};

MostrarAjax=function(t){

    if( t=="docdigitales_relaciones" ){
        if( columnDefsG1.length>0 ){
            dataTableG.CargarDatos(t,'documentodig','cargarcompleto',columnDefsG1);
        }
        else{
            alert('Faltas datos');
        }
    }
    if( t=="actiasignada" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'actividadpersonal','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn

    if(typeof(fn)!='undefined' && fn.col==2){
        //return '<span id="2616" onclick="CargarActividad('+row.id+',\''+row.actividad+'\')" class="btn btn-success"><i class="fa fa-lg fa-check"></i></span>';
        return '<span id="2616" onclick="CargarActividad('+row.id+',\''+row.actividad.split('"').join('|').split("'").join('|')+'\')" class="btn btn-success"><i class="fa fa-lg fa-check"></i></span>';
    }
    if(typeof(fn)!='undefined' && fn.col==3){
        return "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",4,0); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A4</i> </a>"+
                   "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",5,0); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A5</i> </a>";
    }
    if(typeof(fn)!='undefined' && fn.col==4){
        return "<a class='btn btn-success btn-sm' onclick='SelectDocDig(this,"+row.id+",\""+row.titulo+"\")'><i class='glyphicon glyphicon-ok'></i> </a>";
    }
    if(typeof(fn)!='undefined' && fn.col==8){
       if($.trim(row.ruta) != 0  || $.trim(row.rutadetallev) != 0){
           return "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",4,1); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A4</i> </a>"+
                  "<a class='btn btn-default btn-sm' onclick='openPlantilla("+row.id+",5,1); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'>&nbsp;A5</i> </a>";
       }else{
            return "";
       }
    }

}

    AgregarD = function (obj) {
        var tabla=obj.parentNode.parentNode.parentNode.parentNode;
        var html = '';
        html += "<tr>";
        html += "<td>";
        html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre"  name="pago_nombre[]" value="">' +
                '<input type="text"  style="display: none;" id="pago_archivo" name="pago_archivo[]">' +
                '<label class="btn btn-default btn-flat margin btn-xs">' +
                '<i class="fa fa-file-pdf-o fa-lg"></i>' +
                '<i class="fa fa-file-word-o fa-lg"></i>' +
                '<i class="fa fa-file-image-o fa-lg"></i>' +
                '<input type="file" style="display: none;" onchange="onPagos(event,this);" >' +
                '</label>';
        html += "</td>" +
                '<td><a id="btnDeleteitem"  name="btnDeleteitem" class="btn btn-danger btn-xs btnDeleteitem">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a></td>';
        html += "</tr>";
        $(tabla).find("tbody").append(html);
    }
    
    
    onPagos = function (event,obj) {
        var tr=obj.parentNode.parentNode;
       console.log(tr);
        var files = event.target.files || event.dataTransfer.files;
        if (!files.length)
            return;
        var image = new Image();
        var reader = new FileReader();
        reader.onload = (e) => {
            $(tr).find('input:eq(1)').val(e.target.result);
        };
        reader.readAsDataURL(files[0]);
        $(tr).find('input:eq(0)').val(files[0].name);
        console.log(files[0].name);
    }
    
    SelectDocDig = function (obj,id,titulo) {
        $("#docdigitalModal").modal('hide');

        var html = '';
        html += "<tr>" +
                "<td>#" ;
        html += "<input type='hidden' name='doc_id[]' id='doc_id' value='" + id + "'></td> " +
                "<td>";
        html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre"  name="pago_nombre[]" value="' + titulo + '">';
        html += "</td>" +
                '<td><a id="btnDeleteitem"  name="btnDeleteitem" class="btn btn-danger btn-xs btnDeleteitem" onclick="Contar(this,2)">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a></td>';
        html += "</tr>";
        Contar(TablaDocumento,1);
        $(TablaDocumento).find("tbody").append(html);


    }
    
    openPlantilla=function(id,tamano,tipo){
    window.open("documentodig/vista/"+id+"/"+tamano+"/"+tipo,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};
</script>
