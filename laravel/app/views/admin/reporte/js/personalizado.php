<script type="text/javascript">

$(document).ready(function() {

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
        showDropdowns: true
    });
    
    $("#generar").click(function (){
        var fecha=$("#fecha").val();
        if ( fecha!=="") {
            var dataG = {fecha:fecha};
            Auditoria.CuadroAuditoria(dataG);
        }else{
            alert("Seleccione Fecha");
        }
    });
   
    $("#btnexport").click(GeneraHref);

});

GeneraHref=function(){
        area_id = $('#slct_area_id').val();
        $('#area_id').val(area_id);
        var fecha=$("#fecha").val();
        if($.trim(area_id)!==''){
        $("#btnexport").removeAttr('href');
        if ( fecha!=="") {
            data = {fecha:fecha,area_id:$("#slct_area_id").val().join(',')};
            window.location='reporte/exportdiarioactividades?fecha='+data.fecha+'&area_id='+data.area_id;
        } else {
            alert("Seleccione Fecha");
        }}
        else {  alert("Seleccione Área"); }
}

HTMLAuditoriaAcceso=function(datos,cabecera){
  var html="";var html_cabecera="";
    var alerta_tipo= '';
    $('#t_auditoria').dataTable().fnDestroy();
    pos=0;
    html_cabecera+="<tr>"+
             "<th colspan='3'></th>";
    var n=0;
    $.each(cabecera,function(index,cabecera){

       html_cabecera+="<th colspan='2'>"+cabecera+"</th>";
       n++;
    });
    html_cabecera+="<th colspan='2'>TOTAL</th>";
    html_cabecera+="</tr>";
    
     html_cabecera+="<tr>"+
             "<th>N°</th>"+
             "<th>Area</th>"+
             "<th>Persona</th>";
    var n=0;
    $.each(cabecera,function(index,cabecera){

       html_cabecera+="<th >N° Ingreso</th>";
       html_cabecera+="<th >N° Consultas</th>";
       n++;
    });
    html_cabecera+="<th>N° Ingreso Total</th>"+
                    "<th>N° Consulta Total</th>";
    html_cabecera+="</tr>";
    
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+pos+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.persona+"</td>";
        var i;
        for(i=1;i<=n;i++){ 

        html+='<td style="cursor:pointer" onclick="Detalle(\''+data.persona_id+'\',\''+cabecera[i - 1]+'\',\''+cabecera[i - 1]+'\')">'+$.trim(data['ti'+i])+'</td>'+
              '<td style="cursor:pointer" onclick="Detalle(\''+data.persona_id+'\',\''+cabecera[i - 1]+'\',\''+cabecera[i - 1]+'\')">'+$.trim(data['tc'+i])+"</td>";
        }
        html+='<td style="cursor:pointer" onclick="Detalle(\''+data.persona_id+'\',\''+cabecera[0]+'\',\''+cabecera[n - 1]+'\')">'+data.ti+"</td>";
        html+='<td style="cursor:pointer" onclick="Detalle(\''+data.persona_id+'\',\''+cabecera[0]+'\',\''+cabecera[n - 1]+'\')">'+data.tc+"</td>";
        
    });

    html+="</tr>";
    $("#tb_auditoria").html(html);
    $("#tt_auditoria").html(html_cabecera);
    $("#t_auditoria").dataTable(
             {
            "order": [[ 0, "asc" ]],
            "pageLength": 50,
        }
    ); 

};




ActPest=function(nro){
    Pest=nro;
};


activarTabla=function(){
    $("#t_detalles").dataTable(); // inicializo el datatable    
};
eventoSlctGlobalSimple=function(slct,valores){
};

Detalle=function(persona_id,fi,ff){
        var dataG = {persona_id:persona_id,fi:fi,ff:ff};
        Auditoria.CuadroDetalleAuditoria(dataG);
        $('#auditoriaaccesoModal').modal('show');
};

HTMLAuditoriaAccesoDetalle=function(datos){
    var html ='';
    $('#form_auditoriaacceso #t_auditoriaacceso').dataTable().fnDestroy();
    pos=0;
    tti=0;
    ttc=0;
    $.each(datos,function(index,data){
        pos++;
        tti=tti+data.ti;
        ttc=ttc+data.tc;
        html+="<tr>"+
            "<td>"+pos+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.ti+"</td>"+
            "<td>"+data.tc+"</td>";
        html+="</tr>";
    });
    
        html+="<tr>"+
            "<td ></td>"+
            "<td >Total:</td>"+
            "<td>"+tti+"</td>"+
            "<td>"+ttc+"</td>";
        html+="</tr>";
        
    $("#form_auditoriaacceso #tb_auditoriaacceso").html(html);
    $("#form_auditoriaacceso #t_auditoriaacceso").dataTable(
                         {
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 10,
        }
    );


};

MostrarMensajes=function(){

 new Chart(document.getElementById("myChart"), {
  type: 'bar',
  data: {
    labels: [Estadistica.persona],
    datasets: [{ 
        data: [86,114,106,106,107,111,133],
        label: "# de Ejecución de Reportes",
        borderColor: "#3e95cd",
        fill: false
      }, { 
        data: [282,350,411,502,635,809,947,1402,3700,5267],
        label: "# de Accesos a los módulos",
        borderColor: "#8e5ea2",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'Análisis de Auditoría de Accesos'
    }
  }
});
};


</script>
