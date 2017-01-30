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

activarTabla=function(){
    $("#t_cargos").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaCargos()){
        Cargos.AgregarEditarCargo(1);
    }
};

activar=function(id){
    Cargos.CambiarEstadoCargos(id,1);
};
desactivar=function(id){
    Cargos.CambiarEstadoCargos(id,0);
};

Agregar=function(){
    if(validaCargos()){
        Cargos.AgregarEditarCargo(0);
    }
};
AgregarOpcion=function(){
    //añadir registro "opcion" por usuario
    var menu_id=$('#slct_menus option:selected').val();
    var menu=$('#slct_menus option:selected').text();
    var buscar_menu = $('#menu_'+menu_id).text();
    if (menu_id!=='') {
        if (buscar_menu==="") {

            var html='';
            html+="<li class='list-group-item'><div class='row'>";
            html+="<div class='col-sm-4' id='menu_"+menu_id+"'><h5>"+menu+"</h5></div>";

            html+="<div class='col-sm-6'>";
            html+="<select class='form-control' multiple='multiple' name='slct_opciones"+menu_id+"[]' id='slct_opciones"+menu_id+"'></select></div>";
            var envio = {menu_id: menu_id};

            html+='<div class="col-sm-2">';
            html+='<button type="button" id="'+menu_id+'" Onclick="EliminarOpcion(this)" class="btn btn-danger btn-sm" >';
            html+='<i class="fa fa-minus fa-sm"></i> </button></div>';
            html+="</div></li>";

            $("#t_opcionCargo").append(html);
            slctGlobal.listarSlct('opcion','slct_opciones'+menu_id,'multiple',null,envio);
            menus_selec.push(menu_id);
        } else 
            alert("Ya se agrego este menu");
    } else 
        alert("Seleccione Menu");

};
EliminarOpcion=function(obj){
    //console.log(obj);
    var valor= obj.id;
    obj.parentNode.parentNode.parentNode.remove();
    var index = menus_selec.indexOf(valor);
    menus_selec.splice( index, 1 );
};
validaCargos=function(){
    $('#form_cargos [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","nombre","");
    var rpta=true;

    for(i=0;i<a.length;i++){
        if(a[i]===false){
            rpta=false;
            break;
        }
    }
    return rpta;
};

valida=function(inicial,id,v_default){
    var texto="Seleccione";
    if(inicial=="txt"){
        texto="Ingrese";
    }

    if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
        $('#error_'+id).attr('data-original-title',texto+' '+id);
        $('#error_'+id).css('display','');
        return false;
    }   
};
HTMLCargarCargo=function(datos){
    var html="";
    $('#t_cargos').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr>"+
            "<td >"+data.nombre+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cargoModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_cargos").html(html); 
    activarTabla();
};



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
    var actividades = $(".valido input[id='txt_actividad']").map(function(){return $(this).val();}).get();
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
    }
}

</script>