<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var cabeceraG1=[]; // Cabecera del Datatable
var columnDefsG1=[]; // Columnas de la BD del datatable
var targetsG1=-1; // Posiciones de las columnas del datatable
var TicketgmgmsG={
                    id:0,
                    persona_id:"",
                    solicitante:"",
                    area_id:"",
                    area:"",
                    descripcion:"",fecha_pendiente:"",
                    fecha_atencion:"",
                    responsable_atencion:"",
                    fecha_solucion:"",
                    responsable_solucion:"",
                    solucion:"",
                    estado_tipo_problema:"",
                    estado_ticket:1,
                    estado:1}; // Datos Globales
$(document).ready(function() {  
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */


    slctGlobalHtml('slct_estado_tipo_problema','simple');


    var idG={   solicitante        :'onBlur|Solicitante|#DCE6F1', //#DCE6F1
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
                editar        :'1|Editar|#DCE6F1', //#DCE6F1
                estado        :'1|Eliminar|#DCE6F1', //#DCE6F1
                
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'ticketgmgms','t_ticketgmgms');
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

    MostrarAjax('ticketgmgms');


    $('#ticketgmgmModal').on('show.bs.modal', function (event) {


      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
    
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Ticket GMGM');
      $('#form_ticketgmgms_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_ticketgmgms_modal input[type='hidden']").not('.mant').remove();

        if(titulo=='Nuevo'){ 

            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');

        }else {

            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_ticketgmgms_modal #txt_persona_id').val( TicketgmgmsG.persona_id );
            $('#form_ticketgmgms_modal #txt_area_id').val( TicketgmgmsG.area_id );
            $('#form_ticketgmgms_modal #txt_fecha_pendiente').val( TicketgmgmsG.fecha_pendiente );
            $('#form_ticketgmgms_modal #txt_descripcion').val( TicketgmgmsG.descripcion );
            $("#form_ticketgmgms_modal").append("<input type='hidden' value='"+TicketgmgmsG.id+"' name='id'>");
        }

        $('#form_ticketgmgms_modal select').multiselect('rebuild');
        
    });

    $('#ticketgmgmModal').on('hide.bs.modal', function (event) {
        $('#form_ticketgmgms_modal #txt_descripcion').val( '' );      
    });



});

MostrarAjax=function(t){
    if( t=="ticketgmgms" ){
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
            if(row.estado_ticket==1){ // PENDIENTE A ATENDIDO
                estado_tickethtml='<span id="'+row.id+'" onClick="CambiarEstado_Pendiente('+row.id+',2)" data-estado_ticket="'+row.estado_ticket+'" class="btn btn-success"  >Pendiente</span>';
            }
            else if(row.estado_ticket==2){
                estado_tickethtml='<span id="'+row.id+'" onClick="Abrir_soluciongmgm('+row.id+')" data-estado_ticket="'+row.estado_ticket+'" class="btn btn-warning" data-toggle="modal" data-target="#soluciongmgmModal" return false; >Atendido</span>';
            }
            else if(row.estado_ticket==3){
                estado_tickethtml='<span id="'+row.id+'" data-estado_ticket="'+row.estado_ticket+'" >Solucionado</span>';
            }
        return estado_tickethtml;
    }
    else if(typeof(fn)!='undefined' && fn.col==11){
     if(row.estado_ticket==1)
         {
           return "<a class='btn btn-primary btn-sm' onClick='BtnEditar(this,"+row.id+")' data-toggle='modal' data-target='#ticketgmgmModal' return false;' data-titulo='Editar'><i class='glyphicon glyphicon-pencil'></i> </a>";  
         }
    }
    else if(typeof(fn)!='undefined' && fn.col==12){
        if(row.estado_ticket==1)
         {
            return "<a class='btn btn-danger btn-sm' onClick='BtnEliminar("+row.id+"); return false;' data-titulo='Eliminar'><i class='glyphicon glyphicon-trash'></i> </a>";  
        }         
    }
}
Abrir_soluciongmgm=function(id){
    $('#form_soluciongmgm_modal #txt_solucion').val( '' );
    $('#soluciongmgmModal #id_1').val(id);

    
};
BtnEliminar = function(id){
    var c= confirm("¿Está seguro de eliminar el Ticket?");
    if(c)
        {
            data={'estado':0,'id':id};
            Ticketgmgms.EliminarTicket(data);
        }
};

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    TicketgmgmsG.id=id;
    TicketgmgmsG.persona_id=$(tr).find("td:eq(0) input[name='txt_persona_id']").val();
    TicketgmgmsG.area_id=$(tr).find("td:eq(1)").text();
    TicketgmgmsG.descripcion=$(tr).find("td:eq(2)").text();
    TicketgmgmsG.fecha_pendiente=$(tr).find("td:eq(3)").text();
    $("#BtnEditar").click();
};

Mostrartickets=function(){
           $("#ticketscompletogmgm_historicoModal").modal('show');
           $('#form_ticketscompletogmgm_historico').show();
           $("#t_ticketscompletogmgm_historico").dataTable();
           MostrarAjax('ticketscompletogmgm_historico'); 
};

activarTabla=function(){
    $("#t_ticketgmgms").dataTable(); // inicializo el datatable    
};

activar=function(id){
    Ticketgmgms.CambiarEstadoTickets(id,1);
};

desactivar=function(id){
    Ticketgmgms.CambiarEstadoTickets(id,0);
};

Editar=function(){
    if(validaTickets()){
        Ticketgmgms.AgregarEditarTicket(1);
    }
};

Agregar=function(){
    if(validaTickets()){
        Ticketgmgms.AgregarEditarTicket(0);
    }
};

validaTickets=function(){
    var r=true;
    if( $("#form_ticketgmgms_modal #txt_persona_id").val()=='' ){
        alert("Ingrese Nombre de Solicitante");
        r=false;
    }
    return r;
};

CambiarEstado_Pendiente=function(id,valor){   //pendiete a atendido
        Ticketgmgms.CambiarEstadoTickets_Pendiente(id,valor);
};

CambiarEstado_Atendido=function(){   //atendido a solucion
        Ticketgmgms.CambiarEstadoTickets();   
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
