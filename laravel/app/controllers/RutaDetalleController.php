<?php
class RutaDetalleController extends \BaseController
{

    public function postCargarrd()
    {
        if ( Request::ajax() ) {
            $r           = new RutaDetalle;
            $res         = Array();
            $res         = $r->getRutadetalle();

            return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Detalle Cargado',
                    'datos' => $res
                )
            );
        }
    }

    public function postCargarrdv()
    {
        if ( Request::ajax() ) {
            $r           = new RutaDetalle;
            $res         = Array();
            $res         = $r->getRutadetallev();

            return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Detalle Cargado',
                    'datos' => $res
                )
            );
        }
    }

    public function postListar()//aqui listará las areas unicas
    {
        if ( Request::ajax() ) {
            $r      = new RutaDetalle;
            $listar = Array();
            $listar = $r->getListaareas();
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

    public function postCargardetalle()
    {
        $r          = new RutaDetalle;
        $res        = Array();
        $res        = $r->getRutadetalle();

        if ( Request::ajax() ) {
            return Response::json(
                array(
                    'rst'=>'1',
                    'msj'=>'Detalle cargado',
                    'datos'=>$res
                )
            );
        }
    }

    public function postActualizar(){
        if ( Request::ajax() ) {
            DB::beginTransaction();
            $verbog= explode( "|",Input::get('verbog') );
            $codg= explode( "|",Input::get('codg') );
            $obsg= explode( "|",Input::get('obsg') );
            for( $i=0; $i<count($verbog); $i++ ){
                $rdv= RutaDetalleVerbo::find($verbog[$i]);
                $rdv['finalizo'] = '1';
                $rdv['documento'] = $codg[$i];
                $rdv['observacion'] = $obsg[$i];
                $rdv['usuario_updated_at']= Auth::user()->id;
                $rdv->save();
            }

            $rdid=Input::get('ruta_detalle_id');
            $rd = RutaDetalle::find($rdid);

            $alerta= Input::get('alerta');
            $alertaTipo= Input::get('alerta_tipo');
            
            if ( Input::get('tipo_respuesta') ) {
                $rd['dtiempo_final']= Input::get('respuesta');
                $rd['tipo_respuesta_id']= Input::get('tipo_respuesta');
                $rd['tipo_respuesta_detalle_id']= Input::get('tipo_respuesta_detalle');
                $rd['observacion']= Input::get('observacion');
                $rd['alerta']= Input::get('alerta');
                $rd['alerta_tipo']= Input::get('alerta_tipo');
                $rd['usuario_updated_at']= Auth::user()->id;
                $rd->save();

                $parametros=array(
                    'email'     => Input::get('email')
                );

                $query='
                    SELECT condicion,sum(finalizo) suma,count(condicion) cant
                    FROM rutas_detalle_verbo
                    WHERE ruta_detalle_id='.$rdid.'
                    GROUP BY condicion
                    HAVING suma=cant
                    ORDER BY condicion DESC';
                $querycondicion= DB::select($query);
                if( count($querycondicion) >0 ){
                    $siguiente= $querycondicion[0]->condicion;
                }
                else{
                    $siguiente= "0";
                }

                $validaSiguiente= DB::table('rutas_detalle AS rd')
                                    ->select('rd.id', DB::raw('now() AS ahora') )
                                    ->join(
                                        'areas AS a',
                                        'a.id', '=', 'rd.area_id'
                                    )
                                    ->where('rd.ruta_id', '=', $rd->ruta_id)
                                    ->where('rd.norden', '>', $rd->norden)
                                    ->where('rd.condicion', '=', '0')
                                    ->get();
                                    
                if( count($validaSiguiente)>0  and ( ($alerta==1 and $alertaTipo==1) or ($alerta==0 and $alertaTipo==0) ) ){
                    if($siguiente==0){
                        $idSiguiente= $validaSiguiente[0]->id;
                        $fechaInicio= $validaSiguiente[0]->ahora;
                    }
                    elseif($siguiente==1){
                        $idinvalido= $validaSiguiente[1]->id;
                        $rdinv= RutaDetalle::find($idinvalido);
                        $rdinv['condicion']=1;
                        $rdinv['usuario_updated_at']= Auth::user()->id;
                        $rdinv->save();

                        $idSiguiente= $validaSiguiente[0]->id;
                        $fechaInicio= $validaSiguiente[0]->ahora;
                    }
                    elseif($siguiente==2){
                        $idinvalido= $validaSiguiente[0]->id;
                        $rdinv= RutaDetalle::find($idinvalido);
                        $rdinv['condicion']=1;
                        $rdinv['usuario_updated_at']= Auth::user()->id;
                        $rdinv->save();

                        $idSiguiente= $validaSiguiente[1]->id;
                        $fechaInicio= $validaSiguiente[1]->ahora;
                    }

                    $rd2 = RutaDetalle::find($idSiguiente);
                    $rd2['fecha_inicio']= $fechaInicio ;
                    $rd2['usuario_updated_at']= Auth::user()->id;
                    $rd2->save();

                }
                elseif( count($validaSiguiente)==0 ){
                    $validaerror =  DB::table('rutas_detalle AS rd')
                                    ->select('rd.id')
                                    ->join(
                                        'areas AS a',
                                        'a.id', '=', 'rd.area_id'
                                    )
                                    ->where('rd.ruta_id', '=', $rd->ruta_id)
                                    ->where('rd.alerta', '!=', 0)
                                    ->get();

                    $rutaFlujo= DB::table('rutas')
                                    ->where('id', '=', $rd->ruta_id)
                                    ->get();
                    $rf = RutaFlujo::find($rutaFlujo[0]->ruta_flujo_id);

                    if( count($validaerror)>0 ){
                        $rf['n_flujo_error']=$rf['n_flujo_error']*1+1;
                    }
                    else{
                        $rf['n_flujo_ok']=$rf['n_flujo_ok']*1+1;
                    }
                    $rf['usuario_updated_at']=Auth::user()->id;
                    $rf->save();
                }
                /*try{
                    Mail::send('emails', $parametros , 
                        function($message){
                        $message->to(Input::get('jorgeshevchenk@gmail.com'),'')
                                ->subject('.::Inicio Trámite Activado::.');
                        }
                    );
                    //DB::commit();
                    return Response::json(array(
                        'rst'=>1,
                        'msj'=>'Se realizó con éxito su cierre',
                    )); 
                }
                catch(Exception $e){
                    //DB::rollback();
                    return Response::json(array(
                        'rst'=>2,
                        'msj'=>array('No se pudo realizar el envio de Email; Favor de verificar su email e intente nuevamente.'),
                    ));
                    throw $e;
                }*/
                DB::commit();
                    return Response::json(array(
                        'rst'=>1,
                        'msj'=>'Se realizó con éxito',
                    )); 
            }
            else{
                DB::commit();
                return Response::json(
                    array(
                        'rst'=>'1',
                        'msj'=>'Se realizó con éxito',
                        'datos'=>''
                    )
                );
            }
        }
    }

}
