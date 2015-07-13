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

    public function postValidar()
    {
        if ( Request::ajax() ) {
            $rf             = new RutaFlujo();
            $cargar         = Array();
            $cargar         = $rf->getValidar();

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

            if($validaVerbo==''){
            $validaVerbo = $rf->validaOrden();
            }

            if($validaVerbo==''){
            $validaVerbo = $rf->validaRol();
            }

            if($validaVerbo==''){
            $validaVerbo = $rf->validaVerbo();
            }

            if($validaVerbo==''){
            $validaVerbo = $rf->validaDocuento();
            }

            if($validaVerbo==''){
            $validaVerbo = $rf->validaDescripcion();
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

    public function postActualizar()
    {
        if ( Request::ajax() ) {
            $rpt=array();
            $rf                 = new RutaFlujo();

            $actualizar         = Array();
            $actualizar         = $rf->actualizarRuta();
            $rpt=array(
                    'rst'   => 1,
                    'msj' => ".::Se actualizó correctamente::."
                );

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

            $estadoG= explode( "*", Input::get('estadoG') );
            $areasGid= explode( "*", Input::get('areasGId') );
            $theadArea= explode( "*", Input::get('theadArea') );
            $tbodyArea= explode( "*", Input::get('tbodyArea') );

            $tiempoGid= explode( "*", Input::get('tiempoGId') );
            $tiempoG= explode( "*", Input::get('tiempoG') );
            $verboG= explode( "*", Input::get('verboG') );

            $finalizar= DB::table('rutas_flujo_detalle')
                          ->where('ruta_flujo_id', '=', $rutaFlujo->id)
                          ->where('norden', '>', count($areasGid))
                          ->where('estado', '=', 1)
                          ->update( array(
                                        'estado'=> 0,
                                        'usuario_updated_at'=> Auth::user()->id
                                    )
                            );

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
                            ->update(array(
                                        'estado' => 0,
                                        'usuario_updated_at'=> Auth::user()->id
                                    )
                            );
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
                $rutaFlujoDetalle['estado_ruta']= $estadoG[$i];
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
                            ->update(array(
                                        'estado' => 0,
                                        'usuario_updated_at'=> Auth::user()->id
                                    )
                            );
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
                        //if( trim($dtg[1])!='' ){
                            $detdtg=explode("|",$dtg[1]);
                            $detdtg2=explode("|",$dtg[2]);
                            $detdtg3=explode("|",$dtg[3]);
                            $detdtg4=explode("|",$dtg[4]);
                            $detdtg5=explode("|",$dtg[5]);
                            $detdtg6=explode("|",$dtg[6]);

                            for($j=0;$j<count($detdtg);$j++){
                                $rutaFlujoDetalleVerbo="";
                                
                                $rutaFlujoDetalleVerbo= new RutaFlujoDetalleVerbo;
                                $rutaFlujoDetalleVerbo['usuario_created_at']= Auth::user()->id;
                                $rutaFlujoDetalleVerbo['ruta_flujo_detalle_id']= $rutaFlujoDetalle->id;
                                $rutaFlujoDetalleVerbo['nombre']=$detdtg[$j];
                                $rutaFlujoDetalleVerbo['condicion']=$detdtg2[$j];
                                if($detdtg3[$j]!=''){
                                $rutaFlujoDetalleVerbo['rol_id']=$detdtg3[$j];
                                }

                                if($detdtg4[$j]!=''){
                                $rutaFlujoDetalleVerbo['verbo_id']=$detdtg4[$j];
                                }

                                if($detdtg5[$j]!=''){
                                $rutaFlujoDetalleVerbo['documento_id']=$detdtg5[$j];
                                }

                                if($detdtg6[$j]!=''){
                                $rutaFlujoDetalleVerbo['orden']=$detdtg6[$j];
                                }

                                $rutaFlujoDetalleVerbo->save();
                            }
                        //}
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

    public function postCreardos()
    {
        if ( Request::ajax() ) {
            DB::beginTransaction();
            $rutaFlujo="";
            $mensajefinal=".::Se registro correctamente::.";
            $rutaFlujo = new RutaFlujoAux;
            $rutaFlujo['usuario_created_at']= Auth::user()->id;
            $rutaFlujo['estado']= 1;

            $rutaFlujo['flujo_id']= Input::get('flujo_id');
            $rutaFlujo['persona_id']= Auth::user()->id;
            $rutaFlujo['area_id']= Input::get('area_id');
            $rutaFlujo['ruta_id_dep']= Input::get('ruta_flujo_id');

            $rutaFlujo->save();

            $areasGid= explode( "*", Input::get('areasGId') );
            $theadArea= explode( "*", Input::get('theadArea') );
            $tbodyArea= explode( "*", Input::get('tbodyArea') );

            $tiempoGid= explode( "*", Input::get('tiempoGId') );
            $tiempoG= explode( "*", Input::get('tiempoG') );
            $verboG= explode( "*", Input::get('verboG') );

            for($i=0; $i<count($areasGid); $i++ ){
                $rutaFlujoDetalle = new RutaFlujoDetalleAux;
                $rutaFlujoDetalle['usuario_created_at']= Auth::user()->id;
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
                                
                                $rutaFlujoDetalleVerbo= new RutaFlujoDetalleVerboAux;
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

            $verificando=true;

            $qinicial=" SELECT * 
                        FROM rutas_flujo_detalle 
                        WHERE ruta_flujo_id='".Input::get('ruta_flujo_id')."'
                        AND estado=1
                        ORDER BY ruta_flujo_id,norden";
            $qrinicial=DB::select($qinicial);

            $qinicialaux=" SELECT * 
                        FROM rutas_flujo_detalle_aux 
                        WHERE ruta_flujo_id='".$rutaFlujo->id."'
                        AND estado=1
                        ORDER BY ruta_flujo_id,norden";
            $qrinicialaux=DB::select($qinicialaux);

        if( count($qrinicial)==count($qrinicialaux) ){

            for( $i=0; $i< count($qrinicial); $i++ ){
                if($qrinicial[$i]->norden!=$qrinicialaux[$i]->norden){
                    $verificando=false;
                    $i=9999;
                    break;
                }
                elseif($qrinicial[$i]->area_id!=$qrinicialaux[$i]->area_id){
                    $verificando=false;
                    $i=9999;
                    break;
                }
                elseif($qrinicial[$i]->tiempo_id!=$qrinicialaux[$i]->tiempo_id){
                    $verificando=false;
                    $i=9999;
                    break;
                }
                elseif($qrinicial[$i]->dtiempo!=$qrinicialaux[$i]->dtiempo){
                    $verificando=false;
                    $i=9999;
                    break;
                }
                else{
                    $qinicialverbo="    SELECT * 
                                        FROM rutas_flujo_detalle_verbo 
                                        WHERE ruta_flujo_detalle_id='".$qrinicial[$i]->id."'
                                        AND estado=1
                                        ORDER BY ruta_flujo_detalle_id,nombre";
                    $qrinicialverbo=DB::select($qinicialverbo);

                    $qinicialverboaux=" SELECT * 
                                        FROM rutas_flujo_detalle_verbo_aux 
                                        WHERE ruta_flujo_detalle_id='".$qrinicialaux[$i]->id."'
                                        AND estado=1
                                        ORDER BY ruta_flujo_detalle_id,nombre";
                    $qrinicialverboaux=DB::select($qinicialverboaux);

                    if( count($qrinicialverbo)==count($qrinicialverboaux) ){
                        for( $j=0; $j< count($qrinicialverbo); $j++ ){
                            if($qrinicialverbo[$j]->nombre!=$qrinicialverboaux[$j]->nombre){
                                $verificando=false;
                                $j=9999;
                                $i=9999;
                                break;
                            }
                            elseif($qrinicialverbo[$j]->condicion!=$qrinicialverboaux[$j]->condicion){
                                $verificando=false;
                                $j=9999;
                                $i=9999;
                                break;
                            }
                        }// finliza for!! verbo
                    }
                    else{
                        $verificando=false;
                        $i=9999;
                        break;
                    }
                }
            }//finaliza el for!!

        }
        else{
            $verificando=false;
        }

        $envioestado=0;
        $iniciara= Input::get('iniciara');
        $ruta_id=Input::get('ruta_id');
        $ruta_detalle_id= Input::get('ruta_detalle_id');
        $estado_final=Input::get('estado_final');
        $condicional=Input::get('condicional');

        if($verificando==false){
            $envioestado=1;
            $qfinal="   SELECT * 
                        FROM rutas_flujo rf
                        INNER JOIN rutas_flujo_detalle rfd ON rf.id=rfd.ruta_flujo_id AND rf.estado=1
                        WHERE rf.flujo_id='".Input::get('flujo_id')."' 
                        AND rf.area_id='".Input::get('area_id')."'
                        AND rf.estado=1";
            $qrfinal= DB::select($qfinal);
        }

        if( $iniciara!="" ){
            $sqldetalle="SELECT * 
                         FROM rutas_detalle
                         WHERE ruta_id='".$ruta_id."'
                         AND estado=1
                         ORDER BY norden ";
            $qdetalle= DB::select($sqldetalle);

            for($i=0; $i<count($qdetalle); $i++){
                if( trim($qdetalle[$i]->dtiempo_final)!='' 
                    AND $qdetalle[$i]->norden>=$iniciara ){
                    $rda=RutaDetalle::find($qdetalle[$i]->id);
                    $rda['condicion']=2;
                    $rda->save();

                    $rd=new RutaDetalle;
                    $rd['ruta_id']=$qdetalle[$i]->ruta_id;
                    $rd['area_id']=$qdetalle[$i]->area_id;
                    $rd['tiempo_id']=$qdetalle[$i]->tiempo_id;
                    $rd['dtiempo']=$qdetalle[$i]->dtiempo;
                    $rd['norden']=$qdetalle[$i]->norden;

                    if($qdetalle[$i]->norden==$iniciara){
                        $rd['fecha_inicio']=date("Y-m-d");
                    }
                    $rd->save();

                    $sqldetalleverbo="SELECT * 
                                      FROM rutas_detalle_verbo
                                      WHERE ruta_detalle_id='".$qdetalle[$i]->id."'
                                      ORDER BY id ";
                    $qdetalleverbo= DB::select($sqldetalleverbo);
                    for($j=0; $j<count($qdetalleverbo); $j++ ){
                        $rdv= new RutaDetalleVerbo;
                        $rdv['ruta_detalle_id']=$rd->id;
                        $rdv['nombre']=$qdetalleverbo[$j]->nombre;
                        $rdv['condicion']=$qdetalleverbo[$j]->condicion;
                        $rdv->save();
                    }
                }
                elseif( trim($qdetalle[$i]->dtiempo_final)=='' AND $qdetalle[$i]->norden<=$iniciara+$condicional ){
                    if($qdetalle[$i]->norden==$iniciara){
                        $rda=RutaDetalle::find($qdetalle[$i]->id);
                        $rda['fecha_inicio']=date("Y-m-d");
                        $rda->save();
                    }
                    else{
                        $rda=RutaDetalle::find($qdetalle[$i]->id);
                        $rda['condicion']=1;
                        $rda->save();
                    }
                }
            }
        }

            $rdvalida=RutaDetalle::find($ruta_detalle_id);
            $rdvalida['alerta']=$estado_final;
            $rdvalida->save();



            DB::commit();
            return Response::json(
                array(
                    'rst'   => 1,
                    'msj'   => $mensajefinal,
                    'ruta_flujo_id'=>$rutaFlujo->id,
                    'envioestado'=>$envioestado,
                )
            );
        }
    }

}
