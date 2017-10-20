<?php

class ActividadPersonalController extends \BaseController
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
                    $array['where'].=" AND ap.actividad LIKE '%".$actividad."%' ";
                }
            }

            if( Input::has("asignado") ){
                    $array['where'].=" AND ap.estado=1";
                    $array['where'].=" AND ap.tipo=2";
                    $array['where'].=" AND ap.respuesta=0";
                    $array['where'].=" AND ap.persona_id=".Auth::user()->id;
            }

            $array['order']=" ORDER BY ap.actividad ";

            $cant  = ActividadPersonal::getCargarCount( $array );
            $aData = ActividadPersonal::getCargar( $array );

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

}
