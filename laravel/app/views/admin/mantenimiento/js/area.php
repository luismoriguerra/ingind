<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var AreasG={id:0,nombre:"",nemonico:"",imagen:0,imagenc:0,imagenp:0,estado:1}; // Datos Globales
$(document).ready(function() {  
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var idG={   nombre        :'onBlur|Nombre Area|#DCE6F1', //#DCE6F1
                nemonico      :'3|Nemonico Area|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'areas','t_areas');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_areas','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('areas');


    $('#areaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
    
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Area');
      $('#form_areas_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_areas_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){

            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_areas_modal #slct_estado').val(1); 
            $('#form_areas_modal #txt_nombre').focus();
             $('#form_areas_modal #txt_nemonico').focus();
        }
        else{
//            var imagen='a'+AreasG.id'.png';
//            alert(imagen);
            if (AreasG.imagen===null || AreasG.imagen==='')
                $("#img_imagen_").attr( "src",'');
            else
                $("#img_imagen_").attr( "src", 'img/admin/area/'+AreasG.imagen );

            if (AreasG.imagenc===null || AreasG.imagenc==='') 
                $("#img_imagenc").attr( "src", '');
            else
                $("#img_imagenc").attr( "src", 'img/admin/area/'+AreasG.imagenc );
            if (AreasG.imagenp===null || AreasG.imagenp==='')
                $("#img_imagenp").attr( "src",'');
            else
                $("#img_imagenp").attr( "src", 'img/admin/area/'+AreasG.imagenp );


            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_areas_modal #txt_nombre').val( AreasG.nombre );
            $('#form_areas_modal #txt_nemonico').val( AreasG.nemonico );
            $('#form_areas_modal #slct_estado').val( AreasG.estado );
            $("#form_areas_modal").append("<input type='hidden' value='"+AreasG.id+"' name='id'>");
            $("#upload_id").val(AreasG.id);
            $("#upload_idc").val(AreasG.id);
            $("#upload_idp").val(AreasG.id);
        }
        $('#form_areas_modal select').multiselect('rebuild');
        $("#upload_imagen").on('change',function() {
            CargarImagen(this, 'imagen_');
        });
        $("#upload_imagenc").on('change',function() {
            CargarImagen(this, 'imagenc');
        });
        $("#upload_imagenp").on('change',function() {
            CargarImagen(this, 'imagenp');
        });
    });

    $('#areaModal').on('hide.bs.modal', function (event) {
         $('#form_areas_modal input').val('');
        //var modal = $(this); captura el modal
        // modal.find('.modal-body input').val(''); busca un input para copiarle texto
        $("#upload_imagen").val('');
        $("#upload_imagenc").val('');
        $("#upload_imagenp").val('');
        $("#img_imagen_").attr( "src", '' );
        $("#img_imagenp").attr( "src", '' );
        $("#img_imagenc").attr( "src", '' );
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    AreasG.id=id;
    AreasG.nombre=$(tr).find("td:eq(0)").text();
    AreasG.nemonico=$(tr).find("td:eq(0)").text();
    AreasG.imagen=$(tr).find("td:eq(1) input[name='txt_imagen']").val();
    AreasG.imagenc=$(tr).find("td:eq(1) input[name='txt_imagenc']").val();
    AreasG.imagenp=$(tr).find("td:eq(1) input[name='txt_imagenp']").val();
    AreasG.estado=$(tr).find("td:eq(2)>span").attr("data-estado");
    $("#BtnEditar").click();
};


MostrarAjax=function(t){
    if( t=="areas" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'area','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==1){
        return row.nemonico+"<input type='hidden' name='txt_imagen' value='"+row.imagen+"'><input type='hidden' name='txt_imagenc' value='"+row.imagenc+"'><input type='hidden' name='txt_imagenp' value='"+row.imagenp+"'>";
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
    $("#t_areas").dataTable(); // inicializo el datatable    
};

activar=function(id){
    Areas.CambiarEstadoAreas(id,1);
};

desactivar=function(id){
    Areas.CambiarEstadoAreas(id,0);
};



Editar=function(){
    if(validaAreas()){
        Areas.AgregarEditarArea(1);
    }
};

Agregar=function(){
    if(validaAreas()){
        Areas.AgregarEditarArea(0);
    }
};

validaAreas=function(){
    var r=true;
    if( $("#form_areas_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de Area");
        r=false;
    }
    if( $("#form_areas_modal #txt_nemonico").val()=='' ){
        alert("Ingrese Nemonico");
        r=false;
    }

    return r;
};


HTMLCargarArea=function(datos){
    var html="", estadohtml="";
    $('#t_areas').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.nemonico+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#areaModal" data-id="'+index+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_areas").html(html);
    activarTabla();
};
CargarImagen=function(input, html){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_'+html).attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
};





validaAreas=function(){
   var r=true;
    if( $("#form_areas_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre de areas");
        r=false;
    }
    return r;
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
};
beforeSubmit=function (){};
        success=function (){};
</script>
