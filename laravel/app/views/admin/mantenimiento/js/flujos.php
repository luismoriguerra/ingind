<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var FlujosG={
        id:0,
        nombre:"",
        area:"",
        categoria:"",
        tipo_flujo:"",
        estado:1
        }; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
        nombre
        area
        categoria
        tipo_flujo
        estado
    */
    var data={estado:1}; 
    slctGlobal.listarSlctFuncion('area','listara','slct_area_id','simple',null,data);
    slctGlobal.listarSlct('categoria','slct_categoria_id','simple',null,data);
    slctGlobalHtml('slct_tipo_flujo,#slct_estado','simple');

    var idG={   nombre        :'onBlur|Nombre del Flujo|#DCE6F1', //#DCE6F1
                area          :'3|Área del Flujo|#DCE6F1', //#DCE6F1
                categoria     :'3|Categoría del Flujo|#DCE6F1', //#DCE6F1
                tipo_flujo    :'3|Tipo del Flujo|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'flujos','t_flujos');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_flujos','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('flujos');


    $('#flujoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Flujo');
      $('#form_flujos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_flujos_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_flujos_modal #slct_estado').val(1);
            $('#form_flujos_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_flujos_modal #txt_nombre').val( FlujosG.nombre );
            $('#form_flujos_modal #slct_area_id').val( FlujosG.area );
            $('#form_flujos_modal #slct_categoria_id').val( FlujosG.categoria );
            $('#form_flujos_modal #slct_tipo_flujo').val( FlujosG.tipo_flujo );
            $('#form_flujos_modal #slct_estado').val( FlujosG.estado );
            $("#form_flujos_modal").append("<input type='hidden' value='"+FlujosG.id+"' name='id'>");
        }
            $('#form_flujos_modal select').multiselect('rebuild');
    });

    $('#flujoModal').on('hide.bs.modal', function (event) {
        $('#form_flujos_modal input').val('');
        $('#form_flujos_modal #slct_categoria_id,#form_flujos_modal #slct_area_id,#form_flujos_modal #slct_tipo_flujo').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    FlujosG.id=id;
    FlujosG.nombre=$(tr).find("td:eq(0)").text();
    FlujosG.area=$(tr).find("td:eq(1) input[name='txt_area']").val();
    FlujosG.categoria=$(tr).find("td:eq(2) input[name='txt_categoria']").val();
    FlujosG.tipo_flujo=$(tr).find("td:eq(3) input[name='txt_tipo_flujo']").val();
    FlujosG.estado=$(tr).find("td:eq(4)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="flujos" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'flujo','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==1){
        return row.area+"<input type='hidden'name='txt_area' value='"+row.area_id+"'>";
    }
    else if(typeof(fn)!='undefined' && fn.col==2){
        return row.categoria+"<input type='hidden'name='txt_categoria' value='"+row.categoria_id+"'>";
    }
    else if(typeof(fn)!='undefined' && fn.col==3){
        return row.tipo_flujo+"<input type='hidden'name='txt_tipo_flujo' value='"+row.tipo_flujo_id+"'>";
    }
    else if(typeof(fn)!='undefined' && fn.col==4){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activar = function(id){
    Flujos.CambiarEstadoFlujos(id, 1);
};
desactivar = function(id){
    Flujos.CambiarEstadoFlujos(id, 0);
};
Editar = function(){
    if(validaFlujos()){
        Flujos.AgregarEditarFlujos(1);
    }
};
Agregar = function(){
    if(validaFlujos()){
        Flujos.AgregarEditarFlujos(0);
    }
};
validaFlujos = function(){
    var r=true;
    if( $("#form_flujos_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de Flujo");
        r=false;
    }
    else if( $("#form_flujos_modal #slct_area_id").val()=='' ){
        alert("Seleccione Área");
        r=false;
    }
    else if( $("#form_flujos_modal #slct_categoria_id").val()=='' ){
        alert("Seleccione Categoría");
        r=false;
    }
    else if( $("#form_flujos_modal #slct_tipo_flujo").val()=='' ){
        alert("Seleccione Tipo de Flujo");
        r=false;
    }
    return r;
};
</script>
