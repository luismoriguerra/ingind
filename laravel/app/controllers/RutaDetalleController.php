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

    public function postCargartramite()
    {
        if ( Request::ajax() ) {
            $r           = new RutaDetalle;
            $res         = Array();
            $res         = $r->getTramite();

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

    public function postActualizartramite(){
        if ( Request::ajax() ) {
            $ruta_id=Input::get('ruta_id');
            $tabla_relacion_id=Input::get('tabla_relacion_id');

            DB::beginTransaction();
            $r=Ruta::find($ruta_id);
            $r['estado']=0;
            $r['usuario_updated_at']=Auth::user()->id;
            $r->save();

            $tr=TablaRelacion::find($tabla_relacion_id);
            $tr['estado']=0;
            $tr['usuario_updated_at']=Auth::user()->id;
            $tr->save();

            DB::commit();
            return Response::json(
                array(
                    'rst'=>'1',
                    'msj'=>'Se realizó con éxito'
                )
            );
        }
    }

    public function postActualizar(){
        if ( Request::ajax() ) {
            DB::beginTransaction();

            $rdid=Input::get('ruta_detalle_id');
            $rd = RutaDetalle::find($rdid);

            $r=Ruta::find($rd->ruta_id);

            $alerta= Input::get('alerta');
            $alertaTipo= Input::get('alerta_tipo');

            if( Input::get('verbog') OR Input::get('codg') OR Input::get('obsg') ){
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

                    if( $rdv->verbo_id==1 ){
                        $refid=Referido::where(
                                    'tipo','=','1'
                                )
                                ->where(
                                    'ruta_id','=',$r->id
                                )
                                ->where(
                                    'tabla_relacion_id','=',$r->tabla_relacion_id
                                )
                                ->where(
                                    'ruta_detalle_id','=',$rd->id
                                )
                                ->first();
                        $referidoid='';

                        if( count($refid)==0 ){
                            $referido=new Referido;
                            $referido['ruta_id']=$r->id;
                            $referido['tabla_relacion_id']=$r->tabla_relacion_id;
                            $referido['ruta_detalle_id']=$rd->id;
                            $referido['estado_ruta']=$rd->estado_ruta;
                            $referido['tipo']=1;
                            $referido['usuario_created_at']=Auth::user()->id;
                            $referido->save();
                            $referidoid= $referido->id;
                        }
                        else{
                            $referidoid=$refid->id;
                        }

                        $sqlvalida= "SELECT count(id) cant
                                     FROM rutas_detalle_verbo
                                     WHERE verbo_id=1
                                     AND ruta_detalle_id=".$rd->id."
                                     AND id>".$rdv->id;
                        $rv = DB::select($sqlvalida);

                        if( $rv[0]->cant>0 ){
                            $sustento=new Sustento;
                            $sustento['referido_id']=$referidoid;
                            $sustento['ruta_detalle_id']=$rd->id;
                            $sustento['documento_id']=$rdv->documento_id;
                            $sustento['sustento']=$rdv->documento;
                            $sustento['fecha_hora_sustento']=$rdv->updated_at;
                            $sustento['usuario_sustento']=$rdv->usuario_updated_at;
                            $sustento['usuario_created_at']=Auth::user()->id;
                            $sustento->save();
                        }
                        else{
                            $referido=Referido::find($referidoid);
                            $referido['documento_id']=$rdv->documento_id;
                            $referido['id_tipo']=$rdv->id;
                            $referido['referido']=$rdv->documento;
                            $referido['fecha_hora_referido']=$rdv->updated_at;
                            $referido['usuario_referido']=$rdv->usuario_updated_at;
                            $referido['usuario_updated_at']=Auth::user()->id;
                            $referido->save();
                        }
                    }
                }
            }

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
                    AND estado=1
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

                $query='
                    SELECT condicion
                    FROM rutas_detalle_verbo
                    WHERE ruta_detalle_id='.$rdid.'
                    AND estado=1
                    GROUP BY condicion
                    ORDER BY condicion DESC';
                $querycondicion= DB::select($query);
                $siguientefinal="0";
                if( count($querycondicion) >0 ){
                    $siguientefinal= $querycondicion[0]->condicion;
                }

                $validaSiguiente= DB::table('rutas_detalle AS rd')
                                    ->select(
                                        'rd.id',
                                        'rd.estado_ruta',
                                        'rd.fecha_inicio', 
                                        DB::raw('now() AS ahora') 
                                    )
                                    ->join(
                                        'areas AS a',
                                        'a.id', '=', 'rd.area_id'
                                    )
                                    ->where('rd.ruta_id', '=', $rd->ruta_id)
                                    ->whereRaw('dtiempo_final is null')
                                    //->where('rd.norden', '>', $rd->norden)
                                    ->where('rd.condicion', '=', '0')
                                    ->where('rd.estado', '=', '1')
                                    ->orderBy('rd.norden','ASC')
                                    ->get();
                                    
                if( count($validaSiguiente)>0  and ( ($alerta==1 and $alertaTipo==1) or ($alerta==0 and $alertaTipo==0) ) ){
                    $faltaparalelo=0;
                    $inciodato=0;
                    $terminodato=0;
                    for ($i=0; $i<count($validaSiguiente); $i++) {
                        if(trim($validaSiguiente[$i]->fecha_inicio)!=''){
                            $faltaparalelo++;
                        }
                        elseif($faltaparalelo==0 and $inciodato==0 and $terminodato==0 and $validaSiguiente[$i]->estado_ruta==1){ // cuando se coge el primer registro
                            $inciodato++;
                            if($siguiente==0){ // cuando es una ruta normal
                                $idSiguiente= $validaSiguiente[$i]->id;
                                $fechaInicio= $validaSiguiente[$i]->ahora;
                            }
                            elseif($siguiente==1){ // condiciona +1
                                $idinvalido= $validaSiguiente[($siguientefinal-1)]->id;
                                $rdinv= RutaDetalle::find($idinvalido);
                                $rdinv['condicion']=1;
                                $rdinv['usuario_updated_at']= Auth::user()->id;
                                $rdinv->save();

                                if($siguientefinal==2){
                                    $i++;
                                }

                                $idSiguiente= $validaSiguiente[0]->id;
                                $fechaInicio= $validaSiguiente[0]->ahora;
                            }
                            elseif($siguiente>1){ // condicional +n
                                for($j=0; $j<$siguientefinal; $j++){
                                    if( ($j+1)==$siguientefinal ){
                                        $idSiguiente= $validaSiguiente[($i+$j)]->id;
                                        $fechaInicio= $validaSiguiente[($i+$j)]->ahora;
                                        $i=$i+$j;
                                    }
                                    else{
                                        $idinvalido= $validaSiguiente[($i+$j)]->id;
                                        $rdinv= RutaDetalle::find($idinvalido);
                                        $rdinv['condicion']=1;
                                        $rdinv['usuario_updated_at']= Auth::user()->id;
                                        $rdinv->save();
                                    }
                                }
                            }

                            $rd2 = RutaDetalle::find($idSiguiente);
                            $rd2['fecha_inicio']= $fechaInicio ;
                            $rd2['usuario_updated_at']= Auth::user()->id;
                            $rd2->save();
                        }
                        elseif($faltaparalelo==0 and $inciodato>0 and $terminodato==0 and $validaSiguiente[$i]->estado_ruta==2){ // cuando es paralelo iniciar tb
                            $rd3 = RutaDetalle::find($validaSiguiente[$i]->id);
                            $rd3['fecha_inicio']= $validaSiguiente[$i]->ahora;
                            $rd3['usuario_updated_at']= Auth::user()->id;
                            $rd3->save();
                        }
                        else{
                            $terminodato++;
                        }
                    }
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
                                    ->where('rd.estado', '=', 1)
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
