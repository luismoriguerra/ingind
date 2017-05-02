<?php
class Ruta extends Eloquent
{
    public $table="rutas";

    /**
     * Areas relationship
     */
    public function crearRuta(){
        DB::beginTransaction();
        $codigounico="";
        $codigounico=Input::get('codigo');
        $id_documento='';
        if( Input::get('fecha_inicio')=='0000-00-00 00:00:00' ){
            Input::get('fecha_inicio')=date('Y-m-d H:i:s');
        }

        if( Input::has('documento_id') ){
            $id_documento=Input::get('documento_id');
        }
        $ruta_id= Input::get('ruta_id');
        $rutadetalle_id= Input::get('rutadetalle_id');
        $tablarelacion_id= Input::get('tablarelacion_id');

        $tablaRelacion=DB::table('tablas_relacion as tr')
                        ->join(
                            'rutas as r',
                            'tr.id','=','r.tabla_relacion_id'
                        )
                        ->where('tr.id_union', '=', $codigounico)
                        ->where('r.ruta_flujo_id', '=', Input::get('ruta_flujo_id'))
                        ->where('tr.estado', '=', '1')
                        ->where('r.estado', '=', '1')
                        ->get();

        if(count($tablaRelacion)>0){
            DB::rollback();
            return  array(
                    'rst'=>2,
                    'msj'=>'El trámite ya fue registrado anteriormente'
                );
        }
        else{

        $tablaRelacion=new TablaRelacion;
        $tablaRelacion['software_id']=1;

        $tablaRelacion['id_union']=Input::get('codigo');
        
        $tablaRelacion['fecha_tramite']= Input::get('fecha_inicio'); //Input::get('fecha_tramite');
        $tablaRelacion['tipo_persona']=Input::get('tipo_persona');

        if( Input::has('paterno') AND Input::has('materno') AND Input::has('nombre') ){
            $tablaRelacion['paterno']=Input::get('paterno');
            $tablaRelacion['materno']=Input::get('materno');
            $tablaRelacion['nombre']=Input::get('nombre');
        }
        elseif( Input::has('razon_social') AND Input::has('ruc') ){
            $tablaRelacion['razon_social']=Input::get('razon_social');
            $tablaRelacion['ruc']=Input::get('ruc');
        }
        elseif( Input::has('area_p_id') ){
            $tablaRelacion['area_id']=Input::get('area_p_id');
        }
        elseif( Input::has('carta_id') ){ // Este caso solo es para asignar carta inicio
            $tablaRelacion['area_id']=Auth::user()->area_id;
        }
        elseif( Input::has('razon_social') ){
            $tablaRelacion['razon_social']=Input::get('razon_social');
        }


        if( Input::has('referente') AND trim(Input::get('referente'))!='' ){
            $tablaRelacion['referente']=Input::get('referente');
        }

        if( Input::has('responsable') AND trim(Input::get('responsable'))!='' ){
            $tablaRelacion['responsable']=Input::get('responsable');
        }
        $tablaRelacion['sumilla']=Input::get('sumilla');

        if( Input::has('doc_digital_id')){
             $tablaRelacion['doc_digital_id']=Input::get('doc_digital_id');
        }

        $tablaRelacion['persona_autoriza_id']=Input::get('id_autoriza');
        $tablaRelacion['persona_responsable_id']=Input::get('id_responsable');

        $tablaRelacion['usuario_created_at']=Auth::user()->id;
        $tablaRelacion->save();

        $rutaFlujo=RutaFlujo::find(Input::get('ruta_flujo_id'));

        $ruta= new Ruta;
        $ruta['tabla_relacion_id']=$tablaRelacion->id;
        $ruta['fecha_inicio']= Input::get('fecha_inicio');
        $ruta['ruta_flujo_id']=$rutaFlujo->id;
        $ruta['flujo_id']=$rutaFlujo->flujo_id;
        $ruta['persona_id']=$rutaFlujo->persona_id;
        if( Input::has('doc_digital_id')){
            $ruta['doc_digital_id']=Input::get('doc_digital_id');
        }
        $ruta['area_id']=$rutaFlujo->area_id;
        $ruta['usuario_created_at']= Auth::user()->id;
        $ruta->save();
        /**************CARTA *************************************************/
        $carta=array();
        if( Input::has('carta_id') ){
            $carta= Carta::find(Input::get('carta_id'));
        }
        else{
            $carta= new Carta;
            $carta['flujo_id']=$ruta->flujo_id;
            $carta['correlativo']=0;
            $carta['nro_carta']=Input::get('codigo');
            $carta['objetivo']="";
            $carta['entregable']="";
            $carta['alcance']="MDI";
            $carta['flujo_id']=$ruta->flujo_id;

            if( trim(Auth::user()->area_id)!='' ){
                $carta['area_id']=Auth::user()->area_id;
            }
            else{
                $carta['area_id']=$ruta->area_id;
            }
        }
            $carta['union']=1;
            $carta['usuario_updated_at']=Auth::user()->id;
            $carta['ruta_id']=$ruta->id;
            $carta->save();
        /*********************************************************************/
        /************Agregado de referidos*************/
        $referido=new Referido;
        $referido['ruta_id']=$ruta->id;
        $referido['tabla_relacion_id']=$tablaRelacion->id;
        if($tablarelacion_id!=''){
            $referido['tabla_relacion_id']=$tablarelacion_id;
        }

        if( Input::has('doc_digital_id')){
               $referido['doc_digital_id']=Input::get('doc_digital_id');
        }
      
        $referido['tipo']=0;
        $referido['ruta_detalle_verbo_id']=0;
        $referido['referido']=$tablaRelacion->id_union;
        $referido['fecha_hora_referido']=$tablaRelacion->created_at;
        $referido['usuario_referido']=$tablaRelacion->usuario_created_at;
        $referido['usuario_created_at']=Auth::user()->id;
        $referido->save();
        /**********************************************/

        $qrutaDetalle=DB::table('rutas_flujo_detalle')
            ->where('ruta_flujo_id', '=', $rutaFlujo->id)
            ->where('estado', '=', '1')
            ->orderBy('norden','ASC')
            ->get();
            $validaactivar=0;
        
        $conteo=0;$array['fecha']=''; // inicializando valores para desglose

            foreach($qrutaDetalle as $rd){
                $rutaDetalle = new RutaDetalle;
                $rutaDetalle['ruta_id']=$ruta->id;
                $rutaDetalle['area_id']=$rd->area_id;
                $rutaDetalle['tiempo_id']=$rd->tiempo_id;
                $rutaDetalle['dtiempo']=$rd->dtiempo;
                $rutaDetalle['norden']=$rd->norden;
                $rutaDetalle['estado_ruta']=$rd->estado_ruta;
                if($rd->norden==1 or ($rd->norden>1 and $validaactivar==0 and $rd->estado_ruta==2) ){
                    $rutaDetalle['fecha_inicio']=Input::get('fecha_inicio');
                }
                else{
                    $validaactivar=1;
                }
                $rutaDetalle['usuario_created_at']= Auth::user()->id;
                $rutaDetalle->save();
                /**************CARTA DESGLOSE*********************************/
                $cartaDesglose=array();
                if( Input::has('carta_id') ){
                    $carta_id=Input::get('carta_id');
                    $sql="  SELECT id
                            FROM carta_desglose
                            WHERE carta_id='$carta_id'
                            AND estado=1
                            ORDER BY id
                            LIMIT $conteo,1";
                    $cd=DB::select($sql);
                    if(count($cd)==0){
                        DB::rollback();
                        return  array(
                                'rst'=>2,
                                'msj'=>'Numero de actidades del proceso no concuerda con numero de actividades de la carta'
                            );
                    }
                    $conteo++;
                    $cartaDesglose=CartaDesglose::find($cd[0]->id);
                }
                else{
                    $sql="  SELECT id
                            FROM personas
                            WHERE estado=1
                            AND rol_id IN (8,9,70)
                            AND area_id='".$rutaDetalle->area_id."'";
                    $person=DB::select($sql);
                        /***********MEDIR LOS TIEMPOS**************************/
                        $cantmin=0;
                        if( $rutaDetalle->tiempo_id==1 ){
                            $cantmin=60;
                        }
                        elseif( $rutaDetalle->tiempo_id==2 ){
                            $cantmin=1440;
                        }

                        if( $array['fecha']=='' ){
                            $array['fecha']= Input::get('fecha_inicio');
                        }
                        $array['tiempo']=($rutaDetalle->dtiempo*$cantmin);
                        $array['area']=$rutaDetalle->area_id;
                        $ff=Carta::CalcularFechaFin($array);
                        $fi=$array['fecha'];
                        $array['fecha']=$ff;

                    $cartaDesglose= new CartaDesglose;
                    $cartaDesglose['carta_id']=$carta->id;
                    $cartaDesglose['tipo_actividad_id']=19;
                    $cartaDesglose['actividad']="Actividad";
                        if( isset($person[0]->id) ){
                        $cartaDesglose['persona_id']=$person[0]->id;
                        }
                    $cartaDesglose['area_id']=$rutaDetalle->area_id;
                    $cartaDesglose['recursos']="";
                    $cartaDesglose['fecha_inicio']=$fi;
                    $cartaDesglose['fecha_fin']=$ff;
                    $cartaDesglose['hora_inicio']="08:00";
                    $cartaDesglose['hora_fin']="17:30";
                    $cartaDesglose['fecha_alerta']=$ff;
                }
                    $cartaDesglose['ruta_detalle_id']=$rutaDetalle->id;
                    $cartaDesglose->save();
                /*************************************************************/
                if( $rd->norden==1 AND Input::has('carta_id') ){
                    $rutaDetalleVerbo = new RutaDetalleVerbo;
                    $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                    $rutaDetalleVerbo['nombre']= '-';
                    $rutaDetalleVerbo['condicion']= '0';
                    $rol_id=1;
                        if( Input::has('rol_id') AND Input::get('rol_id')!='' ){
                            $rol_id=Input::get('rol_id');
                        }
                        elseif( isset(Auth::user()->rol_id) ){
                            $rol_id=Auth::user()->rol_id;
                        }
                    $rutaDetalleVerbo['rol_id']= $rol_id;
                    $rutaDetalleVerbo['verbo_id']= '1';
                    $rutaDetalleVerbo['documento_id']= '57';//Carta de inicio
                    $rutaDetalleVerbo['orden']= '0';
                    $rutaDetalleVerbo['finalizo']='1';
                    $rutaDetalleVerbo['documento']=Input::get('codigo');
                    $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                    $rutaDetalleVerbo['usuario_updated_at']= Auth::user()->id;
                    $rutaDetalleVerbo->save();
                }

                $qrutaDetalleVerbo=DB::table('rutas_flujo_detalle_verbo')
                                ->where('ruta_flujo_detalle_id', '=', $rd->id)
                                ->where('estado', '=', '1')
                                ->orderBy('orden', 'ASC')
                                ->get();
                    if(count($qrutaDetalleVerbo)>0){
                        foreach ($qrutaDetalleVerbo as $rdv) {
                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $rdv->nombre;
                            $rutaDetalleVerbo['condicion']= $rdv->condicion;
                            $rutaDetalleVerbo['rol_id']= $rdv->rol_id;
                            $rutaDetalleVerbo['verbo_id']= $rdv->verbo_id;
                            $rutaDetalleVerbo['documento_id']= $rdv->documento_id;
                            $rutaDetalleVerbo['orden']= $rdv->orden;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();
                        }
                    }
            }

            /*if( Input::has('referente') ){
                $rutaid=$ruta->id;
                $referente=trim( Input::get('referente') );
                $sql="  SELECT r.id, IFNULL(tr.referente,'') referente
                        FROM rutas r
                        INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1
                        WHERE r.estado=1
                        AND tr.id_union='".$referente."'
                        AND r.id < ".$rutaid."
                        ORDER BY r.id DESC
                        LIMIT 0,1
                        ";
                $padre= DB::select($sql);

                while( count($padre)>0 ){
                    $insert='INSERT INTO referentes (ruta_id,ruta_id_padre) 
                             VALUES ('.$ruta->id.','.$padre[0]->id.')';
                    $ins=DB::insert($insert);
                    if( trim($padre[0]->referente)!='' ){
                        $referente=$padre[0]->referente;
                        $rutaid=$padre[0]->id;
                        $sql="  SELECT r.id, IFNULL(tr.referente,'') referente
                                FROM rutas r
                                INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1
                                WHERE r.estado=1
                                AND tr.id_union='".$referente."'
                                AND r.id < ".$rutaid."
                                ORDER BY r.id DESC
                                LIMIT 0,1
                                ";
                        $padre= DB::select($sql);
                    }
                    else{
                        $padre=''; $padre=array();
                    }
                }
            }*/

        DB::commit();
        if($id_documento!=''){
            $url ='https://www.muniindependencia.gob.pe/repgmgm/index.php?opcion=sincro&documento_id='.$id_documento;
            $curl_options = array(
                        //reemplazar url 
                        CURLOPT_URL => $url,
                        CURLOPT_HEADER => 0,
                        CURLOPT_RETURNTRANSFER => TRUE,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_FOLLOWLOCATION => TRUE,
                        CURLOPT_ENCODING => 'gzip,deflate',
                );

                $ch = curl_init();
                curl_setopt_array( $ch, $curl_options );
                $output = curl_exec( $ch );
                curl_close($ch);

            $r = json_decode(utf8_encode($output),true);

            if ( !isset($r["sincro"][0]["valida"]) OR (isset($r["sincro"][0]["valida"]) AND $r["sincro"][0]["valida"]!='TRUE') ){
              try {             
                  $insert='INSERT INTO documentos_indedocs (documento_id) 
                                 VALUES ('.$id_documento.')';
                        DB::insert($insert);
              } catch (Exception $ex) {
                  
              }
              
            }
        }

        return  array(
                    'rst'=>1,
                    'msj'=>'Registro realizado con éxito'
                );
        }
    }

