<script type="text/javascript">
temporalBandeja=0;
var areasG=[]; // texto area
var areasGId=[]; // id area
var theadArea=[]; // cabecera area
var tbodyArea=[]; // cuerpo area
var tfootArea=[]; // pie area

$(document).ready(function() {
    $("[data-toggle='offcanvas']").click();
    $("#btn_nuevo").click(Nuevo);
    $("#btn_close").click(Close);
    $("#btn_adicionar_ruta_detalle").click(adicionarRutaDetalle);
    Ruta.CargarRuta(HTMLCargarRuta);
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id_2','simple',ids,data);

    //$("#areasasignacion").DataTable();
});

adicionarRutaDetalle=function(){
    if( $.trim($("#slct_area_id_2").val())=='' ){
        alert('Seleccione un Area para adicionar');
    }
    else if( areasGId.length>0 && $("#slct_area_id_2").val()==areasGId[(areasGId.length-1)] ){
        alert('No se puede asignar 2 veces continuas la misma Area');
    }
    else if( $.trim($("#slct_area_id_2").val())!='' ){
        valorText=$("#slct_area_id_2 option[value='"+$("#slct_area_id_2").val()+"']").text();
        valor=$("#slct_area_id_2").val();

        areasG.push(valorText);
        areasGId.push(valor);

        head='<th class="eliminadetalleg" style="width:110px;min-width:100px !important;">'+valorText+'</th>';
        theadArea.push(head);

        body=   '<td class="eliminadetalleg">'+
                    '<table class="table table-bordered">'+
                        '<tr>'+
                            '<td class="area'+areasG.length+'" style="height:100px;">&nbsp;'+
                            '<span class="badge bg-yellow">'+areasG.length+'</span>'+
                            '</td>'+
                        '</tr>'+
                    '</table>'+
                '</td>';
        tbodyArea.push(body);

        foot=   '<th class="eliminadetalleg">'+
                    '<div>'+
                    '<a id="" class="btn bg-olive btn-sm">'+
                        '<i class="fa fa-clock-o fa-lg"></i>'+
                    '</a>'+
                    '<a id="" class="btn btn-info btn-sm">'+
                        '<i class="fa fa-list-ul fa-lg"></i>'+
                    '</a>'+
                    '</div>'+
                '</th>';
        tfootArea.push(foot);

        pintarAreasG();
    }
}

CambiarDetalle=function(t){
    var auxText=areasG[t];
    var aux=areasGId[t];
    var auxthead=theadArea[t];
    var auxtbody=tbodyArea[t].split("area"+t).join("area"+(t-1)).split(">"+t).join(">"+(t-1));
    var auxtfoot=tfootArea[t];


    areasG[t]=areasG[(t-1)];
    areasGId[t]=areasGId[(t-1)];
    theadArea[t]=theadArea[(t-1)];
    tbodyArea[t]=tbodyArea[(t-1)].split("area"+(t-1)).join("area"+t).split(">"+(t-1)).join(">"+t);
    tfootArea[t]=tfootArea[(t-1)];

    areasG[(t-1)]=auxText;
    areasGId[(t-1)]=aux;
    theadArea[(t-1)]=auxthead;
    tbodyArea[(t-1)]=auxtbody;
    tfootArea[(t-1)]=auxtfoot;

    pintarAreasG();
}

EliminarDetalle=function(t){
    $("#tr-detalle-"+t).remove();
    for( var i=t; i<areasG.length; i++){
        if( (i+1)==areasG.length ){
            areasG.pop();
            areasGId.pop();
            theadArea.pop();
            tbodyArea.pop();
            tfootArea.pop();
        }
        else{
            areasG.splice(i, 1, areasG[(i+1)]);
            areasGId.splice(i, 1, areasGId[(i+1)]);
            theadArea.splice(i, 1, theadArea[(i+1)]);
            tbodyArea.splice(i, 1, tbodyArea[(i+1)]).split("area"+(i+1)).join("area"+i).split(">"+(i+1)).join(">"+i);
            tfootArea.splice(i, 1, tfootArea[(i+1)]);
        }
    }
    
    pintarAreasG();
}

pintarAreasG=function(){
    var htm=''; var click=""; var imagen="";
    $("#areasasignacion .eliminadetalleg").remove();
    for ( var i=0; i<areasG.length; i++ ) {
        click="";
        imagen="";

        if ( i>0 ) {
            click=" onclick='CambiarDetalle("+i+");' ";
            imagen="<i class='fa fa-sort-up fa-sm'></i>";
        }

        htm+=   "<tr id='tr-detalle-"+i+"'>"+
                    "<td>"+
                        "<button class='btn bg-navy btn-sm' "+click+" type='button'>"+
                            (i+1)+"&nbsp;"+imagen+
                        "</button>&nbsp;&nbsp;"+
                        "<button class='btn btn-danger btn-sm' onclick='EliminarDetalle("+i+");' type='button'>"+
                            "<i class='fa fa-remove fa-sm'></i>"+
                        "</button>"+
                    "</td>"+
                    "<td>"+
                        areasG[i]+
                    "</td>"+
                "</tr>";

        $("#areasasignacion>thead>tr.head").append(theadArea[i]);
        $("#areasasignacion>tbody>tr.body").append(tbodyArea[i]);
        $("#areasasignacion>tfoot>tr.head").append(tfootArea[i]);
    };

    $("#areasasignacion>thead>tr.head").append('<th class="eliminadetalleg" style="min-width:1000px important!;">[]</th>'); // aqui para darle el area global

    $("#tb_rutaflujodetalleAreas").html(htm);
}

Nuevo=function(){
    $(".form-group").css("display","");
    $("#txt_titulo").val("Nueva Ruta");
    $("#slct_flujo,#slct_area").val("");
    $("#slct_flujo,#slct_area").multiselect('refresh');
    $("#txt_persona").val('<?php echo Auth::user()->paterno." ".Auth::user()->materno." ".Auth::user()->nombre;?>');
    $("#txt_ok,#txt_error").val("0");
    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
}

Actualiza=function(){
    $("#txt_titulo").val("Actualiza Ruta");
    $("#fecha_creacion").html('');
}

Close=function(){
    $(".form-group").css("display","none");
}

HTMLCargarRuta=function(datos){
    var html="";
    var cont=0;
     $('#t_rutaflujo').dataTable().fnDestroy();

    $.each(datos,function(index,data){
    cont++;
    html+="<tr>"+
        "<td>"+cont+"</td>"+
        "<td>"+data.flujo+"</td>"+
        "<td>"+data.area+"</td>"+
        "<td>"+data.persona+"</td>"+
        "<td>"+data.ok+"</td>"+
        "<td>"+data.error+"</td>"+
        "<td>"+data.dep+"</td>"+
        "<td>"+data.fruta+"</td>"+
        '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rutaflujoModal" data-id="'+data.id+'"><i class="fa fa-edit fa-lg"></i> </a>'+
            '<a class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

    });
    $("#tb_rutaflujo").html(html); 
    $("#t_rutaflujo").dataTable();
}
</script>
