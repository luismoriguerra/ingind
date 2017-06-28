<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var MetasG={id:0,nombre:"",fecha:"",area:"",estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    
    var data = {estado:1,areagestionall:1};
    slctGlobal.listarSlct('area','slct_area_id','multiple',null,data);
    slctGlobalHtml('slct_estado','simple');
    var idG={   meta          :'3|Nombre de Meta |#DCE6F1',
                fecha        :'onChange|Fecha Aviso|#DCE6F1|fechaG', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'metas','t_metas');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_metas','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('metas');
    $('.fechaG').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
    });

    $('#metaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Meta');
      $('#form_metas_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_metas_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_metas_modal #slct_estado').val(1);
            $('#form_metas_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_metas_modal #txt_nombre').val( MetasG.nombre );
            $('#form_metas_modal #slct_estado').val( MetasG.estado );
            $('#form_metas_modal #txt_fecha').val( MetasG.fecha );
             var opciones = MetasG.area.split(",");
             slctGlobal.listarSlct('area','form_metas_modal #slct_area_id','multiple',opciones,data);
            $("#form_metas_modal").append("<input type='hidden' value='"+MetasG.id+"' name='id'>");
        }
             $('#form_metas_modal select').multiselect('rebuild');
    });

    $('#metaModal').on('hide.bs.modal', function (event) {
       $('#form_metas_modal input').val('');
       $('#form_metas_modal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    MetasG.id=id;
    MetasG.nombre=$(tr).find("td:eq(0)").text();
    MetasG.fecha=$(tr).find("td:eq(1)").text();
    MetasG.estado=$(tr).find("td:eq(2)>span").attr("data-estado");
    MetasG.area=$(tr).find("td:eq(0) input[name='txt_area']").val();
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="metas" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'meta','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==0){
         return row.nombre+"<input type='hidden'name='txt_area' value='"+row.area_multiple_id+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==2){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}
activarTabla=function(){
    $("#t_metas").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Metas.CambiarEstadoMetas(id, 1);
};
desactivar = function(id){
    Metas.CambiarEstadoMetas(id, 0);
};
Editar = function(){
    if(validaMetas()){
        Metas.AgregarEditarMeta(1);
    }
};
Agregar = function(){
    if(validaMetas()){
        Metas.AgregarEditarMeta(0);
    }
};
validaMetas = function(){
    var r=true;
    if( $("#form_metas_modal #slct_area_id").val()=='' ){
        alert("Ingrese Área(s) de Meta");
        r=false;
    }
    return r;
};
</script>