    public function crearRutaGestion(){
        DB::beginTransaction();
        $codigounico="";
        $codigounico=Input::get('codigo2');
        $id_documento='';
        if( Input::has('documento_id2') ){
            $id_documento=Input::get('documento_id2');
        }
        $ruta_id= Input::get('ruta_id2');
        $rutadetalle_id= Input::get('rutadetalle_id2');
        $tablarelacion_id= Input::get('tablarelacion_id2');

        $tablaRelacion=DB::table('tablas_relacion as tr')
                        ->join(
                            'rutas as r',
                            'tr.id','=','r.tabla_relacion_id'
                        )
                        ->where('tr.id_union', '=', $codigounico)
                        ->where('r.ruta_flujo_id', '=', 3620)
                        ->where('tr.estado', '=', '1')
                        ->where('r.estado', '=', '1')
                        ->get();

        if(count($tablaRelacion)>0){
            DB::rollback();
            return  array(
                    'rst'=>2,
                    'msj'=>'El trámite ya fue registrado anteriormente'
                );
        }
        else{

        $tablaRelacion=new TablaRelacion;
        $tablaRelacion['software_id']=1;

        $tablaRelacion['id_union']=Input::get('codigo2');
        
        $tablaRelacion['fecha_tramite']= Input::get('fecha_inicio2'); //Input::get('fecha_tramite');
        $tablaRelacion['tipo_persona']=Input::get('tipo_persona2');

        if( Input::has('paterno2') AND Input::has('materno2') AND Input::has('nombre2') ){
            $tablaRelacion['paterno']=Input::get('paterno2');
            $tablaRelacion['materno']=Input::get('materno2');
            $tablaRelacion['nombre']=Input::get('nombre2');
        }
        elseif( Input::has('razon_social2') AND Input::has('ruc2') ){
            $tablaRelacion['razon_social']=Input::get('razon_social2');
            $tablaRelacion['ruc']=Input::get('ruc2');
        }
        elseif( Input::has('area_p_id2') ){
            $tablaRelacion['area_id']=Input::get('area_p_id2');
        }
        elseif( Input::has('carta_id') ){ // Este caso solo es para asignar carta inicio
            $tablaRelacion['area_id']=Auth::user()->area_id;
        }
        elseif( Input::has('razon_social2') ){
            $tablaRelacion['razon_social']=Input::get('razon_social2');
        }

        if( Input::has('doc_digital_id2')){
            $tablaRelacion['doc_digital_id']=Input::get('doc_digital_id2');
        }


        if( Input::has('referente2') AND trim(Input::get('referente2'))!='' ){
            $tablaRelacion['referente']=Input::get('referente2');
        }

        if( Input::has('responsable') AND trim(Input::get('responsable'))!='' ){
            $tablaRelacion['responsable']=Input::get('responsable');
        }
        $tablaRelacion['sumilla']=Input::get('sumilla2');

        $tablaRelacion['persona_autoriza_id']=Input::get('id_autoriza');
        $tablaRelacion['persona_responsable_id']=Input::get('id_responsable');

        $tablaRelacion['usuario_created_at']=Auth::user()->id;
        $tablaRelacion->save();

        $rutaFlujo=RutaFlujo::find(3620);//3620

        $ruta= new Ruta;
        $ruta['tabla_relacion_id']=$tablaRelacion->id;
        $ruta['fecha_inicio']= Input::get('fecha_inicio2');
        $ruta['ruta_flujo_id']=$rutaFlujo->id;
        $ruta['flujo_id']=$rutaFlujo->flujo_id;
        $ruta['persona_id']=$rutaFlujo->persona_id;
        $ruta['area_id']=$rutaFlujo->area_id;

        if( Input::has('doc_digital_id2')){
            $ruta['doc_digital_id']=Input::get('doc_digital_id2');
        }
        $ruta['usuario_created_at']= Auth::user()->id;
        $ruta->save();
        /**************CARTA *************************************************/
        $carta=array();
        if( Input::has('carta_id') ){
            $carta= Carta::find(Input::get('carta_id'));
        }
        else{
            $carta= new Carta;
            $carta['flujo_id']=$ruta->flujo_id;
            $carta['correlativo']=0;
            $carta['nro_carta']=Input::get('codigo2');
            $carta['objetivo']="";
            $carta['entregable']="";
            $carta['alcance']="MDI";
            $carta['flujo_id']=$ruta->flujo_id;

            if( trim(Auth::user()->area_id)!='' ){
                $carta['area_id']=Auth::user()->area_id;
            }
            else{
                $carta['area_id']=$ruta->area_id;
            }
        }
            $carta['union']=1;
            $carta['usuario_updated_at']=Auth::user()->id;
            $carta['ruta_id']=$ruta->id;
            $carta->save();
        /*********************************************************************/
        /************Agregado de referidos*************/
        $referido=new Referido;
        $referido['ruta_id']=$ruta->id;
        $referido['tabla_relacion_id']=$tablaRelacion->id;
        if($tablarelacion_id!=''){
            $referido['tabla_relacion_id']=$tablarelacion_id;
        }
        if( Input::has('doc_digital_id2')){
            $referido['doc_digital_id']=Input::get('doc_digital_id2');
        }
        $referido['tipo']=0;
        $referido['ruta_detalle_verbo_id']=0;
        $referido['referido']=$tablaRelacion->id_union;
        $referido['fecha_hora_referido']=$tablaRelacion->created_at;
        $referido['usuario_referido']=$tablaRelacion->usuario_created_at;
        $referido['usuario_created_at']=Auth::user()->id;
        $referido->save();
        /**********************************************/

        $qrutaDetalle=DB::table('rutas_flujo_detalle')
            ->where('ruta_flujo_id', '=', 3620)
            ->where('estado', '=', '1')
            ->orderBy('norden','ASC')
            ->get();
            $validaactivar=0;
        
        $conteo=0;$array['fecha']=''; // inicializando valores para desglose

        $tiempo = [];
        $areas = [];
        if(Input::has('areasSelect')){
/*            $tiempo = json_decode(Input::get('diasTiempo'));*/
            $areas = json_decode(Input::get('areasSelect'));
        }elseif(Input::has('areasTodas')){
         /*   $tiempo = Input::get('tiempo');*/
            $areas = json_decode(Input::get('areasTodas'));
        }

            foreach ($areas as $index => $val) {
                $rutaDetalle = new RutaDetalle;
                $rutaDetalle['ruta_id']=$ruta->id;
                $rutaDetalle['area_id']=$val->area_id;
                $rutaDetalle['tiempo_id']=2;         
/*
                if (is_array($tiempo)){
                    $rutaDetalle['dtiempo']=$tiempo[$index];                    
                }else{*/
                    $rutaDetalle['dtiempo']=$val->tiempo;
/*                }
*/
                $rutaDetalle['norden']=$index + 1;
                if($index==0){
                    $rutaDetalle['fecha_inicio']=Input::get('fecha_inicio2');
                }
                else{
                    $validaactivar=1;
                }

                if ($index < 2) {
                     $rutaDetalle['estado_ruta']=1;
                }elseif($index >= 2){
                     $rutaDetalle['estado_ruta']=2;
                }
                $rutaDetalle['usuario_created_at']= Auth::user()->id;
                $rutaDetalle->save();
/*            }

            foreach($qrutaDetalle as $rd){
                $rutaDetalle = new RutaDetalle;
                $rutaDetalle['ruta_id']=$ruta->id;
                $rutaDetalle['area_id']=$rd->area_id;
                $rutaDetalle['tiempo_id']=$rd->tiempo_id;
                $rutaDetalle['dtiempo']=$rd->dtiempo;
                $rutaDetalle['norden']=$rd->norden;
                if($rd->norden==1){
                    $rutaDetalle['fecha_inicio']=Input::get('fecha_inicio2');
                }
                else{
                    $validaactivar=1;
                }

                if ($rd->norden < 3) {
                     $rutaDetalle['estado_ruta']=1;
                }elseif($rd->norden >= 3){
                     $rutaDetalle['estado_ruta']=2;
                }
                $rutaDetalle['usuario_created_at']= Auth::user()->id;
                $rutaDetalle->save();*/
                /**************CARTA DESGLOSE*********************************/
                $cartaDesglose=array();
                if( Input::has('carta_id') ){
                    $carta_id=Input::get('carta_id');
                    $sql="  SELECT id
                            FROM carta_desglose
                            WHERE carta_id='$carta_id'
                            AND estado=1
                            ORDER BY id
                            LIMIT $conteo,1";
                    $cd=DB::select($sql);
                    $conteo++;
                    $cartaDesglose=CartaDesglose::find($cd[0]->id);
                }
                else{
                    $sql="  SELECT id
                            FROM personas
                            WHERE estado=1
                            AND rol_id IN (8,9,70)
                            AND area_id='".$rutaDetalle->area_id."'";
                    $person=DB::select($sql);
                        /***********MEDIR LOS TIEMPOS**************************/
                        $cantmin=0;
                        if( $rutaDetalle->tiempo_id==1 ){
                            $cantmin=60;
                        }
                        elseif( $rutaDetalle->tiempo_id==2 ){
                            $cantmin=1440;
                        }

                        if( $array['fecha']=='' ){
                            $array['fecha']= Input::get('fecha_inicio');
                        }
                        $array['tiempo']=($rutaDetalle->dtiempo*$cantmin);
                        $array['area']=$rutaDetalle->area_id;
                        $ff=Carta::CalcularFechaFin($array);
                        $fi=$array['fecha'];
                        $array['fecha']=$ff;

                    $cartaDesglose= new CartaDesglose;
                    $cartaDesglose['carta_id']=$carta->id;
                    $cartaDesglose['tipo_actividad_id']=19;
                    $cartaDesglose['actividad']="Actividad";
                        if( isset($person[0]->id) ){
                        $cartaDesglose['persona_id']=$person[0]->id;
                        }
                    $cartaDesglose['area_id']=$rutaDetalle->area_id;
                    $cartaDesglose['recursos']="";
                    $cartaDesglose['fecha_inicio']=$fi;
                    $cartaDesglose['fecha_fin']=$ff;
                    $cartaDesglose['hora_inicio']="08:00";
                    $cartaDesglose['hora_fin']="17:30";
                    $cartaDesglose['fecha_alerta']=$ff;
                }
                    $cartaDesglose['ruta_detalle_id']=$rutaDetalle->id;
                    $cartaDesglose->save();
                /*************************************************************/
                if( $index==0 AND Input::has('carta_id') ){
                    $rutaDetalleVerbo = new RutaDetalleVerbo;
                    $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                    $rutaDetalleVerbo['nombre']= '-';
                    $rutaDetalleVerbo['condicion']= '0';
                    $rol_id=1;
                        if( Input::has('rol_id') AND Input::get('rol_id')!='' ){
                            $rol_id=Input::get('rol_id');
                        }
                        elseif( isset(Auth::user()->rol_id) ){
                            $rol_id=Auth::user()->rol_id;
                        }
                    $rutaDetalleVerbo['rol_id']= $rol_id;
                    $rutaDetalleVerbo['verbo_id']= '1';
                    $rutaDetalleVerbo['documento_id']= '57';//Carta de inicio
                    $rutaDetalleVerbo['orden']= '0';
                    $rutaDetalleVerbo['finalizo']='1';
                    $rutaDetalleVerbo['documento']=Input::get('codigo');
                    $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                    $rutaDetalleVerbo['usuario_updated_at']= Auth::user()->id;
                    $rutaDetalleVerbo->save();
                }



                /*$qrutaDetalleVerbo=DB::table('rutas_flujo_detalle_verbo')
                                ->where('ruta_flujo_detalle_id', '=', $rd->id)
                                ->where('estado', '=', '1')
                                ->orderBy('orden', 'ASC')
                                ->get();
                    if(count($qrutaDetalleVerbo)>0){
                        foreach ($qrutaDetalleVerbo as $rdv) {
                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $rdv->nombre;
                            $rutaDetalleVerbo['condicion']= $rdv->condicion;
                            $rutaDetalleVerbo['rol_id']= $rdv->rol_id;

                            $rutaDetalleVerbo['verbo_id']= $rdv->verbo_id;
                            $rutaDetalleVerbo['documento_id']= $rdv->documento_id;
                            $rutaDetalleVerbo['orden']= $rdv->orden;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();
                        }
                    }*/
                    $array_verbos = [];
                    if($index==0){
                        $array_verbos = [1,5,4];
                        /*foreach ($array_verbos as $key => $value) {
                            $verbo = Verbo::find($value);

                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $verbo->nombre;
                            $rutaDetalleVerbo['condicion']= 0;

                            if($value == 5){
                                $Area = Area::find($val);
                                if($Area->area_gestion == 1){
                                    $rutaDetalleVerbo['rol_id']= 8;     
                                }elseif($Area->area_gestion == 2){
                                    $rutaDetalleVerbo['rol_id']= 9;                                    
                                }
                            }else{
                                $rutaDetalleVerbo['rol_id']= 1;                                
                            }

                            $rutaDetalleVerbo['verbo_id']= $value;
                             $rutaDetalleVerbo['documento_id']= '';
                            $rutaDetalleVerbo['orden']= $key + 1;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();                           
                        }*/
                    }elseif( Input::get('select_tipoenvio')==1 && $val->copia==0){ //con retorno
                        $array_verbos = [2,1,5,4];
         /*               foreach ($array_verbos as $key => $value) {
                            $verbo = Verbo::find($value);

                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $verbo->nombre;
                            $rutaDetalleVerbo['condicion']= 0;

                            if($value == 5){
                                $Area = Area::find($val);
                                if($Area->area_gestion == 1){
                                    $rutaDetalleVerbo['rol_id']= 8;     
                                }elseif($Area->area_gestion == 2){
                                    $rutaDetalleVerbo['rol_id']= 9;                                    
                                }
                            }else{
                                $rutaDetalleVerbo['rol_id']= 1;                                
                            }

                            $rutaDetalleVerbo['verbo_id']= $value;
                             $rutaDetalleVerbo['documento_id']= '';
                            $rutaDetalleVerbo['orden']= $key + 1;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();                           
                        }*/
                    }else if(Input::get('select_tipoenvio')==2  or $val->copia==1){ //sin retorno
                        $array_verbos = [2,14];
         /*               foreach ($array_verbos as $key => $value) {
                            $verbo = Verbo::find($value);

                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $verbo->nombre;
                            $rutaDetalleVerbo['condicion']= 0;
                            $rutaDetalleVerbo['rol_id']= 1;

                            $rutaDetalleVerbo['verbo_id']= $value;
                             $rutaDetalleVerbo['documento_id']= '';
                            $rutaDetalleVerbo['orden']= $key + 1;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();                           
                        }*/
                    }

                    foreach ($array_verbos as $key => $value) {
                        $verbo = Verbo::find($value);

                        $rutaDetalleVerbo = new RutaDetalleVerbo;
                        $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                        $rutaDetalleVerbo['nombre']= $verbo->nombre;
                        $rutaDetalleVerbo['condicion']= 0;

                        if($value == 5){
                            $Area = Area::find($val->area_id);
                            if($Area->area_gestion == 1){
                                $rutaDetalleVerbo['rol_id']= 8;     
                            }elseif($Area->area_gestion == 2){
                                $rutaDetalleVerbo['rol_id']= 9;                                    
                            }
                        }else{
                            $rutaDetalleVerbo['rol_id']= 1;                                
                        }

                        $rutaDetalleVerbo['verbo_id']= $value;
                         $rutaDetalleVerbo['documento_id']= '';
                        $rutaDetalleVerbo['orden']= $key + 1;
                        $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                        $rutaDetalleVerbo->save();                           
                    }
            }
            DB::commit();
            return  array(
                    'rst'=>1,
                    'msj'=>'Registro realizado con éxito'
            );
        }
    }



