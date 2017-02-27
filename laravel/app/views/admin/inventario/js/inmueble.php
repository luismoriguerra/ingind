<script type="text/javascript">
$(document).ready(function() {
    Bandeja.FechaActual("");

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
    slctGlobalHtml('slct_modalidad','simple');
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
});

poblateDataUser = function(data){
    DataUser = '<?php echo Auth::user(); ?>';
    var result = JSON.parse(DataUser);
    document.querySelector("#txt_useresponsable").value = result.paterno + " " + result.materno + " " + result.nombre;
    document.querySelector("#txt_apenomb").value = result.paterno + " " + result.materno + " " + result.nombre;
}


registrarInmueble = function(){
    if( $("#txt_dependencia").val()=='' ){
        alert("Ingrese Dependencia");
    }
    else if( $.trim($("#slct_modalidad").val())==''){
        alert("Seleccione modalidad");
    }
    else if( $.trim($("#slct_local").val()) == '' ){
        alert("Seleccione local");
    }
     else if( $.trim($("#slct_estado").val()) == '' ){
        alert("Seleccione estado");
    }
    else if( $("#txt_ubicacion").val()=='' ){
        alert("Ingrese Ubicacion");
    }
   else if( $("#txt_codpatrimonial").val()=='2'){
       alert("Ingrese Codigo Patrimonial");
   }
   else if( $("#txt_codinterno").val()=='2'){
       alert("Ingrese Codigo Interno");
   }
   else if($("#txt_descripcion").val()=='1'){
       alert("Ingrese Descripcion");
   }
   else{
    Bandeja.guardarInmueble();
    }
}
</script>
