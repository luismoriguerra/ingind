<script type="text/javascript">
$(document).ready(function() {
    FichaProceso.FechaActual("");
    FichaProceso.CargarFichaProceso();  
    var data={micro:1,pasouno:1,tipo_flujo:1,soloruta:1};
    FichaProceso.CargarProceso(data);
    poblateDataUser();


    $(document).on('click', '#btnnuevo', function(event) {
        $(".crearPreTramite").removeClass('hidden');
        
        window.scrollTo(0,document.body.scrollHeight);
    });
    
     $('#buscartramite').on('hide.bs.modal', function (event) {
//      var modal = $(this); //captura el modal
//      $("#form_ruta_tiempo input[type='hidden']").remove();
//      $("#form_ruta_verbo input[type='hidden']").remove();
      $("#buscartramite #reporte").show();
    });
     /*validaciones*/

    $(document).on('click', '.btnEnviar', function(event) {
        generarUsuario();
    });
});
poblateDataUser = function(){
    var nombrecompleto= '<?php echo Auth::user()->paterno?>'+' '+'<?php echo Auth::user()->materno?>'+' '+'<?php echo Auth::user()->nombre?>'; 
    var area= '<?php echo Auth::user()->area_id?>'
    $('#txt_userresponsable').val(nombrecompleto);

}
eventoSlctGlobalSimple=function(){
};

registrarInmueble = function(){

     if( $.trim($("#r1").val())==''){
        alert("Seleccione modalidad");
    }
    else if( $.trim($("#r1").val()) == '' ){
        alert("Seleccione local");
    }
   else{
    FichaProceso.guardarFichaProceso();
    }
};
HTMLcargarFichaProceso=function(datos){
    var html="";
    var alerta_tipo= '';
   
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        $('#form_ficha #ficha_proceso_id').val(data.id);
        $('#form_ficha #ficha_proceso_respuesta_id').val(data.ficha_proceso_respuesta_id);
        for(i=1;i<=4;i++){
            html+="<tr id="+data.norden+">"+
                "<td><b><label style='color:#015f9f'>"+i+"- "+data['p'+i]+"</label></b></td>";
            html+="</tr>";
            html+="<tr id="+data.norden+">"+
                "<td><textarea rows='4' id='r"+i+"' name='r"+i+"' style='margin: 0px; width: 100%; color: #015f9f;'>"+data['r'+i]+"</textarea></td>";
            html+="</tr>";
        }

    });
    $("#tb_ficha").html(html);
  };  
  
HTMLcargarProceso=function(datos){
    var html="";
    var alerta_tipo= '';
    $('#t_proceso').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        if(data.checked=='0'){
            checked='';
            val='0';
        }else{
            checked='checked';
            val='1';
        }
        
            html+="<tr id="+data.norden+">"+
                "<td>"+pos+"</td>"+
                "<td>"+data.nombre+"</td>"+
                "<td>"+
                "<input type='hidden' name='check[]' id='check' value='"+val+"'>"+
                "<input type='hidden' name='estado[]' id='estado' value='1'>"+
                "<input type='hidden' name='ruta_flujo_id[]' id='ruta_flujo_id' value='"+data.ruta_flujo_id+"'>"+
                "<input type='checkbox' name='marca[]' id='marca'  onClick='ActualizarCheck(this)' "+checked+">"+
                "</td>";
            html+="</tr>";
    });
    $("#tb_proceso").html(html);
    $("#t_proceso").dataTable(
            {
            "order": [[ 0, "asc" ]],
            "pageLength": 50,
            }
    );
  };

ActualizarCheck = function(boton){

    var td = boton.parentNode;
    
    if ($(td).find('#marca').is(':checked')) {
        $(td).find('#check').val(1);
    }else {
        $(td).find('#check').val(0);
    }
};
</script>
