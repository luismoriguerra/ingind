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
        
        CartaInicio.cargar(filtro, HTMLreportep);
    });
});
activarTabla=function(){
    var table = $("#t_reporte").dataTable( {
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false,
            "visible": false,
            "targets": -1
        
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
        //semaforo='#FF0000';//'Incumplimiento';//
        //semaforo='#FFC000';//'Existe retraso en el paso actual';//
        //semaforo='#92D050';//'No existe retraso en el paso actual';//
        
        html+="<tr>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.cantidad_pasos_proceso+"</td>"+
            "<td>"+data.dias_total+"</td>"+
            "<td>"+data.tramite+"</td>"+
            "<td>"+data.ultimo_paso+"</td>"+
            "<td>"+data.dias_ultimo_paso+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.fecha_fin+"</td>"+
            "<td style='background-color:#"+data.semaforo+"'>"+"</td>"+
            "<td>"+data.tarea+"</td>"+
            "<td>"+data.descripcion_tarea+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.responsable+"</td>"+
            "<td>"+data.recursos+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#areaModal" data-id="'+index+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    activarTabla();
};
</script>