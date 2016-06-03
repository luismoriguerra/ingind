<script type="text/javascript">

$(document).ready(function() {

    var fechaFormModal = $('#fechanolaborableModal');

    slctGlobal.listarSlct('fechanolaborable','slct_area','simple');

    fechaFormModal.on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body input').val('');

        $("#slct_area").multiselect('destroy');
        slctGlobal.listarSlct('fechanolaborable','slct_area','simple');

    });

    fechaFormModal.on('show.bs.modal', function (event) {

        var modal = $(this);
        var titulo = modal.data('titulo');

        if(titulo=='editar'){

            $('#fechanolaborableModal').find('.modal-footer .btn-primary').text('Actualizar');
            $('#fechanolaborableModal').find('.modal-footer .btn-primary').attr('onClick','editarFechaNoLaborable(1);');

        } else {

            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','agregarFechaNoLaborable(0);');

            $('#form_fechanolaborable #slct_estado').val(1);
            $('#form_fechanolaborable #txt_fechanolaborable').focus();
        }

    });

    var calendar = $('#calendar').fullCalendar({
        lang: "es",
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        eventDrop: function(event,dayDelta,revertFunc) {
            revertFunc();
        },
        eventClick: function(calEvent, jsEvent, view) {

            var fecha = moment(calEvent.start).format('YYYY-MM-DD');

            $('#fechanolaborableModal').data('titulo', 'editar');

            $('#form_fechanolaborable #slct_estado').val(calEvent.estado);
            $('#form_fechanolaborable #txt_fechanolaborable').val(fecha).focus();
            $('#form_fechanolaborable #txt_id').val(calEvent.id);

            $("#slct_area").multiselect('select', calEvent.area);
            $("#slct_area").multiselect('refresh');

            $('#fechanolaborableModal').modal('show');

        },
        select: function(start, end) {

            $('body').find('#txt_fechanolaborable').val( start.format() );
            $('#fechanolaborableModal').data('titulo', 'nuevo');
            $('#fechanolaborableModal').modal('show');

            calendar.fullCalendar('unselect');
        },
        events: {
            url: 'fechanolaborable/cargar',
            error: function() {
            }
        },
    });

    $('.fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: true,
        showDropdowns: true
    });


});

agregarFechaNoLaborable = function(){
    if(validaFechanolaboral()){
        FechaNolaborable.AgregarEditarFecha(0);
    }
};
editarFechaNoLaborable = function(){
    if(validaFechanolaboral()){
        FechaNolaborable.AgregarEditarFecha(1);
    }
};
validaFechanolaboral = function(){
    $('#form_fechanolaborable [data-toggle="tooltip"]').css("display","none");
    var a = [];
    a[0] = valida("txt", "fechanolaborable", "");
    var rpta = true;

    for(i=0;i<a.length;i++){
        if(a[i]===false){
            rpta=false;
            break;
        }
    }
    return rpta;
};
valida = function(inicial, id, v_default){
    var texto = "Seleccione";

    if(inicial=="txt"){
        texto = "Ingrese";
    }
    if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
        $('#error_'+id).attr('data-original-title',texto+' '+id);
        $('#error_'+id).css('display','');
        return false;
    }
};

</script>
