<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var TicketsG={id:0,persona_id:"",area_id:"",descripcion:"",fecha_pendiente:"",fecha_atencion:"",fecha_solucion:"",estado:1}; // Datos Globales
$(document).ready(function() {  
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    slctGlobalHtml('slct_estado','simple');
    var datos={estado:1};
    var ids = [];
    slctGlobal.listarSlct('persona_id','txt_persona_id','simple',ids,datos);
    slctGlobal.listarSlct('area_id','txt_area_id','simple',ids,datos);

    var idG={   persona_id        :'onBlur|Solicitante|#DCE6F1', //#DCE6F1
                area_id      :'onBlur|Area|#DCE6F1', //#DCE6F1
                descripcion      :'onBlur|Descripción|#DCE6F1', //#DCE6F1
                fecha_pendiente      :'onBlur|Fecha Pendiente|#DCE6F1', //#DCE6F1
                fecha_atencion      :'onBlur|Fecha Atencion|#DCE6F1', //#DCE6F1
                fecha_solucion      :'onBlur|Fecha Solucion|#DCE6F1', //#DCE6F1
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'tickets','t_tickets');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_tickets','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('tickets');


    $('#ticketModal').on('show.bs.modal', function (event) {

        /*$('#txt_fecha_nacimiento').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });
*/

      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
    
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Area');
      $('#form_tickets_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tickets_modal input[type='hidden']").remove();

        if(titulo=='Nuevo'){

            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tickets_modal #slct_estado').val(1); 
            $('#form_tickets_modal #txt_persona_id').focus();
            $('#form_tickets_modal #txt_area_id').focus();
            $('#form_tickets_modal #txt_descripcion').focus();
            $('#form_tickets_modal #txt_fecha_pendiente').focus();
            $('#form_tickets_modal #txt_fecha_atencion').focus();
            $('#form_tickets_modal #txt_fecha_solucion').focus();
            //$('#form_tickets_modal #txt_responsable').focus();

        }
        else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_tickets_modal #txt_persona_id').val( TicketsG.persona_id );
            $('#form_tickets_modal #txt_area_id').val( TicketsG.area_id );
            $('#form_tickets_modal #txt_descripcion').val( TicketsG.descripcion );
            $('#form_tickets_modal #txt_fecha_pendiente').val( TicketsG.fecha_pendiente );
            $('#form_tickets_modal #txt_fecha_atencion').val( TicketsG.fecha_atencion );
            $('#form_tickets_modal #txt_fecha_solucion').val( TicketsG.fecha_solucion );
           // $('#form_tickets_modal #txt_responsable').val( TicketsG.responsable );
            $('#form_tickets_modal #slct_estado').val( TicketsG.estado );
            $("#form_tickets_modal").append("<input type='hidden' value='"+TicketsG.id+"' name='id'>");
           // slctGlobal.listarSlctFijo('persona_id','txt_persona_id',PersonasG.persona_id);
         //   slctGlobal.listarSlctFijo('area_id','txt_area_id',PersonasG.area_id);
         }
        $('#form_tickets_modal select').multiselect('rebuild');
        
    });

    $('#ticketModal').on('hide.bs.modal', function (event) {
        $('#form_tickets_modal input').val('');

    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TicketsG.id=id;
    TicketsG.persona_id=$(tr).find("td:eq(0)").text();
    TicketsG.area_id=$(tr).find("td:eq(1)").text();
    TicketsG.descripcion=$(tr).find("td:eq(2)").text();
    TicketsG.fecha_pendiente=$(tr).find("td:eq(3)").text();
    TicketsG.fecha_atencion=$(tr).find("td:eq(4)").text();
    TicketsG.fecha_solucion=$(tr).find("td:eq(5)").text();
    TicketsG.estado=$(tr).find("td:eq(6)>span").attr("data-estado");
    $("#BtnEditar").click();
};


MostrarAjax=function(t){
    if( t=="tickets" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'ticket','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==0){
        return row.persona_id+"<input type='hidden'name='txt_persona_id' value='"+row.persona_id+"'>";
    }

    else if(typeof(fn)!='undefined' && fn.col==1){
        return row.area_id+"<input type='hidden'name='txt_area_id' value='"+row.area_id+"'>";
    }
  
    else if(typeof(fn)!='undefined' && fn.col==6){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
}

activarTabla=function(){
    $("#t_tickets").dataTable(); // inicializo el datatable    
};

activar=function(id){
    Tickets.CambiarEstadoTickets(id,1);
};

desactivar=function(id){
    Tickets.CambiarEstadoTickets(id,0);
};



Editar=function(){
    if(validaTickets()){
        Tickets.AgregarEditarTicket(1);
    }
};

Agregar=function(){
    if(validaTickets()){
        Tickets.AgregarEditarTicket(0);
    }
};

validaTickets=function(){
    var r=true;
    if( $("#form_tickets_modal #txt_persona_id").val()=='' ){
        alert("Ingrese Nombre de Solicitante");
        r=false;
    }
    if( $("#form_tickets_modal #txt_area_id").val()=='' ){
        alert("Ingrese Area");
        r=false;
    }

    return r;
};


HTMLCargarTicket=function(datos){
    var html="", estadohtml="";
    $('#t_tickets').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr>"+
            "<td>"+data.persona_id+"</td>"+
            "<td>"+data.area_id+"</td>"+
            "<td>"+data.descripcion+"</td>"+
            "<td>"+data.fecha_pendiente+"</td>"+
            "<td>"+data.fecha_atencion+"</td>"+
            "<td>"+data.fecha_solucion+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ticketModal" data-id="'+index+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_tickets").html(html);
    activarTabla();
};



validaTickets=function(){
   var r=true;
    if( $("#form_tickets_modal #txt_persona_id").val()=='' ){
        alert("Ingrese Nombre de Solicitante");
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

</script>
