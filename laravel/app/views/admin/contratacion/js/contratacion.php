<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var ContratacionG={id:0,titulo:"",monto_total:"",objeto:"",justificacion:"",actividades:"",fecha_conformidad:"",fecha_inicio:"",fecha_fin:"",fecha_aviso:"",programacion_aviso:"",nro_doc:"",estado:1,area:""}; // Datos Globales
var ContratacionDetalleG={id:0,texto:"",monto_total:"",objeto:"",justificacion:"",actividades:"",fecha_conformidad:"",fecha_inicio:"",fecha_fin:"",fecha_aviso:"",programacion_aviso:"",nro_doc:"",estado:1,area:""}; // Datos Globales
 // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
    var datos={estado:1};
    slctGlobal.listarSlct('area','slct_area','simple',null,datos);
    slctGlobalHtml('slct_estado','simple');
    var idG={    titulo        :'onBlur|Titulo Contratación|#DCE6F1', //#DCE6F1
                monto_total        :'onBlur|Monto Contratación|#DCE6F1', //#DCE6F1
                objeto        :'onBlur|Objeto Contratación|#DCE6F1', //#DCE6F1
                justificacion        :'onBlur|Justificación Contratación|#DCE6F1', //#DCE6F1
                actividades        :'onBlur|Actividades Contratación|#DCE6F1', //#DCE6F1
                fecha_conformidad        :'onBlur|Fecha Conformidad|#DCE6F1', //#DCE6F1
                fecha_inicio        :'onBlur|Fecha Inicio|#DCE6F1', //#DCE6F1
                fecha_fin        :'onBlur|Fecha Fin|#DCE6F1', //#DCE6F1
                fecha_aviso        :'onBlur|Fecha Aviso|#DCE6F1', //#DCE6F1
                programacion_aviso        :'onBlur|Programación Aviso|#DCE6F1', //#DCE6F1
                area          :'3|Área |#DCE6F1',
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'contrataciones','t_contrataciones');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_contrataciones','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
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
    ContratacionG.fecha_conformidad=$(tr).find("td:eq(5)").text();
    ContratacionG.fecha_inicio=$(tr).find("td:eq(6)").text();
    ContratacionG.fecha_fin=$(tr).find("td:eq(7)").text();
    ContratacionG.fecha_aviso=$(tr).find("td:eq(8)").text();
    ContratacionG.programacion_aviso=$(tr).find("td:eq(9)").text();
    ContratacionG.area=$(tr).find("td:eq(10) input[name='txt_area']").val();alert(ContratacionG.area);
    ContratacionG.estado=$(tr).find("td:eq(11)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="contrataciones" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'contratacion','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
      if(typeof(fn)!='undefined' && fn.col==10){
        return row.area+"<input type='hidden'name='txt_area' value='"+row.area_id+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==11){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activarTabla=function(){
    $("#t_contrataciones").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Contrataciones.CambiarEstadoContrataciones(id, 1);
};
desactivar = function(id){
    Contrataciones.CambiarEstadoContrataciones(id, 0);
};
Editar = function(){
    if(validaContrataciones()){
        Contrataciones.AgregarEditarContratacion(1);
    }
};
Agregar = function(){
    if(validaContrataciones()){
       Contrataciones.AgregarEditarContratacion(0);
    }
};

validaContrataciones = function(){
    var r=true;
    if( $("#form_contrataciones_modal #txt_titulo").val()=='' ){
        alert("Ingrese Titulo de Contratacion");
        r=false;
    }
    return r;
};
</script>