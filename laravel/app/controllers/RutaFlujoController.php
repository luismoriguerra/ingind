<?php
class RutaFlujoController extends \BaseController
{

    public function postRegistrar()
    {
        if ( Request::ajax() ) {
            DB::beginTransaction();
            $rutaFlujo="";
            $mensajefinal=".::Se registro correctamente::.";
            $modificap=false;
            if ( Input::get('ruta_flujo_id') ) {
                $modificap=true;
                $mensajefinal=".::Actualización finalizada::.";
                $rutaFlujo = RutaFlujo::find( Input::get('ruta_flujo_id') );
                $rutaFlujo['usuario_updated_at']= Auth::user()->id;

                $rutaFlujo['nactualizar']=$rutaFlujo->nactualizar*1+1;
            }
            else{
                $rutaFlujo = new RutaFlujo;
                $rutaFlujo['usuario_created_at']= Auth::user()->id;
                $rutaFlujo['estado']= 2;
                $rutaFlujo['flujo_id']= Input::get('flujo_id');
                $rutaFlujo['persona_id']= Auth::user()->id;
                $rutaFlujo['area_id']= Input::get('area_id');
                $rutaFlujo['tipo_ruta']=Input::get('tipo_ruta');
            }

            

            $rutaFlujo->save();

            /*Agregar Valores Auxiliares*/
            $auxflujo   = Flujo::find( Input::get('flujo_id') );
            $auxpersona = Persona::find( Auth::user()->id );
            $auxarea    = Area::find( Input::get('area_id') );
            /****************************/
            $estadoG= explode( "*", Input::get('estadoG') );
            $areasGid= explode( "*", Input::get('areasGId') );
            $theadArea= explode( "*", Input::get('theadArea') );
            $tbodyArea= explode( "*", Input::get('tbodyArea') );

            $tiempoGid= explode( "*", Input::get('tiempoGId') );
            $tiempoG= explode( "*", Input::get('tiempoG') );
            $verboG= explode( "*", Input::get('verboG') );

            $modificaG=Input::get('modificaG');

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
                $validapase=explode("*".$i."*",$modificaG);
                $valor=1;
                if ( Input::get('ruta_flujo_id') ) {
                    $valor= DB::table('rutas_flujo_detalle')
                                ->where('ruta_flujo_id', '=', $rutaFlujo->id)
                                ->where('norden', '=', ($i+1))
                                ->where('area_id', '=', $areasGid[$i] )
                                ->where('estado', '=', 1)
                                ->count();
                }
                
                if( $modificap==false || $valor==0 || ($modificap==true && count($validapase)>1) ){ //Validacion solo q actualice o genre cuando sea nuevo o permitido
                    $rutaFlujoDetalle="";
                    if ( Input::get('ruta_flujo_id') ) {
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

                            $em= "  SELECT a.id,cp.persona_id,p.email,
                                    p.paterno,p.materno,p.nombre,a.nombre area
                                    FROM area_cargo_persona acp
                                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                    INNER JOIN personas p ON p.id=cp.persona_id AND p.estado=1
                                    WHERE acp.estado=1
                                    AND cp.cargo_id=5
                                    AND acp.area_id=".$areasGid[$i]."
                                    ORDER BY cp.persona_id";
                            $qem= DB::select($em);
                            //echo $em;
                            if( count($qem)>0 ){
                                for($k=0;$k<count($qem);$k++){
                                $parametros=array(
                                    'paso'      => ($i+1),
                                    'persona'   => $qem[$k]->paterno.' '.$qem[$k]->materno.','.$qem[$k]->nombre,
                                    'area'      => $qem[$k]->area,
                                    'procesoe'  => $auxflujo->nombre,
                                    'personae'  => $auxpersona->paterno.' '.$auxpersona->materno.','.$auxpersona->nombre,
                                    'areae'     => $auxarea->nombre
                                );

                                    try{
                                        Mail::send('emails', $parametros , 
                                            function($message) use ($qem,$k) {
                                            $message
                                                ->to($qem[$k]->email)
                                                ->subject('.::Se ha involucrado en nuevo proceso::.');
                                            }
                                        );
                                    }
                                    catch(Exception $e){
                                        //echo $qem[$k]->email."<br>";
                                    }
                                }
                            }

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
                        $em= "  SELECT a.id,cp.persona_id,p.email,p.paterno,p.materno,p.nombre,a.nombre area
                                FROM area_cargo_persona acp
                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                INNER JOIN personas p ON p.id=cp.persona_id AND p.estado=1
                                WHERE acp.estado=1
                                AND cp.cargo_id=5
                                AND acp.area_id=".$areasGid[$i]."
                                ORDER BY cp.persona_id";
                        $qem= DB::select($em);
                        //echo "2".$em;
                        if( count($qem)>0 ){
                            for($k=0;$k<count($qem);$k++){
                            $parametros=array(
                                'paso'      => ($i+1),
                                'persona'   => $qem[$k]->paterno.' '.$qem[$k]->materno.','.$qem[$k]->nombre,
                                'area'      => $qem[$k]->area,
                                'procesoe'  => $auxflujo->nombre,
                                'personae'  => $auxpersona->paterno.' '.$auxpersona->materno.','.$auxpersona->nombre,
                                'areae'     => $auxarea->nombre
                            );

                                try{
                                    Mail::send('emails', $parametros , 
                                        function($message) use( $qem,$k ) {
                                        $message
                                            ->to($qem[$k]->email)
                                            ->subject('.::Se ha involucrado en nuevo proceso::.');
                                        }
                                    );
                                }
                                catch(Exception $e){
                                    //echo $qem[$k]->email."<br>";
                                }
                            }
                        }

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
                }// Fin del if cuando se valida
                //DB::rollback();
            }

            DB::commit();
            return Response::json(
                array(
                    'rst'   => 1,
                    'msj'   => $mensajefinal,
                    'ruta_flujo_id'=>$rutaFlujo->id,
                )
            );
        }
    }

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
                                
