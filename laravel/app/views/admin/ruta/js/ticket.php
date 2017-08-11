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

    //slctGlobalHtml('slct_estado','simple');


    var idG={   persona_id        :'3|Solicitante|#DCE6F1', //#DCE6F1
                area_id      :'3|Area|#DCE6F1', //#DCE6F1
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
      modal.find('.modal-title').text(titulo+' Ticket');
      $('#form_tickets_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_tickets_modal input[type='hidden']").not('.mant').remove();

        if(titulo=='Nuevo'){

            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
           // $('#form_tickets_modal #slct_estado').val(1); 
            $('#form_tickets_modal #txt_persona_id').focus();
            $('#form_tickets_modal #txt_area_id').focus();
            $('#form_tickets_modal #txt_descripcion').focus();
            $('#form_tickets_modal #txt_fecha_pendiente').focus();
            $('#form_tickets_modal #txt_fecha_atencion').focus();
            $('#form_tickets_modal #txt_fecha_solucion').focus();
            //$('#form_tickets_modal #txt_responsable').focus();

            var tbarchivo =[];
            var tablaarchivo = $(".valido table[id='t_darchivo']").map(function(){
//            console.log(this);
            tbarchivo =[];
            tbarchivo.push($(this).find("tbody tr").map(function(){
                            return $(this).find('input:eq(0)').val()+'|'+$(this).find('input:eq(1)').val();
                        }).get());
//            console.log(tbarchivo);
            return tbarchivo;
            }).get();

        }

        $('#form_tickets_modal select').multiselect('rebuild');
        
    });

    $('#ticketModal').on('hide.bs.modal', function (event) {
        //$('#form_tickets_modal input').not('.mant').val('');
        $('#form_tickets_modal #txt_descripcion').val( '' );
        $('#form_tickets_modal #txt_fecha_atencion').val( '' );
        $('#form_tickets_modal #txt_fecha_solucion').val( '' );

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
        return row.solicitante+"<input type='hidden'name='txt_persona_id' value='"+row.persona_id+"'>";
    }

    else if(typeof(fn)!='undefined' && fn.col==1){
        return row.area+"<input type='hidden'name='txt_area_id' value='"+row.area_id+"'>";
    }
    // else if(typeof(fn)!='undefined' && fn.col==3){
    //     return row.fecha_pendiente+"<input type='hidden'name='txt_fecha_pendiente' value='"+row.fecha_pendiente+"'>";
    // }
  
    else if(typeof(fn)!='undefined' && fn.col==6){
        var estadohtml='';
        //estadohtml='<span id="'+row.id+'" onClick="atendido('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Atendido</span>';
       
            if(row.estado==1){
                estadohtml='<span id="'+row.id+'"  data-estado="'+row.estado+'" >Pendiente</span>';
            }
            else if(row.estado==2){
                estadohtml='<span id="'+row.id+'"  data-estado="'+row.estado+'" >Atendido</span>';
            }
            else if(row.estado==3){
                estadohtml='<span id="'+row.id+'"  data-estado="'+row.estado+'" >Solucionado</span>';
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
