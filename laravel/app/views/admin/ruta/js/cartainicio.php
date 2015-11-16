<script type="text/javascript">
var PosCarta=[];
PosCarta[0]=0;PosCarta[1]=0;PosCarta[2]=0;
var recursos=[];
recursos.push("Ingrese Descripción");
recursos.push("Ingrese Cantidad");
recursos.push("Ingrese Total");
var metricos=[];
metricos.push("Ingrese Métrico");
metricos.push("Ingrese Actual");
metricos.push("Ingrese Objetivo");
var desgloses=[];
desgloses.push("Ingrese Actividad");
desgloses.push("Ingrese Responsable");
desgloses.push("Ingrese Area");
desgloses.push("Ingrese Recursos");
desgloses.push("Seleccione Fecha Inicio");
desgloses.push("Seleccione Fecha Fin");
desgloses.push("Seleccione Hora Inicio");
desgloses.push("Seleccione Hora Fin");
$(document).ready(function() {
    Carta.CargarCartas(HTMLCargarCartas);
    $("#btn_nuevo").click(Nuevo);
    $("#btn_close").click(Close);
    $("#btn_guardar").click(Guardar);

    /*
    $("#btn_guardar_tiempo,#btn_guardar_verbo").remove();
    var data = {estado:1,tipo_flujo:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    data = {estado:1};
    slctGlobal.listarSlct('area','slct_area2_id,#slct_area_id,#slct_area_p_id','simple',ids,data);
    */
});

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
    Carta.CargarCartas(HTMLCargarCartas);
    Close();
    alert("Proceso aun en validación");
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
    var datatext="";

    var add="<tr id='tr_"+idf+"_"+PosCarta[pos]+"'>";
        add+="<td>";
        add+=$("#t_"+idf+" tbody tr").length+1;
        add+="</td>";
    for (var i = 0; i < ($("#t_"+idf+" thead tr th").length-2); i++) {
        if ( idf=="recursos" ){
            datatext=recursos[i];
        }
        else if ( idf=="metricos" ){
            datatext=metricos[i];
        }
        else if ( idf=="desgloses" ){
            datatext=desgloses[i];
        }
        add+="<td>";
        add+="<input class='form-control col-sm-12' type='text' data-text='"+datatext+"' data-type='txt' id='txt_"+idf+"_"+PosCarta[pos]+"' name='txt_"+idf+"[]'>";
        add+="</td>";
    };
        add+="<td>";
        add+="<a class='btn btn-sm btn-danger' id='btn_"+idf+"_"+PosCarta[pos]+"' onClick='RemoveTr(this.id);'><i class='fa fa-lg fa-minus'></i></a>";
        add+="</td>";
        add+="</tr>";
    $("#t_"+idf+" tbody").append(add);
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
            "<td >"+data.entregable+"</td>";
        html+="</tr>";
    });
    $("#tb_carta").html(html); 
    $('#t_carta').dataTable();
}
</script>
