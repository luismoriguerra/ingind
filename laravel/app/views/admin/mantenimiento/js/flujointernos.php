<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var FlujoInternosG={
        id:0,
        nombre_interno:"",
        nombre:"",
        flujo:"",     
        estado:1
        }; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
        nombre
        flujo
        categoria
        tipo_flujointerno
        estado
    */
    var data={estado:1}; 

    slctGlobal.listarSlctFuncion('flujo','listar','slct_flujo_id','simple',null,data);

    //slctGlobalHtml('slct_estado','simple');

    var idG={   nombre_interno       :'onBlur|Nombre Interno|#DCE6F1', 
                nombre        :'onBlur|Nombre|#DCE6F1', //#DCE6F1
                
                flujo          :'3|Flujo|#DCE6F1', 
 
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'flujointernos','t_flujointernos');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_flujointernos','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('flujointernos');




    $('#flujointernoModal').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' FlujoInterno');
      $('#form_flujointernos [data-toggle="tooltip"]').css("display","none");
      $("#form_flujointernos input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');   

            $('#form_flujointernos #slct_estado').val(1);

            $('#form_flujointernos #txt_nombre').focus();
       
            
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_flujointernos #txt_nombre_interno').val( FlujoInternosG.nombre_interno );

            $('#form_flujointernos #txt_nombre').val( FlujoInternosG.nombre );

            $('#form_flujointernos #slct_flujo_id').val( FlujoInternosG.flujo );    
       
            $('#form_flujointernos #slct_estado').val( FlujoInternosG.estado );
            $("#form_flujointernos").append("<input type='hidden' value='"+FlujoInternosG.id+"' name='id'>");

        }
            $('#form_flujointernos select').multiselect('rebuild');
    });
             
    $('#flujointernoModal').on('hide.bs.modal', function (event) {
        $('#form_flujointernos input').val('');
        $('#form_flujointernos #slct_flujo_id').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    FlujoInternosG.id=id;
    FlujoInternosG.nombre_interno=$(tr).find("td:eq(0)").text();

    FlujoInternosG.nombre=$(tr).find("td:eq(1)").text();

    FlujoInternosG.flujo=$(tr).find("td:eq(2) input[name='txt_flujo']").val();   
    FlujoInternosG.estado=$(tr).find("td:eq(3)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="flujointernos" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'flujointerno','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn

    if(typeof(fn)!='undefined' && fn.col==2){
        return row.flujo+"<input type='hidden'name='txt_flujo' value='"+row.flujo_id+"'>";
    }


    else if(typeof(fn)!='undefined' && fn.col==3){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activar = function(id){
    FlujoInternos.CambiarEstadoFlujoInternos(id, 1);
};
desactivar = function(id){
    FlujoInternos.CambiarEstadoFlujoInternos(id, 0);
};
Editar = function(){
    if(validaFlujoInternos()){
        FlujoInternos.AgregarEditarFlujoInternos(1);
    }
};
Agregar = function(){
    if(validaFlujoInternos()){
        FlujoInternos.AgregarEditarFlujoInternos(0);
    }

};
validaFlujoInternos = function(){
    var r=true;
    if( $("#form_flujointernos #txt_nombre_interno").val()==''){
        alert("Ingrese Nombre Interno");
        r=false;
    }

   else if( $("#form_flujointernos #txt_nombre").val()=='' ){
        alert("Ingrese Nombre");
        r=false;
    }

    else if( $("#form_flujointernos #slct_flujo_id").val()=='' ){
        alert("Seleccione Área");
        r=false;
    }

    return r;
};
</script>
