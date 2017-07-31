<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable
var VerbosG={id:0, ruc:"", proveedor:"", estado:1}; // Datos Globales

$(document).ready(function() {

    slctGlobalHtml('slct_estado','simple');
    var idG={   ruc        :'onBlur|Ruc|#DCE6F1', //#DCE6F1
                proveedor        :'onBlur|Nombre|#DCE6F1',
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

/*
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
*/

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
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
    MostrarAjax('gastos');
}

verSaldosPagar = function(id){
    $('#modalSaldosPagar').modal();
    //var id= $('#modalSaldosPagar').attr("id");
    $.ajax({
            type: 'POST',
            url: 'proveedor/mostrarsaldospagar',
            cache: false,
            data: {id : id},
            dataType: 'json',
            beforeSend : function() {
                $("#tb_saldos_pagar").html('<tr><td colspan="5" class="text-center">Cargando Registros...</td></tr>');
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
                                   '<td>'+data.total_pagar.toFixed(2)+'</td>'+
                               '</tr>';
                        con++;
                    });
                }
                else
                {
                    html = '<tr><td colspan="5" class="text-center">No existe Saldos!</td></tr>';
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



<!-- Proceso de Gastos! -->
<?php define('name_controllerG', 'gastos'); ?>
<?php define('name_frmG', 'gastos'); ?>
<script type="text/javascript">
var cabeceraG2=[]; // Cabecera del Datatable
var columnDefsG2=[]; // Columnas de la BD del datatable
var targetsG2=-1; // Posiciones de las columnas del datatable
var dataG2={id:0, proveedor:"", nro_expede:"", monto_total:"", monto_historico:"", total_gc:"", total_gd:"", total_gg:"", total_pagar:""}; // Datos Globales

var name_controllerG = 'gastos';
var name_frmG = 'gastos';

$(document).ready(function() {

    slctGlobalHtml('slct_estado','simple');
    //El nombre de las cabeceras debe ser de acuerdo al SELECT del metoo getCargar();
    var idG2={   
                proveedor       :'onBlur|Proveedor|#DCE6F1', //#DCE6F1
                nro_expede      :'onBlur|Expedediente|#DCE6F1|columntext',
                monto_total     :'onBlur|Pago Deuda|#DCE6F1|columntext',
                monto_historico :'onBlur|Total Historico|#DCE6F1|columntext', //#DCE6F1,
                total_gc        :'|Total GC|#DCE6F1',
                total_gd        :'|Total GD|#DCE6F1',
                total_gg        :'|Total GG|#DCE6F1',
                total_pagar     :'|Total Pagar|#DCE6F1'
            }

    var resG2=dataTableG.CargarCab(idG2);
    cabeceraG2=resG2; // registra la cabecera

    var resG2=dataTableG.CargarCol(cabeceraG2,columnDefsG2,targetsG2,1, name_frmG,'t_'+name_frmG);
    columnDefsG2=resG2[0]; // registra las columnas del datatable
    targetsG2=resG2[1]; // registra los contadores
    
    var resG2=dataTableG.CargarBtn(columnDefsG2,targetsG2,1,'BtnEditar2','t_'+name_frmG,'fa-edit');
    columnDefsG2=resG2[0]; // registra las columnas del datatable
    targetsG2=resG2[1]; // registra los contadores
    //MostrarAjax(name_frmG);


    $('#'+name_controllerG+'Modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

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

            $('#form_'+name_frmG+'_modal #txt_proveedor').val( dataG2.proveedor ).attr('readonly', true);
            $('#form_'+name_frmG+'_modal #txt_nro_expede').val( dataG2.nro_expede ).attr('readonly', true);
            $('#form_'+name_frmG+'_modal #txt_monto_total').val( dataG2.monto_total );
            $('#form_'+name_frmG+'_modal #txt_monto_historico').val( dataG2.monto_historico );


            // PROCESO DE CRUD PARA GASTOS HISTORICOS
                $('#form_'+name_frmG+'_modal #txt_contabilidad_gastos_id').val( dataG2.id ); //pasa el ID
                $.ajax({
                    type: 'POST', 
                    url: name_controllerG+'/mostrardatosregistro',
                    cache: false,
                    data: {id : dataG2.id},
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

            
            $("#form_"+name_frmG+"_modal").append("<input type='hidden' value='"+dataG2.id+"' name='id'>");

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

BtnEditar2=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    dataG2.id=id;
    dataG2.proveedor=$(tr).find("td:eq(0)").text();
    dataG2.nro_expede=$(tr).find("td:eq(1)").text();
    dataG2.monto_total=$(tr).find("td:eq(2)").text();
    dataG2.monto_historico=$(tr).find("td:eq(3)").text();
    $("#BtnEditar2").click();
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
    if( t=='gastos' ){
        if( columnDefsG2.length>0 ){
            dataTableG.CargarDatos(t, 'gastos', 'cargar', columnDefsG2);
        }
        else{
            alert('Faltas datos');
        }
    }
}

Editar2 = function(){
    if(valida2()){
        Data.AgregarEditar(1, name_frmG, name_controllerG);
    }
};
Agregar2 = function(){
    if(valida2()){
        Data.AgregarEditar(0, name_frmG, name_controllerG);
    }
};

valida2 = function(){
    var r=true;
    if( $("#form_"+name_frmG+"_modal #nro_expede").val()=='' ){
        alert("Ingrese el Nro. Expediente");
        r=false;
    }
    return r;
};


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