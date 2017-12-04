<script type="text/javascript">
var rdrfi=0;
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */ 
      $('#microprocesoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text('MicroProceso');
      modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
      $('#form_microproceso_modal [data-toggle="tooltip"]').css("display","none");
      $("#form_microproceso_modal input[type='hidden']").not('.mant').remove();
    });

    $('#microprocesoModal').on('hide.bs.modal', function (event) {
       $('#form_microproceso_modal input').val('');
       $('#form_microproceso_modal select').val('');
       $('#form_microproceso_modal #tb_microproceso').html('');
    });
});

microHTML=function(datos){
  var html="";
    var alerta_tipo= '';
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
            "<td>"+pos+"<input type='hidden' name='id[]' id='id' value='"+data.id+"'></td>"+
            '<td>'+
                '<input class="form-control" type="hidden" id="txt_ruta_flujo_id2" name="txt_ruta_flujo_id2[]" value="'+data.ruta_flujo_id2+'" readOnly>'+
                '<input class="form-control" type="text" id="txt_micro" name="txt_micro[]" value="'+data.nombre+'"  disabled>'+
            '</td>'+
             '<td>'+
                '<span class="btn btn-primary" data-toggle="modal" data-target="#procesoModal" data-texto="txt_proceso" data-id="txt_flujo_id"  id="btn_buscar" onClick="Posicion(this)">'+
                            '<i class="fa fa-search fa-lg"></i>'+
                        '</span>'+
            '</td>'+
            "<td><select class='form-control' name='slct_norden[]' id='slct_norden"+index+"'></select></td>"+
            '<td><button type="button" onclick="EliminarMicro(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-sm"></i> </button></td>';
        html+="</tr>";
            var dat={estado:1,ruta_flujo_id:rdrfi};
            slctGlobal.listarSlctFuncion('ruta','listardetalleruta','slct_norden'+index,'simple',[data.norden],dat);
            
    });
    $("#tb_microproceso").html(html);
};
AgregarMicro = function(meta_cuadro_id){
  var html='';
        html+="<tr>"+
             "<td>#<input type='hidden' name='id[]' id='id'></td>"+
            '<td>'+
                '<input class="form-control" type="hidden" id="txt_ruta_flujo_id2" name="txt_ruta_flujo_id2[]" readOnly>'+
                '<input class="form-control" type="text" id="txt_micro" name="txt_micro[]"  disabled>'+
            '</td>'+
             '<td>'+
                '<span class="btn btn-primary" data-toggle="modal" data-target="#procesoModal" data-texto="txt_proceso" data-id="txt_flujo_id"  id="btn_buscar" onClick="Posicion(this)">'+
                            '<i class="fa fa-search fa-lg"></i>'+
                        '</span>'+
            '</td>'+
            "<td><select class='form-control fecharelacion' name='slct_norden[]' id='slct_norden'></select></td>"+
            '<td><button type="button" onclick="EliminarMicro(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-sm"></i> </button></td>';
        html+="</tr>";
        var data={estado:1,ruta_flujo_id:rdrfi}; 
        slctGlobal.listarSlctFuncion('ruta','listardetalleruta','ñ,.fecharelacion','simple',null,data);
  $("#t_microproceso").append(html);
  
};
CargarMicro=function(ruta_flujo_id){
      rdrfi=ruta_flujo_id;
      $('#form_microproceso_modal #ruta_flujo_id').val(ruta_flujo_id);
      var dataG={ruta_flujo_id:ruta_flujo_id};
      MicroProceso.CargarMicro(dataG);
      $("#microprocesoModal").modal('show');
};
CargarMicroProceso=function(ruta_flujo_id,flujo){
    $(posicionColumnaG).find("td:eq(1) input[id='txt_micro']").val(flujo);
    $(posicionColumnaG).find("td:eq(1) input[id='txt_ruta_flujo_id2']").val(ruta_flujo_id);
    $("#procesoModal .modal-footer>button").click();
};
Posicion=function(btn){
     posicionColumnaG="";
     posicionColumnaG = btn.parentNode.parentNode;
};
Agregar=function(){
//    if(validaAreas()){
        MicroProceso.AgregarEditarMicroProceso(0);
//    }
};
EliminarMicro=function(boton){
        var tr = boton.parentNode.parentNode;
        $(tr).remove();
};

</script>