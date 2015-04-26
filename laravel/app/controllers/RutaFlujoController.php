<?php
class RutaFlujoController extends \BaseController
{
    public function postCargar()
    {
        if ( Request::ajax() ) {
            $rf             = new RutaFlujo();
            $cargar         = Array();
            $cargar         = $rf->getRutaFlujo();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postCdetalle()
    {
        if ( Request::ajax() ) {
            $rf             = new RutaFlujo();
            $cargar         = Array();
            $cargar         = $rf->getRutaFlujoDetalle();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postActivar()
    {
        if ( Request::ajax() ) {
            $rpt=array();
            $validaVerbo='';$validaTiempo='';
            $rf                 = new RutaFlujo();

            $validaTiempo = $rf->validaTiempo();
            
            if($validaTiempo==''){
            $validaVerbo = $rf->validaVerbo();
            }

            if($validaTiempo=='' and $validaVerbo==''){
            $actualizar         = Array();
            $actualizar         = $rf->actualizarProduccion();
            $rpt=array(
                    'rst'   => 1,
                    'msj' => ".::Se actualizó correctamente::."
                );
            }
            elseif ($validaTiempo!=''){
                $rpt=array(
                    'rst'   => 2,
                    'msj' => $validaTiempo
                );
            }
            elseif ($validaVerbo!=''){
                $rpt=array(
                    'rst'   => 2,
                    'msj' => $validaVerbo
                );
            }

            return Response::json(
                $rpt
            );
        }
    }

    public function postCrear()
    {
        if ( Request::ajax() ) {
            DB::beginTransaction();
            $rutaFlujo="";
            $mensajefinal=".::Se registro correctamente::.";
            if ( Input::get('ruta_flujo_id') ) {
                $mensajefinal=".::Actualización finalizada::.";
                $rutaFlujo = RutaFlujo::find( Input::get('ruta_flujo_id') );
                $rutaFlujo['usuario_updated_at']= Auth::user()->id;

                $rutaFlujo['nactualizar']=$rutaFlujo->nactualizar*1+1;
            }
            else{
                $rutaFlujo = new RutaFlujo;
                $rutaFlujo['usuario_created_at']= Auth::user()->id;
                $rutaFlujo['estado']= 2;
            }

            $rutaFlujo['flujo_id']= Input::get('flujo_id');
            $rutaFlujo['persona_id']= Auth::user()->id;
            $rutaFlujo['area_id']= Input::get('area_id');

            $rutaFlujo->save();

            $areasGid= explode( "*", Input::get('areasGId') );
            $theadArea= explode( "*", Input::get('theadArea') );
            $tbodyArea= explode( "*", Input::get('tbodyArea') );

            $tiempoGid= explode( "*", Input::get('tiempoGId') );
            $tiempoG= explode( "*", Input::get('tiempoG') );
            $verboG= explode( "*", Input::get('verboG') );

            for($i=0; $i<count($areasGid); $i++ ){
                $rutaFlujoDetalle="";
                if ( Input::get('ruta_flujo_id') ) {
                    $valor= DB::table('rutas_flujo_detalle')
                            ->where('ruta_flujo_id', '=', $rutaFlujo->id)
                            ->where('norden', '=', ($i+1))
                            ->where('area_id', '=', $areasGid[$i] )
                            ->where('estado', '=', 1)
                            ->count();
                    if($valor==0){
                        $rfd=DB::table('rutas_flujo_detalle')
                            ->where('ruta_flujo_id', '=', $rutaFlujo->id)
                            ->where('norden', '=', ($i+1))
                            ->where('estado', '=', 1)
                            ->update(array('estado' => 0));
                        $rutaFlujoDetalle = new RutaFlujoDetalle;
                        $rutaFlujoDetalle['usuario_created_at']= Auth::user()->id;
                    }
                    else{
                        $rfd=DB::table('rutas_flujo_detalle')
                            ->where('ruta_flujo_id', '=', $rutaFlujo->id)
                            ->where('norden', '=', ($i+1))
                            ->where('estado', '=', 1)
                            ->first();
                        $rutaFlujoDetalle = RutaFlujoDetalle::find( $rfd->id );
                        $rutaFlujoDetalle['usuario_updated_at']= Auth::user()->id;
                    }
                    //$rutaFlujoDetalle
                }
                else{
                    $rutaFlujoDetalle = new RutaFlujoDetalle;
                    $rutaFlujoDetalle['usuario_created_at']= Auth::user()->id;
                }
                $rutaFlujoDetalle['ruta_flujo_id']= $rutaFlujo->id;
                $rutaFlujoDetalle['area_id']= $areasGid[$i];
                $rutaFlujoDetalle['norden']= ($i+1);

                $post = array_search($areasGid[$i], $tiempoGid);

                $posdetalleTiempoG= array("0","0");
                // Inicializa valores en caso no tenga datos...
                $rutaFlujoDetalle['tiempo_id']="1";
                $rutaFlujoDetalle['dtiempo']="0";

                if( trim($post)!='' and $post*1>=0 ){
                    $detalleTiempoG=explode( ",", $tiempoG[$post] );
                    
                    if( $theadArea[$i]=="0" ){
                        $posdetalleTiempoG= explode( "|", $tbodyArea[$i] );
                    }

                    $dtg="";

                    if( isset($detalleTiempoG[ $posdetalleTiempoG[1] ]) and trim($detalleTiempoG[ $posdetalleTiempoG[1] ])!=''){
                        $dtg=explode( "_", $detalleTiempoG[ $posdetalleTiempoG[1] ] );
                        if( trim($dtg[1])!='' ){
                            $rutaFlujoDetalle['tiempo_id']=$dtg[1];
                            $rutaFlujoDetalle['dtiempo']=$dtg[2];
                        }
                    }

                }

                $rutaFlujoDetalle->save();

                $cantrfd= DB::table('rutas_flujo_detalle_verbo')
                            ->where('ruta_flujo_detalle_id', '=', $rutaFlujoDetalle->id)
                            ->count();
                    $probando="";
                    $rfdv="";
                    if($cantrfd>0){
                        $rfdv=DB::table('rutas_flujo_detalle_verbo')
                            ->where('ruta_flujo_detalle_id', '=', $rutaFlujoDetalle->id)
                            ->where('estado', '=', 1)
                            ->update(array('estado' => 0));
                       $probando="editar";
                        
                    }
                    /*return Response::json(
                        array(
                            'rst'   => 1,
                            'msj'   => "Probando Ando",
                            'datos' => $probando,
                            'cantrfd' => $cantrfd,
                            'rfdv' => $rfdv,
                            'ruta_flujo_id'=>$rutaFlujo->id
                        )
                    );*/

                // probando para los verbos
                $posdetalleTiempoG= array("0","0");

                if( trim($post)!='' and $post*1>=0 ){
                    $detalleTiempoG=explode( ",", $verboG[$post] );
                    
                    if( $theadArea[$i]=="0" ){
                        $posdetalleTiempoG= explode( "|", $tbodyArea[$i] );
                    }

                    $dtg="";

                    if( isset($detalleTiempoG[ $posdetalleTiempoG[1] ]) and trim($detalleTiempoG[ $posdetalleTiempoG[1] ])!=''){
                        $dtg=explode( "_", $detalleTiempoG[ $posdetalleTiempoG[1] ] );
                        if( trim($dtg[1])!='' ){
                            $detdtg=explode("|",$dtg[1]);
                            $detdtg2=explode("|",$dtg[2]);

                            for($j=0;$j<count($detdtg);$j++){
                                $rutaFlujoDetalleVerbo="";
                                
                                $rutaFlujoDetalleVerbo= new RutaFlujoDetalleVerbo;
                                $rutaFlujoDetalleVerbo['usuario_created_at']= Auth::user()->id;
                                $rutaFlujoDetalleVerbo['ruta_flujo_detalle_id']= $rutaFlujoDetalle->id;
                                $rutaFlujoDetalleVerbo['nombre']=$detdtg[$j];
                                $rutaFlujoDetalleVerbo['condicion']=$detdtg2[$j];
                                $rutaFlujoDetalleVerbo->save();
                            }
                        }
                    }

                }
                //DB::rollback();
            }

            DB::commit();
            return Response::json(
                array(
                    'rst'   => 1,
                    'msj'   => $mensajefinal,
                    'datos' => "Hola Probando ando",
                    'ruta_flujo_id'=>$rutaFlujo->id
                )
            );
        }
    }

}
