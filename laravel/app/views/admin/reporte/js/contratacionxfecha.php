<script type="text/javascript">


$(document).ready(function() {

     /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
         showDropdowns: true
    });
    var dataG = {estado:1};

    slctGlobalHtml('slct_contratacion','simple');
    slctGlobalHtml('slct_fecha','simple');

      $("#generar").click(function (){
        contratacion = $('#slct_contratacion').val();
        tipo_fecha=$('#slct_fecha').val();

        var fecha=$("#fecha").val();
        if(contratacion!==''){
            if(tipo_fecha!==''){
                if ( fecha!=="") {
                window.location='reporte/exportcontratacion'+'?fecha='+fecha+'&tipo_fecha='+tipo_fecha+'&contratacion='+contratacion;   
                } 
                else {
                    alert("Seleccione Fecha");
                      }
                 }else {
                    alert("Seleccione Tipo de Fecha");
                      }
                      }
                else {  
                    alert("Seleccione Contratación"); 
                }
    });

});

MostrarSelect=function (dato) {
    var html='<option value="" >.:Seleccione:.</option>';
        if (dato == "1") {
            html+='<option value="1" >Fecha de Inicio</option>'+
                    '<option value="2">Fecha de Fin</option>'+
                    '<option value="3">Fecha de Aviso</option>';   
        }
        else if (dato == "2") {
            html+='<option value="1" >Fecha de Inicio</option>'+
                    '<option value="2">Fecha de Fin</option>'+
                    '<option value="3">Fecha de Aviso</option>'+
                    '<option value="4">Fecha de Inicio del Detalle</option>'+
                    '<option value="5">Fecha de Fin del Detalle</option>'+
                    '<option value="6">Fecha de Aviso del Detalle</option>';
            $('#slct_fecha > option').css("display", "");
        }
    $("#slct_fecha").html(html);
    $("#slct_fecha").multiselect("rebuild");
};
    

</script>
