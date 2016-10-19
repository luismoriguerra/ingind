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

                if( Input::has("nombre") ){
                    $nombre=Input::get("nombre");
                    if( trim( $nombre )!='' ){
                        $array['where'].=" AND r.nombre LIKE '%".$nombre."%' ";
                    }
                }

                if( Input::has("estado") ){
                    $estado=Input::get("estado");
                    if( trim( $estado )!='' ){
                        $array['where'].=" AND r.estado='".$estado."' ";
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
