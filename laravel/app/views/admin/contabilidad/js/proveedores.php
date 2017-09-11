<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var VerbosG={id:0, ruc:"", proveedor:"", estado:1}; // Datos Globales

$(document).ready(function() {

    slctGlobalHtml('slct_estado','simple');
    var idG={   ruc        :'onBlur|Ruc|#DCE6F1', //#DCE6F1
                proveedor        :'onBlur|Nombre del Proveedor|#DCE6F1|columntext_prov',
                estado        :'2|Estado|#DCE6F1', //#DCE6F1
                ver           : '1|[]|#FFF',
                pagar           : '1|[]|#FFF'
             };

    var resG=dataTableG.CargarCab(idG);
    cabeceraG=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG,columnDefsG,targetsG,1,'proveedores','t_proveedores');
    columnDefsG=resG[0]; // registra las columnas del datatable
    targetsG=resG[1]; // registra los contadores
    var resG=dataTableG.CargarBtn(columnDefsG,targetsG,1,'BtnEditar','t_proveedores','fa-edit');
    columnDefsG=resG[0]; // registra la colunmna adiciona con boton
    targetsG=resG[1]; // registra el contador actualizado
    MostrarAjax('proveedores');


    $('#proveedorModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Proveedor');
      $('#form_proveedores_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_proveedores_modal input[type='hidden']").not('.cls_nhidden').remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_proveedores_modal #slct_estado').val(1);
            $('#form_proveedores_modal #txt_ruc').focus();
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_proveedores_modal #txt_ruc').val( VerbosG.ruc );
            $('#form_proveedores_modal #txt_proveedor').val( VerbosG.proveedor );
            $('#form_proveedores_modal #slct_estado').val( VerbosG.estado );
            $("#form_proveedores_modal").append("<input type='hidden' value='"+VerbosG.id+"' name='id'>");
        }
             $('#form_proveedores_modal select').multiselect('rebuild');
    });

    $('#proveedorModal').on('hide.bs.modal', function (event) {
       $('#form_proveedores_modal input').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
});

BtnEditar=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    VerbosG.id=id;
    VerbosG.ruc=$(tr).find("td:eq(0)").text();
    VerbosG.proveedor=$(tr).find("td:eq(1)").text();
    VerbosG.estado=$(tr).find("td:eq(2)>span").attr("data-estado");
    $("#BtnEditar").click();
};


