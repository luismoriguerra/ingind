<script type="text/javascript">

$(document).ready(function(){
    $('#txt_fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
        showDropdowns: true
    });
    $('#mostrar').click(function(event) {
        var filtro={};
        
        if ($('#slct_semaforo').val()!=='') 
            filtro.semaforo=$('#slct_semaforo').val();
        
        if ($('#txt_tramite').val()!=='') 
            filtro.tramite = $('#txt_tramite').val();
        
        if ($('#txt_fecha').val()!=='') 
            filtro.fecha = $('#txt_fecha').val();

        if ($('#slct_categoria').val()!=='') 
            filtro.categoria = $('#slct_categoria').val();

        if ($('#slct_area').val()!=='') 
            filtro.area = $('#slct_area').val();
        
        CartaInicio.cargar(filtro, HTMLreportep);
    });
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('categoria','slct_categoria','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area','simple',ids,data);
});
activarTabla=function(){
    var table = $("#t_reporte").dataTable( {
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "visible": false,
            "order": [[10, "asc" ],[9,"asc"]]
        
    } ); // inicializo el datatable
    $('#t_reporte tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
        }
        else {
            table.$('tr.active').removeClass('active');
            $(this).addClass('active');
        }
    } );
};
HTMLreportep=function(datos){
    var html="", semaforo="", estdo='', estado_carta_inicio='';
    $('#t_reporte').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        //semaforo='#507C33';//'Resuelto';//
        //semaforo='#FE0000';//'Incumplimiento';//
        //semaforo='#F8BB00';//'Existe retraso en el paso actual';//
        //semaforo='#89C34B';//'No existe retraso en el paso actual';//
        
        html+="<tr>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.pasos+"</td>"+
            "<td>"+data.tiempo+"</td>"+
            "<td>"+data.fi+"</td>"+
            "<td>"+data.ff+"</td>"+
            "<td>"+data.tramite+"</td>"+
            "<td>"+data.norden+"</td>"+
            "<td>"+data.tiempo_paso+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.fecha_fin+"</td>"+
            "<td style='background-color:#"+data.semaforo.split("_")[1]+"'><font color='#"+data.semaforo.split("_")[1]+"'>"+data.semaforo.split("_")[0]+"</font></td>"+
            "<td>"+data.tipo_tarea+"</td>"+
            "<td>"+data.descripcion+"</td>"+
            "<td>"+data.nemonico+"</td>"+
            "<td>"+data.responsable+"</td>"+
            "<td>"+data.recursos+"</td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    activarTabla();
};

eventoSlctGlobalSimple=function(){
}
</script>
