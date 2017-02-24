<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var PoiG={id:0,objetivo_general:"",anio:"",tipo_organo:"",centro_apoyo:"",meta_siaf:"",unidad_medida:"",cantidad_programada_semestral:"",cantidad_programada_anual:"",linea_estrategica_pdlc:"",estado:1,area:""}; // Datos Globales
var CostoPersonalG={id:0,rol:"",modalidad:"",monto:"",estimacion:"",essalud:"",subtotal:"",estado:1}; // Datos Globales
var ActividadG={id:0,poi_estrat_pei:"",orden:"",actividad:"",unidad_medida:"",indicador_cumplimiento:"",estado:1}; // Datos Globales
var EstratPeiG={id:0,descripcion:"",estado:1}; // Datos Globales

    // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
   $("#btn_close").click(Close);
   $("[data-toggle='offcanvas']").click();
    var datos={estado:1};
    slctGlobal.listarSlct('rol','slct_rol','simple',null,datos);
    slctGlobalHtml('form_costo_personal_modal #slct_estado','simple');
    slctGlobal.listarSlct('area','slct_area','simple',null,datos);
    slctGlobalHtml('form_pois_modal #slct_estado','simple');
    slctGlobalHtml('form_estrat_pei_modal #slct_estado','simple');
    slctGlobal.listarSlctFuncion('poi','listarsestratpei','slct_poi_estrat_pei','simple',null,datos);
    slctGlobalHtml('form_actividad_modal #slct_estado','simple'); 
    
    var idG={   objetivo_general        :'onBlur|Objetivo General|#DCE6F1', //#DCE6F1
                ano        :'onBlur|Año|#DCE6F1', //#DCE6F1
                tipo_organo        :'onBlur|Tipo de Órgano|#DCE6F1', //#DCE6F1
                centro_apoyo        :'onBlur|Centro de Apoyo|#DCE6F1', //#DCE6F1
                meta_siaf        :'onBlur|Meta SIAF|#DCE6F1', //#DCE6F1
                unidad_medida        :'onBlur|Unidad de Medida|#DCE6F1', //#DCE6F1
                cantidad_programada_semestral        :'onBlur|Cantidad Programada Semestral|#DCE6F1', //#DCE6F1
                cantidad_programada_anual        :'onBlur|Cantidad Programada Anual|#DCE6F1', //#DCE6F1
                linea_estrategica_pdlc        :'onBlur|Linea Estratégica PDLC|#DCE6F1', //#DCE6F1
                area          :'3|Área |#DCE6F1',
                estado        :'1|Estado|#DCE6F1', //#DCE6F1
                Grupo          :'1|  |#DCE6F1',
                a          :'1|  |#DCE6F1',
                b          :'1|  |#DCE6F1',
                c          :'1|  |#DCE6F1',
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'pois','t_pois');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
//    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_contrataciones','fa-edit');
//    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
//    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('pois');
     $('.fecha').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });

    $('#poiModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' POI');
      $('#form_pois_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_pois_modal input[type='hidden']").remove();
        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_pois_modal #slct_estado').val(1);
            $('#form_pois_modal #txt_objetivo_general').focus();
            
        } else {
             modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_pois_modal #txt_objetivo_general').val( PoiG.objetivo_general );
            $('#form_pois_modal #txt_anio').val( PoiG.anio );
            $('#form_pois_modal #txt_tipo_organo').val( PoiG.tipo_organo );
            $('#form_pois_modal #txt_centro_apoyo').val( PoiG.centro_apoyo );
            $('#form_pois_modal #txt_meta_siaf').val( PoiG.meta_siaf );
            $('#form_pois_modal #txt_unidad_medida').val( PoiG.unidad_medida );
            $('#form_pois_modal #txt_cp_semestral').val( PoiG.cp_semestral );
            $('#form_pois_modal #txt_cp_anual').val( PoiG.cp_anual );
            $('#form_pois_modal #txt_linea_estrat').val( PoiG.linea_estrat );
            $('#form_pois_modal #slct_estado').val( PoiG.estado );
            $("#form_pois_modal").append("<input type='hidden' value='"+PoiG.id+"' name='id'>");
            $('#form_pois_modal #slct_area').val( PoiG.area );
            //slctGlobal.listarSlctFijo('area','slct_area',PoiG.area);
        }
             $('#form_pois_modal select').multiselect('rebuild');
    });

    $('#poiModal').on('hide.bs.modal', function (event) {
       $('#form_pois_modal input').val('');
       $('#form_pois_modal textarea').val('');
       $('#form_pois_modal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
    $('#costopersonalModal').on('show.bs.modal', function (event) { 
        
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Costo Personal');
      $('#form_costo_personal_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_costo_personal_modal input[type='hidden']").remove();
 
        if(titulo=='Nuevo'){
            //$("#form_costo_personal_modal").append("<input type='hidden' value='263' name='txt_contratacion_id'>");
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarCostoPersonal();');
            $('#form_costo_personal_modal #slct_estado').val(1);
            $('#form_costo_personal_modal #txt_modalidad').focus();
           
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarCostoPersonal();');

            $('#form_costo_personal_modal #txt_modalidad').val( CostoPersonalG.modalidad );
            $('#form_costo_personal_modal #slct_rol').val( CostoPersonalG.rol );
            $('#form_costo_personal_modal #txt_monto').val( CostoPersonalG.monto );
            $('#form_costo_personal_modal #txt_estimacion').val( CostoPersonalG.estimacion );
            $('#form_costo_personal_modal #txt_essalud').val( CostoPersonalG.essalud );
            $('#form_costo_personal_modal #txt_subtotal').val( CostoPersonalG.subtotal );
            $('#form_costo_personal_modal #slct_estado').val( CostoPersonalG.estado );
            $("#form_costo_personal_modal").append("<input type='hidden' value='"+CostoPersonalG.id+"' name='id'>");
            
          
        }
             $('#form_costo_personal_modal select').multiselect('rebuild');
    });
    
    $('#costopersonalModal').on('hide.bs.modal', function (event) {
       $('#costopersonalModal :visible').val('');
       $('#costopersonalModal textarea').val('');
        $('#costopersonalModal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
    $('#estratpeiModal').on('show.bs.modal', function (event) { 
        
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Estrategia PEI');
      $('#form_estrat_pei_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_estrat_pei_modal input[type='hidden']").remove();
 
        if(titulo=='Nueva'){
            //$("#form_estrat_pei_modal").append("<input type='hidden' value='263' name='txt_contratacion_id'>");
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarEstratPei();');
            $('#form_estrat_pei_modal #slct_estado').val(1);
            $('#form_estrat_pei_modal #txt_descripcion').focus();
           
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarEstratPei();');

            $('#form_estrat_pei_modal #txt_descripcion').val( EstratPeiG.descripcion );
            $('#form_estrat_pei_modal #slct_estado').val( EstratPeiG.estado );
            $("#form_estrat_pei_modal").append("<input type='hidden' value='"+EstratPeiG.id+"' name='id'>");
            
          
        }
             $('#form_estrat_pei_modal select').multiselect('rebuild');
    });
    
    $('#estratpeiModal').on('hide.bs.modal', function (event) {
       $('#estratpeiModal :visible').val('');
       $('#estratpeiModal textarea').val('');
        $('#estratpeiModal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
    $('#actividadModal').on('show.bs.modal', function (event) { 
        
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Actividad');
      $('#form_actividad_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_costo_personal_modal input[type='hidden']").remove();
 
        if(titulo=='Nueva'){
            //$("#form_actividad_modal").append("<input type='hidden' value='263' name='txt_contratacion_id'>");
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarActividad();');
            $('#form_actividad_modal #slct_estado').val(1);
            $('#form_actividad_modal #txt_actividad').focus();
           
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarActividad();');
            
            $('#form_actividad_modal #slct_poi_estrat_pei').val( ActividadG.poi_estrat_pei );
            $('#form_actividad_modal #txt_orden').val( ActividadG.orden );
            $('#form_actividad_modal #txt_actividad').val( ActividadG.actividad );
            $('#form_actividad_modal #txt_unidad_medida').val( ActividadG.unidad_medida );
            $('#form_actividad_modal #txt_indicador_cumplimiento').val( ActividadG.indicador_cumplimiento );
            $('#form_actividad_modal #slct_estado').val( ActividadG.estado );
            $("#form_actividad_modal").append("<input type='hidden' value='"+ActividadG.id+"' name='id'>");
            
          
        }
             $('#form_actividad_modal select').multiselect('rebuild');
    });
    
    $('#actividadModal').on('hide.bs.modal', function (event) {
       $('#actividadModal :visible').val('');
       $('#actividadModal textarea').val('');
        $('#actividadModal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    PoiG.id=id;
    PoiG.objetivo_general=$(tr).find("td:eq(0)").text();
    PoiG.anio=$(tr).find("td:eq(1)").text();
    PoiG.tipo_organo=$(tr).find("td:eq(2)").text();
    PoiG.centro_apoyo=$(tr).find("td:eq(3)").text();
    PoiG.meta_siaf=$(tr).find("td:eq(4)").text();
    PoiG.unidad_medida=$(tr).find("td:eq(5)").text();
    PoiG.cp_semestral=$(tr).find("td:eq(6)").text();
    PoiG.cp_anual=$(tr).find("td:eq(7)").text();
    PoiG.linea_estrat=$(tr).find("td:eq(8)").text();
    PoiG.area=$(tr).find("td:eq(9) input[name='txt_area']").val();
    PoiG.estado=$(tr).find("td:eq(10)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="pois" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'poi','cargar',columnDefsG);
            $("#form_detalle_contrataciones .form-group").css("display","none");
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn 
      if(typeof(fn)!='undefined' && fn.col==9){
        return row.area+"<input type='hidden'name='txt_area' value='"+row.area_id+"'>";
    }
    if(typeof(fn)!='undefined' && fn.col==11){
        var grupo='';
        grupo+= '<a class="form-control btn btn-primary" onclick="BtnEditar(this,'+row.id+')"><i class="fa fa-lg fa-edit"></i></a><br>';
        return grupo;
   }
   
   if(typeof(fn)!='undefined' && fn.col==12){
        var grupo='';
        grupo+= '<span id="'+row.id+'" title="Costo Personal" onClick="CargarCostoPersonal(\''+row.id+'\',\''+row.objetivo_general+'\',this)" data-estado="'+row.estado+'" class="btn btn-info"><i class="glyphicon glyphicon-user"></i></span>';
        return grupo;
   }
   
   if(typeof(fn)!='undefined' && fn.col==13){
        var grupo='';
        grupo+= '<span id="'+row.id+'" title="Estrategia PEI" onClick="CargarEstratPei(\''+row.id+'\',\''+row.objetivo_general+'\',this)" data-estado="'+row.estado+'" class="btn btn-info"><i class="glyphicon glyphicon-ok"></i></span>';
        return grupo;
   }
   
      if(typeof(fn)!='undefined' && fn.col==14){
        var grupo='';
        grupo+= '<span id="'+row.id+'" title="Actividad" onClick="CargarActividad(\''+row.id+'\',\''+row.objetivo_general+'\',this)" data-estado="'+row.estado+'" class="btn btn-info"><i class="glyphicon glyphicon-list-alt"></i></span>';
        return grupo;
   }

    if(typeof(fn)!='undefined' && fn.col==10){
         var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
};

activarTabla=function(){
    $("#t_contrataciones").dataTable(); // inicializo el datatable    
};

desactivar = function(id){
 
      Pois.CambiarEstadoPois(id, 0);
      $("#form_costo_personal .form-group").css("display","none");
   
};

activar = function(id){
 
      Pois.CambiarEstadoPois(id, 1);
      $("#form_costo_personal .form-group").css("display","none");
   
};

desactivarCostoPersonal = function(id){
      Pois.CambiarEstadoCostoPersonal(id, 0); 
};

activarCostoPersonal = function(id){
      Pois.CambiarEstadoCostoPersonal(id, 1);   
};

desactivarActividad = function(id){
      Pois.CambiarEstadoActividad(id, 0); 
};

activarActividad = function(id){
      Pois.CambiarEstadoActividad(id, 1);   
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
    
    $("#form_costo_personal_modal #txt_poi_id").val(id);
    $("#form_costo_personal #txt_titulo").text(titulo);
    $("#form_costo_personal .form-group").css("display","");
    
    $("#form_estrat_pei .form-group").css("display","none");
    $("#form_actividad .form-group").css("display","none");
    data={id:id};
    Pois.CargarCostoPersonal(data);
};

CargarEstratPei=function(id,titulo,boton){
    
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    
    $("#form_estrat_pei_modal #txt_poi_id").val(id);
    $("#form_estrat_pei #txt_titulo").text(titulo);
    $("#form_estrat_pei .form-group").css("display","");
    
    $("#form_costo_personal .form-group").css("display","none");
    $("#form_actividad .form-group").css("display","none");
    data={id:id};
    Pois.CargarEstratPei(data);
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
    $("#form_estrat_pei .form-group").css("display","none");
    data={id:id};
    Pois.CargarActividad(data);
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
            "<td>"+data.rol+"<input type='hidden'name='txt_rol' value='"+data.rol_id+"'></td>"+
            "<td>"+data.modalidad+"</td>"+
            "<td>"+data.monto+"</td>"+
            "<td>"+data.estimacion+"</td>"+
            "<td>"+data.essalud+"</td>"+
            "<td>"+data.subtotal+"</td>";
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#costopersonalModal' data-titulo='Editar' onclick='BtnEditarCostoPersonal(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
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
            "<td>"+data.descripcion+"</td>";
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#estratpeiModal' data-titulo='Editar' onclick='BtnEditarEstratPei(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
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

actividadHTML=function(datos){
  var html="";
    var alerta_tipo= '';
    $('#t_actividad').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
              "<td>"+pos+"</td>"+
              "<td>"+data.estrat_pei+"<input type='hidden'name='txt_poi_estrat_pei' value='"+data.poi_estrat_pei_id+"'></td>"+
              "<td>"+data.orden+"</td>"+
              "<td>"+data.actividad+"</td>"+
              "<td>"+data.unidad_medida+"</td>"+
              "<td>"+data.indicador_cumplimiento+"</td>";
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#actividadModal' data-titulo='Editar' onclick='BtnEditarActividad(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
        if(data.estado==1){
            html+='<td align="center"><span id="'+data.id+'" onClick="desactivarActividad('+data.id+')" data-estado="'+data.estado+'" class="btn btn-success">Activo</span></td>';
        }
        else {
           html+='<td align="center"><span id="'+data.id+'" onClick="activarActividad('+data.id+')" data-estado="'+data.estado+'" class="btn btn-danger">Inactivo</span></td>';

        }

        html+="</tr>";
    });
    $("#tb_actividad").html(html);
    $("#t_actividad").dataTable(
    ); 


};

eventoSlctGlobalSimple=function(){
};

BtnEditarCostoPersonal=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    CostoPersonalG.id=id;
    CostoPersonalG.rol=$(tr).find("td:eq(1) input[name='txt_rol']").val();
    CostoPersonalG.modalidad=$(tr).find("td:eq(2)").text();
    CostoPersonalG.monto=$(tr).find("td:eq(3)").text();
    CostoPersonalG.estimacion=$(tr).find("td:eq(4)").text();
    CostoPersonalG.essalud=$(tr).find("td:eq(5)").text();
    CostoPersonalG.subtotal=$(tr).find("td:eq(6)").text();
    CostoPersonalG.estado=$(tr).find("td:eq(8)>span").attr("data-estado");

};

BtnEditarActividad=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    ActividadG.id=id;
    ActividadG.poi_estrat_pei=$(tr).find("td:eq(1) input[name='txt_poi_estrat_pei']").val();
    ActividadG.orden=$(tr).find("td:eq(2)").text();
    ActividadG.actividad=$(tr).find("td:eq(3)").text();
    ActividadG.unidad_medida=$(tr).find("td:eq(4)").text();
    ActividadG.indicador_cumplimiento=$(tr).find("td:eq(5)").text();
    ActividadG.estado=$(tr).find("td:eq(7)>span").attr("data-estado");

};


BtnEditarEstratPei=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    EstratPeiG.id=id;
    EstratPeiG.descripcion=$(tr).find("td:eq(1)").text();
    EstratPeiG.estado=$(tr).find("td:eq(3)>span").attr("data-estado");

};

validaCostoPersonal = function(){
    var r=true;
    if( $("#form_costo_personal_modal #txt_modalidad").val()=='' ){
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

EditarActividad = function(){
    if(validaActividad()){
        Pois.AgregarEditarActividad(1);
    }
};
AgregarActividad = function(){
    if(validaActividad()){
        Pois.AgregarEditarActividad(0);
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
    if( $("#form_estrat_pei_modal #txt_descripcion").val()=='' ){
        alert("Ingrese Descripción");
        r=false;
    }
    return r;
};

validaActividad = function(){
    var r=true;
    if( $("#form_actividad_modal #txt_actividad").val()=='' ){
        alert("Ingrese Actividad");
        r=false;
    }
    return r;
};

Close=function(){
    $("#form_costo_personal .form-group").css("display","none");
}



</script>