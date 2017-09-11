<?php

class GastosController extends \BaseController
{
    protected $_errorController;
    /**
     * Valida sesion activa
     */
    public function __construct(ErrorController $ErrorController)
    {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }
    /**
     * cargar proveedores, mantenimiento
     * POST /rol/cargar
     *
     * @return Response
     */
    /*
    public function index () {
        $data = array(
            'manten' => 'Gastosss'
        );
        return View::make('admin/contabilidad/gastos', $data);
    }
    */

    /*
    public function postCargar()
    {
        if ( Request::ajax() ) {
            $array=array();
            $array['where']='';$array['usuario']=Auth::user()->id;
            $array['limit']='';$array['order']='';
            
            if (Input::has('draw')) {
                if (Input::has('order')) {
                    $inorder=Input::get('order');
                    $incolumns=Input::get('columns');
                    $array['order']=  ' ORDER BY '.
                                      $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                      $inorder[0]['dir'];
                }

                $array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
                $aParametro["draw"]=Input::get('draw');
            }

            if( Input::has("id_proveedor") ){
                $id_proveedor=Input::get("id_proveedor");
                if( trim( $id_proveedor )!='' ){
                    $array['where'].=" AND v.contabilidad_proveedores_id = '".$id_proveedor."' ";
                }
            }

            if( Input::has("proveedor") ){
                $proveedor=explode(" ",Input::get("proveedor"));
                $dproveedor=array();

                for ($i=0; $i < count($proveedor) ; $i++) { 
                	if( trim( $proveedor[$i] )!='' ){
	                    array_push($dproveedor," vv.proveedor LIKE '%".$proveedor[$i]."%' ");
	                }
                }
                if( count($dproveedor)>0 ){
                	$array['where'].=" AND ".implode($dproveedor, " AND ");
                }
            }

            if( Input::has("nro_expede") ){
                $nro_expede=Input::get("nro_expede");
                if( trim( $nro_expede )!='' ){
                    $array['where'].=" AND v.nro_expede LIKE '%".$nro_expede."%' ";
                }
            }

            if( Input::has("monto_total") ){
                $monto_total=Input::get("monto_total");
                if( trim( $monto_total )!='' ){
                    $array['where'].=" AND v.monto_total LIKE '".$monto_total."%' ";
                }
            }

            if( Input::has("monto_historico") ){
                $monto_historico=Input::get("monto_historico");
                if( trim( $monto_historico )!='' ){
                    $array['where'].=" AND v.monto_historico = '".$monto_historico."' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND v.estado='".$estado."' ";
                }
            }
            
            $array['order']=" ORDER BY v.nro_expede ";

            $cant  = GastosContables::getCargarCount( $array );
            $aData = GastosContables::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }
    */

    public function postCargargastos()
    {
        $rst = GastosContables::getCargar();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
    }

