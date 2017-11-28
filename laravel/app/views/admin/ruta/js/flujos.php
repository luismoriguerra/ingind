<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var FlujosG={
        id:0,
        nombre:"",
        categoria:"",
        area:"",
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
        tipo_flujo_persona
        estado
    */

    var data={estado:1}; 
     slctGlobal.listarSlctFuncion('categoria','listarc','slct_categoria_id','simple',null,data);
     data={estado:1,areapersona:1}; 
    slctGlobal.listarSlctFuncion('area','listara','slct_area_id','simple',null,data);
   
   
    slctGlobalHtml('slct_tipo_flujo,#slct_estado','simple');

    var idG={   nombre       :'onBlur|Nombre|#DCE6F1', //#DCE6F1
                categoria    :'3|Categoria|#DCE6F1', 
                area         :'3|Área|#DCE6F1',      
                tipo_flujo   :'3|Tipo Flujo|#DCE6F1',           
                estado       :'2|Estado|#DCE6F1', //#DCE6F1
               
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'flujos','t_flujos');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores

//CON ESTO DESAPARECE EL BOTON EDITAR
  //  var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_flujos','fa-edit');

    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('flujos');



/*
    Flujos.CargarFlujos(htmlCargarFlujos);
    Flujos.ListarAreas('slct_area_id');

    Flujos.ListarCategorias('slct_categoria_id');

*/



    $('#flujoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Proceso');
      $('#form_flujos_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_flujos_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');

            //ver porque no pide categoria
            $('#form_flujos_modal #slct_estado').val(1); 
            $('#form_flujos_modal #slct_tipo_flujo').val('');

            Flujos.ObtenerRolUser();
            //$('#form_flujos_modal #slct_categoria_id').val('');
            
            $('#form_flujos_modal #slct_area_id').val(""); 
            $('#form_flujos_modal #txt_nombre').focus();
        }
        else{

            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_flujos_modal #txt_nombre').val( FlujosG.nombre );            
            $('#form_flujos_modal #slct_categoria_id').val( FlujosG.categoria );   
            $('#form_flujos_modal #slct_area_id').val( FlujosG.area );                   
            $('#form_flujos_modal #slct_tipo_flujo').val( FlujosG.tipo_flujo ); 
            $('#form_flujos_modal #slct_estado').val( FlujosG.estado );
            $("#form_flujos_modal").append("<input type='hidden' value='"+FlujosG.id+"' name='id'>");
 
        }
         $('#form_flujos_modal select').multiselect('rebuild');

    });

    $('#flujoModal').on('hide.bs.modal', function (event) {
        $('#form_flujos_modal input').val('');
        $('#form_flujos_modal #slct_categoria_id,#form_flujos_modal #slct_area_id,#form_flujos_modal #slct_tipo_flujo').val('');
/*
    $('#flujoModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto*/
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    FlujosG.id=id;
    FlujosG.nombre=$(tr).find("td:eq(0)").text();    
    FlujosG.categoria=$(tr).find("td:eq(1) input[name='txt_categoria']").val(); 
    FlujosG.area=$(tr).find("td:eq(2) input[name='txt_area']").val();   
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
        return row.categoria+"<input type='hidden'name='txt_categoria' value='"+row.categoria_id+"'>";
    }
    else if(typeof(fn)!='undefined' && fn.col==2){
        return row.area+"<input type='hidden'name='txt_area' value='"+row.area_id+"'>";
    }
    else if(typeof(fn)!='undefined' && fn.col==3){
        return row.tipo_flujo+"<input type='hidden'name='txt_tipo_flujo' value='"+row.tipo_flujo_id+"'>";
    }
    
    else if(typeof(fn)!='undefined' && fn.col==4){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" o data-estado="'+row.estado+'" class="">Inactivo</span>';
       if(row.estado==1){
            estadohtml='<span id="'+row.id+'"  data-estado="'+row.estado+'" class="">Activo</span>';
        }
        return estadohtml;
    }
    /*     else if(typeof(fn)!='undefined' && fn.col==4){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
       if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }*/
}


activarTabla=function(){
    $("#t_flujos").dataTable(); // inicializo el datatable    
};

activar=function(id){
    Flujos.CambiarEstadoFlujos(id,1);
};
desactivar=function(id){
    Flujos.CambiarEstadoFlujos(id,0);
};

Editar=function(){
    if(validaFlujos()){
        Flujos.AgregarEditarFlujos(1);
    }
};
Agregar=function(){
    if(validaFlujos()){
        Flujos.AgregarEditarFlujos(0);
    }
};

htmlCargarFlujos=function(obj){
    var html="";
    var estadohtml="";
    $('#t_flujos').dataTable().fnDestroy();
    if(obj.rst==1){
        $.each(obj.data,function(index,data){
            estadohtml='Inactivo';
            if(data.estado==1){
                estadohtml='Activo';
            }

            html+="<tr>"+
                "<td id='nombre_"+data.id+"'>"+data.nombre+"</td>"+
                "<td id='categoria_"+data.id+"' data-categoria='"+data.categoria_id+"'>"+data.categoria+"</td>"+
                "<td id='area_"+data.id+"' data-area='"+data.area_id+"'>"+data.area+"</td>"+
                "<td id='tipo_"+data.id+"' data-tipo='"+data.tipo_flujo_id+"'>"+data.tipo_flujo+"</td>"+
                "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                '<td> &nbsp; </td>';

            html+="</tr>";
        });                    
    }      
    $("#tb_flujos").html(html); 
    $("#t_flujos").dataTable();
}


/*
validaFlujos=function(){
    $('#form_flujos_modal [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","nombre","");
    a[1]=true;
    a[2]=true;

    if($("#slct_categoria_id").val()==""){
        a[2]=false;
        $('#error_categoria').attr('data-original-title','Seleccione Categoria');
        $('#error_categoria').css('display','');
    }
    if($("#slct_area_id").val()==""){
        a[1]=false;
        $('#error_area').attr('data-original-title','Seleccione Area');
        $('#error_area').css('display','');
    }

    if($("#slct_tipo_flujo").val()==""){
        a[2]=false;
        $('#error_tipo_flujo').attr('data-original-title','Seleccione Tipo');
        $('#error_tipo_flujo').css('display','');
    }
    var rpta=true;

    for(i=0;i<a.length;i++){
        if(a[i]===false){
            rpta=false;
            break;
        }
    }
    return rpta;
};

valida=function(inicial,id,v_default){
    var texto="Seleccione";
    if(inicial=="txt"){
        texto="Ingrese";
    }

    if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
        $('#error_'+id).attr('data-original-title',texto+' '+id);
        $('#error_'+id).css('display','');
        return false;
    }   
};*/
validaFlujos = function(){
    var r=true;

   if( $("#form_flujos_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre");
        r=false;
    }
    
    else if( $("#form_flujos_modal #slct_categoria_id").val()=='' ){
        alert("Seleccione Categoria");
        r=false;
    }
    else if( $("#form_flujos_modal #slct_area_id").val()=='' ){
        alert("Seleccione Área");
        r=false;
    }
    else if( $("#form_flujos_modal #slct_tipo_flujo").val()=='' ){
        alert("Seleccione Tipo");
        r=false;
    }

    
    return r;
};
</script>
