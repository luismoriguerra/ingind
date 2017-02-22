<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var SubtiposG={id:0,nombre:"",estado:1,tipo_id:"",costo_actual:"",tamano:"",color:""}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
    var datos={estado:1};
    slctGlobal.listarSlct('poitipo','slct_tipo',datos);
    slctGlobalHtml('slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre Tipo|#DCE6F1', //#DCE6F1
                tipo          :'3|Tipo |#DCE6F1',
                costo_actual        :'onBlur|Costo Actual|#DCE6F1', //#DCE6F1
                tamano        :'onBlur|Tamaño|#DCE6F1', //#DCE6F1
                color        :'onBlur|Color|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'subtipos','t_subtipos');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_subtipos','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('subtipos');


    $('#subtipoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Subtipo');
      $('#form_subtipos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_subtipos_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_subtipos_modal #slct_estado').val(1);
            $('#form_subtipos_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_subtipos_modal #txt_nombre').val( SubtiposG.nombre );
            $('#form_subtipos_modal #txt_costo_actual').val( SubtiposG.costo_actual );
            $('#form_subtipos_modal #txt_tamano').val( SubtiposG.tamano );
            $('#form_subtipos_modal #txt_color').val( SubtiposG.color );
            $('#form_subtipos_modal #slct_estado').val( SubtiposG.estado );
            $('#form_subtipos_modal #slct_tipo').val( SubtiposG.tipo_id );
            $("#form_subtipos_modal").append("<input type='hidden' value='"+SubtiposG.id+"' name='id'>");
        }
             $('#form_subtipos_modal select').multiselect('rebuild');
    });

    $('#subtipoModal').on('hide.bs.modal', function (event) {
       $('#form_subtipos_modal input').val('');
       $('#form_subtipos_modal select').val('');
       $('#form_subtipos_modal textarea').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    SubtiposG.id=id;
    SubtiposG.nombre=$(tr).find("td:eq(0)").text();
    SubtiposG.costo_actual=$(tr).find("td:eq(2)").text();
    SubtiposG.tamano=$(tr).find("td:eq(3)").text();
    SubtiposG.color=$(tr).find("td:eq(4)").text();
    SubtiposG.tipo_id=$(tr).find("td:eq(1) input[name='txt_tipo']").val();
    SubtiposG.estado=$(tr).find("td:eq(5)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="subtipos" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'poisubtipo','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==1){
        return row.tipo+"<input type='hidden'name='txt_tipo' value='"+row.tipo_id+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==5){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activarTabla=function(){
    $("#t_subtipos").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Subtipos.CambiarEstadoSubtipos(id, 1);
};
desactivar = function(id){
    Subtipos.CambiarEstadoSubtipos(id, 0);
};
Editar = function(){
    if(validaSubtipos()){
        Subtipos.AgregarEditarSubtipo(1);
    }
};
Agregar = function(){
    if(validaSubtipos()){
        Subtipos.AgregarEditarSubtipo(0);
    }
};

validaSubtipos = function(){
    var r=true;
    if( $("#form_subtipos_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de Sub Tipo");
        r=false;
    }
    if( $("#form_subtipos_modal #slct_tipo").val()=='' ){
    alert("Seleccione Tipo");
    r=false;
    }
    return r;
};
</script>