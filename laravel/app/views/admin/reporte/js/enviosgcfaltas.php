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

      $("#generar").click(function (){
        var fecha=$("#fecha").val();
                if ( fecha!=="") {
                window.location='reporte/exportenviosgcfaltas'+'?fecha='+fecha;   
                } 
                else {
                    alert("Seleccione Fecha");
                      }
    });

});

</script>