     public function crearOrdenTrabajo(){

        DB::beginTransaction();
        if(Input::has('info')){
            $info = Input::get('info');
            if(count($info) > 0){
                $persona_id=Auth::user()->id;
                /*si crea para otra persona*/
                if($info[0]['persona']){
                    $persona_id = $info[0]['persona'];
                }
                /*fin si crea para otra persona*/
               
                $correlativo = $this->Correlativo($persona_id);
                $codigounico="OT-".$correlativo->correlativo."-".$persona_id."-".date("Y");
                $tablaRelacion=DB::table('tablas_relacion as tr')
                                ->join(
                                    'rutas as r',
                                    'tr.id','=','r.tabla_relacion_id'
                                )
                                ->where('tr.id_union', '=', $codigounico)
                                ->where('r.ruta_flujo_id', '=', 3720)
                                ->where('tr.estado', '=', '1')
                                ->where('r.estado', '=', '1')
                                ->get();

                if(count($tablaRelacion)>0){
                    DB::rollback();
                    return  array(
                            'rst'=>2,
                            'msj'=>'El trámite ya fue registrado anteriormente'
                        );
                }
                else{

                $tablaRelacion=new TablaRelacion;
                $tablaRelacion['software_id']=1;

                $tablaRelacion['id_union']=$codigounico;
                
                $tablaRelacion['fecha_tramite']= date("Y-m-d"); //Input::get('fecha_tramite');
                $tablaRelacion['tipo_persona']= 1;

                if( Input::has('paterno3') AND Input::has('materno3') AND Input::has('nombre3') ){
                    $tablaRelacion['paterno']=Input::get('paterno3');
                    $tablaRelacion['materno']=Input::get('materno3');
                    $tablaRelacion['nombre']=Input::get('nombre3');
                }
                elseif( Input::has('razon_social3') AND Input::has('ruc3') ){
                    $tablaRelacion['razon_social']=Input::get('razon_social3');
                    $tablaRelacion['ruc']=Input::get('ruc2');
                }
                elseif( Input::has('area_p_id3') ){
                    $tablaRelacion['area_id']=Input::get('area_p_id3');
                }
                elseif( Input::has('carta_id') ){ // Este caso solo es para asignar carta inicio
                    $tablaRelacion['area_id']=Auth::user()->area_id;
                }
                elseif( Input::has('razon_social3') ){
                    $tablaRelacion['razon_social']=Input::get('razon_social3');
                }


                if( Input::has('referente3') AND trim(Input::get('referente3'))!='' ){
                    $tablaRelacion['referente']=Input::get('referente2');
                }

                if( Input::has('responsable') AND trim(Input::get('responsable'))!='' ){
                    $tablaRelacion['responsable']=Input::get('responsable');
                }
                $tablaRelacion['sumilla']='';

                $tablaRelacion['persona_autoriza_id']=Auth::user()->id;
                $tablaRelacion['persona_responsable_id']=Auth::user()->id;

                $tablaRelacion['area_id']=Auth::user()->area_id;
                $tablaRelacion['usuario_created_at']=Auth::user()->id;
                $tablaRelacion->save();

                $rutaFlujo=RutaFlujo::find(3720); //3283
                $Persona = Persona::find($persona_id);

                $ruta= new Ruta;
                $ruta['tabla_relacion_id']=$tablaRelacion->id;
                $ruta['fecha_inicio']= date("Y-m-d");
                $ruta['ruta_flujo_id']=$rutaFlujo->id;
                $ruta['flujo_id']=$rutaFlujo->flujo_id;
                $ruta['persona_id']=$Persona->id;
                $ruta['area_id']=$Persona->area_id;
                $ruta['usuario_created_at']= Auth::user()->id;
                $ruta->save();
                /**************CARTA *************************************************/
                $carta=array();
                if( Input::has('carta_id') ){
                    $carta= Carta::find(Input::get('carta_id'));
                }
                else{
                    $carta= new Carta;
                    $carta['flujo_id']=$ruta->flujo_id;
                    $carta['correlativo']=0;
                    $carta['nro_carta']=$codigounico;
                    $carta['objetivo']="";
                    $carta['entregable']="";
                    $carta['alcance']="MDI";
                    $carta['flujo_id']=$ruta->flujo_id;

                    if( trim(Auth::user()->area_id)!='' ){
                        $carta['area_id']=Auth::user()->area_id;
                    }
                    else{
                        $carta['area_id']=$ruta->area_id;
                    }
                }
                    $carta['union']=1;
                    $carta['usuario_updated_at']=Auth::user()->id;
                    $carta['ruta_id']=$ruta->id;
                    $carta->save();

                $qrutaDetalle=DB::table('rutas_flujo_detalle')
                    ->where('ruta_flujo_id', '=', 3720)
                    ->where('estado', '=', '1')
                    ->orderBy('norden','ASC')
                    ->get();

                     foreach ($info as $key => $value) {

                        $ttranscurrido = $value['ttranscurrido'];
                        $minTrascurrido = explode(':', $ttranscurrido)[0] * 60 + explode(':', $ttranscurrido)[1];

                        $rutaDetalle = new RutaDetalle;
                        $rutaDetalle['ruta_id']=$ruta->id;
                        $rutaDetalle['area_id']=$Persona->area_id;
                        $rutaDetalle['tiempo_id']=2;         
                        $rutaDetalle['dtiempo'] = 1;
                        $rutaDetalle['fecha_inicio']= date("Y-m-d", strtotime($value['finicio']))." ".explode(' ',$value['hinicio'])[0];
                        $rutaDetalle['dtiempo_final']= date("Y-m-d", strtotime($value['ffin']))." ".explode(' ',$value['hfin'])[0];
                        $rutaDetalle['estado_ruta']=1;
                        $rutaDetalle['ot_tiempo_transcurrido']=$minTrascurrido;
                        $rutaDetalle['actividad']=$value['actividad'];
                        $rutaDetalle['norden']=$key + 1;
                        $rutaDetalle['usuario_created_at']= Auth::user()->id;
                        $rutaDetalle->save();

                        /**************CARTA DESGLOSE*********************************/
/*                        $cartaDesglose=array();
                        $array = [];
                        if( Input::has('carta_id') ){
                            $carta_id=Input::get('carta_id');
                            $sql="  SELECT id
                                    FROM carta_desglose
                                    WHERE carta_id='$carta_id'
                                    AND estado=1
                                    ORDER BY id
                                    LIMIT $conteo,1";
                            $cd=DB::select($sql);
                            $conteo++;
                            $cartaDesglose=CartaDesglose::find($cd[0]->id);
                        }
                        else{
                            $sql="  SELECT id
                                    FROM personas
                                    WHERE estado=1
                                    AND rol_id IN (8,9,70)
                                    AND area_id='".$rutaDetalle->area_id."'";
                            $person=DB::select($sql);*/
                                /***********MEDIR LOS TIEMPOS**************************/
/*                                $cantmin=0;
                                if( $rutaDetalle->tiempo_id==1 ){
                                    $cantmin=60;
                                }
                                elseif( $rutaDetalle->tiempo_id==2 ){
                                    $cantmin=1440;
                                }

                                if( $array['fecha']=='' ){
                                    $array['fecha']= Input::get('fecha_inicio');
                                }
                                $array['tiempo']=($rutaDetalle->dtiempo*$cantmin);
                                $array['area']=$rutaDetalle->area_id;
                                $ff=Carta::CalcularFechaFin($array);
                                $fi=$array['fecha'];
                                $array['fecha']=$ff;

                            $cartaDesglose= new CartaDesglose;
                            $cartaDesglose['carta_id']=$carta->id;
                            $cartaDesglose['tipo_actividad_id']=19;
                            $cartaDesglose['actividad']="Actividad";
                                if( isset($person[0]->id) ){
                                $cartaDesglose['persona_id']=$person[0]->id;
                                }
                            $cartaDesglose['area_id']=$rutaDetalle->area_id;
                            $cartaDesglose['recursos']="";
                            $cartaDesglose['fecha_inicio']=$fi;
                            $cartaDesglose['fecha_fin']=$ff;
                            $cartaDesglose['hora_inicio']="08:00";
                            $cartaDesglose['hora_fin']="17:30";
                            $cartaDesglose['fecha_alerta']=$ff;
                        }
                        $cartaDesglose['ruta_detalle_id']=$rutaDetalle->id;
                        $cartaDesglose->save();*/
                        /*************************************************************/

           /*                     $array_verbos = [1];
                                foreach ($array_verbos as $key => $value) {*/
                                    $verbo = Verbo::find(6);

                                    $rutaDetalleVerbo = new RutaDetalleVerbo;
                                    $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                                    $rutaDetalleVerbo['nombre']= $verbo->nombre;
                                    $rutaDetalleVerbo['condicion']= 0;
                                    $rutaDetalleVerbo['finalizo']= 1;                                  
                                    $rutaDetalleVerbo['rol_id']= $Persona->rol_id;;     
                                    $rutaDetalleVerbo['verbo_id']= 6;
                                    $rutaDetalleVerbo['documento_id']= 28;
                                    $rutaDetalleVerbo['orden']= $key + 1    ;
                                    $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                                    $rutaDetalleVerbo['usuario_updated_at']= Auth::user()->id;
                                    $rutaDetalleVerbo->save();                           
                             /*   }*/




                            }

                }

                    DB::commit();
                    return  array(
                            'rst'=>1,
                            'msj'=>'Registro realizado con éxito'
                    );
                }
            }
    }

    
    public static function Correlativo($persona){
        $año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
        /*$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";*/
        $sql = "select LPAD(count(tr.id)+1,6,'0') as correlativo from tablas_relacion tr 
                inner join rutas r on r.tabla_relacion_id=tr.id and r.ruta_flujo_id=3720 and r.persona_id=".$persona."
                where tr.estado=1";
        $r= DB::select($sql);
        return (isset($r[0])) ? $r[0] : $r2[0];
    }
    
