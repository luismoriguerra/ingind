<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var MetacuadrosG={id:0,actividad:"",fecha:"",fecha_add:"",anio:"",estado:1}; // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
    var datos={estado:1};
    slctGlobal.listarSlct('meta','slct_meta', 'simple', null, datos);
     
    slctGlobalHtml('slct_estado','simple');
    var idG={   meta          :'3|Proyecto |#DCE6F1',
                actividad        :'onBlur|Actividad|#DCE6F1', //#DCE6F1
                fecha        :'onBlur|Fecha de Actividad|#DCE6F1', //#DCE6F1
                anio        :'onBlur|Año|#DCE6F1', //#DCE6F1
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
   initDatePicker();
        

        
    $('#metacuadroModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Meta Cuadro');
      modal.find('.modal-body .agregarfecha2').attr('onClick','AgregarFecha2('+MetacuadrosG.id+');');
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
            $('#form_metacuadros_modal #txt_fecha').val( MetacuadrosG.fecha );
            $('#form_metacuadros_modal #txt_fecha_add').val(MetacuadrosG.fecha_add);
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
        $('#form_metacuadros_modal #tb_fecha2').html('');
        $('#form_metacuadros_modal #tb_fecha1').html('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    MetacuadrosG.id=id;
    MetacuadrosG.actividad=$(tr).find("td:eq(1)").text();
    MetacuadrosG.fecha=$(tr).find("td:eq(2)").text();
    MetacuadrosG.fecha_add=$(tr).find("td:eq(0) input[name='txt_fecha_add']").val();
    MetacuadrosG.meta=$(tr).find("td:eq(0) input[name='txt_meta']").val();
    MetacuadrosG.anio=$(tr).find("td:eq(3)").text();
    MetacuadrosG.estado=$(tr).find("td:eq(4)>span").attr("data-estado");
    $("#BtnEditar").click();
    data={id:id};
    MetaCuadros.CargarFecha1(data);
     MetaCuadros.CargarFecha2(data);
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
    if(typeof(fn)!='undefined' && fn.col==0){
        return row.meta+"<input type='hidden' name='txt_meta' value='"+row.meta_id+"'>"+
                "<input type='hidden' name='txt_fecha_add' value='"+row.fecha_add+"'>";
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

fecha1HTML=function(datos){
  var html="";
    var alerta_tipo= '';
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
             "<td>"+pos+"<input type='hidden' name='f1id[]' id='f1id' value='"+data.id+"'></td>"+
            "<td><input type='text' class='datepicker form-control fechaG' id='txt_fecha2' name='txt_fecha1[]' value='"+data.fecha+"' onfocus='blur()'></td>"+
            "<td><input type='text' class='datepicker form-control fechaG' id='txt_fecha2_add' name='txt_fecha1_add[]' value='"+data.fecha_add+"' onfocus='blur()'></td>"+
            "<td><textarea class='form-control' id='txt_comentario1' name='txt_comentario1[]'>"+data.comentario+"</textarea></td>";
        html+="</tr>";
    });
    $("#tb_fecha1").html(html); initDatePicker();


};

fecha2HTML=function(datos){
  var html="";
    var alerta_tipo= '';
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
             "<td>"+pos+"<input type='hidden' name='f2id[]' id='f2id' value='"+data.id+"'></td>"+
            "<td><input type='text' class='datepicker form-control fechaG' id='txt_fecha2' name='txt_fecha2[]' value='"+data.fecha+"' onfocus='blur()'></td>"+
            "<td><input type='text' class='datepicker form-control fechaG' id='txt_fecha2_add' name='txt_fecha2_add[]' value='"+data.fecha_add+"' onfocus='blur()'></td>"+
            "<td><textarea class='form-control' id='txt_comentario2' name='txt_comentario2[]'>"+data.comentario+"</textarea></td>"+
            "<td><select class='form-control fechar' name='slct_fecha_relacion2[]' id='slct_fecha_relacion2"+index+"'></select></td>";
        html+="</tr>";
            
            var dat={estado:1,meta_cuadro_id:data.meta_cuadro_id};
            slctGlobal.listarSlctFuncion('metacuadro','listarfecha1','slct_fecha_relacion2'+index,'simple',[data.relacion_id],dat);
            
    });
    $("#tb_fecha2").html(html);
        initDatePicker();


};

AgregarFecha1 = function(){
  var html='';
          html+="<tr>"+
             "<td>#<input type='hidden' name='f1id[]' id='f1id' value=''></td>"+
            "<td><input type='text' class='datepicker form-control fechaG' id='txt_fecha1' name='txt_fecha1[]' onfocus='blur()' required=''></td>"+
            "<td><input type='text' class='datepicker form-control fechaG' id='txt_fecha1_add' name='txt_fecha1_add[]' onfocus='blur()'></td>"+
            "<td><textarea class='form-control' id='txt_comentario1' name='txt_comentario1[]'></textarea></td>";
        html+="</tr>";
        
  $("#t_fecha1").append(html);initDatePicker();
  
};

AgregarFecha2 = function(meta_cuadro_id){
  var html='';
          html+="<tr>"+
             "<td>#<input type='hidden' name='f2id[]' id='f2id' value=''></td>"+
            "<td><input type='text' class='datepicker form-control fechaG' id='txt_fecha2' name='txt_fecha2[]' onfocus='blur()'></td>"+
            "<td><input type='text' class='datepicker form-control fechaG' id='txt_fecha2_add' name='txt_fecha2_add[]' onfocus='blur()'></td>"+
            "<td><textarea class='form-control' id='txt_comentario2' name='txt_comentario2[]'></textarea></td>"+
            "<td><select class='form-control fecharelacion' name='slct_fecha_relacion2[]' id='slct_fecha_relacion2'></select></td>";
        html+="</tr>";
        var dat={estado:1,meta_cuadro_id:meta_cuadro_id};
            slctGlobal.listarSlctFuncion('metacuadro','listarfecha1','ñ,.fecharelacion','simple',null,dat);
  $("#t_fecha2").append(html);initDatePicker();
  
};

function initDatePicker(){
         $('.fechaG').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });
};
</script>