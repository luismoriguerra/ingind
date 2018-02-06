<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var PersonasG={
        id:0,
        paterno:"",
        materno:"",
        nombre:"",
        dni:"",
        sexo:"",
        email:"",
        email_mdi:"",
        fecha_nacimiento:"",
        password:"",
        area:"",     
        rol:"",
        modalidad:"",
        vista_doc:"",
        estado:1
        };

$(document).ready(function() {  
    
      
        var idG={   paterno       :'onBlur|Apellido Paterno|#DCE6F1', //#DCE6F1
                materno       :'onBlur|Apellido Materno|#DCE6F1', //#DCE6F1
                nombre        :'onBlur|Nombre|#DCE6F1', //#DCE6F1
                dni           :'onBlur|DNI|#DCE6F1', //#DCE6F1
                sexo          :'3|Tipo de Sexo|#DCE6F1', //#DCE6F1
                email         :'onBlur|Email|#DCE6F1', //#DCE6F1
                email_mdi         :'onBlur|Email MDI|#DCE6F1', //#DCE6F1
              //  password      :'onBlur|Password|#DCE6F1', //#DCE6F1
                area          :'3|Área de la Persona|#DCE6F1', 
                rol           :'3|Rol de la Persona|#DCE6F1', //#DCE6F1
                modalidad     :'3|Modalidad|#DCE6F1', //#DCE6F1
                vista_doc     :'3|Vista Documento|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'persona','t_persona');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_persona','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('persona');

    $('#personaModal').on('show.bs.modal', function (event) {
        
        $('#txt_fecha_nacimiento').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });

        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        //var persona_id = button.data('id'); //extrae el id del atributo data

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Persona');
        $('#form_personas_modal [data-toggle="tooltip"]').css("display","none");
        $("#form_personas_modal input[type='hidden']").remove();
        slctGlobal.listarSlct('cargo','slct_cargos','simple');
        
        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_personas_modal #txt_nombre').focus();
            var datos={estado:1};
            slctGlobal.listarSlct('area','slct_area','simple',null,datos);
            slctGlobal.listarSlct('rol','slct_rol','simple',null,datos);
        }
        else{


            Persona.CargarAreas(PersonasG.id); //no es multiselect
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            //PersonasG
            $('#form_personas_modal #txt_paterno').val( PersonasG.paterno );
            $('#form_personas_modal #txt_materno').val( PersonasG.materno );
            $('#form_personas_modal #txt_nombre').val( PersonasG.nombre );
            $('#form_personas_modal #txt_dni').val( PersonasG.dni );
            $('#form_personas_modal #slct_sexo').val( PersonasG.sexo );
            $('#form_personas_modal #txt_email').val( PersonasG.email );
            $('#form_personas_modal #txt_email_mdi').val( PersonasG.email_mdi );
            $('#form_personas_modal #txt_fecha_nacimiento').val( PersonasG.fecha_nacimiento );
            $('#form_personas_modal #txt_password').val( '' );
            $('#form_personas_modal #slct_modalidad').val( PersonasG.modalidad );
            $('#form_personas_modal #slct_vista_doc').val( PersonasG.vista_doc );
            

            $('#form_personas_modal #slct_estado').val( PersonasG.estado );
            $("#form_personas_modal").append("<input type='hidden' value='"+PersonasG.id+"' name='id'>");

            var datos={estado:1};
            //var idsarea=[]; idsarea.push(PersonasG.area_id);
            //var idsrol=[]; idsrol.push(PersonasG.rol_id);
            //slctGlobal.listarSlct('area','slct_area','simple',idsarea,datos);
            
            slctGlobal.listarSlct('area','slct_area','simple',PersonasG.area,datos);
         //   alert(PersonasG.fecha_nacimiento_id);
            //slctGlobal.listarSlct('rol','slct_rol','simple',idsrol,datos);
            
            slctGlobal.listarSlctFijo('rol','slct_rol',PersonasG.rol);
        }
        $( "#form_personas_modal #slct_estado" ).trigger('change');
        $( "#form_personas_modal #slct_estado" ).change(function() {
            if ($( "#form_personas_modal #slct_estado" ).val()==1) {
                $('#f_areas_cargo').removeAttr('disabled');
            }
            else {
                $('#f_areas_cargo').attr('disabled', 'disabled');
            }
        });
    });

    $('#personaModal').on('hide.bs.modal', function (event) {
        var modal = $(this); //captura el modal
        modal.find('.modal-body input').val(''); // busca un input para copiarle texto
        $('#slct_cargos,#slct_rol,#slct_area').multiselect('destroy');
        $("#t_cargoPersona").html('');
    });
});
BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    PersonasG.id=id;
    PersonasG.paterno=$(tr).find("td:eq(0)").text();
    PersonasG.materno=$(tr).find("td:eq(1)").text();
    PersonasG.nombre=$(tr).find("td:eq(2)").text();
    PersonasG.dni=$(tr).find("td:eq(3)").text();
    PersonasG.sexo=$(tr).find("td:eq(4) input[name='txt_sexo']").val();
    PersonasG.email=$(tr).find("td:eq(5)").text();
    PersonasG.email_mdi=$(tr).find("td:eq(6)").text();
    // se detecta el atributo que se esta enviando atravez del hiden del txt_sexo
    PersonasG.fecha_nacimiento=$(tr).find("td:eq(4) input[name='txt_sexo']").attr('fecha_nacimiento'); 
      //PersonasG.password=$(tr).find("td:eq(6) input[name='txt_password']").val();
    PersonasG.area=$(tr).find("td:eq(7) input[name='txt_area']").val();   
    PersonasG.rol=$(tr).find("td:eq(8) input[name='txt_rol']").val();
    PersonasG.modalidad=$(tr).find("td:eq(9) input[name='txt_modalidad']").val(); 
    PersonasG.vista_doc=$(tr).find("td:eq(10) input[name='txt_vista_doc']").val(); 
    
    PersonasG.estado=$(tr).find("td:eq(11)>span").attr("data-estado");
    $("#BtnEditar").click();
};