MostrarAjax=function(t){
    if( t=="proveedores" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'proveedor','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    //  alert(fn.col);
    if(typeof(fn)!='undefined' && fn.col==2){ //Cuenta la cantidad de Columna ubicando el select "estado"!
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="activar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-danger">Inactivo</span>';
        if(row.estado==1){
            estadohtml='<span id="'+row.id+'" onClick="desactivar('+row.id+')" data-estado="'+row.estado+'" class="btn btn-success">Activo</span>';
        }
        return estadohtml;
    }
    if(typeof(fn)!='undefined' && fn.col==3){ // Se agrega para el boton Adicional "Ver Expediente".
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="verExpedientes('+row.id+')" class="btn btn-info"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>';
        return estadohtml;
    }
    if(typeof(fn)!='undefined' && fn.col==4){ // Se agrega para el boton Adicional "Ver Pagos".
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="verSaldosPagar('+row.id+')" class="btn btn-default btn-lg" style="padding: 4px 12px;"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></span>';
        return estadohtml;
    }
}

activarTabla=function(){
    $("#t_proveedores").dataTable(); // inicializo el datatable    
};

activar = function(id){
    Verbos.CambiarEstadoProveedor(id, 1);
};
desactivar = function(id){
    Verbos.CambiarEstadoProveedor(id, 0);
};

Editar = function(){
    if(valida()){
        Verbos.AgregarEditarProveedor(1);
    }
};
Agregar = function(){
    if(valida()){
        Verbos.AgregarEditarProveedor(0);
    }
};

valida = function(){
    var r=true;
    if( $("#form_proveedores_modal #txt_ruc").val()=='' ){
        alert("Ingrese el Ruc");
        r=false;
    }
    else if( $("#form_proveedores_modal #txt_proveedor").val()=='' ){
        alert("Ingrese nombre del Proveedor");
        r=false;
    }
    return r;
};

verExpedientes = function(id){
    $(" #mante_gastos ").show();
    $(" #id_proveedor ").val(id); // Carga de manera automática el id y lo pasa a la funcion "MostrarAjax()"
    Cargos.CargarCargos(activarTablaG);
}

verSaldosPagar = function(id){
    $('#modalSaldosPagar').modal();
    $.ajax({
            type: 'POST',
            url: 'proveedor/mostrarsaldospagar',
            cache: false,
            data: {id : id},
            dataType: 'json',
            beforeSend : function() {
                $("#tb_saldos_pagar").html('<tr><td colspan="6" class="text-center">Cargando Registros...</td></tr>');
            },
            success: function (obj) 
            {
                var html = '';
                if(obj.datos.length > 0)
                {
                    var con = 0;
                    $.each(obj.datos,function(index, data){
                        html+='<tr id="trgh'+con+'">'+
                                   '<td>'+data.nro_expede+'</td>'+
                                   '<td>'+data.total_gc+'</td>'+
                                   '<td>'+data.total_gd+'</td>'+
                                   '<td>'+data.total_gg+'</td>'+
                                   '<td>'+data.total_pagar_gd.toFixed(2)+'</td>'+
                                   '<td>'+data.total_pagar_gc.toFixed(2)+'</td>'+
                               '</tr>';
                        con++;
                    });
                }
                else
                {
                    html = '<tr><td colspan="6" class="text-center">No existe Saldos!</td></tr>';
                }
                $("#tb_saldos_pagar").html(html);
            },
            error: function(jqXHR, textStatus, error)
            {
                alert(jqXHR.responseText);
            }
        });
}

</script>





<!-- PROCESO DE GASTOS! -->
<?php define('name_controllerG', 'gastos'); ?>
<?php define('name_frmG', 'gastos'); ?>
<script type="text/javascript">
var name_controllerG = 'gastos';
var name_frmG = 'gastos';

$(document).ready(function() {

    $('#'+name_controllerG+'Modal').on('show.bs.modal', function (event) {      
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      var cargo_id = button.data('id'); //extrae el id del atributo data

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' '+name_controllerG);
      $('#form_'+name_frmG+'_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_"+name_frmG+"_modal input[type='hidden']").not('.cls_nhidden').remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar2();');
            $('#form_'+name_frmG+'_modal #slct_estado').val(1);
            $('#form_'+name_frmG+'_modal #txt_proveedor').focus().attr('readonly', false);
        } else {

            modal.find('.modal-footer-modi .btn-primary').text('Actualizar'); //Se modifico para este caso.
            modal.find('.modal-footer-modi .btn-primary').attr('onClick','Editar2();'); //Se modifico para este caso.
            //alert(cargo_id); 
            $('#form_'+name_frmG+'_modal #txt_proveedor').val( CargoObj[cargo_id].proveedor ).attr('readonly', true);
            $('#form_'+name_frmG+'_modal #txt_nro_expede').val( CargoObj[cargo_id].nro_expede ).attr('readonly', true);
            $('#form_'+name_frmG+'_modal #txt_monto_total').val( CargoObj[cargo_id].monto_total );
            $('#form_'+name_frmG+'_modal #txt_monto_historico').val( CargoObj[cargo_id].monto_historico );
            //$("#form_cargos").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");

            // PROCESO DE CRUD PARA GASTOS HISTORICOS
                $('#form_'+name_frmG+'_modal #txt_contabilidad_gastos_id').val( CargoObj[cargo_id].id ); //pasa el ID
                $.ajax({
                    type: 'POST', 
                    url: name_controllerG+'/mostrardatosregistro',
                    cache: false,
                    data: {id : CargoObj[cargo_id].id},
                    dataType: 'json',
                    beforeSend : function() {
                        $("#btnguardar_pago").attr('disabled', true);
                        $("#tb_gastos_histo").html('<tr><td colspan="9" class="text-center">Cargando Registros...</td></tr>');
                    },
                    success: function (obj) 
                    {
                        var html = '';
                        if(obj.datos.length > 0)
                        {
                            var con = 0;
                            $.each(obj.datos,function(index, data){
                                html+='<tr id="trgh'+con+'">'+
                                           '<td style="padding-top: 15px;">'+
                                                '<span id="'+data.contabilidad_gastos_id+'-'+data.id+'" onclick="editarReg('+con+', this.id)" style="cursor: pointer;" class=" glyphicon glyphicon-pencil" aria-hidden="true"></span> &nbsp;'+
                                                //'<span style="cursor: pointer;" class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>'+
                                           '</td>'+
                                           '<input type="hidden" class="form-control" name="txt_valor_'+con+'" id="txt_valor_'+con+'" value="select">'+
                                           
                                           '<td>'+data.gc+'</td>'+
                                           '<td>'+data.gd+'</td>'+
                                           '<td>'+data.gg+'</td>'+
                                           
                                           '<td>'+data.anio_pago+'</td>'+
                                           '<td>'+data.cuenta_contable+'</td>'+
                                           '<td>'+data.saldo_actual+'</td>'+
                                           '<td>'+data.saldo_presupuesto+'</td>'+
                                           '<td>'+data.created_at.substring(0, 10)+'</td>'+
                                       '</tr>';
                                con++;
                            });
                        }
                        else
                        {
                            html = '<tr><td colspan="9" class="text-center">No existe registros!</td></tr>';
                        }
                        $("#tb_gastos_histo").html(html);
                    },
                    error: function(jqXHR, textStatus, error)
                    {
                        alert(jqXHR.responseText);
                    }
                });
            
            // --

            
            $("#form_"+name_frmG+"_modal").append("<input type='hidden' value='"+CargoObj[cargo_id].id+"' name='id'>");

        }
             $('#form_'+name_frmG+'_modal select').multiselect('rebuild');
    });
    
    $('#'+name_controllerG+'Modal').on('hide.bs.modal', function (event) {
       $('#form_'+name_frmG+'_modal input').val('');
    });


    // PROCESO DE CRUD PARA GASTOS HISTORICOS
    $("#btnagregar_pago").click(function(){
        var tope_max = '99'; //Ultima fila
        $("#trgh"+tope_max).remove();
        //$("#tb_gastos_histo").remove();
        $.ajax({
            type: 'POST', 
            url: name_controllerG+'/agregarregistro',
            data: { contabilidad_gastos_id: $('#form_'+name_frmG+'_modal #txt_contabilidad_gastos_id').val()},
            beforeSend : function() {
                $("#tb_gastos_histo").append('<tr id="trgh'+tope_max+'"><td colspan="9" class="text-center">Cargando Registro... </td></tr>');
            },
            success: function (data) 
            {
                $("#trgh"+tope_max).remove();
                $("#tb_gastos_histo").append(data);
                $("#btnguardar_pago").attr('disabled', false);
            },
            error: function(jqXHR, textStatus, error)
            {
                alert(jqXHR.responseText);
            }
        });
    });

    $("#btnguardar_pago").click(function(){
        $.ajax({
            type: 'POST', 
            url: name_controllerG+'/guardarregistro',
            cache: false,
            data: $('#frmgastos_histo').serialize().split("txt_").join("").split("slct_").join(""),
            dataType: 'json',
            beforeSend : function() {
                //$("#trgh"+tope_max).html('<td colspan="6" class="text-center">Guardando Registro... </td>');
                $("#tb_gastos_histo").html('<tr><td colspan="9" class="text-center">Guardando Registro... </td></tr>');
            },
            success: function (obj) 
            {
                var html = '';
                if(obj.datos.length > 0)
                {
                    var con = 0;
                    $.each(obj.datos,function(index, data){
                        html+='<tr id="trgh'+con+'">'+
                                   '<td style="padding-top: 15px;">'+
                                        '<span id="'+data.contabilidad_gastos_id+'-'+data.id+'" onclick="editarReg('+con+', this.id)" style="cursor: pointer;" class=" glyphicon glyphicon-pencil" aria-hidden="true"></span> &nbsp;'+
                                        //'<span style="cursor: pointer;" class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>'+
                                   '</td>'+
                                   '<input type="hidden" class="form-control" name="txt_valor_'+con+'" id="txt_valor_'+con+'" value="select">'+
                                   '<td>'+data.gc+'</td>'+
                                   '<td>'+data.gd+'</td>'+
                                   '<td>'+data.gg+'</td>'+
                                   '<td>'+data.anio_pago+'</td>'+
                                   '<td>'+data.cuenta_contable+'</td>'+
                                   '<td>'+data.saldo_actual+'</td>'+
                                   '<td>'+data.saldo_presupuesto+'</td>'+
                                   '<td>'+data.created_at.substring(0, 10)+'</td>'+
                               '</tr>';
                        con++;
                    });
                }

                $("#tb_gastos_histo").html(html);
                $("#btnguardar_pago").attr('disabled', true);
            },
            error: function(jqXHR, textStatus, error)
            {
                alert(jqXHR.responseText);
            }
        });
        
    });

    // --

});


