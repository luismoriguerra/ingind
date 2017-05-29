<!-- /.modal -->
<div class="modal fade" id="estadoAnexo" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
             <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </button>
        <h4 class="modal-title">Detalle Anexo</h4>
      </div>
      <div class="modal-body">
           <div class="row form-group">
               <div class="col-md-5">
                   <div class="row">
                       <div class="col-md-6">
                            <label>COD. TRAMITE: </label>
                       </div>
                       <div class="col-md-6">
                           <input class="form-control" type="text" name="txt_anexocodtramite" id="txt_anexocodtramite" value="" disabled> 
                       </div>
                   </div>
               </div>
               <div class="col-md-7">
                   <div class="row">
                       <div class="col-md-6">
                            <label>USUARIO REGISTRO: </label>
                       </div>
                       <div class="col-md-6">
                           <input class="form-control" type="text" name="txt_anexousuariore" id="txt_anexousuariore" value="" disabled> 
                       </div>
                   </div>                   
               </div>
           </div>
           <div class="row form-group">
                <div class="col-md-4">
                    <label>NOMBRE DEL TRAMITE: </label>
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="txt_anexonomtra" id="txt_anexonomtra" value="" disabled> 
                </div>
           </div>          

            <div class="row form-group">
               <div class="col-md-6">
                   <div class="row">
                       <div class="col-md-5">
                            <label>COD. ANEXO: </label>
                       </div>
                       <div class="col-md-7">
                           <input class="form-control" type="text" name="txt_anexocod" id="txt_anexocod" value="" disabled> 
                       </div>
                   </div>
               </div>
               <div class="col-md-6" style="display:none;">
                   <div class="row">
                       <div class="col-md-4">
                            <label>AREA: </label>
                       </div>
                       <div class="col-md-8">
                           <input class="form-control" type="text" name="txt_anexoarea" id="txt_anexoarea" value="" disabled> 
                       </div>
                   </div>                   
               </div>
           </div>
           <div class="row form-group">
               <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                        <label>FECHA REGISTRO: </label>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="txt_anexofecha" id="txt_anexofecha" value="" disabled> 
                    </div>                                     
                  </div>
               </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                       <label>ESTADO: </label> 
                    </div>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="txt_anexoestado" id="txt_anexoestado" value="" disabled>
                    </div>
                  </div>                     
                </div>
           </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <label>OBSERVACION: </label>
                    <textarea class="form-control" name="txt_anexoobser" id="txt_anexoobser" rows="3" disabled></textarea>               
<!--                     <input class="form-control" type="text" name="txt_anexoobser" id="txt_anexoobser" value=""> -->     
                </div>
           </div>
  
      </div>
      <div class="modal-footer" style="padding: 10px;margin-top:-20px">
         <span id="btnAnexoRecepcionar" class="btn btn-primary btn-sm btnAnexoRecepcionar hidden" onclick="recepcionar()">RECEPCIONAR <i class="glyphicon glyphicon-floppy-saved"></i></span>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
