<script type="text/javascript">
Meta_cuadro_id="";
$(document).ready(function() {

    var data = {estado:1};
    var ids = [];

    function DataToFilter(){
        var meta_id = $('#slct_meta').val();
        var data = [];
            if ($.trim(meta_id)!=='') {
                data.push({meta:meta_id});
            } else {
                alert("Seleccione Meta");
            }
        return data;
    }

     var datos = {estado: 1,cuadro:1};
     slctGlobal.listarSlct('meta','slct_meta', 'multiple', null, datos);

    $("#generar").click(function (){
        var data = DataToFilter();            
        if(data.length > 0){
            Accion.mostrar(data[0]);            
        }
    });
    $("#generar1").click(function (){
        var data = DataToFilter();            
        if(data.length > 0){
            Accion.mostrar(data[0]);            
        }
    });
    
    $(document).on('click', '#btnexport', function(event) {
        var data = DataToFilter();
        if(data.length > 0){
            var area = data[0]['area_id'].join('","');
            $(this).attr('href','reporte/exportreporteinventario'+'?area_id='+area);            
        }else{
            event.preventDefault();
        }
    });
    
      $('#validacumplimientometaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Documentos y Archivos');
//      modal.find('.modal-body .agregarfecha2').attr('onClick','AgregarFecha2('+MetacuadrosG.id+');');
      $('#form_metacuadros_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_metacuadros_modal input[type='hidden']").remove();
    });

    $('#validacumplimientometaModal').on('hide.bs.modal', function (event) {
       $('#form_metacuadros_modal input').val('');
        $('#form_metacuadros_modal select').val('');
        $('#form_metacuadros_modal #tb_fecha2').html('');
        $('#form_metacuadros_modal #tb_fecha1').html('');
    });
});

HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();
    cont = 0;
    $.each(datos,function(index,data){
        var style="";
        if(data.estado=='SI'){
            var style=';background-color:#7BF7AE';
        }
        else if(data.estado=='NO'){
            var style=';background-color:#FE4E4E';  
        }
        else if(data.estado=='A TIEMPO'){
            var style=';background-color:#ffff66'; 
        }
        else if(data.estado=='ALERTA'){
        var style=';background-color:#FFA027';
        }
        cont=cont+1;
        html+="<tr style='"+style+"'>"+
            "<td>"+ cont +"</td>"+
            "<td>"+data.meta+"</td>"+
            "<td>"+data.actividad+"</td>"+
            "<td>"+data.fecha+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.porcentaje+" %</td>"+
            "<td>"+data.des_por+" %</td>"+
            '<td><a class="btn btn-info" onClick="CargarSustento('+data.id+')" data-toggle="modal" data-target="#validacumplimientometaModal" data-titulo="Validar">Validar</a></td>';
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

CargarSustento=function(id){
     data={id:id};
     Meta_cuadro_id=id;
     Accion.MostrarSustento(data,HTMLsustento);       
};

HTMLsustento=function(documentos,archivos){
    var html="";
    var html1="";
    $('#t_documento').dataTable().fnDestroy();
    cont = 0;
    $.each(documentos,function(index,data){
        cont=cont+1;
        html+="<tr>"+
            "<td>"+ cont +"</td>"+
            "<td><a target='_blank' href='documentodig/vista/" + data.doc_digital_id + "/4/1'>" + data.titulo + "</a></td>";
        if(data.valida==1){
            html+='<td><select class="form-control" name="slct_documento" id="slct_documento" data-id="'+data.id+'">'+
                        "<option value='1' selected>,::SELECCIONE::.</option>"+
                        "<option value='2'>Válido</option>"+
                        "<option value='3'>Inválido</option>"+
                        "</select></td>";
        }                  
        else if(data.valida==2){
            html+="<td><span style='background-color:#7BF7AE;'>Válido</span></td>";
        }
        else if(data.valida==3){
            html+="<td><span style='background-color:#FE4E4E;'>Inválido</span></td>";
        }
        html+="</tr>";
    });
    $("#tb_documento").html(html);
    $("#t_documento").dataTable(
        {
            "order": [[ 0, "asc" ]],
        }
    ); 
    

    $('#t_archivo').dataTable().fnDestroy();
    cont = 0;
    $.each(archivos,function(index,data){
        cont=cont+1;
        html1+="<tr>"+
            "<td>"+ cont +"</td>"+
            "<td><a target='_blank' href='file/meta/" + data.ruta + "'>" +  data.ruta + "</a></td>";
        if(data.valida==1){
            html1+='<td><select class="form-control" name="slct_archivo" id="slct_archivo" data-id="'+data.id+'">'+
                        "<option value='1' selected>.::SELECCIONE::.</option>"+
                        "<option value='2'>Válido</option>"+
                        "<option value='3'>Inválido</option>"+
                        "</select></td>";
        }                  
        else if(data.valida==2){
            html1+="<td><span style='background-color:#7BF7AE;'>Válido</span></td>";
        }
        else if(data.valida==3){
            html1+="<td><span style='background-color:#FE4E4E;'>Inválido</span></td>";
        }
        html1+="</tr>";
    });
    $("#tb_archivo").html(html1);
    $("#t_archivo").dataTable(
        {
            "order": [[ 0, "asc" ]],
        }
    ); 

    $( "#form_validacumplimientometa_modal #slct_archivo" ).change(function() {
            var id= $(this).data('id'); //captura select y data-id
            var valida=$( "#form_validacumplimientometa_modal #slct_archivo" ).val();
            var data={id:id,valida:valida,t:'a'};
            Accion.ActualizarSustento(data,HTMLsustento);    
    });
    
    $( "#form_validacumplimientometa_modal #slct_documento" ).change(function() {
            var id= $(this).data('id'); //captura select y data-id
            var valida=$( "#form_validacumplimientometa_modal #slct_documento" ).val();
            var data={id:id,valida:valida,t:'d'};
            Accion.ActualizarSustento(data,HTMLsustento);    
    });
};
</script>