activarTablaG=function(){
    $("#t_cargos").dataTable(); // inicializo el datatable    
};

Editar2=function(){
    if(valida2()){
        Cargos.AgregarEditar(1, name_frmG, name_controllerG);
    }
};

valida2 = function(){
    var r=true;
    if( $("#form_"+name_frmG+"_modal #txt_monto_total").val()=='' ){
        alert("Ingrese un Pago Deuda");
        r=false;
    }
    return r;
};

HTMLCargarCargo=function(datos){
    var html="";
    $('#t_cargos').dataTable().fnDestroy();
    var con = 0;
    $.each(datos,function(index,data){
        
        html+="<tr>"+
            "<td >"+data.nro_expede+"</td>"+
            "<td >"+data.proveedor+"</td>"+
            "<td >"+data.monto_total+"</td>"+
            "<td >"+data.monto_historico+"</td>"+
            "<td >"+data.total_gc+"</td>"+
            "<td >"+data.total_gd+"</td>"+
            "<td >"+data.total_gg+"</td>"+
            "<td >"+data.total_deuda_gg+"</td>"+
            "<td >"+data.total_pagar_gc+"</td>"+
            "<td >"+data.total_pagar_gd+"</td>"+
            '<td><a class="btn btn-success btn-sm" onClick="verDetaExpe('+data.id+')" data-id="'+data.id+'" data-titulo="Detalles"><i class="glyphicon glyphicon-list-alt"></i> </a></td>'+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gastosModal" data-id="'+con+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
        con++;
    });
    $("#tb_cargos").html(html); 
    activarTablaG();
};


