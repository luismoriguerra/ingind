<?php
class RutaFlujo extends Eloquent
{
    public $table="rutas_flujo";

    /**
     * Areas relationship
     */
    public function areas()
    {
        return $this->belongsTo('Area');
    }

    public function validaTiempo()
    {
        $resultado='';
        $rf = DB::table('rutas_flujo_detalle AS rfd')
                ->join(
                    'areas AS a',
                    'a.id', '=', 'rfd.area_id'
                )
                ->select('rfd.id','rfd.norden','a.nombre AS area')
                ->where('rfd.ruta_flujo_id', '=', Input::get('ruta_flujo_id'))
                ->where('rfd.dtiempo', '=', '0')
                ->where('rfd.estado', '=', '1')
                ->get();

        if( count($rf)>0 ){
            foreach ($rf as $r) {
                $resultado.=',Falta Tiempo en Area: '.$r->area.' Pos: '.$r->norden;
            }
            $resultado=substr($resultado,1);
        }

        return $resultado;
    }

    public function validaDescripcion()
    {
        $resultado='';
        $ruta_flujo_id=Input::get('ruta_flujo_id');

        $query='SELECT rfd.id,rfd.norden,a.nombre as area,rfdv.orden
                FROM rutas_flujo_detalle rfd
                INNER JOIN areas a ON a.id=rfd.area_id
                LEFT JOIN rutas_flujo_detalle_verbo rfdv ON rfd.id=rfdv.ruta_flujo_detalle_id AND rfdv.estado=1
                WHERE rfd.ruta_flujo_id='.$ruta_flujo_id.'
                AND rfd.estado=1
                AND trim(IFNULL(rfdv.nombre,""))=""';
        $rf = DB::select($query);

        if( count($rf)>0 ){
            foreach ($rf as $r) {
                $resultado.=',Falta descripcion del verbo en el Area: '.$r->area.' con Orden:'.$r->orden.'  y Pos Ruta: '.$r->norden;
            }
            $resultado=substr($resultado,1);
        }

        return $resultado;
    }

    public function validaOrden()
    {
        $resultado='';
        $ruta_flujo_id=Input::get('ruta_flujo_id');

        $query='SELECT rfd.id,rfd.norden,a.nombre as area,rfdv.orden
                FROM rutas_flujo_detalle rfd
                INNER JOIN areas a ON a.id=rfd.area_id
                LEFT JOIN rutas_flujo_detalle_verbo rfdv ON rfd.id=rfdv.ruta_flujo_detalle_id AND rfdv.estado=1
                WHERE rfd.ruta_flujo_id='.$ruta_flujo_id.'
                AND rfd.estado=1
                AND trim(IFNULL(rfdv.orden,""))=""';
        $rf = DB::select($query);

        if( count($rf)>0 ){
            foreach ($rf as $r) {
                $resultado.=',Falta orden del verbo en el Area: '.$r->area.' Pos Ruta: '.$r->norden;
            }
            $resultado=substr($resultado,1);
        }

        return $resultado;
    }

    public function validaRol()
    {
        $resultado='';
        $ruta_flujo_id=Input::get('ruta_flujo_id');

        $query='SELECT rfd.id,rfd.norden,a.nombre as area,rfdv.orden
                FROM rutas_flujo_detalle rfd
                INNER JOIN areas a ON a.id=rfd.area_id
                LEFT JOIN rutas_flujo_detalle_verbo rfdv ON rfd.id=rfdv.ruta_flujo_detalle_id AND rfdv.estado=1
                WHERE rfd.ruta_flujo_id='.$ruta_flujo_id.'
                AND rfd.estado=1
                AND rfdv.rol_id is null';
        $rf = DB::select($query);

        if( count($rf)>0 ){
            foreach ($rf as $r) {
                $resultado.=',Falta rol del verbo en el Area: '.$r->area.' con Orden:'.$r->orden.' y Pos: '.$r->norden;
            }
            $resultado=substr($resultado,1);
        }

        return $resultado;
    }