    /**
     * cargar verbos, mantenimiento
     * POST /rol/listar
     *
     * @return Response
     */
   public function postListar()
    {
        if ( Request::ajax() ) {
            $a      = new GastosContables;
            $listar = Array();
            $listar = $a->getDatos();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /rol/crear
     *
     * @return Response
     */

    public function postCrear()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                //'nombre' => $required.'|'.$regex,
                //'nro_expede' => 'required|numeric|min:11|unique:personas,nro_expede',
                //'monto_total' => 'required|numeric|min:10|unique:personas,monto_total'
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            /*
            $dd=DocumentoDigital::getVerificarTitulo();
            if($dd){
                return Response::json(
                array(
                    'rst' => 2,
                    'msj' => 'El título de Documento ya existe',
                )
                ); 
            }
            */

            $obj = new GastosContables;
            //$obj->contabilidad_proveedor_id = Input::get('contabilidad_proveedor_id');
            $obj->nro_expede = Input::get('nro_expede');
            $obj->monto_total = Input::get('monto_total');
            $obj->monto_historico = Input::get('monto_historico');
            $obj->usuario_created_at = Auth::user()->id;
            $obj->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'data_id'=>$obj->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /rol/editar
     *
     * @return Response
     */
   public function postEditar()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
            	//'nro_expede' => 'required|numeric|min:11|unique:personas,nro_expede',
                //'monto_total' => 'required|numeric|min:10|unique:personas,monto_total'
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $vId = Input::get('id');
            $obj = GastosContables::find($vId);
            //$obj->contabilidad_proveedor_id = Input::get('contabilidad_proveedor_id');
            $obj->nro_expede = Input::get('nro_expede');
            $obj->monto_total = Input::get('monto_total');
            $obj->monto_historico = Input::get('monto_historico');
            $obj->usuario_updated_at = Auth::user()->id;
            $obj->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /rol/cambiarestado
     *
     * @return Response
     */
    
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $proveedor = GastosContables::find(Input::get('id'));
            $proveedor->usuario_created_at = Auth::user()->id;
            $proveedor->estado = Input::get('estado');
            $proveedor->save();
            
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
    // MUESTRA DETALLES DE UN EXPEDIENTE SELECCIONADO
    public function postMostrardetallesexpe()
    {
        if( Input::has("id") )
        {
            $id = Input::get('id'); // El id se carga de manera autimatica al metodo listarDatos();
            
            $rst = GastosContables::verDetallesExpe();
                      return Response::json(
                          array(
                              'rst'=>1,
                              'datos'=>$rst
                          )
                    );
        }
    }


    // PROCESO DE CRUD PARA GASTOS HISTORICOS
    public function postAgregarregistro()
    {
        $tope_max = '99';
        $fecha_actual = date('Y-m-d');
        $contabilidad_gastos_id = Input::get('contabilidad_gastos_id'); //Campo Obtenido el mismo al WHERE.
        /*
        $rst = GastosHistorialContables::insertFirt();        
        foreach($rst as $con=>$lis)
        {
          $gc = $lis->gc;
          $gd = $lis->gd;
          $gg = $lis->gg;
        }
        */
        $html = '<tr id="trgh'.$tope_max.'">
                           <td style="padding-top: 15px;"><span id="'.$tope_max.'" onclick="eliminarReg(this.id)" style="cursor: pointer;" class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></td>
                           <td colspan="3">&nbsp;</td>
                           <td>
                              <input type="hidden" class="form-control" name="txt_valor_'.$tope_max.'" id="txt_valor_'.$tope_max.'" value="insert">
                              <input type="hidden" class="form-control" name="txt_contabilidad_gastos_id_'.$tope_max.'" id="txt_contabilidad_gastos_id_'.$tope_max.'" value="'.$contabilidad_gastos_id.'">
                              <input type="text" class="form-control" name="txt_anio_pago_'.$tope_max.'" id="txt_anio_pago_'.$tope_max.'">
                            </td>
                           <td><input type="text" class="form-control" name="txt_cuenta_contable_'.$tope_max.'" id="txt_cuenta_contable_'.$tope_max.'"></td>
                           <td><input type="text" class="form-control" name="txt_saldo_actual_'.$tope_max.'" id="txt_saldo_actual_'.$tope_max.'"></td>
                           <td><input type="text" class="form-control" name="txt_saldo_presupuesto_'.$tope_max.'" id="txt_saldo_presupuesto_'.$tope_max.'"></td>
                           <td>'.$fecha_actual.'</td>
                       </tr>';
        return $html;
    }

    public function postMostrardatosregistro()
    {
        if( Input::has("id") )
        {
            $id = Input::get('id'); // El id se carga de manera autimatica al metodo listarDatos();
            //$rst = GastosHistorialContables::where( 'contabilidad_gastos_id','=', $id)->get(); //Obtiene todos los registrossegún al WHERE.
            $rst = GastosHistorialContables::listarDatos();
                      return Response::json(
                          array(
                              'rst'=>1,
                              'datos'=>$rst
                          )
                    );
        }
    }

    public function postGuardarregistro()
    {
        $tope_max = '99';
        $contabilidad_gastos_id = 0;

        DB::beginTransaction();
        for($i=0; $i<=$tope_max; $i++)
        {
            if( Input::has("contabilidad_gastos_id_".$i) && Input::has("anio_pago_".$i) && Input::get('valor_'.$i))
            {
                if(Input::get('valor_'.$i) == 'update')
                {
                    $obj = GastosHistorialContables::find(Input::get('id_'.$i));
                    $obj->cuenta_contable = Input::get('cuenta_contable_'.$i);
                    $obj->saldo_actual = Input::get('saldo_actual_'.$i);
                    $obj->saldo_presupuesto = Input::get('saldo_presupuesto_'.$i);
                    $obj->usuario_updated_at = Auth::user()->id;
                    $obj->save();
                }

                if(Input::get('valor_'.$i) == 'insert')
                {
                    $obj = new GastosHistorialContables;
                    $obj->contabilidad_gastos_id = Input::get('contabilidad_gastos_id_'.$i);
                    $obj->anio_pago = Input::get('anio_pago_'.$i);
                    $obj->cuenta_contable = Input::get('cuenta_contable_'.$i);
                    $obj->saldo_actual = Input::get('saldo_actual_'.$i);
                    $obj->saldo_presupuesto = Input::get('saldo_presupuesto_'.$i);
                    $obj->usuario_created_at = Auth::user()->id;
                    $obj->save();
                }

                $commit = 'ok';
                $contabilidad_gastos_id = Input::get('contabilidad_gastos_id_'.$i);
            }
        }
        DB::commit();

        if($commit == 'ok' && $contabilidad_gastos_id > 0)
        {
            //$rst = GastosHistorialContables::where( 'contabilidad_gastos_id','=', $contabilidad_gastos_id)->get();
            $rst = GastosHistorialContables::listarDatos();
                  return Response::json(
                      array(
                          'rst'=>1,
                          'datos'=>$rst
                      )
                  );
        }
        else
                return Response::json(
                      array(
                          'rst'=>0,
                          'msj'=>'No se guardo el Registro'
                      )
                  );
    }

    public function postEditarregistro()
    {
        if( Input::has("ids") )
        {
            $array_ids = explode('-', Input::get('ids'));
            $contabilidad_gastos_id = $array_ids[0];
            $id = $array_ids[1];

            //$rst = GastosHistorialContables::where( 'contabilidad_gastos_id','=', $contabilidad_gastos_id)->get();
            $rst = GastosHistorialContables::listarDatos();
            $html = "";
            
            foreach($rst as $con=>$lis)
            {
                $lis_data = GastosHistorialContables::where( 'id','=', $lis->id )->first();

                if($lis_data->contabilidad_gastos_id == $contabilidad_gastos_id && $lis_data->id == $id)
                {
                    $html .= '<tr id="trgh'.$con.'">
                               <td style="padding-top: 15px;"><span id="'.$lis->contabilidad_gastos_id.'-'.$lis->id.'" onclick="editarReg('.$con.', this.id)" style="cursor: pointer;" class=" glyphicon glyphicon-pencil" aria-hidden="true"></span> &nbsp;</td>
                               <td>'.$lis->gc.'</td>
                               <td>'.$lis->gd.'</td>
                               <td>'.$lis->gg.'</td>
                               <td>
                                  <input type="hidden" class="form-control" name="txt_valor_'.$con.'" id="txt_valor_'.$con.'" value="update">
                                  <input type="hidden" class="form-control" name="txt_id_'.$con.'" id="txt_id_'.$con.'" value="'.$lis->id.'">
                                  <input type="hidden" class="form-control" name="txt_contabilidad_gastos_id_'.$con.'" id="txt_contabilidad_gastos_id_'.$con.'" value="'.$lis->contabilidad_gastos_id.'">
                                  <input type="text" class="form-control" name="txt_anio_pago_'.$con.'" id="txt_anio_pago_'.$con.'" value="'.$lis->anio_pago.'" readonly>
                                </td>
                               <td><input type="text" class="form-control" name="txt_cuenta_contable_'.$con.'" id="txt_cuenta_contable_'.$con.'" value="'.$lis->cuenta_contable.'"></td>
                               <td><input type="text" class="form-control" name="txt_saldo_actual_'.$con.'" id="txt_saldo_actual_'.$con.'" value="'.$lis->saldo_actual.'"></td>
                               <td><input type="text" class="form-control" name="txt_saldo_presupuesto_'.$con.'" id="txt_saldo_presupuesto_'.$con.'" value="'.$lis->saldo_presupuesto.'"></td>
                               <td>'.substr($lis->created_at, 0, 10).'</td>
                            </tr>';
                }
                else
                {
                    //<span style="cursor: pointer;" class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                    $html .= '<tr id="trgh'.$con.'">
                               <td style="padding-top: 15px;">
                                    <span id="'.$lis->contabilidad_gastos_id.'-'.$lis->id.'" onclick="editarReg('.$con.', this.id)" style="cursor: pointer;" class=" glyphicon glyphicon-pencil" aria-hidden="true"></span> &nbsp;
                               </td>
                               <td>'.$lis->gc.'</td>
                               <td>'.$lis->gd.'</td>
                               <td>'.$lis->gg.'</td>
                               <td><input type="hidden" class="form-control" name="txt_valor_'.$con.'" id="txt_valor_'.$con.'" value="select">
                               '.$lis->anio_pago.'</td>
                               <td>'.$lis->cuenta_contable.'</td>
                               <td>'.$lis->saldo_actual.'</td>
                               <td>'.$lis->saldo_presupuesto.'</td>
                               <td>'.substr($lis->created_at, 0, 10).'</td>
                            </tr>';
                }
            }

            return $html;
        }
    }
    
    // --

}