verDetaExpe = function(id){
    $('#modalDetaExpe').modal();
    $.ajax({
            type: 'POST',
            url: 'gastos/mostrardetallesexpe',
            cache: false,
            data: {id : id},
            dataType: 'json',
            beforeSend : function() {
                $("#tb_deta_expe").html('<tr><td colspan="15" class="text-center">Cargando Registros...</td></tr>');
            },
            success: function (obj) 
            {
                var html = '';
                if(obj.datos.length > 0)
                {
                    var con = 0;
                    $.each(obj.datos,function(index, data){
                        html+='<tr id="trgh'+con+'" style="font-size: 12px;">'+
                                   '<td>'+data.nro_expede+'</td>'+
                                   '<td>'+data.gc+'</td>'+
                                   '<td>'+data.gd+'</td>'+
                                   '<td>'+data.gg+'</td>'+
                                   '<td>'+data.fecha_documento+'</td>'+
                                   '<td>'+data.documento+'</td>'+
                                   '<td>'+data.nro_documento+'</td>'+
                                   '<td>'+data.esp_d+'</td>'+
                                   '<td>'+data.fecha_doc_b+'</td>'+
                                   '<td>'+data.doc_b+'</td>'+
                                   '<td>'+data.nro_doc_b+'</td>'+
                                   '<td>'+data.persona_doc_b+'</td>'+
                                   '<td>'+data.observacion+'</td>'+
                               '</tr>';
                        con++;
                    });
                }
                else
                {
                    html = '<tr><td colspan="15" class="text-center">No existe Saldos!</td></tr>';
                }
                $("#tb_deta_expe").html(html);
            },
            error: function(jqXHR, textStatus, error)
            {
                alert(jqXHR.responseText);
            }
        });
}





// PROCESO DE CRUD PARA GASTOS HISTORICOS
eliminarReg = function(idreg){
    $("#trgh"+idreg).remove();
    $("#btnguardar_pago").attr('disabled', true);
};

editarReg = function(idreg, ids){
    $.ajax({
        type: 'POST', 
        url: name_controllerG+'/editarregistro',
        cache: false,
        data: {ids : ids},
        beforeSend : function() {
            $("#trgh"+idreg).html('<td colspan="9" class="text-center">Cargando Registro...</td>');
        },
        success: function (datos) 
        {
            $("#tb_gastos_histo").html(datos);
            $("#btnguardar_pago").attr('disabled', false);
        },
        error: function(jqXHR, textStatus, error)
        {
            alert(jqXHR.responseText);
        }
    });
};

// --

</script>