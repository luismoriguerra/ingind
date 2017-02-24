<?php

class MetaCuadroController extends \BaseController
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

            if( Input::has("actividad") ){
                $actividad=Input::get("actividad");
                if( trim( $actividad )!='' ){
                    $array['where'].=" AND mc.actividad LIKE '%".$actividad."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND mc.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY mc.actividad ";

            $cant  = MetaCuadro::getCargarCount( $array );
            $aData = MetaCuadro::getCargar( $array );

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
   public function postListarmetacuadro()
    {
        if ( Request::ajax() ) {
            $a      = new MetaCuadro;
            $listar = Array();
            $listar = $a->getMetaCuadro();

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
                'actividad' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $metacuadro = new MetaCuadro;
            $metacuadro->meta_id = Input::get('meta');
            $metacuadro->fecha_vencimiento = Input::get('fecha_vencimiento');
            $metacuadro->anio = Input::get('anio');
            $metacuadro->actividad = Input::get('actividad');
            $metacuadro->estado = Input::get('estado');
            $metacuadro->usuario_created_at = Auth::user()->id;
            $metacuadro->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'metacuadro_id'=>$metacuadro->id));
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
                'actividad' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $metacuadroId = Input::get('id');
            $metacuadro = MetaCuadro::find($metacuadroId);
            $metacuadro->meta_id = Input::get('meta');
            $metacuadro->fecha_vencimiento = Input::get('fecha_vencimiento');
            $metacuadro->anio = Input::get('anio');
            $metacuadro->actividad = Input::get('actividad');
            $metacuadro->estado = Input::get('estado');
            $metacuadro->usuario_updated_at = Auth::user()->id;
            $metacuadro->save();

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

            $metacuadro = MetaCuadro::find(Input::get('id'));
            $metacuadro->usuario_created_at = Auth::user()->id;
            $metacuadro->estado = Input::get('estado');
            $metacuadro->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
       public function postListarmeta()
    {
        if ( Request::ajax() ) {
            $a      = new MetaCuadro;
            $listar = Array();
            $listar = $a->getMeta();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

}
