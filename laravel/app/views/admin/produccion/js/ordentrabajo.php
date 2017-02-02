<script type="text/javascript">
$(document).ready(function() { 
    Area_id = '<?php echo Auth::user()->area_id; ?>';
    id = '<?php echo Auth::user()->id; ?>';
    Rol_id='<?php echo Auth::user()->rol_id; ?>';
    slctGlobal.listarSlctFuncion('area','personaarea','slct_personasA','simple',null,{area_id:Area_id,persona:id});
 
    if(Rol_id == 8 || Rol_id ==9){
        $(".selectbyPerson").removeClass('hidden');       
    }else{
        $(".selectbyPerson").addClass('hidden');
    }


     var today = new Date();
                function initDatePicker(){
                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        language: 'es',
                        multidate: 1,
                        todayHighlight:true,
                        startDate: today,
                        daysOfWeekDisabled: '06',//bloqueo domingos
                        onSelect: function (date, el) {
                            var row = el.input[0].parentNode.parentNode.parentNode.parentNode;
                            var FechaInicio = $(row).find('.fechaInicio');
                            var FechaFin = $(row).find('.fechaFin');
                            if(FechaInicio[0].value !== FechaFin[0].value){
                                alert('Las Fechas deben ser del mismo dia');
                            }
                        }
                    })
                    $(".datepicker").datepicker().datepicker("setDate", new Date());
                }
                 initDatePicker();

                function initClockPicker(){
                    $(".clockpicker").clockpicker({ 
                        autoclose: true,
                        twelvehour: true,
                        donetext: 'Aceptar',
                    });
                }               
                initClockPicker();

    $(document).on('change','.clockpicker', function(event) {
        console.log('change');
    });

    // $('.clockpicker').change(function(e){
    //     console.log($(this));
    // });
                
    $(document).on('click', '#btnAdd', function(event) {
        event.preventDefault();
        var template = $(".ordenesT").find('.template-orden').clone().removeClass('template-orden').removeClass('hidden').addClass('valido');
        $(".ordenesT").append(template);
        initDatePicker();
        initClockPicker();
    }); 
});

/*add new verb to generate*/
Addtr = function(e){
    e.preventDefault();
    var template = $(".ordenesT").find('.template-orden').clone().removeClass('template-orden').removeClass('hidden');
    $(".ordenesT").append(template);
    initDatePicker();
    initClockPicker();
}
/*end add new verb to generate*/

/*delete tr*/
Deletetr = function(object){
    object.parentNode.parentNode.parentNode.remove();
    initDatePicker();
    initClockPicker();
}
/*end delete tr*/
var calcTotal = 0;
CalcularHrs = function(object){
    var row = object.parentNode.parentNode.parentNode.parentNode;
    var HoraInicio = $(row).find('.horaInicio')[0].value;
    var HoraFin = $(row).find('.horaFin')[0].value;
    if(HoraInicio != '' && HoraFin != ''){
        var hi = new Date (new Date().toDateString() + ' ' + HoraInicio);
        var hf = new Date (new Date().toDateString() + ' ' + HoraFin);
        var interval = hf.getTime() - hi.getTime();
        calcTotal = calcTotal + interval;
        var hours = ((Math.floor(interval/1000/60/60))%24);
        var min = ((Math.floor(interval/1000/60))%60);
        $(row).find('.ttranscurrido').val(hours + ":" + min);


        var hoursT = ((Math.floor(calcTotal/1000/60/60))%24);
        var minT = ((Math.floor(calcTotal/1000/60))%60);
        $("#txt_ttotal").val(hoursT + ':' + minT);
    }
}

guardarTodo = function(){
    var actividades = $(".valido textarea[id='txt_actividad']").map(function(){return $(this).val();}).get();
    var finicio = $(".valido input[id='txt_fechaInicio']").map(function(){return $(this).val();}).get();
    var ffin = $(".valido input[id='txt_fechaFin']").map(function(){return $(this).val();}).get();
    var hinicio = $(".valido input[id='txt_horaInicio']").map(function(){return $(this).val();}).get();
    var hfin = $(".valido input[id='txt_horaFin']").map(function(){return $(this).val();}).get();
    var ttranscurrido = $(".valido input[id='txt_ttranscurrido']").map(function(){return $(this).val();}).get();
    var persona = document.querySelector("#slct_personasA").value;

    if(actividades.length > 0){
        var data = [];
        var personaid = '';
        if(persona){
            personaid=persona;
        }

        for(var i=0; i < actividades.length;i++){
            data.push({
                'actividad' : actividades[i],
                'finicio' : finicio[i],
                'ffin' : ffin[i],
                'hinicio' : hinicio[i],
                'hfin' : hfin[i],
                'ttranscurrido' : ttranscurrido[i],
                'persona':personaid
            });
        }
        Asignar.guardarOrdenTrabajo(data);
    }else{
        alert('complete todos los campos porfavor');
    }
}

</script>