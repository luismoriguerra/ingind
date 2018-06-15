<script type="text/javascript">
var TablaDocumento; // Datos Globales
var cabeceraG1=[]; // Cabecera del Datatable
var columnDefsG1=[]; // Columnas de la BD del datatable
var targetsG1=-1; // Posiciones de las columnas del datatable
var diferenciador=0;
$(document).ready(function() {

    $(".atencion").hide();
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
    slctGlobal.listarSlctFuncion('area','personaarea','slct_personasA','simple',null,{area_id:Area_id});
    slctGlobal.listarSlct2('actividadcategoria','n, .slct_cate',{estado:1});
    $(".selectbyPerson").removeClass('hidden');       

    CargarOrden();    
     
    var today = new Date();
                
    initDatePicker();
    initClockPicker();

    $(document).on('change','.clockpicker', function(event) {
//        console.log('change');
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
    

    
    $(document).on('change','#slct_asignacion', function(event) {
        if($('#slct_asignacion').val()==1){
            $(".categoria").show();
            $(".atencion").hide();
        }else{
            $(".categoria").hide();
            $(".atencion").show();
        }
        
    });

});

function CargarOrden(){
     var dataG = [];
     dataG = {fecha:'<?php echo date("Y-m-d") ?>',tipopersona:'|'};
     Asignar.CargarOrdenTrabajoDia(dataG); 
}
function initClockPicker(){
    $('[data-mask]').inputmask("hh:mm", {
        placeholder: "HH:MM", 
        insertMode: false, 
        showMaskOnHover: false,
        hourFormat: 24
      }
   );
}

function initDatePicker(){
    $('.fechaG').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        multidate: 1,
        todayHighlight:true,
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
    
hora = function(obj,tipo){
    if(typeof (tipo)!='undefined'){
        var row = obj.parentNode.parentNode;
    }else {
      var row = obj.parentNode.parentNode.parentNode.parentNode;  
    }
    var valor =obj.value;

    $(row).find('.horaFin').val(valor);
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


    var fechaInicio = new Date($(row).find('.fechaInicio')[0].value);
    var fechaFin = new Date($(row).find('.fechaFin')[0].value);



    if(HoraInicio != '' && HoraFin != ''){
        if(fechaInicio <= fechaFin){
            if( (HoraInicio < HoraFin) || fechaInicio < fechaFin){            
                var hi = new Date (new Date().toDateString() + ' ' + HoraInicio);
                var hf = new Date (new Date().toDateString() + ' ' + HoraFin);

                    var interval = hf.getTime() - hi.getTime();
                    calcTotal = calcTotal + interval;
                    var hours = ((Math.floor(interval/1000/60/60))%24);
                    var min = ((Math.floor(interval/1000/60))%60);
                    $(row).find('.ttranscurrido').val(hours + ":" + min);
            }else{
                $(row).find('.horaFin')[0].value = '';
            alert('La hora Inicial ' + HoraInicio +' no puede ser mayor que la final! '+ HoraFin + ', siga el formato hh:mm.');  
            }
        }else{
            $(row).find('.fechaFin')[0].value = '';
                alert('La fecha Inicial ' + $(row).find('.fechaInicio')[0].value +' no puede ser mayor que la final! '+ $(row).find('.fechaFin')[0].value + '.');
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
//    var calcG = CalcGlobalH();
//    $("#txt_ttotal").val(CalcGlobalH());
//    var r = confirm("Usted a generado " + calcG.split(':')[0] + "hora(s) con " + calcG.split(':')[1] + " minuto(s),Desea Guardar?");
//    if (r == true) {
        var actividades = $(".valido textarea[id='txt_actividad']").map(function(){return $(this).val();}).get();
        var finicio = $(".valido input[id='txt_fechaInicio']").map(function(){return $(this).val();}).get();
        var ffin = $(".valido input[id='txt_fechaFin']").map(function(){return $(this).val();}).get();
        var hinicio = $(".valido input[id='txt_horaInicio']").map(function(){return $(this).val();}).get();
        var cantidad = $(".valido input[id='txt_cantidad']").map(function(){return $(this).val();}).get();
        var hfin = $(".valido input[id='txt_horaFin']").map(function(){return $(this).val();}).get();
        var ttranscurrido = $(".valido input[id='txt_ttranscurrido']").map(function(){return $(this).val();}).get();
        var actividad_categoria_id = $(".valido select[id='slct_categoria']").map(function(){return $(this).val();}).get();
        var ruta_detalle_id = $(".valido input:radio[id='ruta_detalle_id']:checked").map(function(){return $(this).val();}).get();
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
        
        var tbtramite=[];
        var tablatramite = $(".valido table[id='t_tramite']").map(function(){
            tbtramite=[];
            tbtramite.push( $(this).find("tbody tr table[id='t_verbo'] tr").map(function(){
                
                return $(this).find('input:eq(0):checked').val();
            }).get());
          return tbtramite;
        }).get();
        var data = [];
        var personaid = '';
        if(persona){
            personaid=persona;
        }

        var incompletas = [];
        var orden = 0;
        
        var tipo_asignacion=$("#slct_asignacion").val(); // categoria:1 | atencion:2

            for(var i=0; i < actividades.length;i++){
                if(tipo_asignacion==1){
                    if(actividades[i] != '' && finicio[i] != '' && ffin[i] != '' && hfin[i]!='' && hinicio[i]!='' && actividad_categoria_id[i]!=''){
                        data.push({
                            'tipo_asignacion':tipo_asignacion,
                            'actividad' : actividades[i],
                            'finicio' : finicio[i],
                            'ffin' : ffin[i],
                            'hinicio' : hinicio[i],
                            'hfin' : hfin[i],
                            'ttranscurrido' : ttranscurrido[i],
                            'persona':personaid,
                            'cantidad':cantidad[i],
                            'archivo':tablaarchivo[i],
                            'documento':tabladocumento[i],
                            'actividad_categoria_id':actividad_categoria_id[i],
                            'tipo':'2',
                        });                    
                    }else{
                        orden = i + 1;
                        incompletas.push(orden);
                    }
                }
                if(tipo_asignacion==2){
                    if(tablatramite[i].length==0){
                        tablatramite[i].push(0);
                    }
                    if(actividades[i] != '' && finicio[i] != '' && ffin[i] != '' && hfin[i]!='' && hinicio[i]!=''){
                        data.push({
                            'tipo_asignacion':tipo_asignacion,
                            'actividad' : actividades[i],
                            'finicio' : finicio[i],
                            'ffin' : ffin[i],
                            'hinicio' : hinicio[i],
                            'hfin' : hfin[i],
                            'ttranscurrido' : ttranscurrido[i],
                            'persona':personaid,
                            'cantidad':cantidad[i],
                            'archivo':tablaarchivo[i],
                            'documento':tabladocumento[i],
                            'tramite':tablatramite[i],
                            'ruta_detalle_id':ruta_detalle_id[i],
                            'tipo':'2',
                        });                    
                    }else{
                        orden = i + 1;
                        incompletas.push(orden);
                    }
                }
            }
            if(incompletas.length > 0){
                alert('Complete los datos en su(s) actividad(es): '+incompletas.join(',') + ' o elimine,para poder completar su registro');          
            }
            else if(persona==''){
                alert("Seleccione al trabajador que se le asignará la(s) actividad(es)");
            }
            else {
                Asignar.guardarOrdenTrabajo(data); 
                $("#ConfirmacionModal").modal('hide'); 
            }

//    }
};

HTMLcargarordentrabajodia=function(datos){
  var html="";
    
    var alerta_tipo= '';
    $('#t_produccion').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        // alert(data.id);
        var fecha_inicio = data.fecha_inicio.split(' ');
        var dtiempo_final = data.dtiempo_final.split(' ');
        var hinicio = fecha_inicio[1].substring(0, 5);
        var hfin = dtiempo_final[1].substring(0, 5);
        var formato = data.formato.substring(0, 5);
        pos++;



        if(data.cargo_dir == '0' || data.cargo_dir == ''){

            var cargo = "<span class='btn btn-info btn-md' title=\"Crear nota de cargo\" onClick='CrearPDF("+data.norden+","+pos+")' > <i class=\"fa fa-file\"></i> </span><span class='btn btn-info btn-md' title=\"Subir soporte de nota\" onClick='subirImgModal("+data.norden+","+pos+")' > <i class=\"fa fa-upload\"></> </span>";

        }else{
            
            var cargo = "<span class='btn btn-info btn-md' title=\"Ver nota de cargo\" onClick='verImagen(\""+data.cargo_dir+"\")' > <i class=\"fa fa-image\"></i> </span>";

        }




        html+="<tr id="+data.norden+">"+
            "<td>"+pos+'</td>'+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.actividad+"</td>"+
            "<td><input type='text' class='datepicker form-control fechaInicio' id='txt_fechaInicio' name='txt_fechaInicio' onchange='fecha(this,2)' value='"+fecha_inicio[0]+"'></td>"+
            "<td><input type='numeric' class='form-control horaInicio' id='txt_horaInicio' name='txt_horaInicio' onchange='CalcularHrs(this,2)' value='"+hinicio+"' data-mask></td>"+
            "<td><input type='text' class='datepicker form-control fechaFin' id='txt_fechaFin' name='txt_fechaFin'  disabled='disabled' value='"+dtiempo_final[0]+"'></td>"+
            "<td><input type='numeric' class='form-control horaFin' id='txt_horaFin' name='txt_horaFin' onchange='CalcularHrs(this,2)' value='"+hfin+"' data-mask></td>"+
            "<td><input type='text' class='form-control ttranscurrido' id='txt_ttranscurrido' name='txt_ttranscurrido' value='"+formato+"' readonly='readonly'></td>"+
            "<td align='center'><span class='btn btn-success btn-md' onClick='EditarActividad("+data.norden+","+pos+")' > Editar</span> <span id=\"cargoID"+data.norden+"\">"+ cargo +"</span></td>";
        html+="</tr>";
    });
    $("#tb_produccion").html(html);
    initClockPicker();
    initDatePicker();
    $("#t_produccion").dataTable(
             {
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 100,
        }
    ); 
  };  

EditarActividad=function(id,pos){
        
//     var finicio = document.getElementById(id).getElementsByTagName('td')[2].innerHTML;
//     var ffin = document.getElementById(id).getElementsByTagName('td')[4].innerHTML;
     var finicio = $('#'+id).find("input:eq(0)").val();     
//     var ffin = $('#'+id).find("input:eq(2)").val();     
     hinicio=$('#'+id).find("input:eq(1)").val();     
     hfin=$('#'+id).find("input:eq(3)").val();
        ttranscurrido=$('#'+id).find("input:eq(4)").val();
     var dataG = [];
     dataG = {id:id,finicio:finicio,hinicio:hinicio,ffin:finicio,hfin:hfin,ttranscurrido:ttranscurrido};
     Asignar.EditarActividad(dataG,pos);  
    
};

CrearPDF=function(norden,pos){
    url = "documentodig/doccargo/"+norden;
    window.open(url,'_blank');
}

subirImgModal=function(norden){
    $("#norden_file").val(norden);
    $("#fileModal").modal("show");
}

verImagen=function(ruta){
    $("#imgSw").attr("src",ruta);
    $("#showModal").modal("show");
}


sendImage=function(){

    var file = document.getElementById("cargo_comprobante").files[0];
    var mnorden = document.getElementById("norden_file").value;

    var reader = new FileReader();
        
    reader.readAsDataURL(file);

    reader.onload = function () {
        $.post("asignacion/uploadcargo",{norden:mnorden, image:reader.result},function(result){
            console.log(result); 
            if(result.result == 1){

                $("#fileModal").modal("hide");
                $("#norden_file").val(0);
                $("#cargoID"+result.norden).hide("slow");
                $("#cargoID"+result.norden).html("<span class='btn btn-info btn-md' title=\"Ver nota de cargo\" onClick='verImagen(\""+result.ruta+"\")' > <i class=\"fa fa-image\"></i> </span>");
                $("#cargoID"+result.norden).show("slow");

            }
        });
    };

}


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

    if(typeof(fn)!='undefined' && fn.col==1){
        return '<span id="2616" onclick="CargarActividad('+row.id+',\''+row.actividad+'\')" class="btn btn-success"><i class="fa fa-lg fa-check"></i></span>';
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
//       console.log(tr);
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
//        console.log(files[0].name);
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

BuscarTramite=function(obj){
     diferenciador++;
     var div=obj.parentNode.parentNode;
     var divtramite=$(div).children('div')[0];
     var divtabla=$(div).children('div')[3];
     var tramite=$(divtramite).find('input:eq(0)').val();
     Asignar.CargarTramite({id_union:tramite},divtabla);
};

HTMLcargartramite=function(datos,divtabla){
    var html="";
    var alerta_tipo= '';
    var verbo='';
    var verbo_id='';
//    $('#t_produccion').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        verbos="";
        verbo=data.verbo.split(',');
        verbo_id=data.verbo_id.split(',');

        for(i=0;i<verbo.length;i++){
            verbos+='<tr><td><b>'+(i+1)+'- </b><input type="checkbox" value="'+verbo_id[i]+'">'+verbo[i]+'</td></tr>';
        }

        html+="<tr id="+data.norden+">"+
           "<td>"+$.trim(data.referido)+"</td>"+
            "<td>"+data.id_union+"</td>"+
            "<td>"+data.flujo+"</td>"+
            "<td>"+data.norden+"</td>"+
            '<td class="rutadetalleid"><input type="radio" name="ruta_detalle_id'+diferenciador+'" id="ruta_detalle_id" value="'+data.ruta_detalle_id+'"></td>'+
            "<td><table id='t_verbo'>"+verbos+"</table></td>";
        html+="</tr>";
    });
    $(divtabla).find("#tb_tramite").html(html);
    $(divtabla).find("#t_tramite").show();
//    $("#t_produccion").dataTable(
//             {
//            "order": [[ 0, "asc" ],[1, "asc"]],
//            "pageLength": 10,
//        }
//    ); 
  }; 
</script>
