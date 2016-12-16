<?php
class ReferidoController extends \BaseController
{

    public function postExpediente(){
        if ( Request::ajax() ) {
            $r           = new Referido;
            $res         = Array();
            $res         = $r->getReferido();

            return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Detalle Cargado',
                    'datos' => $res
                )
            );
        }
    }

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
        
            if( Input::has("fecha_hora_referido") ){
                $fecha=Input::get("fecha_hora_referido");
                if( trim( $fecha )!='' ){
                    $array['where'].=" AND r.fecha_hora_referido LIKE '%".$fecha."%' ";
                }
            }

            if( Input::has('referido') AND Input::get('referido')!='' ){
              $referido=explode(" ",trim(Input::get('referido')));
              for($i=0; $i<count($referido); $i++){
                $array['where'].=" AND r.referido LIKE '%".$referido[$i]."%' ";
              }
            }

            $array['order']=" ORDER BY r.referido ";

            $cant  = Referido::getListarCount( $array );
            $aData = Referido::getListar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";   
            return Response::json($aParametro);

        }
    }
    

}