                                $rutaFlujoDetalleVerbo= new RutaFlujoDetalleVerboAux;
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

            $verificando=true;
            $veriuno=true;

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

            $ruta_id=Input::get('ruta_id');
// cuando  incial es mayor a aux, inical es menor q aux cuando ambos son iguales...
            if(count($qrinicial)>count($qrinicialaux)){ // c
                    DB::table('rutas_detalle')
                       ->where('ruta_id', '=', $ruta_id)
                       ->where('norden', '>', count($qrinicialaux))
                       ->where('estado', '=', '1')
                       ->update(array(
                                    'condicion'=>2,
                                    'usuario_updated_at'=>Auth::user()->id,
                                    'updated_at'=>date("Y-m-d H:i:s")
                                    )
                       );
            }
            for( $i=0; $i< count($qrinicialaux); $i++ ){
                if( count($qrinicial)>$i ){ // indica q aux es mayor o igual
                    $veriuno=true;
                    if($qrinicial[$i]->norden!=$qrinicialaux[$i]->norden){
                        $verificando=false;
                        $veriuno=false;
                    }
                    elseif($qrinicial[$i]->area_id!=$qrinicialaux[$i]->area_id){
                        $verificando=false;
                        $veriuno=false;
                    }
                    elseif($qrinicial[$i]->tiempo_id!=$qrinicialaux[$i]->tiempo_id){
                        $verificando=false;
                        $veriuno=false;
                    }
                    elseif($qrinicial[$i]->dtiempo!=$qrinicialaux[$i]->dtiempo){
                        $verificando=false;
                        $veriuno=false;
                    }
                    elseif($qrinicial[$i]->estado_ruta!=$qrinicialaux[$i]->estado_ruta){
                        $verificando=false;
                        $veriuno=false;
                    }
                    //else{
                    $qdetalleedit=array();
                    if($veriuno==false){
                        $sqldetalle="SELECT *
                                     FROM rutas_detalle
                                     WHERE ruta_id='".$ruta_id."'
                                     AND norden='".$qrinicialaux[$i]->norden."'
                                     AND estado=1
                                     ORDER BY norden ";
                        $qdetalleedit= DB::select($sqldetalle);
                        try{
                        $rda=RutaDetalle::find($qdetalleedit[0]->id);
                        $rda['usuario_updated_at']= Auth::user()->id;
                        $rda['area_id']=$qdetalleedit[0]->area_id;
                        $rda['tiempo_id']=$qdetalleedit[0]->tiempo_id;
                        $rda['dtiempo']=$qdetalleedit[0]->dtiempo;
                        $rda['estado_ruta']=$qdetalleedit[0]->estado_ruta;
                        $rda->save();
                        }
                        catch (Exception $e) {
                            //echo $ruta_id."|".$qrinicialaux[$i]->norden."|".$i."|".$sqldetalle;
                            DB::rollback();
                            exit(0);
                        }
                        //aqui actualizando la data de la ruta actual de tramite
                    }
                    $qinicialverbo="    SELECT nombre,condicion,
                    IFNULL(rol_id,'') rol_id,IFNULL(verbo_id,'') verbo_id,
                    IFNULL(documento_id,'') documento_id,IFNULL(orden,'') orden
                                        FROM rutas_flujo_detalle_verbo 
                                        WHERE ruta_flujo_detalle_id='".$qrinicial[$i]->id."'
                                        AND estado=1
                                        ORDER BY ruta_flujo_detalle_id,nombre";
                    $qrinicialverbo=DB::select($qinicialverbo);

                    $qinicialverboaux=" SELECT nombre,condicion,
                    IFNULL(rol_id,'') rol_id,IFNULL(verbo_id,'') verbo_id,
                    IFNULL(documento_id,'') documento_id,IFNULL(orden,'') orden
                                        FROM rutas_flujo_detalle_verbo_aux 
                                        WHERE ruta_flujo_detalle_id='".$qrinicialaux[$i]->id."'
                                        AND estado=1
                                        ORDER BY ruta_flujo_detalle_id,nombre";
                    $qrinicialverboaux=DB::select($qinicialverboaux);

                    if(count($qrinicialverbo)>count($qrinicialverboaux)){ // c
                            DB::table('rutas_detalle_verbo AS rdv')
                               ->join('rutas_detalle AS rd',
                                      'rdv.ruta_detalle_id','=','rd.id')
                               ->where('rd.norden', '=', $qrinicialaux[$i]->norden)
                               ->where('rd.ruta_id', '=', $ruta_id)
                               ->where('rdv.orden', '>', count($qrinicialverboaux))
                               ->where('rdv.estado', '=', '1')
                               ->where('rd.estado', '=', '1')
                               ->update(array(
                                            'rdv.estado'=>0,
                                            'rdv.usuario_updated_at'=>Auth::user()->id,
                                            'rdv.updated_at'=>date("Y-m-d H:i:s")
                                            )
                               );
                    }

                    for( $j=0; $j< count($qrinicialverboaux); $j++ ){
                        if( count($qrinicialverbo)>$i ){
                            $veriunov=true;
                            if($qrinicialverbo[$j]->nombre!=$qrinicialverboaux[$j]->nombre){
                                $verificando=false;
                                $veriunov=false;
                            }
                            elseif($qrinicialverbo[$j]->condicion!=$qrinicialverboaux[$j]->condicion){
                                $verificando=false;
                                $veriunov=false;
                            }
                            elseif($qrinicialverbo[$j]->rol_id!=$qrinicialverboaux[$j]->rol_id){
                                $verificando=false;
                                $veriunov=false;
                            }
                            elseif($qrinicialverbo[$j]->verbo_id!=$qrinicialverboaux[$j]->verbo_id){
                                $verificando=false;
                                $veriunov=false;
                            }
                            elseif($qrinicialverbo[$j]->documento_id!=$qrinicialverboaux[$j]->documento_id){
                                $verificando=false;
                                $veriunov=false;
                            }
                            elseif($qrinicialverbo[$j]->orden!=$qrinicialverboaux[$j]->orden){
                                $verificando=false;
                                $veriunov=false;
                            }

                            if($veriunov==false){
                                $qdetalleeditv=DB::table('rutas_detalle_verbo AS rdv')
                                               ->join('rutas_detalle AS rd',
                                                      'rdv.ruta_detalle_id','=','rd.id')
                                               ->select('rdv.id','rdv.ruta_detalle_id')
                                               ->where('rd.norden', '=', $qrinicialaux[$i]->norden)
                                               ->where('rd.ruta_id', '=', $ruta_id)
                                               ->where('rdv.orden', '=', $qrinicialverboaux[$j]->orden)
                                               ->where('rdv.estado', '=', '1')
                                               ->where('rd.estado', '=', '1')
                                               ->get();

                                $rd= RutaDetalleVerbo::find($qdetalleeditv[0]->id);
                                $rd['ruta_detalle_id']= $qdetalleeditv[0]->ruta_detalle_id;
                                $rd['usuario_updated_at']= Auth::user()->id;
                                $rd['nombre']=$qrinicialverboaux[$j]->nombre;
                                $rd['condicion']=$qrinicialverboaux[$j]->condicion;
                                if(trim($qrinicialverboaux[$j]->rol_id)!=''){
                                $rd['rol_id']=$qrinicialverboaux[$j]->rol_id;
                                }

                                if(trim($qrinicialverboaux[$j]->verbo_id)!=''){
                                $rd['verbo_id']=$qrinicialverboaux[$j]->verbo_id;
                                }

                                if(trim($qrinicialverboaux[$j]->documento_id)!=''){
                                $rd['documento_id']=$qrinicialverboaux[$j]->documento_id;
                                }

                                if(trim($qrinicialverboaux[$j]->orden)!=''){
                                $rd['orden']=$qrinicialverboaux[$j]->orden;
                                }

                                $rd->save();
                                //aqui actualizando la data de la ruta actual de tramite
                            }
                        }
                        else{
                            if(count($qdetalleedit)==0){
                                $sqldetalle="SELECT *
                                             FROM rutas_detalle
                                             WHERE ruta_id='".$ruta_id."'
                                             AND norden='".$qrinicialaux[$i]->norden."'
                                             AND estado=1
                                             ORDER BY norden ";
                                $qdetalleedit= DB::select($sqldetalle);
                            }

                            $rd= new RutaDetalleVerbo;
                            $rd['usuario_created_at']= Auth::user()->id;
                            $rd['ruta_detalle_id']= $qdetalleedit[0]->id;
                            $rd['nombre']=$qrinicialverboaux[$j]->nombre;
                            $rd['condicion']=$qrinicialverboaux[$j]->condicion;
                            if(trim($qrinicialverboaux[$j]->rol_id)!=''){
                            $rd['rol_id']=$qrinicialverboaux[$j]->rol_id;
                            }

                            if(trim($qrinicialverboaux[$j]->verbo_id)!=''){
                            $rd['verbo_id']=$qrinicialverboaux[$j]->verbo_id;
                            }

                            if(trim($qrinicialverboaux[$j]->documento_id)!=''){
                            $rd['documento_id']=$qrinicialverboaux[$j]->documento_id;
                            }

                            if(trim($qrinicialverboaux[$j]->orden)!=''){
                            $rd['orden']=$qrinicialverboaux[$j]->orden;
                            }

                            $rd->save();
                            $verificando=false;
                        }
                    }// finliza for!! verbo
                }
                else{
                    $rd=new RutaDetalle;
                    $rd['ruta_id']= $ruta_id;
                    $rd['usuario_created_at']= Auth::user()->id;
                    $rd['area_id']=$qrinicialaux[$i]->area_id;
                    $rd['tiempo_id']=$qrinicialaux[$i]->tiempo_id;
                    $rd['dtiempo']=$qrinicialaux[$i]->dtiempo;
                    $rd['estado_ruta']=$qrinicialaux[$i]->estado_ruta;
                    $rd['norden']=$qrinicialaux[$i]->norden;
                    $rd->save();
                    $verificando=false;

                    $qinicialverboadd=" SELECT nombre,condicion,
                    IFNULL(rol_id,'') rol_id,IFNULL(verbo_id,'') verbo_id,
                    IFNULL(documento_id,'') documento_id,IFNULL(orden,'') orden
                                        FROM rutas_flujo_detalle_verbo_aux 
                                        WHERE ruta_flujo_detalle_id='".$qrinicialaux[$i]->id."'
                                        AND estado=1
                                        ORDER BY ruta_flujo_detalle_id,nombre";
                    $qrinicialverboadd=DB::select($qinicialverboadd);

                    for($j=0;$j<count($qrinicialverboadd);$j++){
                        $rdv= new RutaDetalleVerbo;
                        $rdv['usuario_created_at']= Auth::user()->id;
                        $rdv['ruta_detalle_id']= $rd->id;
                        $rdv['nombre']=$qrinicialverboadd[$j]->nombre;
                        $rdv['condicion']=$qrinicialverboadd[$j]->condicion;
                        if(trim($qrinicialverboadd[$j]->rol_id)!=''){
                        $rdv['rol_id']=$qrinicialverboadd[$j]->rol_id;
                        }

                        if(trim($qrinicialverboadd[$j]->verbo_id)!=''){
                        $rdv['verbo_id']=$qrinicialverboadd[$j]->verbo_id;
                        }

                        if(trim($qrinicialverboadd[$j]->documento_id)!=''){
                        $rdv['documento_id']=$qrinicialverboadd[$j]->documento_id;
                        }

                        if(trim($qrinicialverboadd[$j]->orden)!=''){
                        $rdv['orden']=$qrinicialverboadd[$j]->orden;
                        }

                        $rdv->save();
                    }
                    //falta crear sus verbos!!
                }
                //}
            }//finaliza el for!!

