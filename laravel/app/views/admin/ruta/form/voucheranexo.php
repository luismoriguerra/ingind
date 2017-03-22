
<!-- /.modal -->
<div class="modal fade" id="voucherAnexo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
             <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </button>
        <h4 class="modal-title">Voucher de Anexo</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-9 right">
            <label>FECHA: </label>           
          </div>
          <div class="col-md-3">
            <span id="spanvfecha"></span>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-9 right">
            <label>COD ANEXO: </label>                        
          </div>
          <div class="col-md-3">
            <span id="spanvncomprobante"></span>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 right">
            <label>COD. TRAMITE: </label>
          </div>
          <div class="col-md-8">
            <span id="spanvcodtramite"></span>
          </div>
        </div>

        <div class="vempresa hidden">
          <div class="row">
            <div class="col-md-4 right">
              <label>RUC: </label>
            </div>
            <div class="col-md-8">
              <span id="spanveruc"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 right">
              <label>TIPO EMPRESA: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvetipo"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 right">
              <label>RAZON SOCIAL: </label>
            </div>
            <div class="col-md-8">
              <span id="spanverazonsocial">/span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 right">
              <label>NOMBRE COMERCIAL: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvenombreco"></span>
            </div>
          </div>
           <div class="row">
            <div class="col-md-4 right">
              <label>DIRECCION FISCAL: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvedirecfiscal"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 right">
              <label>TELEFONO: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvetelf"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 right">
              <label>REPRESENTANTE: </label>
            </div>
            <div class="col-md-8">
              <span id="spanverepre"></span>
            </div>
          </div>
        </div>

        <div class="vusuario">
          <div class="row">
            <div class="col-md-4 right">
              <label>DNI: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvudni"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 right">
              <label>NOMBRE: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvunomb"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 right">
              <label>APELLIDO PATERNO: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvuapep"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 right">
              <label>APELLIDO MATERNO: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvuapem"></span>
            </div>
          </div>
           <div class="row">
            <div class="col-md-4 right">
              <label>NOMBRE TRAMITE: </label>
            </div>
            <div class="col-md-8">
              <span id="spanvnombtramite"></span>
            </div>
          </div>
           <div class="row">
            <div class="col-md-4 right">
              <label>FECHA DEL TRAMITE: </label>
            </div>
            <div class="col-md-8">
              <span id="spanFechaTramite"></span>
            </div>
          </div>
           <div class="row" style="display:none;">
            <div class="col-md-4 right">
              <label>AREA: </label>
            </div>
            <div class="col-md-8">
              <span id="spanAreaa"></span>
            </div>
          </div>
        </div>

  
      </div>
      <div class="modal-footer" style="border-top: 0px;">
       <a class="btn btn-primary btn-sm" href="#" id="spanImprimir" target="_blank" onclick="exportPDF(this)"><i class="glyphicon glyphicon-print"></i> IMPRIMIR</a>
       <!--  <span class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> IMPRIMIR</span>         -->
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
