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
            for( $i=0; $i<count($verbog); $i++ ){
                $rdv= RutaDetalleVerbo::find($verbog[$i]);
                $rdv['finalizo'] = '1';
                $rdv['usuario_updated_at']= Auth::user()->id;
                $rdv->save();
            }

            $rdid=Input::get('ruta_detalle_id');
            $rd = RutaDetalle::find($rdid);
            
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

                $validaSiguiente= DB::table('rutas_detalle AS rd')
                                    ->select('rd.id', DB::raw('now() AS ahora') )
                                    ->join(
                                        'areas AS a',
                                        'a.id', '=', 'rd.area_id'
                                    )
                                    ->where('rd.ruta_id', '=', $rd->ruta_id)
                                    ->where('rd.norden', '>', $rd->norden)
                                    ->get();
                                    
                if( count($validaSiguiente)>0 ){
                    $idSiguiente= $validaSiguiente[0]->id;
                    $fechaInicio= $validaSiguiente[0]->ahora;

                    $rd2 = RutaDetalle::find($idSiguiente);
                    $rd2['fecha_inicio']= $fechaInicio ;
                    $rd2['usuario_updated_at']= Auth::user()->id;
                    $rd2->save();
                }
                else{
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