MostrarAjax=function(t){
    if( t=="persona" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'persona','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}
GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    
    if(typeof(fn)!='undefined' && fn.col==4){
        //se envia de manera ocultada la fecha de nacimiento en el txt_sexo
        return row.sexo+"<input type='hidden'name='txt_sexo' fecha_nacimiento='"+row.fecha_nacimiento+"' value='"+row.sexo_id+"'>";
    }


    else if(typeof(fn)!='undefined' && fn.col==7){
        return row.area+"<input type='hidden'name='txt_area' value='"+row.area_id+"'>";
    }

    else if(typeof(fn)!='undefined' && fn.col==8){
        return row.rol+"<input type='hidden'name='txt_rol' value='"+row.rol_id+"'>";
    }

    if(typeof(fn)!='undefined' && fn.col==9){
        return row.modalidad+"<input type='hidden'name='txt_modalidad' value='"+row.modalidad_id+"'>";
    }

    if(typeof(fn)!='undefined' && fn.col==10){
        return row.vista_doc+"<input type='hidden'name='txt_vista_doc' value='"+row.vista_doc_id+"'>";
    }

    else if(typeof(fn)!='undefined' && fn.col==11){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

eventoSlctGlobalSimple=function(){
}

activarTabla=function(){
    $("#t_personas").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaPersonas()){
        Persona.AgregarEditarPersona(1);
    }
};

activar=function(id){
    Persona.CambiarEstadoPersonas(id,1);
};
desactivar=function(id){
    Persona.CambiarEstadoPersonas(id,0);
};

Agregar=function(){
    if(validaPersonas()){
        Persona.AgregarEditarPersona(0);
    }
};
AgregarArea=function(){
    //añadir registro "opcion" por usuario
    var cargo_id=$('#slct_cargos option:selected').val();
    var cargo=$('#slct_cargos option:selected').text();
    var buscar_cargo = $('#cargo_'+cargo_id).text();
    if (cargo_id!=='') {
        if (buscar_cargo==="") {

            var html='';
            html+="<li class='list-group-item'><div class='row'>";
            html+="<div class='col-sm-4' id='cargo_"+cargo_id+"'><h5>"+cargo+"</h5></div>";

            html+="<div class='col-sm-6'>";
            html+="<select class='form-control' multiple='multiple' name='slct_areas"+cargo_id+"[]' id='slct_areas"+cargo_id+"'></select></div>";
            var envio = {cargo_id: cargo_id,estado:1};

            html+='<div class="col-sm-2">';
            html+='<button type="button" id="'+cargo_id+'" Onclick="EliminarArea(this)" class="btn btn-danger btn-sm" >';
            html+='<i class="fa fa-minus fa-sm"></i> </button></div>';
            html+="</div></li>";

            $("#t_cargoPersona").append(html);
            slctGlobal.listarSlct('area','slct_areas'+cargo_id,'multiple',null,envio);
            cargos_selec.push(cargo_id);
        } else 
            alert("Ya se agrego este Cargo");
    } else 
        alert("Seleccione Cargo");

};
EliminarArea=function(obj){
    //console.log(obj);
    var valor= obj.id;
    obj.parentNode.parentNode.parentNode.remove();
    var index = cargos_selec.indexOf(valor);
    cargos_selec.splice( index, 1 );
};
validaPersonas=function(){
 /*   $('#form_personas_modal [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","nombre","");
    var rpta=true;

    for(i=0;i<a.length;i++){
        if(a[i]===false){
            rpta=false;
            break;
        }
    }
    return rpta;*/
    var r=true;
    if( $("#form_personas_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre");
        r=false;
    }
    else if( $("#form_personas_modal #txt_paterno").val()==''){
        alert("Ingrese Apellido Paterno");
        r=false;
    }
    else if( $("#form_personas_modal #txt_materno").val()=='' ){
        alert("Ingrese Apellido Materno");
        r=false;
    }
    else if( $("#form_personas_modal #txt_fecha_nacimiento").val()=='' ){
       alert("Ingrese Fecha Nacimiento");
        r=false;
    }
   
    else if( $("#form_personas_modal #txt_dni").val()=='' ){
        alert("Ingrese Numero DNI");
        r=false;
    }
    //else if( $("#form_personas_modal #txt_password").val()=='' ){
    //    alert("Ingrese Password");
    //    r=false;
    //}
    else if( $("#form_personas_modal #txt_email").val()=='' ){
        alert("Ingrese Email");
        r=false;
    }

    else if( $("#form_personas_modal #slct_sexo").val()=='' ){
        alert("Seleccione Tipo de Sexo");
        r=false;
    }

    else if( $("#form_personas_modal #slct_area_id").val()=='' ){
        alert("Seleccione Área");
        r=false;
    }
    else if( $("#form_personas_modal #slct_rol_id").val()=='' ){
        alert("Seleccione Rol");
        r=false;
    }
    return r;
};

/*valida=function(inicial,id,v_default){
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

/*HTMLCargarPersona=function(datos){
    var html="";
    $('#t_personas').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td >"+data.paterno+' '+"</td>"+
            "<td >"+data.materno+"</td>"+
            "<td >"+data.nombre+"</td>"+
            "<td >"+data.email+"</td>"+
            "<td >"+data.dni+"</td>"+
            "<td >"+$.trim(data.area)+"</td>"+
            "<td >"+$.trim(data.rol)+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#personaModal" data-id="'+index+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_personas").html(html);
    activarTabla();
};*/
</script>
