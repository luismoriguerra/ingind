<?php

class VerboController extends \BaseController
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
     * cargar verbos, mantenimiento
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

            if( Input::has("nombre") ){
                $nombre=Input::get("nombre");
                if( trim( $nombre )!='' ){
                    $array['where'].=" AND v.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND v.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY v.nombre ";

            $cant  = Verbo::getCargarCount( $array );
            $aData = Verbo::getCargar( $array );

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
            $a      = new Verbo;
            $listar = Array();
            $listar = $a->getVerbo();

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
                'nombre' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $verbo = new Verbo;
            $verbo->nombre = Input::get('nombre');
            $verbo->estado = Input::get('estado');
            $verbo->usuario_created_at = Auth::user()->id;
            $verbo->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'verbo_id'=>$verbo->id));
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
                'nombre' => $required.'|'.$regex,
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
            $verbo = Verbo::find($verboId);
            $verbo->nombre = Input::get('nombre');
            $verbo->estado = Input::get('estado');
            $verbo->usuario_updated_at = Auth::user()->id;
            $verbo->save();

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

            $verbo = Verbo::find(Input::get('id'));
            $verbo->usuario_created_at = Auth::user()->id;
            $verbo->estado = Input::get('estado');
            $verbo->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
