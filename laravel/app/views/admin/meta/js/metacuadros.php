<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var MetacuadrosG={id:0,actividad:"",fecha_vencimiento:"",anio:"",estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
    var datos={estado:1};
    slctGlobal.listarSlctFuncion('metacuadro','listarmeta','slct_meta','simple',null,datos);
    slctGlobalHtml('slct_estado','simple');
    var idG={   actividad        :'onBlur|Actividad|#DCE6F1', //#DCE6F1
                meta          :'3|Meta |#DCE6F1',
                anio        :'onBlur|Año|#DCE6F1', //#DCE6F1
                fecha_vencimiento        :'onChange|Fecha Vencimiento|#DCE6F1|fechaG', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };
             
    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'metacuadros','t_metacuadros');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_metacuadros','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('metacuadros');

         $('.fecha').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });
        
       $('.fechaG').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });
        
    $('#metacuadroModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Meta Cuadro');
      $('#form_metacuadros_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_metacuadros_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_metacuadros_modal #slct_estado').val(1);
            $('#form_metacuadros_modal #txt_actividad').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_metacuadros_modal #txt_actividad').val( MetacuadrosG.actividad );
            $('#form_metacuadros_modal #txt_fecha_vencimiento').val( MetacuadrosG.fecha_vencimiento );
            $('#form_metacuadros_modal #txt_anio').val( MetacuadrosG.anio );
            $('#form_metacuadros_modal #slct_estado').val( MetacuadrosG.estado );
            $('#form_metacuadros_modal #slct_meta').val( MetacuadrosG.meta );
            $("#form_metacuadros_modal").append("<input type='hidden' value='"+MetacuadrosG.id+"' name='id'>");
        }
             $('#form_metacuadros_modal select').multiselect('rebuild');
    });

    $('#metacuadroModal').on('hide.bs.modal', function (event) {
       $('#form_metacuadros_modal input').val('');
        $('#form_metacuadros_modal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    MetacuadrosG.id=id;
    MetacuadrosG.actividad=$(tr).find("td:eq(0)").text();
    MetacuadrosG.meta=$(tr).find("td:eq(1) input[name='txt_meta']").val();
    MetacuadrosG.anio=$(tr).find("td:eq(2)").text();
    MetacuadrosG.fecha_vencimiento=$(tr).find("td:eq(3)").text();
    MetacuadrosG.estado=$(tr).find("td:eq(4)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="metacuadros" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'metacuadro','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==4){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
    if(typeof(fn)!='undefined' && fn.col==1){
        return row.meta+"<input type='hidden' name='txt_meta' value='"+row.meta_id+"'>";
    }
}

activarTabla=function(){
    $("#t_metacuadros").dataTable(); // inicializo el datatable    
};

activar = function(id){
    MetaCuadros.CambiarEstadoMetaCuadros(id, 1);
};
desactivar = function(id){
    MetaCuadros.CambiarEstadoMetaCuadros(id, 0);
};
Editar = function(){
    if(validaVerbos()){
        MetaCuadros.AgregarEditarMetaCuadro(1);
    }
};
Agregar = function(){
    if(validaVerbos()){
        MetaCuadros.AgregarEditarMetaCuadro(0);
    }
};

validaVerbos = function(){
    var r=true;
    if( $("#form_metacuadros_modal #txt_actividad").val()=='' ){
        alert("Ingrese Nombre de Meta Cuadros");
        r=false;
    }
    return r;
};
</script>