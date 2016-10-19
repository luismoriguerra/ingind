<?php

class TablaRelacionController extends \BaseController
{

    public function postPlataforma()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$cargar         = TablaRelacion::getPlataforma();

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

                if( Input::has("tramite") ){
                    $tramite=Input::get("tramite");
                    if( trim( $tramite )!='' ){
                        $array['where'].=" AND tr.id_union LIKE '%".$tramite."%' ";
                    }
                }

                if( Input::has("proceso") ){
                    $proceso=Input::get("proceso");
                    if( trim( $proceso )!='' ){
                        $array['where'].=" AND f.nombre LIKE '%".$proceso."%' ";
                    }
                }

                if( Input::has("fecha_inicio") ){
                    $fecha_inicio=Input::get("fecha_inicio");
                    if( trim( $fecha_inicio )!='' ){
                        $array['where'].=" AND rd2.fecha_inicio='".$fecha_inicio."' ";
                    }
                }

                $array['order']=" ORDER BY rd2.fecha_inicio DESC ";

                $cant  = TablaRelacion::getPlataformaCount( $array );
                $aData = TablaRelacion::getPlataforma( $array );

                $aParametro['rst'] = 1;
                $aParametro["recordsTotal"]=$cant;
                $aParametro["recordsFiltered"]=$cant;
                $aParametro['data'] = $aData;
                $aParametro['msj'] = "No hay registros aún";
                return Response::json($aParametro);

            /*return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );*/
        }
    }

    public function postRelacion()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tr             = new TablaRelacion;
            $cargar         = Array();
            $cargar         = $tr->getRelacion();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postRelacionunico()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tr             = new TablaRelacion;
            $cargar         = Array();
            $cargar         = $tr->getRelacionunico();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postRutaflujo()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $rf             = new RutaFlujo;
            $cargar         = Array();
            $cargar         = $rf->getRutaFlujoProduccion();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postGuardar()
    {
        if( Request::ajax() ) {
            $tr         = new TablaRelacion;
            $datos      = array();
            $datos      = $tr->guardarRelacion();

            return Response::json(
                array(
                    'rst'    => 1,
                    'id'     => $datos->id,
                    'codigo' => Input::get('codigo')
                )
            );
        }
    }

}
