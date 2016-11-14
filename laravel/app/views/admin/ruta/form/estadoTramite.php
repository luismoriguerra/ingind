<!-- /.modal -->
<div class="modal fade" id="estadoTramite" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
         <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Estado Tramite</h4>
      </div>
      <div class="modal-body">
           <div class="row form-group">
               <div class="col-md-6">
                   <div class="row">
                       <div class="col-md-5">
                            <label>COD. TRAMITE: </label>
                       </div>
                       <div class="col-md-7">
                           <input class="form-control" type="text" name="txtcodtramite" id="txtcodtramite" value="" disabled> 
                       </div>
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="row">
                       <div class="col-md-6">
                            <label>FECHA INGRESADA: </label>
                       </div>
                       <div class="col-md-6">
                           <input class="form-control" type="text" name="txtfechaIngresado" id="txtfechaIngresado" value="" disabled> 
                       </div>
                   </div>                   
               </div>
           </div>
           <div class="row form-group">
                <div class="col-md-4">
                    <label>NOMBRE DEL TRAMITE: </label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="txtnombtramite" id="txtnombtramite" value="" disabled> 
                </div>
           </div>
           <div class="row form-group">
                <div class="col-md-12">
                    <label>DETALLE: </label>
                    <textarea class="form-control" name="txtdetalle" id="txtdetalle" disabled></textarea>                
                   <!--  <input class="form-control" type="text" name="txtdetalle" id="txtdetalle" value="" disabled>       -->               
                </div>
           </div>
      </div>
      <div class="modal-footer" style="padding: 0px">
        <!--  <span id="btnAgregarAnexo" class="btn btn-primary btn-sm" onclick="updateTiempo(this)"><i class="glyphicon glyphicon-plus"></i> AGREGAR ANEXO</span> -->
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
