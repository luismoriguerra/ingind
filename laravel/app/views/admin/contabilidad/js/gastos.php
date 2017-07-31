<?php define('name_controllerG', 'gastos'); ?>
<?php define('name_frmG', 'gastos'); ?>

<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var dataG={id:0, proveedor:"", nro_expede:"", monto_total:"", estado:1 }; // Datos Globales

var name_controllerG = 'gastos';
var name_frmG = 'gastos';

$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    //El nombre de las cabeceras debe ser de acuerdo al SELECT del metoo getCargar();
    var idG={   proveedor        :'onBlur|Proveedor|#DCE6F1', //#DCE6F1
                nro_expede        :'onBlur|Expedediente|#DCE6F1',
                monto_total        :'onBlur|Total|#DCE6F1',
                estado        :'2|Estado|#DCE6F1' //#DCE6F1,
             }

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera

    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1, name_frmG,'t_'+name_frmG);
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_'+name_frmG,'fa-edit');
    //columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    //targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax(name_frmG);


    $('#'+name_controllerG+'Modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' '+name_controllerG);
      $('#form_'+name_frmG+'_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_"+name_frmG+"_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_'+name_frmG+'_modal #slct_estado').val(1);
            $('#form_'+name_frmG+'_modal #txt_proveedor').focus().attr('readonly', false);
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_'+name_frmG+'_modal #txt_proveedor').val( dataG.proveedor ).attr('readonly', true);
            $('#form_'+name_frmG+'_modal #txt_nro_expede').val( dataG.nro_expede );
            $('#form_'+name_frmG+'_modal #txt_monto_total').val( dataG.monto_total );

            $('#form_'+name_frmG+'_modal #slct_estado').val( dataG.estado );
            $("#form_"+name_frmG+"_modal").append("<input type='hidden' value='"+dataG.id+"' name='id'>");
        }
             $('#form_'+name_frmG+'_modal select').multiselect('rebuild');
    });

    $('#'+name_controllerG+'Modal').on('hide.bs.modal', function (event) {
       $('#form_'+name_frmG+'_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    dataG.id=id;
    dataG.proveedor=$(tr).find("td:eq(0)").text();
    dataG.nro_expede=$(tr).find("td:eq(1)").text();
    dataG.monto_total=$(tr).find("td:eq(2)").text();
    dataG.estado=$(tr).find("td:eq(3)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t==name_frmG ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t, name_controllerG, 'cargar', columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}


GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==3){ //Cuenta la cantidad de Columna ubicando el select "estado", inicia en 0.
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}


activarTabla=function(){
    $("#t_"+name_frmG).dataTable(); // inicializo el datatable    
};

activar = function(id){
    Data.CambiarEstado(id, 1, name_frmG, name_controllerG);
};
desactivar = function(id){
    Data.CambiarEstado(id, 0, name_frmG, name_controllerG);
};

Editar = function(){
    if(valida()){
        Data.AgregarEditar(1, name_frmG, name_controllerG);
    }
};
Agregar = function(){
    if(valida()){
        Data.AgregarEditar(0, name_frmG, name_controllerG);
    }
};

valida = function(){
    var r=true;
    if( $("#form_"+name_frmG+"_modal #nro_expede").val()=='' ){
        alert("Ingrese el Nro. Expediente");
        r=false;
    }
    return r;
};
</script>