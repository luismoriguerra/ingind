<!-- /.modal -->
<div class="modal fade" id="expedienteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lgz">
    <div class="modal-content">
      <div class="modal-header logo">
        <button class="btn btn-sm btn-default pull-right" data-dismiss="modal">
            <i class="fa fa-close"></i>
        </button>
        <h4 class="modal-title">Historico de Expediente</h4>
      </div>
      <div class="modal-body">
        <form name="form_expediente" id="form_expediente" method="POST" action="">
          <div class="row form-group">
              <div class="col-sm-12">
                  <div class="box-body table-responsive">
                     <!--  <table id="t_expediente" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>Carta</th>
                                  <th>Objetivo</th>
                                  <th>Entregable</th>
                                  <th>[ ]</th>
                              </tr>
                          </thead>
                          <tbody id="tb_expediente">
                              
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th>Carta</th>
                                  <th>Objetivo</th>
                                  <th>Entregable</th>
                                  <th>[ ]</th>
                              </tr>
                          </tfoot>
                      </table> -->
                    <!--   <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                 <th></th>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
                <th>Map Columns</th>
            </tr>
        </thead>
        <tbody>
            <tr>
               <td class="details-control" data-agencies='["agency22", "agency33","agency17","agency89"]'></td>       
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td>
                <button type="button" class="btn">Assign Agenc and Glob</button>
            </td>
            </tr>
            <tr>
                 <td class="details-control" data-agencies='["agency23", "agency344","agency7","agency8"]'></td>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
                <td>
                <button type="button" class="btn">Assign Agenc and Glob</button>
            </td>
            </tr>
            <tr>
                 <td class="details-control" data-agencies='["agency2", "agency53","agency67","agency29"]'></td>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
                <td>
                <button type="button" class="btn">Assign Agenc and Glob</button>
            </td>
            </tr>
           
        </tbody>
        </table> -->  <div class="container">
                      <h2 class="text-center">Expediente Unico</h2>
                        <table id="tree-table" class="table table-hover table-bordered">
                          <thead>
                            <th>Documento</th>
                            <th>Fecha</th>
                            <th>Proceso</th>
                            <th>Area</th>
                            <th>Paso</th>
                          </thead>
                          <tbody id="tb_tretable">                         
                       <!--    <tr data-id="1" data-parent="0" data-level="1">
                            <td data-column="name">Node 1</td>
                            <td>Additional info</td>
                          </tr>
                          <tr data-id="2" data-parent="1" data-level="2">
                            <td data-column="name">Node 1</td>
                            <td>Additional info</td>
                          </tr>
                          <tr data-id="3" data-parent="1" data-level="2">
                            <td data-column="name">Node 1</td>
                            <td>Additional info</td>
                          </tr>
                          <tr data-id="4" data-parent="3" data-level="3">
                            <td data-column="name">Node 1</td>
                            <td>Additional info</td>
                          </tr>
                          <tr data-id="5" data-parent="3" data-level="3">
                            <td data-column="name">Node 1</td>
                            <td>Additional info</td>
                          </tr> -->
                            </tbody>
                          
                        </table>
                      </div>
                  </div>
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_cerrar_asignar" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
