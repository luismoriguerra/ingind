<script type="text/javascript">
var PosCarta=[];
PosCarta[0]=0;PosCarta[1]=0;PosCarta[2]=0;
var recursos=[]; var recursosid=[]; var recursostype=[]; var recursoscopy=[];
recursos.push("Seleccione Tipo Recurso");   recursosid.push("rec_tre");     recursostype.push("slct");      recursoscopy.push("slct_tipo_recurso_id");
recursos.push("Ingrese Descripcion");       recursosid.push("rec_des");     recursostype.push("txt");
recursos.push("Ingrese Cantidad");          recursosid.push("rec_can");     recursostype.push("txt");
var metricos=[]; var metricosid=[]; var metricostype=[]; var metricoscopy=[];
metricos.push("Ingrese Métrico");           metricosid.push("met_met");     metricostype.push("txt");
metricos.push("Ingrese Actual");            metricosid.push("met_act");     metricostype.push("txt");
metricos.push("Ingrese Objetivo");          metricosid.push("met_obj");     metricostype.push("txt");
metricos.push("Ingrese Comentario");        metricosid.push("met_com");     metricostype.push("txt");
var desgloses=[]; var desglosesid=[]; var desglosestype=[]; var desglosescopy=[];
desgloses.push("Seleccione Tipo Actividad");desglosesid.push("des_tac");    desglosestype.push("slct");     desglosescopy.push("slct_tipo_actividad_id");
desgloses.push("Ingrese Actividad");        desglosesid.push("des_act");    desglosestype.push("txt");      desglosescopy.push("");
desgloses.push("Seleccione Responsable");   desglosesid.push("des_res");    desglosestype.push("slct");     desglosescopy.push("slct_persona_id");
desgloses.push("Ingrese Recursos");         desglosesid.push("des_rec");    desglosestype.push("txt");
desgloses.push("Seleccione Fecha Inicio");  desglosesid.push("des_fin");    desglosestype.push("txt");
desgloses.push("Seleccione Fecha Fin");     desglosesid.push("des_ffi");    desglosestype.push("txt");
desgloses.push("Seleccione Hora Inicio");   desglosesid.push("des_hin");    desglosestype.push("txt");
desgloses.push("Seleccione Hora Fin");      desglosesid.push("des_hfi");    desglosestype.push("txt");
var AreaIdG='';
var tiemposG=[];

$(document).ready(function() {
    AreaIdG='';
    AreaIdG='<?php echo Auth::user()->area_id; ?>';
    ValidaAreaRol();

    /*init daterangepicker*/
    $('#txt_fecha_inicio').daterangepicker({
        format: 'YYYY-MM-DD HH:mm',
        singleDatePicker: true,
        timePicker: true,
        showDropdowns: true
    });
    /*end daterangepicker*/
});

ValidaAreaRol=function(){
    if(AreaIdG!='' && AreaIdG*1>0){
        var datos={union:1,area_id:AreaIdG};
        Carta.CargarCartas(HTMLCargarCartas,datos);
        $("#btn_nuevo").click(Nuevo);
        $("#btn_close").click(Close);
        $("#btn_guardar").click(Guardar);

        var ids=[];
        var data={estado:1};
        slctGlobal.listarSlct('tiporecurso','slct_tipo_recurso_id','simple',ids,data);
        slctGlobal.listarSlct('tipoactividad','slct_tipo_actividad_id','simple',ids,data);
        data={estado_persona:1};
        slctGlobal.listarSlct('persona','slct_persona_id','simple',ids,data);
    }
    else{
        alert('.::No cuenta con area asignada; Bloqueando accesos::.');
    }
}

HTMLCargarCorrelativo=function(obj){
    $("#txt_nro_carta").val("");
    var ano= obj.ano;
    var correlativo=obj.correlativo;
    var area = obj.area.split(" ");
    var siglas=obj.siglas;

    var codigo= "CI-"+correlativo+"-"+ano+"-"+siglas;
    $("#txt_nro_carta").val(codigo);
}

