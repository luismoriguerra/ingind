<script type="text/javascript">
var PosCarta=[];
PosCarta[0]=0;PosCarta[1]=0;PosCarta[2]=0;
var recursos=[]; var recursosid=[];
recursos.push("Ingrese Descripción");       recursosid.push("rec_des");
recursos.push("Ingrese Cantidad");          recursosid.push("rec_can");
recursos.push("Ingrese Total");             recursosid.push("rec_tot");
var metricos=[]; var metricosid=[];
metricos.push("Ingrese Métrico");           metricosid.push("met_met");
metricos.push("Ingrese Actual");            metricosid.push("met_act");
metricos.push("Ingrese Objetivo");          metricosid.push("met_obj");
metricos.push("Ingrese Comentario");        metricosid.push("met_com");
var desgloses=[]; var desglosesid=[];
desgloses.push("Ingrese Actividad");        desglosesid.push("des_act");
desgloses.push("Ingrese Responsable");      desglosesid.push("des_res");
desgloses.push("Ingrese Area");             desglosesid.push("des_are");
desgloses.push("Ingrese Recursos");         desglosesid.push("des_rec");
desgloses.push("Seleccione Fecha Inicio");  desglosesid.push("des_fin");
desgloses.push("Seleccione Fecha Fin");     desglosesid.push("des_ffi");
desgloses.push("Seleccione Hora Inicio");   desglosesid.push("des_hin");
desgloses.push("Seleccione Hora Fin");      desglosesid.push("des_hfi");

$(document).ready(function() {
    Carta.CargarCartas(HTMLCargarCartas);
    $("#btn_nuevo").click(Nuevo);
    $("#btn_close").click(Close);
    $("#btn_guardar").click(Guardar);
});

HTMLCargarDetalleCartas=function(datos){
    Nuevo();
    var html="";
    var rec=[];var met=[]; var des=[];

    $("#form_carta #txt_carta_id").remove();
    $.each(datos,function(index,data){
        $("#form_carta").append("<input type='hidden' name='txt_carta_id' id='txt_carta_id' value='"+data.id+"'>");
        $("#txt_nro_carta").val(data.nro_carta);
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
}

CargarRegistro=function(id){
    Limpiar();
    var datos={carta_id:id};
    Carta.CargarDetalleCartas(HTMLCargarDetalleCartas,datos);
}

Validacion=function(){
    var r=true;
    $("#cartainicio .form-control").each(function(){
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
    Close();
}

Guardar=function(){
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
    var clase="";

    var add="<tr id='tr_"+idf+"_"+PosCarta[pos]+"'>";
        add+="<td>";
        add+=$("#t_"+idf+" tbody tr").length+1;
        add+="</td>";
    for (var i = 0; i < ($("#t_"+idf+" thead tr th").length-2); i++) {

        clase='';
        if ( value!='0' ){
            val=value.split("|")[i].split("0000-00-00").join("").split("00:00:00").join("");
        }

        if ( idf=="recursos" ){
            datatext=recursos[i];
            dataid=recursosid[i];
        }
        else if ( idf=="metricos" ){
            datatext=metricos[i];
            dataid=metricosid[i];
        }
        else if ( idf=="desgloses" ){
            datatext=desgloses[i];
            dataid=desglosesid[i];

            if( i==5 || i==4 ){
                clase='fecha';
            }
        }

        add+="<td>";
        add+="<input class='form-control col-sm-12 "+clase+"' type='text' data-text='"+datatext+"' data-type='txt' id='txt_"+idf+"_"+PosCarta[pos]+"' name='txt_"+dataid+"[]' value='"+val+"'>";
        add+="</td>";
    };
        add+="<td>";
        add+="<a class='btn btn-sm btn-danger' id='btn_"+idf+"_"+PosCarta[pos]+"' onClick='RemoveTr(this.id);'><i class='fa fa-lg fa-minus'></i></a>";
        add+="</td>";
        add+="</tr>";
    $("#t_"+idf+" tbody").append(add);

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
            "<td> <a class='btn btn-primary btn-sm' onClick='CargarRegistro("+data.id+")'><i class='fa fa-edit fa-lg'></i></a></td>";
        html+="</tr>";
    });
    $("#tb_carta").html(html); 
    $('#t_carta').dataTable();
}
</script>
