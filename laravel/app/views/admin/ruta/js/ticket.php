<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var cabeceraG1=[]; // Cabecera del Datatable
var columnDefsG1=[]; // Columnas de la BD del datatable
var targetsG1=-1; // Posiciones de las columnas del datatable
var TicketsG={id:0,
              persona_id:"",
              solicitante:"",
              area_id:"",
              area:"",
              descripcion:""
              ,fecha_pendiente:"",
              fecha_atencion:"",
              responsable_atencion:"",
              fecha_solucion:"",
              responsable_solucion:"",
              solucion:"",
              estado_tipo_problema:"",
              estado_ticket:1,
              estado:1}; // Datos Globales
$(document).ready(function() {  


    var idG={   solicitante        :'onBlur|Solicitante|#DCE6F1', //#DCE6F1
                area      :'onBlur|Area|#DCE6F1', //#DCE6F1
                descripcion      :'onBlur|Descripción|#DCE6F1', //#DCE6F1
                fecha_pendiente      :'onBlur|Fecha Pendiente|#DCE6F1', //#DCE6F1
                fecha_atencion      :'onBlur|Fecha Atencion|#DCE6F1', //#DCE6F1
                responsable_atencion      :'onBlur|R. Atencion|#DCE6F1', //#DCE6F1
                fecha_solucion      :'onBlur|Fecha Solucion|#DCE6F1', //#DCE6F1                
                responsable_solucion      :'onBlur|R. Solucion|#DCE6F1', //#DCE6F1
                solucion        :'onBlur|Solucion|#DCE6F1', //#DCE6F1
                estado_tipo_problema        :'onBlur|Tipo Problema|#DCE6F1', //#DCE6F1
                estado_ticket        :'2|Estado Ticket|#DCE6F1', //#DCE6F1
                editar        :'1|Editar|#DCE6F1', //#DCE6F1
                estado        :'1|Eliminar|#DCE6F1', //#DCE6F1
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'tickets','t_tickets');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores

    var idG1={  solicitante        :'onBlur|Solicitante|#DCE6F1', //#DCE6F1
                area      :'onBlur|Area|#DCE6F1', //#DCE6F1
                descripcion      :'onBlur|Descripción|#DCE6F1', //#DCE6F1
                fecha_pendiente      :'onBlur|Fecha Pendiente|#DCE6F1', //#DCE6F1
                fecha_atencion      :'onBlur|Fecha Atencion|#DCE6F1', //#DCE6F1
                responsable_atencion      :'onBlur|R. Atencion|#DCE6F1', //#DCE6F1
                fecha_solucion      :'onBlur|Fecha Solucion|#DCE6F1', //#DCE6F1                
                responsable_solucion      :'onBlur|R. Solucion|#DCE6F1', //#DCE6F1
                solucion        :'onBlur|Solucion|#DCE6F1', //#DCE6F1
                estado_tipo_problema        :'2|Tipo Problema|#DCE6F1', //#DCE6F1
                estado_ticket        :'2|Estado Ticket|#DCE6F1', //#DCE6F1
                
             };

    var resG1=dataTableG.CargarCab(idG1);
    cabeceraG1=resG1; // registra la cabecera
    var resG1=dataTableG.CargarCol(cabeceraG1,columnDefsG1,targetsG1,1,'ticketscompletogmgm_historico','t_ticketscompletogmgm_historico');
    columnDefsG1=resG1[0]; // registra las columnas del datatable
    targetsG1=resG1[1]; // registra los contadores

    MostrarAjax('tickets');


    $('#ticketModal').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      modal.find('.modal-title').text(titulo+' Ticket');
      $('#form_tickets_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tickets_modal input[type='hidden']").not('.mant').remove();

        if(titulo=='Nuevo'){ 

            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
        }else {

            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_tickets_modal #txt_persona_id').val( TicketsG.persona_id );
            $('#form_tickets_modal #txt_area_id').val( TicketsG.area_id );
            $('#form_tickets_modal #txt_fecha_pendiente').val( TicketsG.fecha_pendiente );
            $('#form_tickets_modal #txt_descripcion').val( TicketsG.descripcion );
            $("#form_tickets_modal").append("<input type='hidden' value='"+TicketsG.id+"' name='id'>");
        }

        $('#form_tickets_modal select').multiselect('rebuild');
        
    });

    $('#ticketModal').on('hide.bs.modal', function (event) {

        $('#form_tickets_modal #txt_descripcion').val( '' );
        


    });
});