    public function validaVerbo()
    {
        $resultado='';
        $ruta_flujo_id=Input::get('ruta_flujo_id');

        $query='SELECT rfd.id,rfd.norden,a.nombre as area,rfdv.orden
                FROM rutas_flujo_detalle rfd
                INNER JOIN areas a ON a.id=rfd.area_id
                LEFT JOIN rutas_flujo_detalle_verbo rfdv ON rfd.id=rfdv.ruta_flujo_detalle_id AND rfdv.estado=1
                WHERE rfd.ruta_flujo_id='.$ruta_flujo_id.'
                AND rfd.estado=1
                AND rfdv.verbo_id is null';
        $rf = DB::select($query);

        if( count($rf)>0 ){
            foreach ($rf as $r) {
                $resultado.=',Falta verbo en el Area: '.$r->area.' con Orden:'.$r->orden.' y Pos Ruta: '.$r->norden;
            }
            $resultado=substr($resultado,1);
        }

        return $resultado;
    }

    public function validaDocuento()
    {
        $resultado='';
        $ruta_flujo_id=Input::get('ruta_flujo_id');

        $query='SELECT rfd.id,rfd.norden,a.nombre as area,rfdv.orden
                FROM rutas_flujo_detalle rfd
                INNER JOIN areas a ON a.id=rfd.area_id
                LEFT JOIN rutas_flujo_detalle_verbo rfdv ON rfd.id=rfdv.ruta_flujo_detalle_id AND rfdv.estado=1
                WHERE rfd.ruta_flujo_id='.$ruta_flujo_id.'
                AND rfd.estado=1
                AND rfdv.verbo_id=1
                AND rfdv.documento_id is null';
        $rf = DB::select($query);

        if( count($rf)>0 ){
            foreach ($rf as $r) {
                $resultado.=',Falta tipo documento en el Area: '.$r->area.' con Orden:'.$r->orden.' y Pos Ruta: '.$r->norden;
            }
            $resultado=substr($resultado,1);
        }

        return $resultado;
    }

    public function actualizarProduccion()
    {
        $rf = DB::table('rutas_flujo')
              ->where('id', '=', Input::get('ruta_flujo_id'))
              ->update(array(
                        "estado"=>1,
                        "updated_at"=>date("Y-m-d H:i:s"),
                        "usuario_updated_at"=>Auth::user()->id
                        )
                );
        return $rf;
    }

    public function actualizarRuta()
    {
        $rf = DB::table('rutas_flujo')
              ->where('id', '=', Input::get('ruta_flujo_id'))
              ->update(array(
                        "estado"=>Input::get('estado'),
                        "updated_at"=>date("Y-m-d H:i:s"),
                        "usuario_updated_at"=>Auth::user()->id
                        )
                );
        return $rf;
    }
    
