<script type="text/javascript">
var filtro_fecha, filtro_averia, fecha_ini, fecha_fin, file;
$(document).ready(function() {

    //$("#slct_reporte").change(ValidaTipo);

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD'
    });

    slctGlobal.listarSlct('flujo','slct_flujos','simple');
    //Mostrar 
    $("#generar_movimientos").click(function (){
        flujo_id = $('#slct_flujos').val();
        reporte(flujo_id);
    });


});
reporte=function(flujo_id){
    Rutas.mostrar(flujo_id);
    
};
HTMLreporte=function(datos){
    var html="";
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td id='software_"+data.id+"'>"+data.software+"</td>"+
            "<td id='persona_"+data.id+"'>"+data.persona+"</td>"+
            "<td id='area_"+data.id+"'>"+data.area+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.fecha_inicio+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#usuarioModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    activarTabla();
    
};
activarTabla=function(){
    //$("#t_reporte").dataTable(); // inicializo el datatable
    $("#t_reporte").dataTable().rowGrouping();

};

</script>