MostrarAjax=function(t){
    if( t=="tickets" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'ticket','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
    if( t=="ticketscompletogmgm_historico" ){

        if( columnDefsG1.length>0 ){
            dataTableG.CargarDatos(t,'ticket','cargarhistorico',columnDefsG1);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn

    if(typeof(fn)!='undefined' && fn.col==9){
        //se envia de manera ocultada la fecha de nacimiento en el txt_sexo
        return row.estado_tipo_problema+"<input type='hidden'name='txt_estado_tipo_problema' value='"+row.estado_tipo_problema_id+"'>";
    }

    else if(typeof(fn)!='undefined' && fn.col==10){
        var estado_tickethtml='';

            if(row.estado_ticket==1){
                estado_tickethtml='<span id="'+row.id+'"  data-estado_ticket="'+row.estado_ticket+'" >Pendiente</span>';
            }
            else if(row.estado_ticket==2){
                estado_tickethtml='<span id="'+row.id+'"  data-estado_ticket="'+row.estado_ticket+'" >Atendido</span>';
            }
            else if(row.estado_ticket==3){
                estado_tickethtml='<span id="'+row.id+'"  data-estado_ticket="'+row.estado_ticket+'" >Solucionado</span>';
            }
        return estado_tickethtml;
    }

    else if(typeof(fn)!='undefined' && fn.col==11){
     if(row.estado_ticket==1)
         {
           return "<a class='btn btn-primary btn-sm' onClick='BtnEditar(this,"+row.id+")' data-toggle='modal' data-target='#ticketModal' return false;' data-titulo='Editar'><i class='glyphicon glyphicon-pencil'></i> </a>";  
         }
    }

    else if(typeof(fn)!='undefined' && fn.col==12){
        if(row.estado_ticket==1)
         {
            return "<a class='btn btn-danger btn-sm' onClick='BtnEliminar("+row.id+"); return false;' data-titulo='Eliminar'><i class='glyphicon glyphicon-trash'></i> </a>";  
        }
         
    }
}
BtnEliminar = function(id){
    var c= confirm("¿Está seguro de eliminar el Ticket?");
    if(c)
        {
            data={'estado':0,'id':id};
            Tickets.EliminarTicket(data);
        }
};

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TicketsG.id=id;
    // TicketsG.nombre_solicitante=$(tr).find("td:eq(0)").text();
    // TicketsG.nombre_solicitante_area=$(tr).find("td:eq(1)").text();
    TicketsG.persona_id=$(tr).find("td:eq(0) input[name='txt_persona_id']").val();
    TicketsG.area_id=$(tr).find("td:eq(1)").text();
    TicketsG.descripcion=$(tr).find("td:eq(2)").text();
    TicketsG.fecha_pendiente=$(tr).find("td:eq(3)").text();
    $("#BtnEditar").click();
};

Mostrarticket=function(){
           $("#ticketscompletogmgm_historicoModal").modal('show');
           $('#form_ticketscompletogmgm_historico').show();
           $("#t_ticketscompletogmgm_historico").dataTable();
           MostrarAjax('ticketscompletogmgm_historico'); 
};


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

CambiarEstado=function(id,valor){
    

        Tickets.CambiarEstadoTickets(id,valor);
    
};

//ELIMINAR ARCHIVOS -
$(document).on('click', '.btnDeleteitem', function (event) {
            $(this).parent().parent().remove();
    });

//SUBIR ARCHIVOS +
AgregarD = function (obj) {
        var tabla=obj.parentNode.parentNode.parentNode.parentNode;
        var html = '';
        html += "<tr>";
        html += "<td>";
        html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre"  name="pago_nombre[]" value="">' +
                '<input type="text"  style="display: none;" id="pago_archivo" name="pago_archivo[]">' +
                '<label class="btn btn-default btn-flat margin btn-xs">' +
                '<i class="fa fa-file-pdf-o fa-lg"></i>' +
                '<i class="fa fa-file-word-o fa-lg"></i>' +
                '<i class="fa fa-file-image-o fa-lg"></i>' +
                '<input type="file" style="display: none;" onchange="onPagos(event,this);" >' +
                '</label>';
        html += "</td>" +
                '<td><a id="btnDeleteitem"  name="btnDeleteitem" class="btn btn-danger btn-xs btnDeleteitem">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a></td>';
        html += "</tr>";
        $(tabla).find("tbody").append(html);
    }

onPagos = function (event,obj) {
        var tr=obj.parentNode.parentNode;
       console.log(tr);
        var files = event.target.files || event.dataTransfer.files;
        if (!files.length)
            return;
        var image = new Image();
        var reader = new FileReader();
        reader.onload = (e) => {
            $(tr).find('input:eq(1)').val(e.target.result);
        };
        reader.readAsDataURL(files[0]);
        $(tr).find('input:eq(0)').val(files[0].name);
        console.log(files[0].name);
    }    

</script>
