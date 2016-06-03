<template id="bs-modal">
    <!-- MODAL -->
    <div class="modal fade" id="selecProcesoModal" tabindex="-1" role="dialog" aria-labelledby="selecProcesoModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="selecProcesoModal">Seleccione Proceso</h4>
          </div>
          <div class="modal-body">
            <form id="form_flujos" name="form_flujos" action="" method="post">
              <div class="form-group">
                  <label class="control-label">Procesos:
                    <a id="error_proceso" style="display:none" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Seleccione Proceso">
                        <i class="fa fa-exclamation"></i>
                    </a>
                  </label>
                  <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                  </select>
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="cerrarModal" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="nuevaCartaInicio">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    Vue.component('modal', {
        template: '#bs-modal',
        data: function () {
            //console.log("### DATA");
        },
        methods: {
          cerrarModal: function(){
            $('#slct_flujo_id').val('');
            $('#slct_flujo_id').multiselect('refresh');
          },
          nuevaCartaInicio: function (event) {
            if ( $("#slct_flujo_id").val()=='') {
              alert("Seleccione Proceso");
              return ;
            }
            //seleccionar proceso al que pertenecera la carta
            //para obtener los tiempos asignados y la cantidad de pasos a asignarse
            $("#form_carta input[type='text'],#form_carta textarea,#form_carta select").val("");
            $("#t_recursos tbody,#t_metricos tbody,#t_desgloses tbody").html("");

            var nombre=$('#slct_flujo_id option:selected').text();
            var flujo={flujo_id:$("#slct_flujo_id").val(),nombre:nombre};
            Carta.CargarDetalleCartas(HTMLCargarDetalleCartas,flujo);

            $("#cartainicio").css("display","");
            $("#txt_nro_carta").focus();
            var datos={area_id:AreaIdG};
            Carta.CargarCorrelativo(HTMLCargarCorrelativo,datos);
            $('#selecProcesoModal .modal-footer [data-dismiss="modal"]').click();
            $('#slct_flujo_id').val('');
            $('#slct_flujo_id').multiselect('refresh');
          }
        },
    });

    var vm = new Vue({
      el: '#el',
      data: {
        query: "select * from clients;",
        showModal: false
      },
      methods: {
        fetchProcesos: function () {
          //cargar procesos: (TABLA flujos)
          data={soloruta:1,tipo_flujo:2,pasouno:1};
          slctGlobal.listarSlct('flujo','slct_flujo_id','simple',null,data)
        }
      },
      ready: function () {
        this.fetchProcesos();
      },

    });

</script>
