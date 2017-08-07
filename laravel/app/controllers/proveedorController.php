<?php

class ProveedorController extends \BaseController
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
    public function postCargar()
    {
        if ( Request::ajax() ) {
            /*********************FIJO*****************************/
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
            /************************************************************/

            if( Input::has("ruc") ){
                $ruc=Input::get("ruc");
                if( trim( $ruc )!='' ){
                    $array['where'].=" AND v.ruc LIKE '".$ruc."%' ";
                }
            }

            if( Input::has("proveedor") ){
                $proveedor=explode(" ",Input::get("proveedor"));
                $dproveedor=array();

                for ($i=0; $i < count($proveedor) ; $i++) { 
                	if( trim( $proveedor[$i] )!='' ){
	                    array_push($dproveedor," v.proveedor LIKE '%".$proveedor[$i]."%' ");
	                }
                }
                if( count($dproveedor)>0 ){
                	$array['where'].=" AND ".implode($dproveedor, " AND ");
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND v.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY v.proveedor ";

            $cant  = Proveedor::getCargarCount( $array );
            $aData = Proveedor::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
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
            $a      = new Proveedor;
            $listar = Array();
            $listar = $a->getProveedor();

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
                'proveedor' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $proveedor = new Proveedor;
            $proveedor->ruc = Input::get('ruc');
            $proveedor->proveedor = Input::get('proveedor');
            $proveedor->estado = Input::get('estado');
            $proveedor->usuario_created_at = Auth::user()->id;
            $proveedor->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'verbo_id'=>$proveedor->id));
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
            	'proveedor' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $verboId = Input::get('id');
            $proveedor = Proveedor::find($verboId);
            $proveedor->ruc = Input::get('ruc');
            $proveedor->proveedor = Input::get('proveedor');
            $proveedor->estado = Input::get('estado');
            $proveedor->usuario_updated_at = Auth::user()->id;
            $proveedor->save();

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

            $proveedor = Proveedor::find(Input::get('id'));
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
    
    // MUESTRA LISTA DE SALDOS POR PAGAR POR CADA PROVEEDOR
    public function postMostrarsaldospagar()
    {
        if( Input::has("id") )
        {
            $id = Input::get('id'); // El id se carga de manera autimatica al metodo listarDatos();
            
            $rst = GastosHistorialContables::listarSaldosPagar();
                      return Response::json(
                          array(
                              'rst'=>1,
                              'datos'=>$rst
                          )
                    );
        }
    }

}
