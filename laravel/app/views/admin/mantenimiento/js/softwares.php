<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var SoftwaresG={
        id:0,
        nombre:"",
        tabla:"",
        campo:"",
        estado:1
        }; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre|#DCE6F1', //#DCE6F1
                tabla        :'onBlur|Nombre APOCOPE|#DCE6F1', //#DCE6F1
                campo     :'onBlur|Software|#DCE6F1',    
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'softwares','t_softwares');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_softwares','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('softwares');


    $('#softwareModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Software');
      $('#form_softwares_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_softwares_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_softwares_modal #slct_estado').val(1);
            $('#form_softwares_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_softwares_modal #txt_nombre').val( SoftwaresG.nombre );
            $('#form_softwares_modal #txt_tabla').val( SoftwaresG.tabla );
            $('#form_softwares_modal #txt_campo').val( SoftwaresG.campo );
            $('#form_softwares_modal #slct_estado').val( SoftwaresG.estado );
            $("#form_softwares_modal").append("<input type='hidden' value='"+SoftwaresG.id+"' name='id'>");
        }
             $('#form_softwares_modal select').multiselect('rebuild');
    });

    $('#softwareModal').on('hide.bs.modal', function (event) {
       $('#form_softwares_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    SoftwaresG.id=id;
    SoftwaresG.nombre=$(tr).find("td:eq(0)").text();
    SoftwaresG.tabla=$(tr).find("td:eq(1)").text();
    SoftwaresG.campo=$(tr).find("td:eq(2)").text();
    SoftwaresG.estado=$(tr).find("td:eq(3)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="softwares" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'software','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==3){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activarTabla=function(){
    $("#t_softwares").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Softwares.CambiarEstadoSoftwares(id, 1);
};
desactivar = function(id){
    Softwares.CambiarEstadoSoftwares(id, 0);
};
Editar = function(){
    if(validaSoftwares()){
        Softwares.AgregarEditarSoftware(1);
    }
};
Agregar = function(){
    if(validaSoftwares()){
        Softwares.AgregarEditarSoftware(0);
    }
};
validaSoftwares = function(){
    var r=true;
    if( $("#form_softwares_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de Software");
        r=false;
    }
    else if( $("#form_softwares_modal #txt_tabla").val()=='' ){
        alert("Ingrese Tabla");
        r=false;
    }

    else if( $("#form_softwares_modal #txt_campo").val()=='' ){
        alert("Ingrese Campo");
        r=false;
    }

    return r;
};
</script>
