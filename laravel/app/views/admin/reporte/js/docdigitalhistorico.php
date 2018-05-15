<script type="text/javascript">
$(document).ready(function() {

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
         showDropdowns: true
    });
    var data = {estado:1};
    var ids = [];
    function DataToFilter(){
        var fecha = $('#fecha').val();
        var titulo = $('#txt_titulo').val();
        var data = [];
            if ($.trim(fecha)!=='') {
                data.push({fecha:fecha,titulo:titulo});
            } else {
                alert("Seleccione Rango de Fecha");
            }
        return data;
    }

//    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);

    $("#generar").click(function (){
        var data = DataToFilter();  
        if(data.length > 0){
            Accion.mostrar(data[0]);            
        }
    });

    $(document).on('click', '#btnexport', function(event) {
        var data = DataToFilter();
        if(data.length > 0){
            var fecha = data;
            $(this).attr('href','reporte/exporthistoricoinventario'+'?fecha='+data[0]['fecha']);            
        }else{
            event.preventDefault();
        }
    });
});

HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();
    cont = 0;
    $.each(datos,function(index,data){
        cont=cont+1;
        html+="<tr>"+
            "<td>"+ cont +"</td>"+
            "<td>"+data.titulo+"</td>"+
            '<td><a class="btn btn-default btn-sm" onclick="openPlantilla('+data.id+',4,0); return false;" data-titulo="Previsualizar"><i class="fa fa-eye fa-lg">&nbsp;A4</i> </a></td>'+
            "<td><button Onclick='MostrarHistorico("+data.id+")' class='btn btn-default btn-sm'>Ver Histórico</button></td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#t_reporte").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"]],
        }
    ); 
    $("#reporte").show();
};

eventoSlctGlobalSimple=function(slct,valores){
};

openPlantilla=function(id,tamano,tipo){
    window.open("documentodig/vista/"+id+"/"+tamano+"/"+tipo,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};

MostrarHistorico=function(id){
    var data={doc_digital_id:id};
    Accion.mostrarhistorico(data,HTMLmostrarhistorico);
};

HTMLmostrarhistorico=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_historico').dataTable().fnDestroy();
    cont = 0;
    $.each(datos,function(index,data){
        cont=cont+1;
        html+="<tr>"+
            "<td>"+ cont +"</td>"+
            "<td>"+data.titulo+"</td>"+
            '<td><a class="btn btn-default btn-sm" onclick="openPlantilla('+data.doc_digital_id+',4,0); return false;" data-titulo="Previsualizar"><i class="fa fa-eye fa-lg">&nbsp;A4</i> </a></td>';
        html+="</tr>";
    });
    $("#tb_historico").html(html);
    $("#t_historico").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"]],
        }
    ); 
     $("#historicoModal").modal("show");
};
</script>
