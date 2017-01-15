<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var DocumentosG={id:0,nombre:"",estado:1}; // Datos Globales
$(document).ready(function() {

    /*datatable ajax*/
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
   /* var idG={   proceso        :'onBlur|Proceso|#DCE6F1', //#DCE6F1
                area        :'onBlur|Area|#DCE6F1', //#DCE6F1
                cantidad        :'onBlur|Cantidad|#DCE6F1',
             };

    var resG=dataTableG.CargarCab(idG);*/
    /*cabeceraG=resG; */// registra la cabecera
/*    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'documentos','t_documentos');*/
    /*columnDefsG=resG[0];*/ // registra las columnas del datatable
   /* targetsG=resG[1];*/ // registra los contadores
    /*var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_documentos','fa-edit');*/
    /*columnDefsG=resG[0];*/ // registra la colunmna adiciona con boton
    /*targetsG=resG[1];*/ // registra el contador actualizado
/*    MostrarAjax('documentos');*/
    /*end datatable ajax*/









    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];

    function DataToFilter(){
        area_id = $('#slct_area_id').val();
        var fecha=$("#fecha").val();
        var element = {}
        var data = [];
        if ( fecha!=="") {
            element.fecha = fecha;
        }

        if ($.trim(area_id)!=='') {
            element.area_id = area_id.join(",");
        }

        data.push(element);
        return data;
    }

    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);
    $("#generar").click(function (){
        var data = DataToFilter();           
        if(data.length > 0){
            Accion.mostrar(data[0]);            
        }
    });

    $(document).on('click', '#btnexport', function(event) {
        var data = DataToFilter();
        if(data.length > 0){
            var info = '';
            if(data[0]['fecha']){
                info+= 'fecha='+data[0]['fecha'];
            }
            if(data[0]['area_id']){
                info+= (info) ? '&area_id='+data[0]['area_id'] : 'area_id='+data[0]['area_id'];
            }

            $(this).attr('href','flujo/exportproduccionxproceso?'+info);            
        }else{
             $(this).attr('href','flujo/exportproduccionxproceso');
        }
    });


    Accion.mostrar('');
});

/*MostrarAjax=function(t){
    if( t=="documentos"){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'flujo','produccionxproceso',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}*/





HTMLreporte=function(datos){
    console.log(datos);
    var html="";
    
    var alerta_tipo= '';
    $('#t_documentos').dataTable().fnDestroy();
    cont = 0;
    $.each(datos,function(index,data){
        cont=cont+1;
        html+="<tr>"+
            "<td>"+ cont +"</td>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.cantidad+"</td>";
        html+="</tr>";
    });
    $("#t_documentos tbody").html(html);
    $("#t_documentos").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"]],
        }
    ); 
    $("#t_documentos").show();
};

eventoSlctGlobalSimple=function(slct,valores){
};
</script>