    public function getRutaFlujo(){
        $rutaFlujo =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'flujos AS f',
                                'f.id','=','rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id','=','rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id','=','rf.area_id'
                            )
                            ->join(
                                'rutas_flujo_detalle AS rfd',
                                'rf.id','=','rfd.ruta_flujo_id'
                            )
                            ->select('rf.estado AS cestado',
                                    'rf.id',
                                    DB::raw(
                                        'f.nombre AS flujo'
                                    ),
                                    DB::raw(
                                        'CONCAT(
                                            p.paterno," ",p.materno," ",p.nombre
                                        ) AS persona'
                                    ),
                                    'a.nombre AS area',
                                    'rf.n_flujo_ok AS ok',
                                    'rf.n_flujo_error AS error',
                                    DB::raw(
                                        'IFNULL(rf.ruta_id_dep,"") AS dep'
                                    ),
                                    DB::raw(
                                        'DATE(rf.created_at) AS fruta'
                                    ),
                                    DB::raw(
                                        'IF(rf.estado=1,"Produccion",
                                            IF(rf.estado=2,"Pendiente","Inactivo")
                                        ) AS estado'
                                    )
                            )
                            ->where(
                                function($query){
                                    if ( Input::get('fecha') ){
                                        $fecha = Input::get('fecha');
                                        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                                        $areaId=implode('","',Input::get('area_id'));
                                        $query->whereRaw(
                                            ' rf.area_id IN ("'.$areaId.'") 
                                            AND date(rf.created_at) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'"
                                            AND rf.estado IN (1,2)
                                            AND f.estado=1'
                                        );
                                    }
                                    elseif ( Input::get('vista') ) {
                                        //$query->where('rf.estado', '=', '2')
                                        $query->whereRaw(
                                            'rfd.area_id IN (
                                                SELECT a.id
                                                FROM area_cargo_persona acp
                                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                WHERE acp.estado=1
                                                AND cp.persona_id='.Auth::user()->id.'
                                            )
                                            AND rf.estado IN (1,2)
                                            AND f.estado=1'
                                        );
                                    }
                                    elseif ( Input::get('estado') ) {
                                        //$query->where('rf.estado', '=', '2')
                                        $query->whereRaw(
                                            'rf.area_id IN (
                                                SELECT a.id
                                                FROM area_cargo_persona acp
                                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                WHERE acp.estado=1
                                                AND cp.persona_id='.Auth::user()->id.'
                                            )
                                            AND rf.estado IN (1)
                                            AND f.estado=1'
                                        );
                                    }
                                    else{
                                        //->where('rf.estado', '=', '2')
                                        $query->whereRaw(
                                            'rf.area_id IN (
                                                SELECT a.id
                                                FROM area_cargo_persona acp
                                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                WHERE acp.estado=1
                                                AND cp.persona_id='.Auth::user()->id.'
                                            )
                                            AND rf.estado IN (1,2)
                                            AND f.estado=1'
                                        );
                                    }

                                    if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==1 ){
                                        $query->where('f.tipo_flujo', '=', '1');
                                    }
                                    elseif( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==2 ){
                                        $query->where('f.tipo_flujo', '=', '2');
                                    }
                                }
                            )
                            ->groupBy('rf.id')
                            ->get();
        return $rutaFlujo;
    }

    public function getRutaFlujoProduccion(){
        $rutaFlujo =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'flujos AS f',
                                'f.id','=','rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id','=','rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id','=','rf.area_id'
                            )
                            ->select('f.nombre AS flujo','rf.estado AS cestado',
                                    'rf.id',
                                    DB::raw(
                                        'CONCAT(
                                            p.paterno," ",p.materno," ",p.nombre
                                        ) AS persona'
                                    ),
                                    'a.nombre AS area',
                                    'rf.n_flujo_ok AS ok',
                                    'rf.n_flujo_error AS error',
                                    DB::raw(
                                        'IFNULL(rf.ruta_id_dep,"") AS dep'
                                    ),
                                    DB::raw(
                                        'DATE(rf.created_at) AS fruta'
                                    ),
                                    DB::raw(
                                        'IF(rf.estado=1,"Produccion",
                                            IF(rf.estado=2,"Pendiente","Inactivo")
                                        ) AS estado'
                                    )
                            )
                            ->where('rf.estado', '=', '1')
                            ->where(
                                function($query)
                                {
                                    if ( Input::get('flujo_id') ) {
                                        $query->where(
                                            'rf.flujo_id', 
                                            '=', 
                                            Input::get('flujo_id') 
                                        )
                                        ->where(
                                            'rf.area_id', 
                                            '=', 
                                            Input::get('area_id') 
                                        );
                                    }
                                    
                                }
                            )
                            ->orderBy('n_flujo_ok','DESC')
                            ->orderBy('n_flujo_error','ASC')
                            ->get();
        return $rutaFlujo;
    }

    public function getRutaFlujoDetalle(){
        $set=DB::select('SET group_concat_max_len := @@max_allowed_packet');

        if( Input::has('ruta_id') ){
            $rutaFlujoD =    DB::table('rutas AS rf')
                            ->join(
                                'rutas_detalle AS rfd',
                                'rf.id','=','rfd.ruta_id'
                            )
                            ->join(
                                'flujos AS f',
                                'f.id','=','rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id','=','rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id','=','rf.area_id'
                            )
                            ->join(
                                'areas AS a2',
                                'a2.id','=','rfd.area_id'
                            )
                            ->leftJoin(
                                'rutas_detalle_verbo AS rfdv', 
                                function($join)
                                {
                                    $join->on(
                                        'rfdv.ruta_detalle_id','=','rfd.id'
                                    )
                                    ->where('rfdv.estado', '=', '1');
                                }
                            )
                            ->select('rf.area_id','a.nombre as area','rfd.id',
                                    'a2.imagen','a2.imagenc','a2.imagenp',
                                    'rf.persona_id','f.nombre as flujo','rfd.estado_ruta',
                                    'rfd.area_id as area_id2','a2.nombre as area2',
                                    'rfd.norden','rf.flujo_id',
                                    DB::raw(
                                        'IFNULL(rfd.tiempo_id,"") AS tiempo_id,
                                        IFNULL(rfd.dtiempo,"") AS dtiempo,
                                        CONCAT(
                                            p.paterno," ",p.materno," ",p.nombre
                                        ) AS persona,
                                        IFNULL(
                                            GROUP_CONCAT(
                                                CONCAT( rfdv.nombre,"^^",rfdv.condicion,"^^",IFNULL(rfdv.rol_id,""),"^^",IFNULL(rfdv.verbo_id,""),"^^",IFNULL(rfdv.documento_id,""),"^^",IFNULL(rfdv.orden,"") 
                                                ) 
                                                ORDER BY rfdv.orden ASC
                                                SEPARATOR "|"
                                            ),
                                            ""
                                        ) as verbo, 
                                        (   SELECT count(acp.id)
                                            FROM area_cargo_persona acp
                                            INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                            INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                            WHERE acp.estado=1
                                            AND acp.area_id=rfd.area_id
                                            AND cp.persona_id='.Auth::user()->id.'
                                        ) as modifica'
                                    )
                            )
                            ->where( 'rf.id','=', Input::get('ruta_id') )
                            ->where( 'rfd.estado', '=', '1')
                            ->groupBy( 'rfd.id' )
                            ->orderBy( 'rfd.norden', 'asc')
                            ->get();
        }
        else{
            $rutaFlujoD =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'rutas_flujo_detalle AS rfd',
                                'rf.id','=','rfd.ruta_flujo_id'
                            )
                            ->join(
                                'flujos AS f',
                                'f.id','=','rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id','=','rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id','=','rf.area_id'
                            )
                            ->join(
                                'areas AS a2',
                                'a2.id','=','rfd.area_id'
                            )
                            ->leftJoin(
                                'rutas_flujo_detalle_verbo AS rfdv', 
                                function($join)
                                {
                                    $join->on(
                                        'rfdv.ruta_flujo_detalle_id','=','rfd.id'
                                    )
                                    ->where('rfdv.estado', '=', '1');
                                }
                            )
                            ->select('rf.area_id','a.nombre as area','rfd.id',
                                    'a2.imagen','a2.imagenc','a2.imagenp',
                                    'rf.persona_id','f.nombre as flujo','rfd.estado_ruta',
                                    'rfd.area_id as area_id2','a2.nombre as area2',
                                    'rfd.norden','rf.flujo_id','rf.tipo_ruta',
                                    DB::raw(
                                        'IFNULL(rfd.tiempo_id,"") AS tiempo_id,
                                        IFNULL(rfd.dtiempo,"") AS dtiempo,
                                        CONCAT(
                                            p.paterno," ",p.materno," ",p.nombre
                                        ) AS persona,
                                        IFNULL(
                                            GROUP_CONCAT(
                                                CONCAT( rfdv.nombre,"^^",rfdv.condicion,"^^",IFNULL(rfdv.rol_id,""),"^^",IFNULL(rfdv.verbo_id,""),"^^",IFNULL(rfdv.documento_id,""),"^^",IFNULL(rfdv.orden,"") 
                                                ) 
                                                ORDER BY rfdv.orden ASC
                                                SEPARATOR "|"
                                            ),
                                            ""
                                        ) as verbo, 
                                        (   SELECT count(acp.id)
                                            FROM area_cargo_persona acp
                                            INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                            INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                            WHERE acp.estado=1
                                            AND acp.area_id=rfd.area_id
                                            AND cp.persona_id='.Auth::user()->id.'
                                        ) as modifica'
                                    )
                            )
                            ->where( 'rf.id','=', Input::get('ruta_flujo_id') )
                            ->where( 'rfd.estado', '=', '1')
                            ->groupBy( 'rfd.id' )
                            ->orderBy( 'rfd.norden', 'asc')
                            ->get();
        }
        return $rutaFlujoD;
    }

    public function getValidar(){
        $rutaFlujoD =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'flujos AS f',
                                'f.id','=','rf.flujo_id'
                            )
                            ->select('f.id'
                            )
                            ->where( 'f.id','=', Input::get('id') )
                            ->get();
        return $rutaFlujoD;
    }

    public static function getGuardar(){
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

        $rpta['mensaje']=$mensajefinal;
        $rpta['ruta_flujo_id']=$rutaFlujo->id;

        return $rpta;
    }
}
?>