HTMLCargarDetalleCartas=function(datos,tipo = 0){
    Nuevo();
    var html="";
    var rec=[];var met=[]; var des=[];

    /*determinate if its copy or edit*/
    if(tipo == 1){
        var area={area_id:AreaIdG};
        Carta.CargarCorrelativo(HTMLCargarCorrelativo,area);
    }
    /*end determinate if its copy or edit*/

    $("#form_carta #txt_carta_id").remove();
    $.each(datos,function(index,data){

        /*poblate to determinate new dates*/
         tiemposG.push(data.tiempo+'|'+data.responsable_area.split("-")[1]);
        /*end poblate to determinate new dates*/
        
        if(tipo != 1){$("#form_carta").append("<input type='hidden' name='txt_carta_id' id='txt_carta_id' value='"+data.id+"'>")};
        if(tipo != 1){$("#txt_nro_carta").val(data.nro_carta)};
        $("#txt_objetivo").val(data.objetivo);
        $("#txt_entregable").val(data.entregable);
        $("#txt_alcance").val(data.alcance);

        if( data.recursos!=null && data.recursos.split("|").length>1 ){
            rec=data.recursos.split("*");
            for( i=0; i<rec.length; i++ ){
                AddTr("btn_recursos_0",rec[i]);
            }
        }

        if( data.metricos!=null && data.metricos.split("|").length>1 ){
            met=data.metricos.split("*");
            for( i=0; i<met.length; i++ ){
                AddTr("btn_metricos_1",met[i]);
            }
        }

        if( data.desgloses!=null && data.desgloses.split("|").length>1 ){
            des=data.desgloses.split("*");
            for( i=0; i<des.length; i++ ){
                AddTr("btn_desgloses_2",des[i]);
            }
        }

    });
    $("#form_carta #txt_flujo").val(datos[0].flujo);
    $("#form_carta #txt_flujo_id").val(datos[0].flujo_id);
}

CargarRegistro=function(id){
    Limpiar();
    var datos={carta_id:id};
    Carta.CargarDetalleCartas(HTMLCargarDetalleCartas,datos);
}

CopyCarta = function (id){
    Limpiar();
    var datos={carta_id:id};
    Carta.CargarDetalleCartas(HTMLCargarDetalleCartas,datos,1);   
}

Validacion=function(){
    var r=true;
    $("#cartainicio .form-control.col-sm-12").each(function(){
        if( $(this).val()=='' && r==true ){
            alert( $(this).attr("data-text") );
            $(this).focus();
            r=false;
        }
    });
    return r;
}

Limpiar=function(){
    $("#form_carta input[type='text'],#form_carta textarea,#form_carta select").val("");
    $("#t_recursos tbody,#t_metricos tbody,#t_desgloses tbody").html("");
    var data={union:1,area_id:AreaIdG};
    Carta.CargarCartas(HTMLCargarCartas,data);
    Close();
}

Guardar=function(){
    $("#txt_area_id").remove();
    $("#form_carta").append("<input type='hidden' id='txt_area_id' name='txt_area_id' value='"+AreaIdG+"'>");
    var datos=$("#form_carta").serialize().split("txt_").join("").split("slct_").join("");
    if( Validacion() ){
        Carta.GuardarCartas(Limpiar,datos);
    }
}

