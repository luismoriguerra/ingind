<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var ContratacionG={id:0,titulo:"",monto_total:"",objeto:"",justificacion:"",actividades:"",fecha_conformidad:"",fecha_inicio:"",fecha_fin:"",fecha_aviso:"",programacion_aviso:"",nro_doc:"",estado:1,area:""}; // Datos Globales
var ContratacionDetalleG={id:0,texto:"",fecha_inicio:"",fecha_fin:"",fecha_aviso:"",fecha_conformidad:"",monto:"",tipo:"",programacion_aviso:"",nro_doc:""}; // Datos Globales
 // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
   $("[data-toggle='offcanvas']").click();
    var datos={estado:1};
    slctGlobal.listarSlct('area','slct_area','simple',null,datos);
    slctGlobalHtml('slct_estado','simple');
    slctGlobalHtml('slct_tipo','simple');
    var idG={   titulo        :'onBlur|Titulo Contratación|#DCE6F1', //#DCE6F1
                monto_total        :'onBlur|Monto Contratación|#DCE6F1', //#DCE6F1
                objeto        :'onBlur|Objeto Contratación|#DCE6F1', //#DCE6F1
                justificacion        :'onBlur|Justificación Contratación|#DCE6F1', //#DCE6F1
                actividades        :'onBlur|Actividades Contratación|#DCE6F1', //#DCE6F1
                fecha_inicio        :'onBlur|Fecha Inicio|#DCE6F1', //#DCE6F1
                fecha_fin        :'onBlur|Fecha Fin|#DCE6F1', //#DCE6F1
                fecha_aviso        :'onBlur|Fecha Aviso|#DCE6F1', //#DCE6F1
                programacion_aviso        :'onBlur|Programación Aviso|#DCE6F1', //#DCE6F1
                area          :'3|Área |#DCE6F1',
                fecha_conformidad        :'onBlur|Fecha Conformidad|#DCE6F1', //#DCE6F1
                nro_doc       :'3|Número de Documento|#DCE6F1', //#DCE6F1  
                estado        :'1|Estado|#DCE6F1', //#DCE6F1
                Grupo          :'1|  |#DCE6F1',
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'contrataciones','t_contrataciones');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
//    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_contrataciones','fa-edit');
//    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
//    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('contrataciones');
     $('.fecha').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });

    $('#contratacionModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Contratación');
      $('#form_contrataciones_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_contrataciones_modal input[type='hidden']").remove();
        if(titulo=='Nueva'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_contrataciones_modal #slct_estado').val(1);
            $('#form_contrataciones_modal #txt_titulo').focus();
            
        } else {
             modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_contrataciones_modal #txt_titulo').val( ContratacionG.titulo );
            $('#form_contrataciones_modal #txt_monto_total').val( ContratacionG.monto_total );
            $('#form_contrataciones_modal #txt_objeto').val( ContratacionG.objeto );
            $('#form_contrataciones_modal #txt_justificacion').val( ContratacionG.justificacion );
            $('#form_contrataciones_modal #txt_actividades').val( ContratacionG.actividades );
            $('#form_contrataciones_modal #fecha_conformidad').val( ContratacionG.fecha_conformidad );
            $('#form_contrataciones_modal #fecha_inicio').val( ContratacionG.fecha_inicio );
            $('#form_contrataciones_modal #fecha_fin').val( ContratacionG.fecha_fin );
            $('#form_contrataciones_modal #fecha_aviso').val( ContratacionG.fecha_aviso );
            $('#form_contrataciones_modal #txt_programacion_aviso').val( ContratacionG.programacion_aviso );
            $('#form_contrataciones_modal #txt_nro_doc').val( ContratacionG.nro_doc );
            $('#form_contrataciones_modal #slct_estado').val( ContratacionG.estado );
            $("#form_contrataciones_modal").append("<input type='hidden' value='"+ContratacionG.id+"' name='id'>");
            $('#form_contrataciones_modal #slct_area').val( ContratacionG.area );
            //slctGlobal.listarSlctFijo('area','slct_area',ContratacionG.area);
        }
             $('#form_contrataciones_modal select').multiselect('rebuild');
    });

    $('#contratacionModal').on('hide.bs.modal', function (event) {
       $('#form_contrataciones_modal input').val('');
       $('#form_contrataciones_modal textarea').val('');
       $('#form_contrataciones_modal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
     $('#contrataciondetalleModal').on('show.bs.modal', function (event) { 
        
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Detalle de Contratación');
      $('#form_detalle_contrataciones_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_detalle_contrataciones_modal input[type='hidden']").remove();
 
        if(titulo=='Nuevo'){
            //$("#form_detalle_contrataciones_modal").append("<input type='hidden' value='263' name='txt_contratacion_id'>");
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarDetalle();');
            $('#form_detalle_contrataciones_modal #slct_estado').val(1);
            $('#form_detalle_contrataciones_modal #txt_texto').focus();
           
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarDetalle();');

            $('#form_detalle_contrataciones_modal #txt_texto').val( ContratacionDetalleG.texto );
            $('#form_detalle_contrataciones_modal #txt_monto').val( ContratacionDetalleG.monto );
            $('#form_detalle_contrataciones_modal #fecha_conformidad').val( ContratacionDetalleG.fecha_conformidad );
            $('#form_detalle_contrataciones_modal #fecha_inicio').val( ContratacionDetalleG.fecha_inicio );
            $('#form_detalle_contrataciones_modal #fecha_fin').val( ContratacionDetalleG.fecha_fin );
            $('#form_detalle_contrataciones_modal #fecha_aviso').val( ContratacionDetalleG.fecha_aviso );
            $('#form_detalle_contrataciones_modal #txt_programacion_aviso').val( ContratacionDetalleG.programacion_aviso );
            $('#form_detalle_contrataciones_modal #txt_nro_doc').val( ContratacionDetalleG.nro_doc );
            $('#form_detalle_contrataciones_modal #slct_tipo').val( ContratacionDetalleG.tipo );
            $("#form_detalle_contrataciones_modal").append("<input type='hidden' value='"+ContratacionDetalleG.id+"' name='id'>");
            
          
        }
             $('#form_detalle_contrataciones_modal select').multiselect('rebuild');
    });
    
    $('#contrataciondetalleModal').on('hide.bs.modal', function (event) {
       $('#contrataciondetalleModal :visible').val('');
       $('#contrataciondetalleModal textarea').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    ContratacionG.id=id;
    ContratacionG.titulo=$(tr).find("td:eq(0)").text();
    ContratacionG.monto_total=$(tr).find("td:eq(1)").text();
    ContratacionG.objeto=$(tr).find("td:eq(2)").text();
    ContratacionG.justificacion=$(tr).find("td:eq(3)").text();
    ContratacionG.actividades=$(tr).find("td:eq(4)").text();
    ContratacionG.fecha_inicio=$(tr).find("td:eq(5)").text();
    ContratacionG.fecha_fin=$(tr).find("td:eq(6)").text();
    ContratacionG.fecha_aviso=$(tr).find("td:eq(7)").text();
    ContratacionG.programacion_aviso=$(tr).find("td:eq(8)").text();
    ContratacionG.area=$(tr).find("td:eq(9) input[name='txt_area']").val();
    ContratacionG.fecha_conformidad=$(tr).find("td:eq(10)").text();
    ContratacionG.nro_doc=$(tr).find("td:eq(11)").text();
    ContratacionG.estado=$(tr).find("td:eq(12)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="contrataciones" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'contratacion','cargar',columnDefsG);
            $("#form_detalle_contrataciones .form-group").css("display","none");
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
      if(typeof(fn)!='undefined' && fn.col==9){
        return row.area+"<input type='hidden'name='txt_area' value='"+row.area_id+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==13){
        var grupo='';
        if(row.fecha_conformidad===null || row.nro_doc===''){
        grupo+= '<a class="form-control btn btn-primary" onclick="BtnEditar(this,'+row.id+')"><i class="fa fa-lg fa-edit"></i></a><br>';
        }
        grupo+= '<span id="'+row.id+'" onClick="CargarDetalleContratacion(\''+row.id+'\',\''+row.titulo+'\')" data-estado="'+row.estado+'" class="btn btn-info"><i class="glyphicon glyphicon-eye-open"></i></span>';
        return grupo;
   }
    if(typeof(fn)!='undefined' && fn.col==11){
        var nro_doc='';
         nro_doc+=row.nro_doc;
        return nro_doc;     
    }
    if(typeof(fn)!='undefined' && fn.col==12){
        var estadohtml='<div style="color:blue"><b>Activo</b></div>';
        return estadohtml;
    }
};

activarTabla=function(){
    $("#t_contrataciones").dataTable(); // inicializo el datatable    
};

//activar = function(id){
//    var c=confirm("¡Está seguro de Inactivar la Contratación. No se mostrará?")
//    if(c){
//        Contrataciones.CambiarEstadoContrataciones(id, 1);
//    }
//    
//};
desactivar = function(id){
    var c=confirm("¿Está seguro de Eliminar la Contratación? No se mostrará");
    if(c){
      Contrataciones.CambiarEstadoContrataciones(id, 0);
      $("#form_detalle_contrataciones .form-group").css("display","none");
    }
};
Editar = function(){
     if(validaContrataciones()){
        Contrataciones.AgregarEditarContratacion(1);
        $("#form_detalle_contrataciones .form-group").css("display","none");
     }
};
Agregar = function(){
    if(validaContrataciones()){
       Contrataciones.AgregarEditarContratacion(0);
       $("#form_detalle_contrataciones .form-group").css("display","none");
    }
};

validaContrataciones = function(){
    var r=true;
    var c=confirm("¿Confirma los datos registrados?");
    if(c){
        if( $("#form_contrataciones_modal #txt_nro_doc").val()=='' ){
            alert("Ingrese Número de Documento");
            r=false;
        }
    }
    else {
        r=false;
    }
    return r;
};

CargarDetalleContratacion=function(id,titulo){
    $("#form_detalle_contrataciones_modal #txt_contratacion_id").val(id);
//    $("#txt_ruta_flujo_id_modal").remove();
//    $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+ruta_flujo_id+'">');
    $("#form_detalle_contrataciones #txt_titulo").text(titulo);
//    $("#texto_fecha_creacion").text("Fecha Vista:");

    $("#form_detalle_contrataciones .form-group").css("display","");
    data={id:id};
    Contrataciones.CargarDetalleContrataciones(data);
};

mostrarHTML=function(datos){
  var html="";
    var alerta_tipo= '';
    $('#t_detalle_contrataciones').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
             "<td>"+pos+"</td>"+
            "<td>"+data.texto+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.fecha_fin+"</td>"+
            "<td>"+data.fecha_aviso+"</td>"+
            "<td>"+data.monto+"</td>"+
           "<td>"+data.tipo_nombre+"<input type='hidden'name='txt_tipo' value='"+data.tipo+"'></td>"+
            "<td>"+data.programacion_aviso+"</td>"+
            "<td>"+data.fecha_conformidad+"</td>"+
            "<td>"+data.nro_doc+"</td>";
    
        if(data.fecha_conformidad==='' && data.nro_doc===''){
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#contrataciondetalleModal' data-titulo='Editar' onclick='BtnEditarDetalle(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";

        }
        if(data.fecha_conformidad==='' && data.nro_doc!==''){
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#contrataciondetalleModal' data-titulo='Editar' onclick='BtnEditarDetalle(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
  }
        if(data.fecha_conformidad!=='' && data.nro_doc!=='') {
        html+="<td align='center'></td>";


        }
        if(data.fecha_conformidad!=='' && data.nro_doc==='') {
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#contrataciondetalleModal' data-titulo='Editar' onclick='BtnEditarDetalle(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";

        }
        
        html+="</tr>";
    });
    $("#tb_detalle_contrataciones").html(html);
    $("#t_detalle_contrataciones").dataTable(
    ); 


};
eventoSlctGlobalSimple=function(){
};

BtnEditarDetalle=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    ContratacionDetalleG.id=id;
    ContratacionDetalleG.texto=$(tr).find("td:eq(1)").text();
    ContratacionDetalleG.fecha_inicio=$(tr).find("td:eq(2)").text();
    ContratacionDetalleG.fecha_fin=$(tr).find("td:eq(3)").text();
    ContratacionDetalleG.fecha_aviso=$(tr).find("td:eq(4)").text();
    ContratacionDetalleG.monto=$(tr).find("td:eq(5)").text();
    ContratacionDetalleG.tipo=$(tr).find("td:eq(6) input[name='txt_tipo']").val();
    ContratacionDetalleG.programacion_aviso=$(tr).find("td:eq(7)").text();
    ContratacionDetalleG.fecha_conformidad=$(tr).find("td:eq(8)").text();
    ContratacionDetalleG.nro_doc=$(tr).find("td:eq(9)").text();
//    $("#BtnEditar").click();
};

validaDetalleContrataciones = function(){
    var r=true;
    if( $("#form_detalle_contrataciones_modal #txt_nro_doc").val()=='' ){
        alert("Ingrese Número de Documento");
        r=false;
    }
    return r;
};
EditarDetalle = function(){
    if(validaDetalleContrataciones()){
        Contrataciones.AgregarEditarDetalleContratacion(1);
    }
};
AgregarDetalle = function(){
    if(validaDetalleContrataciones()){
        Contrataciones.AgregarEditarDetalleContratacion(0);
    }
};

tacho = function(id){
    c=confirm("¿Está seguro de Eliminar este registro?");
    if(c){
    Contrataciones.CambiarEstadoDetalleContrataciones(id, 0);}
};

confirmardetalle = function(id){
    c=confirm("¿Está seguro de brindar la conformidad?");
    if(c){
    Contrataciones.Confirmardetalle(id);}
};

denegardetalle = function(id){
    c=confirm("¿Está seguro de Denegar este registro?");
    if(c){
    Contrataciones.Denegardetalle(id);}
};

confirmar = function(id){
    c=confirm("¿Está seguro de brindar la conformidad a la contratación?");
    if(c){
    Contrataciones.Confirmar(id);}
};

denegar = function(id){
    c=confirm("¿Está seguro de Denegar la contratación?");
    if(c){
    Contrataciones.Denegar(id);}
};

</script>