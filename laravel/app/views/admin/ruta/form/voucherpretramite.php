<!-- /.modal -->
<div class="modal fade" id="voucher" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
             <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </button>
        <h4 class="modal-title">Voucher de Pre Tramite</h4>
      </div>
        <div class="modal-body">
        <div class="row">
          <div class="col-md-5">
            <label>FECHA: </label>           
          </div>
          <div class="col-md-3">
            <span id="spanvfecha">19/06/2016</span>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 ">
            <label>COD. PRE TRAMITE: </label>
          </div>
          <div class="col-md-7">
            <span id="spanvcodpretramite">1254</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 ">
            <label>AREA: </label>
          </div>
          <div class="col-md-7">
            <span id="spantArea">1254</span>
          </div>
        </div>

        <div class="vempresa hidden">
          <div class="row">
            <div class="col-md-5 ">
              <label>RUC: </label>
            </div>
            <div class="col-md-7">
              <span id="spanveruc">123123123</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 ">
              <label>TIPO EMPRESA: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvetipo">JURIDICA</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 ">
              <label>RAZON SOCIAL: </label>
            </div>
            <div class="col-md-7">
              <span id="spanverazonsocial">CAZADOSA S.A.C</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 ">
              <label>NOMBRE COMERCIAL: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvenombreco">CAZADOSA</span>
            </div>
          </div>
           <div class="row">
            <div class="col-md-5 ">
              <label>DIRECCION FISCAL: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvedirecfiscal">URB. PACIFICO 2015</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 ">
              <label>TELEFONO: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvetelf">(01) 5242205</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 ">
              <label>REPRESENTANTE: </label>
            </div>
            <div class="col-md-7">
              <span id="spanverepre">CARLOS SANTOS DIAZ</span>
            </div>
          </div>
        </div>

        <div class="vusuario">
          <div class="row">
            <div class="col-md-5 ">
              <label>DNI: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvudni">48341270</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 ">
              <label>NOMBRE: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvunomb">CARLOS</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 ">
              <label>APELLIDO PATERNO: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvuapep">DIAZ</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 ">
              <label>APELLIDO MATERNO: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvuapem">SANTOS</span>
            </div>
          </div>
           <div class="row">
            <div class="col-md-5 ">
              <label>NOMBRE TRAMITE: </label>
            </div>
            <div class="col-md-7">
              <span id="spanvnombtramite">LICENCIA PARA EL USO DE PANCARTAS EN PUBLICO</span>
            </div>
          </div>
        </div>

  
      </div>
      <div class="modal-footer" style="border-top: 0px;">
        <a class="btn btn-primary btn-sm" href="#" id="spanImprimir" target="_blank" onclick="exportPDF(this)"><i class="glyphicon glyphicon-print"></i> IMPRIMIR</a>        
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->


<!-- /.modal -->
<!-- <div class="modal fade" id="voucherempresa" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header logo">
             <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </button>
        <h4 class="modal-title">Voucher de Pre Tramite</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-9 right">
            <label>FECHA: </label>           
          </div>
          <div class="col-md-3">
            <span>19/06/2016</span>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-9 right">
            <label>Nº COMPROBANTE: </label>                        
          </div>
          <div class="col-md-3">
            <span>156</span>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>COD. PRE TRAMITE: </label>
          </div>
          <div class="col-md-7">
            <span>1254</span>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5 right">
            <label>RUC: </label>
          </div>
          <div class="col-md-7">
            <span>123123123</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>TIPO EMPRESA: </label>
          </div>
          <div class="col-md-7">
            <span>JURIDICA</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>RAZON SOCIAL: </label>
          </div>
          <div class="col-md-7">
            <span>CAZADOSA S.A.C</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>NOMBRE COMERCIAL: </label>
          </div>
          <div class="col-md-7">
            <span>CAZADOSA</span>
          </div>
        </div>
         <div class="row">
          <div class="col-md-5 right">
            <label>DIRECCION FISCAL: </label>
          </div>
          <div class="col-md-7">
            <span>URB. PACIFICO 2015</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>TELEFONO: </label>
          </div>
          <div class="col-md-7">
            <span>(01) 5242205</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>REPRESENTANTE: </label>
          </div>
          <div class="col-md-7">
            <span>CARLOS SANTOS DIAZ</span>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5 right">
            <label>DNI: </label>
          </div>
          <div class="col-md-7">
            <span>48341270</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>NOMBRE: </label>
          </div>
          <div class="col-md-7">
            <span>CARLOS</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>APELLIDO PATERNO: </label>
          </div>
          <div class="col-md-7">
            <span>DIAZ</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>APELLIDO MATERNO: </label>
          </div>
          <div class="col-md-7">
            <span>SANTOS</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 right">
            <label>NOMBRE DEL TRAMITE: </label>
          </div>
          <div class="col-md-7">
            <span>LICENCIA PARA EL USO DE PANCARTAS EN PUBLICO</span>
          </div>
        </div>
  
      </div>
      <div class="modal-footer" style="border-top: 0px;">
        <span class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> IMPRIMIR</span>        
      </div>
    </div>
  </div>
</div>
 --><!-- /.modal -->