AddTr=function(id,value){
    var idf=id.split("_")[1];
    var pos=id.split("_")[2];
    PosCarta[pos]++;
    var datatext=""; var dataid=""; var val="";
    var clase="";var readonly="";
    var ctype=""; var ccopy=""; var vcopy=[];

    var add="<tr id='tr_"+idf+"_"+PosCarta[pos]+"'>";
        add+="<td>";
        add+=$("#t_"+idf+" tbody tr").length+1;
        add+="</td>";
    for (var i = 0; i < ($("#t_"+idf+" thead tr th").length-2); i++) {

        clase='';
        val='';
        //console.log(i);
        if ( value!='0' ){
            val=value.split("|")[i].split("0000-00-00").join("").split("00:00:00").join("");
        }

        if ( idf=="recursos" ){
            datatext=recursos[i];
            dataid=recursosid[i];
            ctype=recursostype[i];
            ccopy="";
            if( typeof recursoscopy[i] != 'undefined' ){
                ccopy = recursoscopy[i];
            }
        }
        else if ( idf=="metricos" ){
            datatext=metricos[i];
            dataid=metricosid[i];
            ctype=metricostype[i];
            ccopy="";
            if( typeof metricoscopy[i] != 'undefined' ){
                ccopy = metricoscopy[i];
            }
        }
        else if ( idf=="desgloses" ){
            datatext=desgloses[i];
            dataid=desglosesid[i];
            ctype=desglosestype[i];
            ccopy="";
            if( typeof desglosescopy[i] != 'undefined' ){
                ccopy = desglosescopy[i];
            }

           /* if( i==5 || i==4 ){ //para cargar la fecha
                clase='fecha';
            }*/
            if( i==5 || i==4 || i==8 ){ //para cargar la fecha
                if( typeof automatico =='undefined' || i==8 ){
                clase='fecha';
                }
                readonly='readonly';
            }
            else if( i==6 ){
                val='08:00';
            }
            else if( i==7 ){
                val='17:30';
            }
        }

        if( ctype=="slct" ){
            add+="<td>";
            add+="<select class='form-control col-sm-12' data-text='"+datatext+"' data-type='slct' id='slct_"+idf+"_"+PosCarta[pos]+"_"+dataid+"' name='slct_"+dataid+"[]'>";
            add+="</select>";
            add+="</td>";
            //alert("slct_"+idf+"_"+PosCarta[pos]+"_"+dataid+"|"+ccopy+"|"+val);
            vcopy.push("slct_"+idf+"_"+PosCarta[pos]+"_"+dataid+"|"+ccopy+"|"+val);
        }
        else{
            add+="<td>";
            add+="<input class='form-control col-sm-12 "+clase+"' type='text' data-text='"+datatext+"' data-type='txt' id='txt_"+idf+"_"+PosCarta[pos]+"_"+dataid+"' name='txt_"+dataid+"[]' value='"+val+"' "+readonly+">";
            add+="</td>";
        }

    };
        add+="<td>";
        add+="<a class='btn btn-sm btn-danger' id='btn_"+idf+"_"+PosCarta[pos]+"' onClick='RemoveTr(this.id);'><i class='fa fa-lg fa-minus'></i></a>";
        add+="</td>";
        add+="</tr>";
    $("#t_"+idf+" tbody").append(add);

    for (var i = 0; i < vcopy.length; i++) {
        $("#"+vcopy[i].split("|")[0]).html( $("#"+vcopy[i].split("|")[1]).html() );
        $("#"+vcopy[i].split("|")[0]).val( vcopy[i].split("|")[2] );

        slctGlobalHtml(vcopy[i].split("|")[0],'simple');
        $(".multiselect").css("font-size","11px").css("text-transform","lowercase");
        $(".multiselect-container>li").css("font-size","12px").css("text-transform","lowercase");
    };

    $('.fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: true,
        showDropdowns: true
    });
}

RemoveTr=function(id){
    var idf=id.split("_")[1];
    var pos=id.split("_")[2];
    var i=0;

    $("#tr_"+idf+"_"+pos).remove();

    $("#t_"+idf+" tbody tr").each(function(){
        i++;
        $(this).find("td:eq(0)").html(i);
    });
}

Nuevo=function(){
    $("#cartainicio").css("display","");
    $("#txt_nro_carta").focus();
}

Close=function(){
    $("#cartainicio").css("display","none");
}

HTMLCargarCartas=function(datos){
    var html="";
    $('#t_carta').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        html+="<tr>"+
            "<td >"+data.nro_carta+"</td>"+
            "<td >"+data.objetivo+"</td>"+
            "<td >"+data.entregable+"</td>"+
            "<td> " +
                "<a class='btn btn-primary btn-sm' onClick='CargarRegistro("+data.id+")'><i class='fa fa-edit fa-lg'></i></a>" +
                "    <a class='btn btn-primary btn-sm' href='carta/cartainiciopdf?vista=1&carta_id="+data.id+"' >PDF</i></a>" +
                "<a class='btn btn-primary btn-sm' onClick='CopyCarta("+data.id+")'><i class='fa fa-copy fa-lg'></i></a>" +
                "</td>";
        html+="</tr>";
    });
    $("#tb_carta").html(html); 
    $('#t_carta').dataTable();
}


/*load acoording to start date*/
CargarFechas=function(){
    var fechaIni=$("#txt_fecha_inicio").val();
    Carta.CargarFechas(CargarFechasHTML,tiemposG,fechaIni);
}

CargarFechasHTML=function(datos){
    var p=0;
    $( "#t_desgloses>tbody>tr" ).each(function(k,v) {
        if( datos.length>p ){
          $( this ).find("input[name='txt_des_fin[]']").val(datos[p][0]);
          $( this ).find("input[name='txt_des_ffi[]']").val(datos[p][1]);
          $( this ).find("input[name='txt_des_ale[]']").val(datos[p][2]);
          p++;
        }else{
          $( this ).find("input[name='txt_des_fin[]']").val(datos[(p-1)][1]);
          $( this ).find("input[name='txt_des_ffi[]']").val(datos[(p-1)][1]);
          $( this ).find("input[name='txt_des_ale[]']").val(datos[(p-1)][2]);
        }
    });
}
/*end load acoording to start date*/

</script>
