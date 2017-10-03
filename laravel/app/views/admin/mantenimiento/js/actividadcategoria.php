<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var RolsG={id:0,nombre:"",estado:1, area_id:''}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    data={estado:1,areapersona:1}; 
    slctGlobal.listarSlctFuncion('area','listara','slct_area_id','simple',null,data);

    var idG={   area_id        :'3|Area|#DCE6F1', //#DCE6F1
                nombre        :'onBlur|Nombre Categoria|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'rols','t_rols');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_rols','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('rols');


    $('#rolModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Actividad Categoria');
      $('#form_rols_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_rols_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_rols_modal #slct_estado').val(1);
            $('#form_rols_modal #slct_area_id').val(""); 
            $('#form_rols_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_rols_modal #txt_nombre').val( RolsG.nombre );
            $('#form_rols_modal #slct_area_id').val( RolsG.area_id ); 
            $('#form_rols_modal #slct_estado').val( RolsG.estado );
            $("#form_rols_modal").append("<input type='hidden' value='"+RolsG.id+"' name='id'>");
        }
             $('#form_rols_modal select').multiselect('rebuild');
    });

    $('#rolModal').on('hide.bs.modal', function (event) {
       $('#form_rols_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    RolsG.id=id;
    RolsG.area=$(tr).find("td:eq(0)").text();
    RolsG.nombre=$(tr).find("td:eq(1)").text();
    RolsG.estado=$(tr).find("td:eq(2)>span").attr("data-estado");
    RolsG.area_id=$(tr).find("td:eq(0) input[name='txt_area_id']").val();
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="rols" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'actividadcategoria','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==0){
         return row.area+"<input type='hidden'name='txt_area_id' value='"+row.area_id+"'>";
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
    $("#t_rols").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Rols.CambiarEstadoRols(id, 1);
};
desactivar = function(id){
    Rols.CambiarEstadoRols(id, 0);
};
Editar = function(){
    if(validaRols()){
        Rols.AgregarEditarRol(1);
    }
};
Agregar = function(){
    if(validaRols()){
        Rols.AgregarEditarRol(0);
    }
};
validaRols = function(){
    var r=true;

    if( $("#form_rols_modal #slct_area_id").val()=='' ){
        alert("Seleccione Área");
        r=false;
    }
    else if( $("#form_rols_modal #txt_nombre").val()=='' ){
        swal("Mensaje", "Ingrese Nombre de la Categoria Actividad!");
        r=false;
    }
    return r;
};
</script>
