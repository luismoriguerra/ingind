<script type="text/javascript">
$(document).ready(function() {
    Bandeja.FechaActual("");
    Bandeja.CargarInmueble();  
     $('#fecha_nacimiento').daterangepicker({
                format: 'YYYY-MM-DD',
                singleDatePicker: true,
                showDropdowns: true
    });

    
    poblateDataUser();
    /*Inicializar tramites*/
    var data={'estado':1};
    /*end Inicializar tramites*/

    /*inicializate selects*/
    slctGlobal.listarSlct('local','slct_local','simple',null,data); 

    slctGlobalHtml('slct_estado','simple');
    slctGlobalHtml('slct_piso','simple');
    slctGlobalHtml('slct_modalidad','simple');
    slctGlobalHtml('slct_oficina','simple');
/*    slctGlobal.listarSlct('tipotramite','cbo_tipotramite','simple',null,data);
    slctGlobal.listarSlct('persona','cbo_persona','simple',null,{estado_persona:1});
    slctGlobal.listarSlct('empresa','cbo_empresa','simple',null,{estado:1});    
    slctGlobal.listarSlctFuncion('tiposolicitante','listar?pretramite=1','cbo_tiposolicitante','simple',null,{'estado':1,'validado':1});*/
    /*end inicializate selects*/


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

    $('#sincod').on('ifChanged', function(event){
            if(event.target.checked == true){
                $("#txt_codpatrimonial").prop('disabled',true);
                $("#txt_codpatrimonial").val('');

            }else{
                $("#txt_codpatrimonial").prop('disabled',false);
            }
        
});
});
poblateDataUser = function(){
    var nombrecompleto= '<?php echo Auth::user()->paterno?>'+' '+'<?php echo Auth::user()->materno?>'+' '+'<?php echo Auth::user()->nombre?>'; 
    var area= '<?php echo Auth::user()->area_id?>'
    $('#txt_userresponsable').val(nombrecompleto);
    var data={'estado':1};
    slctGlobal.listarSlct('area','slct_area','simple',area,data);

}
eventoSlctGlobalSimple=function(){
};

registrarInmueble = function(){

     if( $.trim($("#slct_modalidad").val())==''){
        alert("Seleccione modalidad");
    }
    else if( $.trim($("#slct_local").val()) == '' ){
        alert("Seleccione local");
    }
     else if( $.trim($("#slct_estado").val()) == '' ){
        alert("Seleccione estado");
    }
    else if( $("#slct_piso").val()=='' ){
        alert("Seleccione Piso");
    }
   else if( $("#txt_codpatrimonial").val()=='' &&  $('#sincod').prop('checked')==false  ){
       alert("Ingrese Codigo Patrimonial");
   }
   else if( $("#txt_codinterno").val()==''){
       alert("Ingrese Codigo Interno");
   }
   else if($("#txt_descripcion").val()==''){
       alert("Ingrese Descripcion");
   }
      else if($("#slct_oficina").val()==''){
       alert("Seleccione Oficina");
   }
   else{
    Bandeja.guardarInmueble();
    }
}
HTMLcargarinmueble=function(datos){
    var html="";
    var alerta_tipo= '';
   
    $('#t_reporte').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        
        html+="<tr id="+data.norden+">"+
            "<td>"+pos+'</td>'+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.cod_patrimonial+"</td>"+
            "<td>"+data.cod_interno+"</td>"+
            "<td>"+data.descripcion+"</td>";
            
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#t_reporte").dataTable(
             {
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 10,
        }
    ); 
  };  
</script>
