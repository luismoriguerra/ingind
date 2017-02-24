<script type="text/javascript">
$(document).ready(function() {
    Bandeja.FechaActual("");
    Bandeja.getApertura({'estado':1},HTMLApertura);


    function initDatePicker(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            multidate: 1,
            todayHighlight:true,
        })

         $('.datepickerActual').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            multidate: 1,
            todayHighlight:true,
        })
    }
    initDatePicker();


    DataUser = '<?php echo Auth::user(); ?>';
    /*Inicializar tramites*/
    var data={'estado':1};
    /*end Inicializar tramites*/


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



registrarApertura = function(){
    if($("#txt_fechainicio").val() == ''){
        alert('Seleccione fecha Inicio');
    }else if($("#txt_fechafinal").val() == ''){
        alert('Seleccione fecha Fin');
    }else if($("#txt_observacion").val() == ''){
        alert('Ingrese una observacion');
    }else{
        Bandeja.guardarApertura();        
    }
}

HTMLApertura = function(data){
    if(data.length > 0){
        var f_ini = new Date(data[0].fecha_inicio);
        var f_fin = new Date(data[0].fecha_fin);
        $('#txt_fechainicioA').datepicker('setDate', f_ini);
        $('#txt_fechafinalA').datepicker('setDate', f_fin);
        document.querySelector("#txt_observacionA").value = data[0].observacion;
        document.querySelector("#txt_idapertura").value = data[0].id;
    }else{
        alert('no hay nada');
    }
}

desbloquear = function(){
    $('#txt_fechainicioA').attr('disabled',false);
    $('#txt_fechafinalA').attr('disabled',false);
    $('#txt_observacionA').attr('readonly',false);
    $('#txt_observacionA').attr('readonly',false);
    $('.btnDesbloquear').addClass('hidden');
    $('.btnActualizar').removeClass('hidden');
}

bloquear = function(){
    $('#txt_fechainicioA').attr('disabled',true);
    $('#txt_fechafinalA').attr('disabled',true);
    $('#txt_observacionA').attr('readonly',true);
}


actualizar = function(){
    Bandeja.ActualizarApertura();
} 

</script>
