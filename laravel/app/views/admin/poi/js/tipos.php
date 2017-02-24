<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var TiposG={id:0,nombre:"",estado:1}; // Datos Globales
var SubtiposG={id:0,nombre:"",estado:1,tipo_id:"",costo_actual:"",tamano:"",color:""}; // Datos Globales

$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('form_subtipos_modal #slct_estado','simple');
    slctGlobalHtml('form_tipos_modal #slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre Tipo|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
                Grupo          :'1|  |#DCE6F1',
                a          :'1|  |#DCE6F1',
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'tipos','t_tipos');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
//    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_contrataciones','fa-edit');
//    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
//    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('tipos');


    $('#tipoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Tipo');
      $('#form_tipos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tipos_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tipos_modal #slct_estado').val(1);
            $('#form_tipos_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_tipos_modal #txt_nombre').val( TiposG.nombre );
            $('#form_tipos_modal #slct_estado').val( TiposG.estado );
            $("#form_tipos_modal").append("<input type='hidden' value='"+TiposG.id+"' name='id'>");
        }
             $('#form_tipos_modal select').multiselect('rebuild');
    });

    $('#tipoModal').on('hide.bs.modal', function (event) {
       $('#form_tipos_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
    $('#subtipoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Subtipo');
      $('#form_subtipos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_subtipos_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarSubtipo();');
            $('#form_subtipos_modal #slct_estado').val(1);
            $('#form_subtipos_modal #txt_nombre').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarSubtipo();');

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
       $('#form_subtipos_modal :visible').val('');
       $('#form_subtipos_modal select').val('');
       $('#form_subtipos_modal textarea').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TiposG.id=id;
    TiposG.nombre=$(tr).find("td:eq(0)").text();
    TiposG.estado=$(tr).find("td:eq(1)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="tipos" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'poitipo','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    
   if(typeof(fn)!='undefined' && fn.col==3){
        var grupo='';
        grupo+= '<span id="'+row.id+'" title="Sub Tipos" onClick="CargarSubTipo(\''+row.id+'\',\''+row.nombre+'\',this)" data-estado="'+row.estado+'" class="btn btn-info"><i class="glyphicon glyphicon-user"></i></span>';
        return grupo;
   }
   
   if(typeof(fn)!='undefined' && fn.col==2){
        var grupo='';
        grupo+= '<a class="form-control btn btn-primary" onclick="BtnEditar(this,'+row.id+')"><i class="fa fa-lg fa-edit"></i></a><br>';
        return grupo;
   }
   
    if(typeof(fn)!='undefined' && fn.col==1){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activarTabla=function(){
    $("#t_tipos").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Tipos.CambiarEstadoTipos(id, 1);
};
desactivar = function(id){
    Tipos.CambiarEstadoTipos(id, 0);
};

activarSubTipo = function(id){
    Tipos.CambiarEstadoSubTipo(id, 1);
};
desactivarSubTipo = function(id){
    Tipos.CambiarEstadoSubTipo(id, 0);
};

Editar = function(){
    if(validaTipos()){
        Tipos.AgregarEditarTipo(1);
    }
};
Agregar = function(){
    if(validaTipos()){
        Tipos.AgregarEditarTipo(0);
    }
};

EditarSubtipo = function(){
    if(validaSubTipos()){
        Tipos.AgregarEditarSubtipo(1);
    }
};
AgregarSubtipo = function(){
    if(validaSubTipos()){
        Tipos.AgregarEditarSubtipo(0);
    }
};

validaTipos = function(){
    var r=true;
    if( $("#form_tipos_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de Tipo");
        r=false;
    }
    return r;
};

validaSubTipos = function(){
    var r=true;
    if( $("#form_subtipos_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de Sub Tipo");
        r=false;
    }
    return r;
};

CargarSubTipo=function(id,titulo,boton){
    
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    
    $("#form_subtipos_modal #txt_tipo").val(id);
    $("#form_subtipo #txt_titulo").text(titulo);
    $("#form_subtipo .form-group").css("display","");
    
    data={id:id};
    Tipos.CargarSubtipos(data);
};

subtipoHTML=function(datos){
  var html="";
    var alerta_tipo= '';
    $('#t_subtipo').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
             "<td>"+pos+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.costo_actual+"</td>"+
            "<td>"+data.tamano+"</td>"+
            "<td>"+data.color+"</td>";
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#subtipoModal' data-titulo='Editar' onclick='BtnEditarSubTipo(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
        if(data.estado==1){
            html+='<td align="center"><span id="'+data.id+'" onClick="desactivarSubTipo('+data.id+')" data-estado="'+data.estado+'" class="btn btn-success">Activo</span></td>';
        }
        else {
           html+='<td align="center"><span id="'+data.id+'" onClick="activarSubTipo('+data.id+')" data-estado="'+data.estado+'" class="btn btn-danger">Inactivo</span></td>';

        }

        html+="</tr>";
    });
    $("#tb_subtipo").html(html);
    $("#t_subtipo").dataTable(
    ); 


};

BtnEditarSubTipo=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    SubtiposG.id=id;
    SubtiposG.nombre=$(tr).find("td:eq(1)").text();
    SubtiposG.costo_actual=$(tr).find("td:eq(2)").text();
    SubtiposG.tamano=$(tr).find("td:eq(3)").text();
    SubtiposG.color=$(tr).find("td:eq(4)").text();
    SubtiposG.estado=$(tr).find("td:eq(6)>span").attr("data-estado");

};
</script>