        public static function OrdenTrabajoDia()
    {     
        $sSql = '';
        $sSql.= "SELECT rd.id norden,rd.actividad,rd.fecha_inicio,rd.dtiempo_final,ABS(rd.ot_tiempo_transcurrido) ot_tiempo_transcurrido ,SEC_TO_TIME(ABS(rd.ot_tiempo_transcurrido) * 60) formato 
                FROM  tablas_relacion tr 
                INNER JOIN rutas r ON r.tabla_relacion_id=tr.id AND r.estado=1 AND r.persona_id=".Auth::user()->id."
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                WHERE tr.estado=1 AND tr.id_union like 'OT%'";

        if(Input::has('fecha') && Input::get('fecha')){
            $fecha = Input::get('fecha');
            $sSql.= " AND DATE(tr.created_at)='".$fecha."'";
        }
        
        $oData= DB::select($sSql);
        return $oData;
    }
    
            public static function ActividadDia()
    {   
        $persona=" AND at.persona_id=".Auth::user()->id;
        
        if(Input::has('tipopersona') && Input::get('tipopersona')){
            $persona= " AND at.usuario_created_at=".Auth::user()->id." AND at.persona_id!=".Auth::user()->id;
        }
        
        $sSql = '';
        $sSql.= "SELECT CONCAT_WS(' ',p.nombre,p.paterno,p.materno) as persona,at.id norden,at.actividad,at.fecha_inicio,at.dtiempo_final,ABS(at.ot_tiempo_transcurrido) ot_tiempo_transcurrido ,SEC_TO_TIME(ABS(at.ot_tiempo_transcurrido) * 60) formato,at.usuario_created_at,at.persona_id 
                FROM  actividad_personal at 
                INNER JOIN personas p on at.persona_id=p.id
                WHERE at.estado=1";

        if(Input::has('fecha') && Input::get('fecha')){
            $fecha = Input::get('fecha');
            $sSql.= " AND DATE(at.created_at)='".$fecha."'";
        }
        $sSql.=$persona;
        
        $oData= DB::select($sSql);
        return $oData;
    }

}
?>