        $envioestado=0;
        $iniciara= Input::get('iniciara');
        $ruta_id=Input::get('ruta_id');
        $ruta_detalle_id= Input::get('ruta_detalle_id');
        $estado_final=Input::get('estado_final');
        $condicional=Input::get('condicional');
        $crear_nuevo= Input::get('crear_nuevo');

        if($verificando==false AND $crear_nuevo=='1'){
            $rf= RutaFlujo::find(Input::get('ruta_flujo_id'));
            $rf['n_flujo_error']=$rf['n_flujo_error']+1;
            $rf['usuario_created_at']= Auth::user()->id;
            $rf->save();

            $rutaFlujo = new RutaFlujo;
            $rutaFlujo['usuario_created_at']= Auth::user()->id;
            $rutaFlujo['estado']= 1;

            $rutaFlujo['flujo_id']= Input::get('flujo_id');
            $rutaFlujo['persona_id']= Auth::user()->id;
            $rutaFlujo['area_id']= Input::get('area_id');
            $rutaFlujo['n_flujo_ok']= '1';
            $rutaFlujo['ruta_id_dep']= Input::get('ruta_flujo_id');

            $rutaFlujo->save();

            // Actualizamos modelo del flujo
            $ract = Ruta::find($ruta_id);
            $ract['ruta_flujo_id']=$rutaFlujo->id;
            $ract->save();

            /*$sqlparaactualizar="SELECT (SELECT count(rf2.id) 
                                        FROM rutas_flujo rf2 
                                        WHERE rf2.id<=rf.id 
                                        AND rf2.flujo_id=rf.flujo_id 
                                        AND rf2.orden>0
                                        ) AS cant,rf.*
                                FROM rutas_flujo rf
                                WHERE rf.id='".$rutaFlujo->id."' ";
            $sqlparaactualizar=DB::select($sqlparaactualizar);

            $rff = RutaFlujo::find($sqlparaactualizar[0]->id);
            $rff['orden']=$sqlparaactualizar[0]->cant;
            $rff->save();*/

            $areasGid= explode( "*", Input::get('areasGId') );
            $theadArea= explode( "*", Input::get('theadArea') );
            $tbodyArea= explode( "*", Input::get('tbodyArea') );

            $tiempoGid= explode( "*", Input::get('tiempoGId') );
            $tiempoG= explode( "*", Input::get('tiempoG') );
            $verboG= explode( "*", Input::get('verboG') );

            for($i=0; $i<count($areasGid); $i++ ){
                $rutaFlujoDetalle = new RutaFlujoDetalle;
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

                }// fin if

                //DB::rollback();
            }// fin for
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
                                      AND estado=1
                                      ORDER BY id ";
                    $qdetalleverbo= DB::select($sqldetalleverbo);
                    for($j=0; $j<count($qdetalleverbo); $j++ ){
                        $rdv= new RutaDetalleVerbo;
                        $rdv['ruta_detalle_id']=$rd->id;
                        $rdv['nombre']=$qdetalleverbo[$j]->nombre;
                        $rdv['condicion']=$qdetalleverbo[$j]->condicion;

                        if(trim($qdetalleverbo[$j]->rol_id)!=''){
                        $rdv['rol_id']=$qdetalleverbo[$j]->rol_id;
                        }

                        if(trim($qdetalleverbo[$j]->verbo_id)!=''){
                        $rdv['verbo_id']=$qdetalleverbo[$j]->verbo_id;
                        }

                        if(trim($qdetalleverbo[$j]->documento_id)!=''){
                        $rdv['documento_id']=$qdetalleverbo[$j]->documento_id;
                        }

                        $rdv['orden']=$qdetalleverbo[$j]->orden;

                        $rdv->save();
                    }
                }
                elseif( trim($qdetalle[$i]->dtiempo_final)=='' AND $qdetalle[$i]->norden<=$iniciara ){ //+$condicional  le quite porq el condiconal deberia ya estar dentro del calculo
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
