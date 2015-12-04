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

$(document).ready(function() {
    Carta.CargarCartas(HTMLCargarCartas);
    $("#btn_nuevo").click(Nuevo);
    $("#btn_close").click(Close);
    $("#btn_guardar").click(Guardar);

    var ids=[];
    var data={estado:1};
    slctGlobal.listarSlct('tiporecurso','slct_tipo_recurso_id','simple',ids,data);
    slctGlobal.listarSlct('tipoactividad','slct_tipo_actividad_id','simple',ids,data);
    data={estado_persona:1};
    slctGlobal.listarSlct('persona','slct_persona_id','simple',ids,data);
});

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
    Carta.CargarCartas(HTMLCargarCartas);
    Close();
}

Guardar=function(){
    var datos=$("#form_carta").serialize().split("txt_").join("").split("slct_").join("");
    if( Validacion() ){
        Carta.GuardarCartas(Limpiar,datos);
    }
}

AddTr=function(id){
    var idf=id.split("_")[1];
    var pos=id.split("_")[2];
    PosCarta[pos]++;
    var datatext=""; var dataid="";
    var clase="";
    var ctype=""; var ccopy=""; var vcopy=[];

    var add="<tr id='tr_"+idf+"_"+PosCarta[pos]+"'>";
        add+="<td>";
        add+=$("#t_"+idf+" tbody tr").length+1;
        add+="</td>";
    for (var i = 0; i < ($("#t_"+idf+" thead tr th").length-2); i++) {
        
        clase='';
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

            if( i==5 || i==4 ){ //para cargar la fecha
                clase='fecha';
            }
        }

        if( ctype=="slct" ){
            add+="<td>";
            add+="<select class='form-control col-sm-12' data-text='"+datatext+"' data-type='slct' id='slct_"+idf+"_"+PosCarta[pos]+"_"+dataid+"' name='slct_"+dataid+"[]'>";
            add+="</select>";
            add+="</td>";

            vcopy.push("slct_"+idf+"_"+PosCarta[pos]+"_"+dataid+"|"+ccopy);
        }
        else{
            add+="<td>";
            add+="<input class='form-control col-sm-12 "+clase+"' type='text' data-text='"+datatext+"' data-type='txt' id='txt_"+idf+"_"+PosCarta[pos]+"_"+dataid+"' name='txt_"+dataid+"[]' >";
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
    var datos={area_id:$("#txt_area_id").val()};
    Carta.CargarCorrelativo(HTMLCargarCorrelativo,datos);
}

HTMLCargarCorrelativo=function(obj){
    $("#txt_nro_carta").val("");
    var ano= obj.ano;
    var correlativo=obj.correlativo;
    var area = obj.area.split(" ");
    var siglas='';
    for( i=0; i<area.length; i++ ){
        siglas+=area[i].substr(0,1);
    }

    var codigo= "CI-"+correlativo+"-"+ano+"-"+siglas;
    $("#txt_nro_carta").val(codigo);
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
            "<td >"+data.entregable+"</td>";
        html+="</tr>";
    });
    $("#tb_carta").html(html); 
    $('#t_carta').dataTable();
}
</script>
