<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable

var CostoPersonalG={id:0,nombre:"",cantidad:"",estado:1}; // Datos Globales
var EstratPeiG={id:0,descripcion:"",estado:1}; // Datos Globales

    // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
   $("#btn_close").click(Close);
    slctGlobalHtml('form_tipotramites_modal #slct_estado','simple');
    slctGlobalHtml('form_requisitos_modal #slct_estado','simple');
    CargarEstratPei();

    
    $('#requisitoModal').on('show.bs.modal', function (event) { 
        
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Costo Personal');
      $('#form_requisitos_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_requisitos_modal input[type='hidden']").remove();
 
        if(titulo=='Nuevo'){
            //$("#form_requisitos_modal").append("<input type='hidden' value='263' name='txt_contratacion_id'>");
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarCostoPersonal();');
            $('#form_requisitos_modal #slct_estado').val(1);
            $('#form_requisitos_modal #txt_nombre').focus();
           
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarCostoPersonal();');

            $('#form_requisitos_modal #txt_nombre').val( CostoPersonalG.nombre );
            $('#form_requisitos_modal #txt_cantidad').val( CostoPersonalG.cantidad );
            $('#form_requisitos_modal #slct_estado').val( CostoPersonalG.estado );
            $("#form_requisitos_modal").append("<input type='hidden' value='"+CostoPersonalG.id+"' name='id'>");
            
          
        }
             $('#form_requisitos_modal select').multiselect('rebuild');
    });
    
    $('#requisitoModal').on('hide.bs.modal', function (event) {
       $('#requisitoModal :visible').val('');
       $('#requisitoModal textarea').val('');
        $('#requisitoModal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
    $('#tipotramiteModal').on('show.bs.modal', function (event) { 
        
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Estrategia PEI');
      $('#form_tipotramites_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_tipotramites_modal input[type='hidden']").remove();
 
        if(titulo=='Nueva'){
            //$("#form_tipotramites_modal").append("<input type='hidden' value='263' name='txt_contratacion_id'>");
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarEstratPei();');
            $('#form_tipotramites_modal #slct_estado').val(1);
            $('#form_tipotramites_modal #txt_descripcion').focus();
           
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarEstratPei();');

            $('#form_tipotramites_modal #txt_nombre').val( EstratPeiG.descripcion );
            $('#form_tipotramites_modal #slct_estado').val( EstratPeiG.estado );
            $("#form_tipotramites_modal").append("<input type='hidden' value='"+EstratPeiG.id+"' name='id'>");
            
          
        }
             $('#form_tipotramites_modal select').multiselect('rebuild');
    });
    
    $('#tipotramiteModal').on('hide.bs.modal', function (event) {
       $('#tipotramiteModal :visible').val('');
        $('#tipotramiteModal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
    
});



desactivarCostoPersonal = function(id){
      Pois.CambiarEstadoCostoPersonal(id, 0); 
};

activarCostoPersonal = function(id){
      Pois.CambiarEstadoCostoPersonal(id, 1);   
};

desactivarEstratPei = function(id){
      Pois.CambiarEstadoEstratPei(id, 0); 
};

activarEstratPei = function(id){
      Pois.CambiarEstadoEstratPei(id, 1);   
};

Editar = function(){
    if(validaContrataciones()){
        Pois.AgregarEditarPois(1);
        $("#form_costo_personal .form-group").css("display","none");
    }
};
Agregar = function(){
    if(validaContrataciones()){
       Pois.AgregarEditarPois(0);
       $("#form_costo_personal .form-group").css("display","none");
    }
};

validaContrataciones = function(){
    var r=true;

        if( $("#form_pois_modal #txt_objetivo_general").val()=='' ){
            alert("Ingrese Objetivo General");
            r=false;
        }
        if( $("#form_pois_modal #slct_area").val()=='' ){
            alert("Seleccione Área");
            r=false;
        }


    return r;
};

CargarCostoPersonal=function(id,titulo,boton){
    
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    
    $("#form_requisitos_modal #txt_poi_id").val(id);
    $("#form_costo_personal #txt_titulo").text(titulo);
    $("#form_costo_personal .form-group").css("display","");
    
    data={id:id};
    Pois.CargarCostoPersonal(data);
};

CargarActividad=function(id,titulo,boton){
    
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    
    $("#form_actividad_modal #txt_poi_id").val(id);
    $("#form_actividad #txt_titulo").text(titulo);
    $("#form_actividad .form-group").css("display","");
    
    $("#form_costo_personal .form-group").css("display","none");
    data={id:id};
    Pois.CargarActividad(data);
};

CargarEstratPei=function(){

    Pois.CargarEstratPei();
};


costopersonalHTML=function(datos){
  var html="";
    var alerta_tipo= '';
    $('#t_costo_personal').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
             "<td>"+pos+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.cantidad+"</td>";
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#requisitoModal' data-titulo='Editar' onclick='BtnEditarCostoPersonal(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
        if(data.estado==1){
            html+='<td align="center"><span id="'+data.id+'" onClick="desactivarCostoPersonal('+data.id+')" data-estado="'+data.estado+'" class="btn btn-success">Activo</span></td>';
        }
        else {
           html+='<td align="center"><span id="'+data.id+'" onClick="activarCostoPersonal('+data.id+')" data-estado="'+data.estado+'" class="btn btn-danger">Inactivo</span></td>';

        }

        html+="</tr>";
    });
    $("#tb_costo_personal").html(html);
    $("#t_costo_personal").dataTable(
    ); 


};

estratpeiHTML=function(datos){
  var html="";
    var alerta_tipo= '';
    $('#t_estrat_pei').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
             "<td>"+pos+"</td>"+
            "<td>"+data.nombre+"</td>";
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#tipotramiteModal' data-titulo='Editar' onclick='BtnEditarEstratPei(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
        if(data.estado==1){
            html+='<td align="center"><span id="'+data.id+'" onClick="desactivarEstratPei('+data.id+')" data-estado="'+data.estado+'" class="btn btn-success">Activo</span></td>';
        }
        else {
           html+='<td align="center"><span id="'+data.id+'" onClick="activarEstratPei('+data.id+')" data-estado="'+data.estado+'" class="btn btn-danger">Inactivo</span></td>';

        }

        html+="</tr>";
    });
    $("#tb_estrat_pei").html(html);
    $("#t_estrat_pei").dataTable(
    ); 


};


eventoSlctGlobalSimple=function(){
};

BtnEditarCostoPersonal=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    CostoPersonalG.id=id;
    CostoPersonalG.nombre=$(tr).find("td:eq(1)").text();
    CostoPersonalG.cantidad=$(tr).find("td:eq(2)").text();
    CostoPersonalG.estado=$(tr).find("td:eq(4)>span").attr("data-estado");

};


BtnEditarEstratPei=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    EstratPeiG.id=id;
    EstratPeiG.descripcion=$(tr).find("td:eq(1)").text();
    EstratPeiG.estado=$(tr).find("td:eq(3)>span").attr("data-estado");

};

validaCostoPersonal = function(){
    var r=true;
    if( $("#form_requisitos_modal #txt_modalidad").val()=='' ){
        alert("Ingrese Modalidad");
        r=false;
    }
    return r;
};
EditarCostoPersonal = function(){
    if(validaCostoPersonal()){
        Pois.AgregarEditarCostoPersonal(1);
    }
};
AgregarCostoPersonal = function(){
    if(validaCostoPersonal()){
        Pois.AgregarEditarCostoPersonal(0);
    }
};


EditarEstratPei = function(){
    if(validaEstratPei()){
        Pois.AgregarEditarEstratPei(1);
    }
};
AgregarEstratPei = function(){
    if(validaEstratPei()){
        Pois.AgregarEditarEstratPei(0);
    }
};

validaEstratPei = function(){
    var r=true;
    if( $("#form_tipotramites_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre");
        r=false;
    }
    return r;
};


Close=function(){
    $("#form_costo_personal .form-group").css("display","none");
}



</script>