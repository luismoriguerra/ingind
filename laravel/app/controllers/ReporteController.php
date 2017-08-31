<?php

class ReporteController extends BaseController
{

    public function postSipoc()
    {
      //$html=View::make("admin.reporte.sipoc");
      $html='Hola';
      //return PDF::load($html, 'A4', 'landscape')->download('prueba');
      echo $html;
    }
  /**
   * bandeja de tramite, devuelve la consulta de tramites que se asignan 
   * a una determinada area que pertenece el usuario
   */

    public function postTrabajoasignado()
    {
        $wfecha="";
        if(Input::has('fecha')){
          $fecha = Input::get('fecha');
          list($fechaIni,$fechaFin) = explode(" - ", $fecha);
          $wfecha= " AND DATE(r.fecha_inicio) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
        }

        $autoriza="";
        if(Input::has('autoriza')){
        $autoriza=" AND tr.persona_autoriza_id IN ('".implode("','",Input::get('autoriza'))."') ";
        }

        $responsable="";
        if(Input::has('responsable')){
        $responsable=" AND tr.persona_responsable_id IN ('".implode("','",Input::get('responsable'))."') ";
        }

        $miembros="";$miembrosF="";
        if(Input::has('miembros')){
        $miembros=" AND cd2.persona_id IN ('".implode("','",Input::get('miembros'))."') ";
        $miembrosF=" AND t.miembrosvalida=1 ";
        }

        $estadoF="";
        if(Input::has('estado_id')){
        $estadoF=" AND t.estado IN ('".implode("','",Input::get('estado_id'))."') ";
        }

        $flujo_id="";
        if(Input::has('flujo_id')){
        $flujo_id=" AND f.id IN ('".implode("','",Input::get('flujo_id'))."') ";
        }
        
        $carta="";
        if(Input::has('carta_inicio')){
        $carta=" AND c.nro_carta LIKE '".Input::get('carta_inicio')."%' ";
        }

        $objetivo="";
        if(Input::has('objetivo')){
        $objetivo=" AND c.objetivo LIKE '".Input::get('objetivo')."%' ";
        }

        $sql="SELECT *
              FROM (
              SELECT f.nombre proceso,
              ( SELECT CONCAT(p.paterno,' ',p.materno,', ',p.nombre,'|',a.nombre) 
                FROM personas p
                INNER JOIN areas a ON a.id=p.area_id
                WHERE p.id=tr.persona_autoriza_id
              ) autoriza,
              ( SELECT CONCAT(p.paterno,' ',p.materno,', ',p.nombre,'|',r.nombre) 
                FROM personas p
                INNER JOIN roles r ON r.id=p.rol_id
                WHERE p.id=tr.persona_responsable_id
              ) responsable,
              c.nro_carta,c.objetivo,
              GROUP_CONCAT( CONCAT(p2.paterno,' ',p2.materno,', ',p2.nombre) SEPARATOR ' | ' ) miembros,
              IF(
                ( SELECT count(cd2.id)
                  FROM carta_desglose cd2
                  WHERE cd2.carta_id=c.id
                   ".$miembros." 
                ) > 0, 1,0
              ) miembrosvalida,
              DATE(r.fecha_inicio) fecha_inicio,MAX(cd.fecha_fin) fecha_fin,
              IF(
                ( SELECT count(rd.id)
                  FROM rutas_detalle rd
                  WHERE rd.ruta_id=r.id
                  AND rd.estado=1
                  AND rd.condicion=0
                  AND dtiempo_final IS NULL
                ) > 0, 'Inconcluso' ,'Concluido'
              ) estado 
              FROM cartas c
              INNER JOIN carta_desglose cd ON cd.carta_id=c.id
              INNER JOIN personas p2 ON p2.id=cd.persona_id
              INNER JOIN tablas_relacion tr ON c.nro_carta=tr.id_union AND tr.estado=1
              INNER JOIN rutas r ON r.tabla_relacion_id=tr.id 
              INNER JOIN flujos f ON f.id=r.flujo_id 
              WHERE r.estado=1
               ".$wfecha.$autoriza.$responsable.$flujo_id.$carta.$objetivo." 
              GROUP BY r.id 
              ) t WHERE 1=1 ".$estadoF.$miembrosF;

        $table=DB::select($sql);

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );
    }

   public function postBandejatramite()
   {
        $input=Input::all();
        if (is_array($input)) {
            $input=implode("','", $input);
        }
        $rst=VisualizacionTramite::BandejaTramites($input);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst, 'input'=>$input
            )
        );
   }

   public function postBandejatramiteot()
   {
        $rst=VisualizacionTramite::BandejaTramitesot();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
   }

  public function postReporteortrabajo()
   {
        $rst=Persona::OrdenTrabjbyPersona();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
   }
   
     public function postCuadroproductividadactividad()
   {
        $oData=Persona::CuadroProductividadActividad();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$oData['data'],
                'validar' => $oData['validar'],
                'cabecera'=>$oData['cabecera']
            )
        );
   }
   
        public function postCuadroproceso()
   {
        $oData=Reporte::CuadroProceso();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$oData['data'],
                'cabecera'=>$oData['cabecera'],
                'sino'=>$oData['sino']
            )
        );
   }
   
           public function postDetallecuadroproceso()
   {
        $oData=Reporte::DetalleCuadroProceso();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$oData,
            )
        );
   }
   
       public function postReportetramite()
    {
      $array=array();
      $fecha='';
      $array['fecha']='';$array['ruta_flujo_id']='';$array['tramite']='';
      
      if( Input::has('ruta_flujo_id') AND Input::get('ruta_flujo_id')!='' ){
        $array['ruta_flujo_id'].=" AND r.ruta_flujo_id='".Input::get('ruta_flujo_id')."' ";
      }
      if( Input::has('fecha_ini') AND Input::get('fecha_ini')!='' AND Input::has('fecha_fin') AND Input::get('fecha_fin')!=''){
        $array['fecha'].=" AND DATE_FORMAT(r.fecha_inicio,'%Y-%m') BETWEEN '".Input::get('fecha_ini')."' AND '".Input::get('fecha_fin')."'  ";
      }
      
      if( Input::has('fechames') AND Input::get('fechames')!=''){
        $array['fecha'].=" AND DATE_FORMAT(r.fecha_inicio,'%Y-%m') = '".Input::get('fechames')."'";
      }
      
      if( Input::has('tramite')){
        $array['tramite'].=" AND ISNULL(rd.dtiempo_final) ";
      }
      if( Input::has('tramite') AND Input::get('tramite')==3){
        $array['tramite'].=" AND ISNULL(rd.dtiempo_final) ";
      }

      $r = Reporte::ReporteTramite( $array );
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$r
          )
      );
    }
   
        public function postCargaractividad()
   {
        $oData=Persona::CargarActividad();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$oData,
            )
        );
   }
   
           public function postMostrartextofecha()
   {
        $oData=Persona::MostrarTextoFecha();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$oData,
            )
        );
   }

    public function getExportordentbyperson(){
        $rst=Persona::OrdenTrabjbyPersona(); 
//        var_dump($rst);exit();

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Mis Actividades',
          'tittle'=>'Mis Actividades',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'Nº',
          'AREA',
          'FECHA INICIO',
          'FECHA FIN',
          'TIEMPO TRANSCURRIDO',
          'FORMATO'
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }
    
        public function getExportdocumentodigital(){
            $array=array();
            $array['where']='';
            
            if( Input::has("plantilla") ){
                $plantilla=Input::get("plantilla");
                if( trim( $plantilla )!='' ){
                    $array['where'].=" AND pd.descripcion LIKE '%".$plantilla."%' ";
                }
            }

            if( Input::has("asunto") ){
                $asunto=Input::get("asunto");
                if( trim( $asunto )!='' ){
                    $array['where'].=" AND dd.asunto LIKE '%".$asunto."%' ";
                }
            }
            
            if( Input::has("titulo") AND Input::get('titulo')!='' ){
                 $titulo=explode(" ",trim(Input::get('titulo')));
                    for($i=0; $i<count($titulo); $i++){
                       $array['where'].=" AND dd.titulo LIKE '%".$titulo[$i]."%' ";
                    }
            }
            
            if( Input::has("created_at") ){
                $created_at=Input::get("created_at");
                list($fechaIni,$fechaFin) = explode(" - ", $created_at);
                if( trim( $created_at )!='' ){
                    $array['where'].=" AND DATE(dd.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."'";
                }
            }
            
            if( Input::has("persona_u") ){
                $persona_u=Input::get("persona_u");
                if( trim( $persona_u )!='' ){
                    $array['where'].=" AND CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre) LIKE '%".$persona_u."%' ";
                }
            }
            
            if( Input::has("persona_c") ){
                $persona_c=Input::get("persona_c");
                if( trim( $persona_c )!='' ){
                    $array['where'].=" AND CONCAT_WS(' ',p.paterno,p.materno,p.nombre) LIKE '%".$persona_c."%' ";
                }
            }
            
            if( Input::has("solo_area") ){
                $usu_id=Auth::user()->id;
                $array['where'].="and dd.area_id IN (
                                        SELECT DISTINCT(a.id)
                                        FROM area_cargo_persona acp
                                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                       INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                        WHERE acp.estado=1
                                        AND cp.persona_id='.$usu_id.'
                        )";
            }  
            $array['order']=" order by `created_at` desc ";
            

        $rst= DocumentoDigital::getExportDocumento($array); 
//        var_dump($rst);exit();

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Mis Actividades',
          'tittle'=>'Mis Actividades',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'Nº',
          'CREADOR',
          'ACTUALIZÓ',
          'TÍTULO',
          'ASUNTO',
          'FECHA CREACIÓN',
          'PLANTILLA',
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }


  public function postReportetrabajoarea()
   {
        $rst=Area::OrdenTrabjbyArea();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
   }

  public function getExportordentbyarea(){
        $rst=Area::OrdenTrabjbyArea(); 
//        var_dump($rst);exit();

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Actividades Area',
          'tittle'=>'Actividades Area',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'Nº',
          'AREA',
          'PERSONA',
          'CANTIDAD',
          'TOTAL MIN',
          'FORMATO'
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }
   /**
   * bandeja de tramite, devuelve la consulta de tramites que se asignan 
   * a una determinada area que pertenece el usuario
   */
   public function postBandejatramitef()
   {
        $input=Input::all();
        
        $rst=VisualizacionTramite::BandejaTramitesf($input);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
   }
   /**
   * bandeja de tramite, devuelve la consulta de tramites que se asignan 
   * a una determinada area que pertenece el usuario
   */
   public function postBandejatramitedetalle()
   {
        $input=Input::all();
        if (is_array($input)) {
            $input=implode("','", $input);
        }
        $rst=VisualizacionTramite::BandejaTramites($input);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst, 'input'=>$input
            )
        );
   }
    /**
     * 
     */
    public function postTramitexfecha()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        //$fechaIni = Input::get('fechaIni');
        $fechaFin = $fechaFin.' 23:59:59';
        $rutaFlujo =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'rutas_flujo_detalle AS rfd',
                                'rf.id', '=', 'rfd.ruta_flujo_id'
                            )
                            ->join(
                                'flujos AS f',
                                'f.id', '=', 'rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id', '=', 'rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id', '=', 'rf.area_id'
                            )
                            ->join(
                                'areas AS a2',
                                'a2.id', '=', 'rfd.area_id'
                            )
                            ->join(
                                'tiempos as t',
                                't.id', '=', 'rfd.tiempo_id'
                            )
                            ->select(
                                'f.nombre AS flujo', 'rf.estado AS cestado',
                                'rf.id', 'a2.nombre as area2', 'rfd.dtiempo',
                                't.nombre as tiempo', 'rfd.norden',
                                DB::raw(
                                    'CONCAT(
                                            IFNULL(p.paterno,"")," ",
                                            IFNULL(p.materno,"")," ",
                                            IFNULL(p.nombre,"")
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
                            ->whereBetween('rf.created_at', array($fechaIni, $fechaFin))
                            //->where('rf.estado', '=', '1') }
                            
                            //->orderBy('n_flujo_ok','DESC')
                            //->orderBy('n_flujo_error','ASC')
                            ->orderBy('rf.id', 'desc')
                            ->get();
        //return $rutaFlujo;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rutaFlujo
            )
        );
    }
    /**
     * Cumplimiento de ruta por tramite
     * POST reporte/cumprutaxtramite
     *
     * @return Response
     */
    public function postCumprutaxtramite()
    {
        /*$flujoId = implode("','",Input::get('flujo_id'));
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);*/
        $rutaFlujoId=Input::get('id');

        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $tipofecha=Input::get('tipofecha');
        $tf='';
        if($tipofecha==2){
          $tf=" AND r.fecha_inicio BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
        }
        /*
        $query = "SELECT tr.id_union, r.id, s.nombre as software,
                p.nombre as persona, a.nombre as area, r.fecha_inicio,
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=1) AS 'error',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=2) AS 'corregido'
                FROM rutas r 
                JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id
                    JOIN softwares s ON tr.software_id=s.id
                JOIN personas p ON r.persona_id=p.id
                JOIN areas a ON r.area_id=a.id
                WHERE r.fecha_inicio BETWEEN '$fechaIni' AND 
                      DATE_ADD('$fechaFin',INTERVAL 1 DAY) AND r.flujo_id=?";
*/
        $query ="SELECT tr.id_union AS tramite, r.id, 
                ts.nombre AS tipo_persona,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre),
                    IF(tr.tipo_persona=2,
                        CONCAT(tr.razon_social,' | RUC:',tr.ruc),
                        IF(tr.tipo_persona=3,
                            a.nombre,
                            IF(tr.tipo_persona=4 or tr.tipo_persona=5,
                                tr.razon_social,''
                            )
                        )
                    )
                ) AS persona,
                  IFNULL(tr.sumilla,'') as sumilla,
                  IF(
                     (SELECT COUNT(rd.id)
                        FROM rutas_detalle rd
                        WHERE rd.ruta_id=r.id
                              AND rd.alerta=1
                              AND rd.alerta_tipo>1
                            ),'Trunco',
                        IF(
                            (SELECT COUNT(norden)
                             FROM rutas_detalle rd 
                             WHERE rd.ruta_id=r.id
                             AND rd.fecha_inicio IS NOT NULL
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                            ),'Inconcluso','Concluido'
                        )
                    ) AS estado,
                    IFNULL((SELECT concat(  min(norden),' (',a.nombre,')'  )
                             FROM rutas_detalle rd 
                             JOIN areas a ON rd.area_id=a.id
                             WHERE rd.ruta_id=r.id
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                             ORDER BY norden LIMIT 1),'' 
                    ) AS ultimo_paso_area,
                    IFNULL((SELECT a.nombre
                             FROM rutas_detalle rd 
                             JOIN areas a ON rd.area_id=a.id
                             WHERE rd.ruta_id=r.id
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                             ORDER BY norden LIMIT 1),'' 
                    ) AS ultima_area,
                    (SELECT count(norden)
                       FROM rutas_detalle rd 
                       WHERE rd.ruta_id=r.id
                       AND rd.estado=1 
                       ) AS total_pasos,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite, '' AS fecha_fin,
                IFNULL(r.fecha_inicio,'') AS fecha_inicio,
                IF( IFNULL(tr.persona_autoriza_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_autoriza_id),'' ) autoriza,
                IF( IFNULL(tr.persona_responsable_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_responsable_id),'' ) responsable,
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=1) AS 'errorr',
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=2) AS 'corregido'
                FROM tablas_relacion tr 
                inner JOIN rutas r ON tr.id=r.tabla_relacion_id and r.estado=1
                LEFT join tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
                WHERE r.ruta_flujo_id='".$rutaFlujoId."'
                $tf
                AND tr.estado=1";

        $table=DB::select($query);

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * Detalle del cumplimiento de ruta por tramite
     * POST reporte/rutaxtramite
     *
     * @return Response
     */
    public function postCumprutaxtramitedetalle()
    {

        $rutaId=Input::get('ruta_id');
        $table = DB::table('rutas as r')
                    ->join('rutas_detalle as rd', 'r.id', '=', 'rd.ruta_id')
                    ->join('rutas_detalle_verbo as v', 'rd.id', '=', 'v.ruta_detalle_id')
                    ->join('areas as a', 'rd.area_id', '=', 'a.id')
                    ->join('tiempos as t', 'rd.tiempo_id', '=', 't.id')
                    ->where('ruta_id', array($rutaId))
                    ->where('r.estado',1)
                    ->where('rd.estado',1)
                    ->where('v.estado',1)
                    ->select(
                        'rd.id',
                        'rd.ruta_id',
                        DB::RAW('ifnull(a.nombre,"") as area'),
                        DB::RAW('ifnull(t.nombre,"") as tiempo'),
                        DB::RAW('ifnull(dtiempo,"") as dtiempo'),
                        DB::RAW('ifnull(rd.fecha_inicio,"") as fecha_inicio'),
                        DB::RAW('ifnull(dtiempo_final,"") as dtiempo_final'),
                        'norden',
                        'alerta',
                        'alerta_tipo',
                        //'v.nombre as verbo',
                        //DB::RAW('ifnull(scaneo,"") as scaneo'),
                        //'finalizo',
                        DB::RAW(
                            "
                            GROUP_CONCAT( 
                                CONCAT(
                                    v.nombre,
                                    ' => ',
                                     IF(v.finalizo=0,'Pendiente','Finalizado')
                                ) SEPARATOR '<br>'
                            ) as verbo_finalizo
                        "
                        )
                    )
                    ->groupBy('rd.id')
                    ->get();

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * detalle de cumplimiento por area
     * POST reporte/estadoofficetrack
     *
     * @return Response
     */
    public function postCumpareadetalle2()
    {
        $rutaId=Input::get('ruta_id');
        $set=DB::select('SET group_concat_max_len := @@max_allowed_packet');
        $query =  DB::table('rutas as r')
                    ->join('rutas_detalle as rd','r.id','=','rd.ruta_id')
                    ->join('areas as a','rd.area_id','=','a.id')
                    ->join('rutas_detalle_verbo as v','rd.id','=','v.ruta_detalle_id')
                        ->leftjoin('roles as ro','v.rol_id','=','ro.id')
                        ->leftjoin('verbos as vs','v.verbo_id','=','vs.id')
                        ->leftjoin('documentos as d','v.documento_id','=','d.id')
                        ->leftjoin('personas as p','v.usuario_updated_at','=','p.id')
                    ->join('tiempos as t','rd.tiempo_id','=','t.id')
                    ->join('tablas_relacion as tr','r.tabla_relacion_id','=','tr.id')
                    ->where('r.id',array($rutaId))
                    //->where('rd.condicion',0)
                    ->where('r.estado',1)
                    ->where('rd.estado',1)
                    ->where('v.estado',1)
                    ->select(
                        'a.nombre as area',
                        'tr.id_union',
                        'rd.id',
                        DB::RAW('ifnull(rd.norden,"") as norden'),
                        DB::RAW('ifnull(rd.fecha_inicio,"") as fecha_inicio'),
                        DB::RAW('ifnull(t.nombre,"") as tiempo'),
                        DB::RAW('ifnull(rd.dtiempo,"") as dtiempo'),
                        DB::RAW('ifnull(rd.dtiempo_final,"") as dtiempo_final'),
                        'norden',
                        'alerta_tipo',
                        'rd.alerta',
                        DB::RAW("
                            GROUP_CONCAT(
                                    IFNULL(v.nombre,'') SEPARATOR ', '
                            ) AS descripcion_v
                        "),
                        DB::RAW("
                            GROUP_CONCAT(
                                    IFNULL(v.observacion,'') SEPARATOR ', '
                            ) AS observacion
                        "),
                        //'v.nombre AS descripcion_v',
                        //DB::RAW('ifnull(scaneo,"") as scaneo'),
                        //'finalizo',
                        DB::RAW("
                            GROUP_CONCAT( 
                                IF(v.finalizo=0,'Pendiente','Finalizado')
                                     SEPARATOR ', '
                            ) AS estado_accion
                        "),
                        DB::RAW("
                            GROUP_CONCAT( 
                                    CONCAT(
                                            v.nombre,
                                            ' => ',
                                             IF(v.finalizo=0,'Pendiente','Finalizado')
                                    ) SEPARATOR '<br>'
                            ) AS verbo_finalizo
                        "),
                        DB::RAW("
                            GROUP_CONCAT( 
                                IFNULL(ro.nombre,'') SEPARATOR ', '
                            ) AS rol
                        "),
                        DB::RAW("
                            GROUP_CONCAT( 
                                IFNULL(d.nombre,'') SEPARATOR ', '
                            ) AS documento
                        "),
                        DB::RAW("
                            GROUP_CONCAT( 
                                IFNULL(vs.nombre,'') SEPARATOR ', '
                            ) AS verbo
                        "),
                        DB::RAW("
                          IFNULL(GROUP_CONCAT(
                              CONCAT(
                                  '<b>',
                                  IFNULL(v.orden,' '),
                                  '</b>',
                                   '.- ',
                                  ro.nombre,
                                   ' tiene que ',
                                  vs.nombre,
                                   ' ',
                                  IFNULL(d.nombre,''),
                                   ' (',
                                  v.nombre,
                                   ' )'
                              )
                          ORDER BY v.orden ASC
                          SEPARATOR '|'),'') AS verbo2
                        "),
                        DB::RAW("
                          IFNULL(GROUP_CONCAT(
                              CONCAT(
                                  '<b>',
                                  IFNULL(v.orden,' '),
                                  '</b>',
                                   '.- ',
                                  IF(v.finalizo=0,'<font color=#EC2121>Pendiente</font>',CONCAT('<font color=#22D72F>Finalizó</font>(',p.paterno,' ',p.materno,', ',p.nombre,' ',IFNULL(v.documento,''),'//',IFNULL(v.observacion,''),')' ) )
                              )
                          ORDER BY v.orden ASC
                          SEPARATOR '|'),'') AS ordenv
                        ")/*,
                        DB::RAW("
                            CASE rd.alerta
                                WHEN '0' THEN 'Sin Alerta'
                                WHEN '1' THEN 'Alerta'
                                WHEN '2' THEN 'Alerta Validada'
                                ELSE '' 
                            END  AS alerta
                        ")*/
                    )
                    ->groupBy('rd.id')
                    ->orderBy('rd.norden')
                    ->get();
        return Response::json(
             array(
                 'rst'=>1,
                'datos'=>$query
             )
        );
    }
    /**
     * detalle de cumplimiento por area
     * POST reporte/estadoofficetrack
     *
     * @return Response
     */
    public function postCumpareadetalle()
    {
        
        $rutaFlujoId=Input::get('ruta_flujo_id');
        //recibir los parametros y enviarlos al modelo, ahi ejecutar el query
        $query ="SELECT tr.id_union AS tramite, r.id, 
                ts.nombre AS tipo_persona,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre),
                    IF(tr.tipo_persona=2,
                        CONCAT(tr.razon_social,' | RUC:',tr.ruc),
                        IF(tr.tipo_persona=3,
                            a.nombre,
                            IF(tr.tipo_persona=4 or tr.tipo_persona=5,
                                tr.razon_social,''
                            )
                        )
                    )
                ) AS persona,
                  IFNULL(tr.sumilla,'') as sumilla,
                  IF(
                     (SELECT COUNT(rd.id)
                        FROM rutas_detalle rd
                        WHERE rd.ruta_id=r.id
                              AND rd.alerta=1
                              AND rd.estado=1
                            ),'Trunco',
                        IF(
                            (SELECT COUNT(norden)
                             FROM rutas_detalle rd 
                             WHERE rd.ruta_id=r.id
                             AND rd.fecha_inicio IS NOT NULL
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                            ),'Inconcluso','Concluido'
                        )
                    ) AS estado,
                    IFNULL((SELECT norden
                             FROM rutas_detalle rd 
                             WHERE rd.ruta_id=r.id
                             AND rd.fecha_inicio IS NOT NULL
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                             ORDER BY norden LIMIT 1),'' 
                        ) AS ultimo_paso,
                        IFNULL((SELECT a.nombre
                                 FROM rutas_detalle rd 
                                 JOIN areas a ON rd.area_id=a.id
                                 WHERE rd.ruta_id=r.id
                                 AND rd.fecha_inicio IS NOT NULL
                                 AND rd.dtiempo_final IS NULL
                                 AND rd.estado=1 
                                 ORDER BY norden LIMIT 1),'' 
                            ) AS ultima_area,
                IF( IFNULL(tr.persona_autoriza_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_autoriza_id),'' ) autoriza,
                IF( IFNULL(tr.persona_responsable_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_responsable_id),'' ) responsable,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite, '' AS fecha_fin,
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=1) AS 'errorr',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=2) AS 'corregido'
                FROM tablas_relacion tr 
                JOIN rutas r ON tr.id=r.tabla_relacion_id
                LEFT join tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
                WHERE r.ruta_flujo_id=? AND tr.estado=1
                AND r.estado=1 ";
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>DB::Select($query, array($rutaFlujoId))
            )
        );
        //return Response::make($output, 200, $headers);
    }
    /**
     * Cumplimiento de are
     * POST reporte/tecnicoofficetrack
     *
     * @return Response
     */
    public function postCumparea()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode("','",Input::get('area_id'));
        $estadoF=implode(",",Input::get('estado_id'));
        $tipoFlujo='';
        if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')!='' ){
          $tipoFlujo=" AND f.tipo_flujo=2 ";
        }

        $query="SELECT rf.flujo_id,f.nombre AS proceso, rf.id AS ruta_flujo_id, 
                CONCAT(p.paterno,' ',p.materno,' ',p.nombre) AS duenio,
                a.nombre  AS area_duenio,
                (SELECT COUNT(DISTINCT a.id) 
                FROM areas a JOIN rutas_flujo_detalle rfd ON a.id=rfd.area_id
                WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1) AS n_areas,
                (SELECT COUNT(DISTINCT rfd.id) 
                FROM rutas_flujo_detalle rfd 
                WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1) AS n_pasos,
                CONCAT(
                    IFNULL(
                        (SELECT CONCAT(t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='1'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='2'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='3'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='4'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') 
                ) AS tiempo,
                IFNULL(max(r.fecha_inicio),'')  AS fecha_inicio,
                rf.created_at AS fecha_creacion,
                rf.updated_at AS fecha_produccion,
                count(distinct(r.id)) AS ntramites,
                rf.estado AS estado_final
                FROM flujos f 
                JOIN rutas_flujo rf ON rf.flujo_id=f.id
                JOIN personas p ON rf.persona_id=p.id
                JOIN rutas_flujo_detalle rfd ON rfd.ruta_flujo_id=rf.id AND rfd.estado=1
                JOIN areas a ON rf.area_id=a.id
                LEFT JOIN rutas r ON r.ruta_flujo_id=rf.id
                WHERE rf.area_id IN ('".$areaId."') 
                 ".$tipoFlujo." 
                AND f.estado=1 
                AND a.estado=1
                AND DATE(rf.updated_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."'
                AND rf.estado IN (".$estadoF.")
                GROUP BY rf.id
                ORDER BY rf.estado,a.nombre";
                
        $result= DB::Select($query);
        //echo $query;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }
        /**
     * Cumplimiento de are
     * POST reporte/tecnicoofficetrack
     *
     * @return Response
     */
    public function postCumparea2()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode("','",Input::get('flujo_id'));
        $estadoF=implode(",",Input::get('estado_id'));
        $tipofecha=Input::get('tipofecha');
        $tf="rf.updated_at";
        if($tipofecha==2){
          $tf="r.fecha_inicio";
        }

        $tipoFlujo='';
        if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')!='' ){
          $tipoFlujo=" AND f.tipo_flujo=2 ";
        }

        $query="SELECT rf.flujo_id,f.nombre AS proceso, rf.id AS ruta_flujo_id, 
                CONCAT(p.paterno,' ',p.materno,' ',p.nombre) AS duenio,
                a.nombre  AS area_duenio,
                (SELECT COUNT(DISTINCT a.id) 
                FROM areas a JOIN rutas_flujo_detalle rfd ON a.id=rfd.area_id
                WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1) AS n_areas,
                (SELECT COUNT(DISTINCT rfd.id) 
                FROM rutas_flujo_detalle rfd 
                WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1) AS n_pasos,
                CONCAT(
                    IFNULL(
                        (SELECT CONCAT(t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='1'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='2'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='3'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='4'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') 
                ) AS tiempo,
                IFNULL(max(r.fecha_inicio),'')  AS fecha_inicio,
                rf.created_at AS fecha_creacion,
                rf.updated_at AS fecha_produccion,
                CONCAT(count(distinct(r.id)),'/',count(DISTINCT(ruf.id))) ntramites,
                count(DISTINCT(IF(ruf.dtiempo_final is null,null,ruf.id))) concluidos,
                count(DISTINCT(IF(ruf.dtiempo_final is null,ruf.id,null))) inconclusos,
                rf.estado AS estado_final
                FROM flujos f 
                JOIN rutas_flujo rf ON rf.flujo_id=f.id
                JOIN personas p ON rf.persona_id=p.id
                JOIN rutas_flujo_detalle rfd ON rfd.ruta_flujo_id=rf.id AND rfd.estado=1
                JOIN areas a ON rf.area_id=a.id
                LEFT JOIN rutas r ON r.ruta_flujo_id=rf.id
                LEFT JOIN (
                      SELECT ru.id,rd.fecha_inicio,rd.id rdid,rd.alerta,rd.alerta_tipo,rd.dtiempo_final
                      FROM rutas ru 
                      INNER JOIN rutas_detalle rd ON rd.ruta_id=ru.id AND rd.estado=1
                      WHERE ru.estado=1
                      AND CONCAT(rd.fecha_inicio,'_',rd.id) IN (
                        SELECT MAX(CONCAT(rdf.fecha_inicio,'_',rdf.id))
                        FROM rutas_detalle rdf
                        WHERE rdf.ruta_id=ru.id
                      )
                      GROUP BY ru.id
                ) ruf ON ruf.id=r.id
                WHERE f.id IN ('".$areaId."') 
                AND f.estado=1
                AND a.estado=1
                AND DATE(".$tf.") BETWEEN '".$fechaIni."' AND '".$fechaFin."'
                AND rf.estado IN (".$estadoF.")
                 ".$tipoFlujo." 
                GROUP BY rf.id
                ORDER BY rf.estado,a.nombre";
//echo $query;
        $result =DB::Select($query);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }

    public function postAcciones()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode('","',Input::get('area_id'));
        $estadoF=implode(",",Input::get('estado_id'));

        $query='SELECT rd.id,a.nombre area,a2.nombre areapaso,CONCAT_WS(" ",p.paterno,p.materno,p.nombre) persona,f.nombre proceso,
                IF(r.estado=1,"Producción",
                  "Pendiente" 
                ) estado,rd.norden,
                CONCAT(count(rd.id),"/",
                  IFNULL(
                    (
                    SELECT count(rdv2.id)
                    FROM rutas_flujo_detalle_verbo rdv2
                    WHERE rdv2.estado=1
                    AND rdv2.ruta_flujo_detalle_id=rd.id
                    GROUP BY rdv2.created_at
                    ORDER BY rdv2.created_at DESC
                    LIMIT 1,1
                    ),"0"
                  )
                ) nverbos,max(rdv.created_at) fecha

                FROM rutas_flujo r
                INNER JOIN rutas_flujo_detalle rd ON r.id=rd.ruta_flujo_id AND rd.estado=1
                INNER JOIN rutas_flujo_detalle_verbo rdv ON rd.id=rdv.ruta_flujo_detalle_id AND rdv.estado=1
                INNER JOIN personas p ON p.id=r.persona_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                INNER JOIN areas a ON a.id=r.area_id
                INNER JOIN areas a2 ON a2.id=rd.area_id
                WHERE rd.area_id IN ("'.$areaId.'") 
                AND r.estado IN ('.$estadoF.')
                AND date(rdv.created_at) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'"
                GROUP BY rd.id
                ORDER BY r.id,rd.norden';
                
        $result= DB::Select($query);
        //echo $query;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }

    public function postDocumentos()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode('","',Input::get('area_id'));

        $query='SELECT rdv.id,a.nombre area, f.nombre proceso, ts.nombre tipo_solicitante,
                t.id_union tramite, d.nombre tipo_documento, rdv.documento
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                INNER JOIN rutas_detalle_verbo rdv ON rdv.ruta_detalle_id=rd.id AND rdv.estado=1
                INNER JOIN documentos d ON rdv.documento_id=d.id 
                INNER JOIN areas a ON rd.area_id=a.id
                INNER JOIN flujos f ON r.flujo_id=f.id
                INNER JOIN tablas_relacion t ON r.tabla_relacion_id=t.id
                LEFT JOIN tipo_solicitante ts ON t.tipo_persona=ts.id
                LEFT JOIN areas a2 ON t.area_id=a2.id
                WHERE rdv.documento IS NOT NULL
                AND rdv.verbo_id=1
                AND rdv.finalizo=1
                AND r.estado=1
                AND rd.area_id IN ("'.$areaId.'") 
                AND date(rdv.updated_at) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'" ';
                
        $result= DB::Select($query);
        //echo $query;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }

    public function postExpediente()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $filtrofecha=" AND DATE(r.fecha_inicio) BETWEEN '".$fechaIni."' and '".$fechaFin."'";
        $flujo="";$filtroflujo="";
        if( Input::has('flujo') ){
          $flujo=implode("','",Input::get('flujo'));
          $filtrofecha=" AND DATE(tr.fecha_tramite) BETWEEN '".$fechaIni."' and '".$fechaFin."'";
          $filtroflujo=" AND r.flujo_id IN ('".$flujo."')";
        }
        $query ="SELECT tr.id_union AS tramite, r.id, f.nombre flujo,
                ts.nombre AS tipo_persona,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre),
                    IF(tr.tipo_persona=2,
                        CONCAT(tr.razon_social,' | RUC:',tr.ruc),
                        IF(tr.tipo_persona=3,
                            a.nombre,
                            IF(tr.tipo_persona=4 or tr.tipo_persona=5,
                                tr.razon_social,''
                            )
                        )
                    )
                ) AS persona,
                  IFNULL(tr.sumilla,'') as sumilla,
                  IF(
                     (SELECT COUNT(rd.id)
                        FROM rutas_detalle rd
                        WHERE rd.ruta_id=r.id
                              AND rd.alerta=1
                            ),'Trunco',
                        IF(
                            (SELECT COUNT(norden)
                             FROM rutas_detalle rd 
                             WHERE rd.ruta_id=r.id
                             AND rd.fecha_inicio IS NOT NULL
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                            ),'Inconcluso','Concluido'
                        )
                    ) AS estado,
                    IFNULL((SELECT concat(  min(norden),' (',a.nombre,')'  )
                             FROM rutas_detalle rd 
                             JOIN areas a ON rd.area_id=a.id
                             WHERE rd.ruta_id=r.id
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                             ORDER BY norden LIMIT 1),'' 
                    ) AS ultimo_paso_area,
                    IFNULL((SELECT a.nombre
                             FROM rutas_detalle rd 
                             JOIN areas a ON rd.area_id=a.id
                             WHERE rd.ruta_id=r.id
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                             ORDER BY norden LIMIT 1),'' 
                    ) AS ultima_area,
                    (SELECT count(norden)
                       FROM rutas_detalle rd 
                       WHERE rd.ruta_id=r.id
                       AND rd.estado=1 
                       ) AS total_pasos,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite, '' AS fecha_fin,
                IFNULL(r.fecha_inicio,'') AS fecha_inicio,
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=1) AS 'errorr',
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=2) AS 'corregido'
                FROM tablas_relacion tr 
                JOIN rutas r ON tr.id=r.tabla_relacion_id and r.estado=1
                INNER JOIN flujos f ON f.id=r.flujo_id and f.estado=1
                LEFT JOIN tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
                WHERE tr.estado=1
                ".$filtrofecha.$filtroflujo;

        $table=DB::select($query);

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }

    public function postExpedientedetalle()
    {
      $id=Input::get('id');

      $query="SELECT rdv.id,tr.id_union,ts.nombre tipo_solicitante,
              a2.nombre area_proceso,f.nombre proceso,
              (SELECT CONCAT(count(DISTINCT(rd2.area_id)),' / ',count(rd2.id)) FROM rutas_detalle rd2 WHERE rd2.ruta_id=r.id GROUP BY rd2.ruta_id)
             nanp,
            a2.nombre area_generada,d.nombre tipo_documento,rdv.documento   
            FROM rutas r
            inner join rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
            inner join rutas_detalle_verbo rdv ON rdv.ruta_detalle_id=rd.id AND rdv.estado=1
            inner join documentos d ON d.id=rdv.documento_id
            inner join areas a2 ON a2.id=r.area_id
            inner join flujos f ON f.id=r.flujo_id AND f.estado=1
            inner join tablas_relacion tr ON tr.id=r.tabla_relacion_id
            LEFT join tipo_solicitante ts ON ts.id=tr.tipo_persona
            LEFT JOIN areas a ON a.id=tr.area_id
            WHERE r.estado=1
            AND rdv.finalizo=1
            AND rdv.verbo_id=1
            AND r.id='".$id."' ";

      $table=DB::select($query);

      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$table
          )
      );

    }

    public function postDocumentoxproceso()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode('","',Input::get('area_id'));

        $query='SELECT a.nombre area, f.nombre proceso, d.nombre tipo_documento, count(DISTINCT(r.id)) ntramites, count(r.id) ndocumentos
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                INNER JOIN rutas_detalle_verbo rdv ON rdv.ruta_detalle_id=rd.id AND rdv.estado=1
                INNER JOIN documentos d ON rdv.documento_id=d.id 
                INNER JOIN areas a ON rd.area_id=a.id
                INNER JOIN flujos f ON r.flujo_id=f.id
                INNER JOIN tablas_relacion t ON r.tabla_relacion_id=t.id
                LEFT JOIN tipo_solicitante ts ON t.tipo_persona=ts.id
                LEFT JOIN areas a2 ON t.area_id=a2.id
                WHERE rdv.documento IS NOT NULL
                AND rdv.verbo_id=1
                AND rdv.finalizo=1
                AND r.estado=1
                AND rd.area_id IN ("'.$areaId.'") 
                AND date(rdv.updated_at) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'" 
                GROUP BY a.nombre,f.nombre,d.nombre
                ORDER BY a.nombre,f.nombre,d.nombre';
                
        $result= DB::Select($query);
        //echo $query;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }

    public function notificacionIncum($fecha='',$area='',$tipo=''){
        $query = '';

       $query.="SELECT rd.id,t.id_union as documento,rd.norden as paso,rd.fecha_inicio as fechaAsignada,
                CalcularFechaFinal(
                  rd.fecha_inicio, 
                  (rd.dtiempo*ti.totalminutos),
                  rd.area_id 
                ) as fechaFinal,CONCAT(pe.paterno,' ',pe.materno,', ',pe.nombre) as persona,
                f.nombre as proceso,a.nombre as area,CASE al.tipo 
                WHEN 1 THEN 'Notificación'
                WHEN 2 THEN 'Reiterativo'
                WHEN 3 THEN 'Relevo'
                END as tipo_aviso ,CONCAT(ti.apocope,': ',rd.dtiempo) tiempo,
                al.fecha fecha_aviso, IFNULL(rd.dtiempo_final,'') fechaGestion,t.sumilla asunto 
                FROM rutas r 
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 
                INNER JOIN tiempos ti ON ti.id=rd.tiempo_id 
                INNER JOIN alertas al on rd.id=al.ruta_detalle_id 
                INNER JOIN areas a ON rd.area_id=a.id 
                INNER JOIN flujos f ON r.flujo_id=f.id 
                INNER JOIN tablas_relacion t ON r.tabla_relacion_id=t.id 
                LEFT JOIN tipo_solicitante ts ON t.tipo_persona=ts.id 
                LEFT JOIN personas pe on pe.id=al.persona_id
                WHERE r.estado=1 AND al.estado=1";

          if($fecha != ''){
            list($fechaIni,$fechaFin) = explode(" - ", $fecha);
            $query.=' AND date(al.fecha) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'" ';
          }
          if($area != ''){
            $query.=' AND rd.area_id IN ("'.$area.'") ';
          }
          if($tipo != ''){
            $query.=' AND al.clasificador='.$tipo;
          }

          $query.=" ORDER BY a.nombre,f.nombre";
          $result= DB::Select($query);

/*          if($result){
            foreach ($result as $key => $value) {
              $alertas = DB::table('alertas')
                ->where('ruta_detalle_id', '=', $value->id)
		->where('estado',1)
		->orderBy('persona_id')
                ->orderBy('fecha')
                ->get();

                if($alertas){
                  $fechaAntigua = "";
                  $ruta_detalle = "";
                  $tipo = 0;
                  $persona_id=0;
                  foreach ($alertas as $index => $val) {
                    if($val->fecha >= '2017-03-28' && $val->fecha <= '2017-03-30'){
                    	if($fechaAntigua == $val->fecha && $ruta_detalle ==$val->ruta_detalle_id && $persona_id==$val->persona_id){
                        $actualizar = Alerta::find($val->id);
                        $actualizar->estado=0;
                        $actualizar->save();
             		}else{
			$actualizar = Alerta::find($val->id);
                        $actualizar->estado=1;
                        $actualizar->save();
			}
			
                    if($val->fecha >= '2017-03-28' && $val->fecha <= '2017-03-29'){
                      if($fechaAntigua == $val->fecha && $ruta_detalle ==$val->ruta_detalle_id && $persona_id==$val->persona_id){
                        $actualizar = Alerta::find($val->id);
                        $actualizar->estado=0;
                        $actualizar->save();
                     

                      if($ruta_detalle == $val->ruta_detalle_id && $fechaAntigua ==  date('Y-m-d', strtotime($val->fecha . ' -1 day')) && $tipo == $val->tipo && $persona_id==$val->persona_id){
                        $updated = Alerta::find($val->id);
                        $updated->tipo=$val->tipo + 1;
                        $updated->save();
                      }
                      $fechaAntigua = $val->fecha;
                      $ruta_detalle = $val->ruta_detalle_id;
                      $tipo = $val->tipo;
                      $persona_id=$val->persona_id;
                    }                    
                  }
                } 
            }
          }*/
          
          return $result;
    }

    public function postNotificacionincumplimiento(){
        $fecha = '';
        $area = '';
        $tipo = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          if(Input::get('area_id')){
            $area=implode('","',Input::get('area_id'));
          }
          if(Input::get('tipo_id')){
            $tipo=Input::get('tipo_id');
          }

        $result = $this->notificacionIncum($fecha,$area,$tipo);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }
    
    public function postHistoricoinventario(){
            $array=array();
            $array['where'] = '';

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(ii.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }

        $result = Inmueble::getCargarHistorico($array);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }
    
        public function getExporthistoricoinventario(){

        $array=array();
        $array['where'] = '';

        if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                 list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                 $array['where'].=" AND date(ii.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
        }
        $rst = Inmueble::getCargarHistorico($array);
        

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Reporte de Inventario',
          'tittle'=>'Personal',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'N°',
          'ÁREA',
          'CÓDIGO PATRIMONIAL',
          'CÓDIGO INTERNO',
          'ÚLTIMO'
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }
    
        public function postReporteinventario(){
        $area = '';

          if(Input::get('area_id')){
            $area=implode('","',Input::get('area_id'));
          }

        $result = Inmueble::getCargar($area);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }
    
        public function getExportreporteinventario(){

        $area=Input::get('area_id');
            if(Input::get('tipo_id')){
                $tipo=Input::get('tipo_id');
            }

        $rst = Inmueble::getCargar($area);
        

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Reporte de Inventario',
          'tittle'=>'Personal',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'N°',
          'ÁREA',
          'PERSONA',
          'LOCAL',
          'PISO',
          'CÓDIGO PATRIMONIAL',
          'CÓDIGO INTERNO',
          'DESCRIPCIÓN',
          'OFICINA',
          'MARCA',
          'MODELO',
          'TIPO',
          'COLOR',
          'SERIE',
          'OBSERVACIÓN',
          'SITUACIÓN'
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }
    
        public function postNotificacionactividad(){
        $fecha = '';
        $area = '';
        $tipo = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          if(Input::get('area_id')){
            $area=implode('","',Input::get('area_id'));
          }
          if(Input::get('tipo_id')){
            $tipo=Input::get('tipo_id');
          }

        $result = ActividadPersonal::getNotificacionactividad($fecha,$area,$tipo);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }
    
    public function getExportnotificacionactividad(){
                $fecha = '';
       
        $tipo = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          $area=Input::get('area_id');
          if(Input::get('tipo_id')){
            $tipo=Input::get('tipo_id');
          }

        $rst = ActividadPersonal::getNotificacionactividad($fecha,$area,$tipo);
        

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Notificaciones de Actividad',
          'tittle'=>'Personal',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'PERSONA',
          'ÁREA',
          'ACTIVIDAD',
          'MINUTO',
          'FECHA DE ALERTA',
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }

     public function getExportdetalleproduccion(){
         $array=array();
            $array['where']='';
            $array['limit']='';$array['order']='';
         
         if( Input::has("usuario_id") ){
                $id_usuario=Input::get("usuario_id");
                if($id_usuario != ''){
                    $array['where'].=" AND rdv.usuario_updated_at=$id_usuario ";
                }
            }
            
            if( Input::has("proceso_id") ){
                $id_proceso=Input::get("proceso_id");
                if($id_proceso != ''){
                    $array['where'].=" AND f.id=$id_proceso ";
                }
            }

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(rdv.updated_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }

            $array['order']=" ORDER BY f.nombre ";
            
        $rst=Persona::getDetalleProduccion($array); 
        

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Detalle de Tareas',
          'tittle'=>'Plataforma',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'PROCESO',
          'AREA',
          'TAREA',
          'VERBO',
          'DOCUMENTO GENERADO',
          'OBSERVACION',
          'N° DE ACTIVIDAD',
          'FECHA',
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }
    public function postDetalleproduccion(){
        
        if ( Request::ajax() ) {
            /*********************FIJO*****************************/
            $array=array();
            $array['where']='';
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

            if( Input::has("usuario_id") ){
                $id_usuario=Input::get("usuario_id");
                if($id_usuario != ''){
                    $array['where'].=" AND rdv.usuario_updated_at=$id_usuario ";
                }
            }
            
            if( Input::has("proceso_id") ){
                $id_proceso=Input::get("proceso_id");
                if($id_proceso != ''){
                    $array['where'].=" AND f.id=$id_proceso ";
                }
            }

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(rdv.updated_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }
            
            $array['order']=" ORDER BY f.nombre ";

            $cant  = Persona::getDPCount( $array );
            $aData = Persona::getDetalleProduccion( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }

    }
    public function postProduccionusuario(){
        $fecha = '';
        $id_usuario = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          if(Input::get('usuario_id')){
             $id_usuario = Input::get('usuario_id');
          }

        $r= Persona::ProduccionUsuario($fecha,$id_usuario);
            return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r 
            )
        );
    }
    public function postProduccionusuarioxarea(){
        $fecha = '';
        $id_usuario = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          if(Input::get('usuario_id')){
             $id_usuario = Input::get('usuario_id');
          }

        $r= Persona::ProduccionUsuarioxArea($fecha,$id_usuario);
            return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r 
            )
        );
    }
    public function postProducciontramiteasignadototal(){
        $fecha = '';
        $id_usuario = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          if(Input::get('usuario_id')){
             $id_usuario = Input::get('usuario_id');
          }

        $r= Persona::ProduccionTramiteAsignadoTotal($fecha,$id_usuario);
            return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r 
            )
        );
    }
    
    public function postProducciontramiteasignado(){
        $fecha = '';
        $id_usuario = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          if(Input::get('usuario_id')){
             $id_usuario = Input::get('usuario_id');
          }

        $r= Persona::ProduccionTramiteAsignado($fecha,$id_usuario);
            return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r 
            )
        );
    }
    
     public function postProducciontramiteasignadodetalle(){
        
        if ( Request::ajax() ) {
            /*********************FIJO*****************************/
            $array=array();
            $array['where']='';
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

            if( Input::has("usuario_id") ){
                $id_usuario=Input::get("usuario_id");
                if($id_usuario != ''){
                    $array['where'].=" AND tr.usuario_created_at=$id_usuario ";
                }
            }
            
            if( Input::has("proceso_id") ){
                $id_proceso=Input::get("proceso_id");
                if($id_proceso != ''){
                    $array['where'].=" AND f.id=$id_proceso ";
                }
            }

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(tr.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }
            
            
      

            $array['order']=" ORDER BY f.nombre ";

            $cant  = Persona::getPTADCount( $array );
            $aData = Persona::getProduccionTramiteAsignadoDetalle( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }

    }
    
    public function getExportproducciontramiteasignadodetalle(){
         $array=array();
            $array['where']='';
            $array['limit']='';$array['order']='';
         
         if( Input::has("usuario_id") ){
                $id_usuario=Input::get("usuario_id");
                if($id_usuario != ''){
                    $array['where'].=" AND tr.usuario_created_at=$id_usuario ";
                }
            }
            
            if( Input::has("proceso_id") ){
                $id_proceso=Input::get("proceso_id");
                if($id_proceso != ''){
                    $array['where'].=" AND f.id=$id_proceso ";
                }
            }

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(tr.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }

            $array['order']=" ORDER BY f.nombre ";
            
        $rst=Persona::getProduccionTramiteAsignadoDetalle($array); 
        

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Detalle de Tareas',
          'tittle'=>'Plataforma',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'PROCESO',
          'AREA',
          'ID_UNION',
          'SUMILLA',
          'FECHA',
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }

    
    public function getExportnotincumplimiento(){
   /*   if( Request::ajax() ){*/
        $fecha = Input::get('fecha');
        $area=Input::get('area_id');
        $tipo=Input::get('tipo_id');
        $result = $this->notificacionIncum($fecha,$area,$tipo);

        /*style*/
        $styleThinBlackBorderAllborders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleAlignmentBold= array(
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleAlignment= array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        /*end style*/

          /*export*/
            /* instanciar phpExcel!*/
            
            $objPHPExcel = new PHPExcel();

            /*configure*/
            $objPHPExcel->getProperties()->setCreator("Gerencia Modernizacion")
               ->setSubject("Notificacion Incumplimiento");

            $objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
            $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
            /*end configure*/

            /*head*/
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A3', 'N°')
                        ->setCellValue('B3', 'DOCUMENTO')
                        ->setCellValue('C3', 'PASO')
                        ->setCellValue('D3', 'FECHA DE ASIGNACIÓN')
                        ->setCellValue('E3', 'FECHA FINAL')
                        ->setCellValue('F3', 'FECHA DE GESTIÓN')
                        ->setCellValue('G3', 'TIEMPO')
                        ->setCellValue('H3', 'NOMBRES Y APELLIDOS')
                        ->setCellValue('I3', 'FECHA DE AVISO')
                        ->setCellValue('J3', 'TIPO DE AVISO')
                        ->setCellValue('K3', 'PROCESO')
                        ->setCellValue('L3', 'ASUNTO')
                        ->setCellValue('M3', 'AREA')
                  ->mergeCells('A1:M1')
                  ->setCellValue('A1', 'NOTIFICACIONES POR INCUMPLIMIENTO')
                  ->getStyle('A1:M1')->getFont()->setSize(18);

            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('k')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('l')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
            /*end head*/
            /*body*/
            if($result){
              foreach ($result as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValueExplicit('A' . ($key + 4), $key + 1)
                              ->setCellValueExplicit('B' . ($key + 4), $value->documento)
                              ->setCellValueExplicit('C' . ($key + 4), $value->paso)
                              ->setCellValueExplicit('D' . ($key + 4), $value->fechaAsignada)
                              ->setCellValueExplicit('E' . ($key + 4), $value->fechaFinal)
                              ->setCellValueExplicit('F' . ($key + 4), $value->fechaGestion)
                              ->setCellValue('G' . ($key + 4), $value->tiempo)
                              ->setCellValue('H' . ($key + 4), $value->persona)
                              ->setCellValue('I' . ($key + 4), $value->fecha_aviso)
                              ->setCellValue('J' . ($key + 4), $value->tipo_aviso)
                              ->setCellValue('K' . ($key + 4), $value->proceso)
                              ->setCellValue('L' . ($key + 4), $value->asunto)
                              ->setCellValue('M' . ($key + 4), $value->area)
                              ;
              }
            }
            /*end body*/
            $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($styleThinBlackBorderAllborders);
            $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleAlignment);
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Notificaciones');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="reporteni.xls"'); // file name of excel
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
          /* end export*/
     /* }else{
        echo 'no hay data';
      }*/
    }

    public function postProcesosyactividades(){
        $rst=Reporte::ProcesosyActividades();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
    }

    public function exportExcel($propiedades,$estilos,$cabecera,$data){
        /*style*/
        $styleThinBlackBorderAllborders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleAlignmentBold= array(
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleAlignment= array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        /*end style*/

      $head=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');

      /*instanciar phpExcel*/            
      $objPHPExcel = new PHPExcel();
      /*end instanciar phpExcel*/

      /*configure*/
      $objPHPExcel->getProperties()->setCreator($propiedades['creador'])
                                  ->setSubject($propiedades['subject']);

      $objPHPExcel->getDefaultStyle()->getFont()->setName($propiedades['font-name']);
      $objPHPExcel->getDefaultStyle()->getFont()->setSize($propiedades['font-size']);
      $objPHPExcel->getActiveSheet()->setTitle($propiedades['tittle']);
      /*end configure*/

      /*set up structure*/
      array_unshift($data,(object) $cabecera);
      foreach($data as $key => $value){
        $cont = 0;

        if($key == 0){ // set style to header
          end($value);       
          $objPHPExcel->getActiveSheet()->getStyle('A1:'.$head[key($value)].'1')->applyFromArray($styleThinBlackBorderAllborders);
        }

        foreach($value as $index => $val){
          $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($head[$cont])->setAutoSize(true);
            
          if($index == 'norden' && $key > 0){ //set orden in excel
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $key);                
          }else{ //poblate info
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $val);
          }

          $cont++;
        }          
      }
      /*end set up structure*/

      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel5)
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="reporte.xls"'); // file name of excel
      header('Cache-Control: max-age=0');
      // If you're serving to IE 9, then the following may be needed
      header('Cache-Control: max-age=1');
      // If you're serving to IE over SSL, then the following may be needed
      header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
      header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
      header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
      header ('Pragma: public'); // HTTP/1.0
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
      exit;
    }

    public function getExportprocesosactividades(){
        $rst=Reporte::ProcesosyActividades();

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Procesos y sus Actividades',
          'tittle'=>'Reporte',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'N°',        
          'PROCESO',
          'DUENO PROCESO',
          'AREA CREACION',
          'ESTADO PROCESO',
          'FECHA CREACION',
          'PASO',
          'AREA DE ACTIVIDAD',
          'TIEMPO',
          'USUARIO MODIFICACION',
          'HORA MODIFICACIÓN'
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }

    public function getExportdocplataforma(){
        set_time_limit(900);
        ini_set('memory_limit','1024M');
        $rst=Reporte::Docplataforma(); 

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Documentos Plataforma',
          'tittle'=>'Plataforma',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'N°',
          'PROCESO',
          'AREA',
          'TRAMITE',
          'FECHA INICIO TRAMITE',
          'FECHA FINAL TRAMITE',
          'PROCESO',
          'FECHA INICIO EN EL PROCESO',
          'TOTAL N PASOS',
          'PASO ACTUAL',
          'FECHA LIMITE EN EL PASO',
          'FECHA FINAL DEL TRAMITE EN EL PROCESO',
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }

    public function postUsuarios(){
      $r=Persona::ListarUsuarios();

      return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r
            )
        );
    }

    public function getExportusuarios(){
       $rst=Persona::ListarUsuarios();

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Listado Usuarios',
          'tittle'=>'Usuarios',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'N°',        
          'PATERNO',
          'MATERNO',
          'NOMBRE',
          'EMAIL',
          'DNI',
          'FECHA NACIMIENTO',
          'SEXO',
          'ESTADO',
          'AREA',
          'CARGO'
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }

    public function postDocplataforma(){
      $rst=Reporte::Docplataforma(); 
      return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
    }

    public function postExpedienteunico(){
      $rst=Reporte::getExpedienteUnico(); 
      return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
    }
    
    public function postProducciontrpersonalxarea(){
        $fecha = '';
        $id_area = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          if(Input::get('area_id')){
             $id_area=Input::get('area_id');
          }

        $r= Persona::ProduccionTRPersonalxArea($fecha,$id_area);
            return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r 
            )
        );
    }
    
        public function postProducciontrpersonalxareadetalle(){
        
        if ( Request::ajax() ) {
            /*********************FIJO*****************************/
            $array=array();
            $array['where']='';
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
            
            if( Input::has("area_id") ){
                $id_area=Input::get("area_id");
                if($id_area != ''){
                    $array['where'].=" AND rd.area_id IN ('$id_area') ";
                }
            }
            
            if( Input::has("array_area_id") ){
            $id_array_area=Input::get("array_area_id");
                $id_array_area=str_replace("%2C", ",", $id_array_area);
                if($id_array_area != ''){
                    $array['where'].=" AND rd.area_id IN ($id_array_area) ";
                }
            }
            
            if( Input::has("proceso_id") ){
                $id_proceso=Input::get("proceso_id");
                if($id_proceso != ''){
                    $array['where'].=" AND f.id=$id_proceso ";
                }
            }

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(rdv.updated_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }
            
            $array['order']=" ORDER BY a.nombre ";

            $cant  = Persona::getPTRPxACount( $array );
            $aData = Persona::getProduccionTRPersonalxAreaDetalle( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }

    }
    
    public function getExportproducciontrpersonalxareadetalle(){
         $array=array();
            $array['where']='';
            $array['limit']='';$array['order']='';
         
         if( Input::has("area_id") ){
                $id_area=Input::get("area_id");
                if($id_area != ''){
                    $array['where'].=" AND rd.area_id IN ('$id_area') ";
                }
            }
            
            if( Input::has("array_area_id") ){
            $id_array_area=Input::get("array_area_id");
//                $id_array_area=str_replace("%2C", ",", $id_array_area);
                if($id_array_area != ''){
                    $array['where'].=" AND rd.area_id IN ($id_array_area) ";
                }
            }
            
            if( Input::has("proceso_id") ){
                $id_proceso=Input::get("proceso_id");
                if($id_proceso != ''){
                    $array['where'].=" AND f.id=$id_proceso ";
                }
            }

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(rdv.updated_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }

            $array['order']=" ORDER BY a.nombre ";
            
        $rst=Persona::getProduccionTRPersonalxAreaDetalle($array); 
//        var_dump($rst);exit();

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Detalle de Tareas',
          'tittle'=>'Plataforma',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'PROCESO',
          'AREA',
          'PERSONA',
          'TAREA',
          'VERBO',
          'DOCUMENTO GENERADO',
          'OBSERVACION',
          'N° DE ACTIVIDAD',
          'FECHA',
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }
    
    public function postProducciontapersonalxarea(){
        $fecha = '';
        $id_area = '';
          if(Input::get('fecha')){
            $fecha = Input::get('fecha');
          }
          if(Input::get('area_id')){
             $id_area=Input::get('area_id');
          }

        $r= Persona::ProduccionTAPersonalxArea($fecha,$id_area);
            return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r 
            )
        );
    }
    
     public function postProducciontapersonalxareadetalle(){
        
        if ( Request::ajax() ) {
            /*********************FIJO*****************************/
            $array=array();
            $array['where']='';
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
            
            if( Input::has("area_id") ){
                $id_area=Input::get("area_id");
                if($id_area != ''){
                    $array['where'].=" AND tr.area_id IN ('$id_area') ";
                }
            }
            
            if( Input::has("array_area_id") ){
            $id_array_area=Input::get("array_area_id");
                $id_array_area=str_replace("%2C", ",", $id_array_area);
                if($id_array_area != ''){
                    $array['where'].=" AND tr.area_id IN ($id_array_area) ";
                }
            }
            
            if( Input::has("proceso_id") ){
                $id_proceso=Input::get("proceso_id");
                if($id_proceso != ''){
                    $array['where'].=" AND f.id=$id_proceso ";
                }
            }

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(tr.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }
            
            $array['order']=" ORDER BY a.nombre ";

            $cant  = Persona::getPTAPxACount( $array );
            $aData = Persona::getProduccionTAPersonalxAreaDetalle( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }

    }
    
        public function getExportproducciontapersonalxareadetalle(){
         $array=array();
            $array['where']='';
            $array['limit']='';$array['order']='';
         
         if( Input::has("area_id") ){
                $id_area=Input::get("area_id");
                if($id_area != ''){
                    $array['where'].=" AND tr.area_id IN ('$id_area') ";
                }
            }
            
            if( Input::has("array_area_id") ){
            $id_array_area=Input::get("array_area_id");
//                $id_array_area=str_replace("%2C", ",", $id_array_area);
                if($id_array_area != ''){
                    $array['where'].=" AND tr.area_id IN ($id_array_area) ";
                }
            }
            
            if( Input::has("proceso_id") ){
                $id_proceso=Input::get("proceso_id");
                if($id_proceso != ''){
                    $array['where'].=" AND f.id=$id_proceso ";
                }
            }

            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(tr.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }

            $array['order']=" ORDER BY a.nombre ";
            
        $rst=Persona::getProduccionTAPersonalxAreaDetalle($array); 
//        var_dump($rst);exit();

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Detalle de Tareas',
          'tittle'=>'Plataforma',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'AREA',
          'PERSONA',
          'PROCESO',
          'ID_UNION',
          'SUMILLA',
          'FECHA',
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }
        
        public function getExportcontratacion(){
         $array=array();
            $array['where']='';
            $array['limit']='';$array['order']='';
         
         if( Input::has("contratacion") ){
                $contratacion=Input::get("contratacion");
            }
            
            if( Input::has("tipo_fecha") ){
                if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                }
                
                $tipo_fecha=Input::get("tipo_fecha");
                if($tipo_fecha == 1){  
                    $array['where'].=" AND date(c.fecha_inicio) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
                }
                if($tipo_fecha == 2){  
                    $array['where'].=" AND date(c.fecha_fin) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
                }
                if($tipo_fecha == 3){  
                    $array['where'].=" AND date(c.fecha_aviso) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
                }
                if($tipo_fecha == 4){  
                    $array['where'].=" AND date(cr.fecha_inicio) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
                }
                if($tipo_fecha == 5){  
                    $array['where'].=" AND date(cr.fecha_fin) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
                }
                if($tipo_fecha == 6){  
                    $array['where'].=" AND date(cr.fecha_aviso) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
                }
            }

            $array['order']=" ORDER BY a.nombre ";
            
        $result=Contratacion::getContratacionReport($array,$contratacion); 
        
        $styleThinBlackBorderAllborders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleAlignmentBold= array(
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleAlignment= array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        /*end style*/

          /*export*/
            /* instanciar phpExcel!*/
            
            $objPHPExcel = new PHPExcel();

            /*configure*/
            $objPHPExcel->getProperties()->setCreator("Gerencia Modernizacion")
               ->setSubject("Reporte de Contrataciones");

            $objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
            $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
            /*end configure*/

            /*head*/       
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A3', 'N°')
                        ->setCellValue('B3', 'TITULO')
                        ->setCellValue('C3', 'MONTO TOTAL')
                        ->setCellValue('D3', 'OBJETO')
                        ->setCellValue('E3', 'JUSTIFICACION')
                        ->setCellValue('F3', 'ACTIVIDADES')
                        ->setCellValue('G3', 'FECHA INICIO')
                        ->setCellValue('H3', 'FECHA FIN')
                        ->setCellValue('I3', 'FECHA AVISO')
                        ->setCellValue('J3', 'FECHA CONFORMIDAD')
                        ->setCellValue('K3', 'NUMERO DE DOCUMENTO')
                        ->setCellValue('L3', 'AREA');
            
            if ($contratacion==1){
                  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1')
                  ->setCellValue('A1', 'REPORTE DE CONTRATACIONES')
                  ->getStyle('A1:L1')->getFont()->setSize(18);
            }
            
            if($contratacion==2){
             $objPHPExcel->setActiveSheetIndex(0)

                        ->setCellValue('M3', 'TEXTO')
                        ->setCellValue('N3', 'MONTO')
                        ->setCellValue('O3', 'TIPO')
                        ->setCellValue('P3', 'FECHA INICIO')
                        ->setCellValue('Q3', 'FECHA FIN')
                        ->setCellValue('R3', 'FECHA AVISO')
                        ->setCellValue('S3', 'FECHA CONFORMIDAD')
                        ->setCellValue('T3', 'NUMERO DE DOCUMENTO')
                     
                  ->mergeCells('A1:T1')->mergeCells('A2:L2')->mergeCells('M2:T2')
                  ->setCellValue('A1', 'REPORTE DE CONTRATACIONES')->setCellValue('A2', 'CONTRATACION')->setCellValue('M2', 'DETALLE DE CONTRATACION')
                  ->getStyle('A1:T1')->getFont()->setSize(18);
                  
            }
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
             
            if ($contratacion==2){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('R')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('S')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('T')->setAutoSize(true);
   
             }
            /*end head*/
            /*body*/
            if($result){
              foreach ($result as $key => $value) {
                
                $objPHPExcel->setActiveSheetIndex(0)
                        
                              ->setCellValueExplicit('A' . ($key + 4), $key + 1)
                              ->setCellValueExplicit('B' . ($key + 4), $value->titulo)
                              ->setCellValueExplicit('C' . ($key + 4), $value->monto_total)
                              ->setCellValueExplicit('D' . ($key + 4), $value->objeto)
                              ->setCellValueExplicit('E' . ($key + 4), $value->justificacion)
                              ->setCellValueExplicit('F' . ($key + 4), $value->actividades)
                              ->setCellValue('G' . ($key + 4), $value->fecha_inicio)
                              ->setCellValue('H' . ($key + 4), $value->fecha_fin)
                              ->setCellValue('I' . ($key + 4), $value->fecha_aviso)
                              ->setCellValueExplicit('J' . ($key + 4), $value->fecha_conformidad)
                              ->setCellValueExplicit('K' . ($key + 4), $value->nro_doc)
                              ->setCellValueExplicit('L' . ($key + 4), $value->area)
                      
                              ;  
                  if ($contratacion==2) {
                $objPHPExcel->setActiveSheetIndex(0)

                              ->setCellValueExplicit('M' . ($key + 4), $value->texto)
                              ->setCellValueExplicit('N' . ($key + 4), $value->monto)
                              ->setCellValueExplicit('O' . ($key + 4), $value->tipo)
                              ->setCellValue('P' . ($key + 4), $value->fid)
                              ->setCellValue('Q' . ($key + 4), $value->ffd)
                              ->setCellValue('R' . ($key + 4), $value->fad)
                              ->setCellValue('S' . ($key + 4), $value->fcd)
                              ->setCellValue('T' . ($key + 4), $value->nro_doc)

                              ;  }
              }
            }
            /*end body*/
             if ($contratacion==1){
                $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($styleThinBlackBorderAllborders);
                $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleAlignment);   
             }
             if ($contratacion==2){
                $objPHPExcel->getActiveSheet()->getStyle('A3:T3')->applyFromArray($styleThinBlackBorderAllborders);
                $objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleThinBlackBorderAllborders);
                $objPHPExcel->getActiveSheet()->getStyle('M2:T2')->applyFromArray($styleThinBlackBorderAllborders);
                $objPHPExcel->getActiveSheet()->getStyle('A1:T1')->applyFromArray($styleAlignment);
                $objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleAlignment);   
                $objPHPExcel->getActiveSheet()->getStyle('M2:T2')->applyFromArray($styleAlignment);   
             }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Reporte');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="reporteni.xls"'); // file name of excel
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
          /* end export*/
     /* }else{
        echo 'no hay data';
      }*/


    }
    
            public function getExportenviosgcfaltas(){
         $array=array();
            $array['where']='';
            $array['limit']='';$array['order']='';


            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                    list($fechaIni,$fechaFin) = explode(" - ", $fecha);
                    $array['where'].=" AND date(acs.fecha_notificacion) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
            }

            $array['order']=" ORDER BY a.nombre ";
            
        $rst=Persona::getEnviosSGCFaltas($array); 


        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Detalle de Tareas',
          'tittle'=>'Plataforma',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

        $cabecera = array(
          'PERSONA',
          'NÚMERO DE FALTAS',
          'NÚMERO DE INASISTENCIAS',
          'FECHA DE NOTIFICACIÓN',
          'ÚLTIMO',
        );
        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }
    
    public function getExportcuadroproceso(){
         $array=array();
            $array['where']='';
            $array['limit']='';$array['order']='';
        
        $rst=Reporte::CuadroProceso();
        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Reporte Mensual de Procesos',
          'tittle'=>'Reporte',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );
        
        array_push($rst['cabecera'],'Total');
        array_push($rst['cabecera1'],'N° de P.');
        
        if($rst['sino']==0){
            array_unshift($rst['cabecera'],'','','');
            array_unshift($rst['cabecera1'],'N°','Proceso');
        }else{
            array_unshift($rst['cabecera'],'','','','');
            array_unshift($rst['cabecera1'],'N°','Área','Proceso');
        }
               
        $this->exportExcelCuadroProceso($propiedades,'',$rst['cabecera'],$rst['cabecera1'],$rst['data']); 

    }
        public function exportExcelCuadroProceso($propiedades,$estilos,$cabecera,$cabecera1,$data){
        /*style*/
        $styleThinBlackBorderAllborders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleAlignmentBold= array(
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleAlignment= array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        /*end style*/

      $head=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');

      /*instanciar phpExcel*/            
      $objPHPExcel = new PHPExcel();
      /*end instanciar phpExcel*/

      /*configure*/
      $objPHPExcel->getProperties()->setCreator($propiedades['creador'])
                                  ->setSubject($propiedades['subject']);

      $objPHPExcel->getDefaultStyle()->getFont()->setName($propiedades['font-name']);
      $objPHPExcel->getDefaultStyle()->getFont()->setSize($propiedades['font-size']);
      $objPHPExcel->getActiveSheet()->setTitle($propiedades['tittle']);
      /*end configure*/

      /*set up structure*/

        
      array_unshift($data,(object) $cabecera1);
      array_unshift($data,(object) $cabecera);
      
    foreach($data as $key => $value){
        $cont = 0;
        $auxi1=0;
        $value_aux=json_decode(json_encode($value), true);
        
        if($key == 0){ // set style to header
          end($value);       
          $objPHPExcel->getActiveSheet()->getStyle('A1:'.$head[key($value)-1].'1')->applyFromArray($styleThinBlackBorderAllborders);
          $objPHPExcel->getActiveSheet()->getStyle('A2:'.$head[key($value)-1].'2')->applyFromArray($styleThinBlackBorderAllborders);
        }

        foreach($value as $index => $val){
          $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($head[$cont])->setAutoSize(true);
            
          if($index == 'norden' && $key > 0){ //set orden in excel
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $key-1);                
          }else{ //poblate info
               if ($index=='ruta_flujo_id' ){
                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $val); 
                  $cont--;
               }
              else if ( $index == 'ft' or $index == 'areas' or $index == 'alertas' or $index == 'pt' or $index == 'p1' or $index == 'p2' or $index == 'p3' or $index == 'p4' or $index == 'p5' or $index == 'p6' or $index == 'p7' or $index == 'p8' or
                $index == 'p9' or $index == 'p10' or $index == 'p11' or $index == 'p12' or $index == 'p13' or $index == 'p14' or $index == 'p15' or $index == 'p16' or
                $index == 'p17' or $index == 'p18' or $index == 'p19' or $index == 'p20' or $index == 'p21' or $index == 'p22' or $index == 'p23' or $index == 'p24' or
                $index == 'p25' or $index == 'p26' or $index == 'p27' or $index == 'p28' or $index == 'p29' or $index == 'p30' or $index == 'p31' or $index == 'p32')
              { 
              $cont--;
              $auxi1=$value_aux[$index];
              }
               else {
               $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $val);}
          }

          $cont++;
        }          
      }

      /*end set up structure*/

      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel5)
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="reporte.xls"'); // file name of excel
      header('Cache-Control: max-age=0');
      // If you're serving to IE 9, then the following may be needed
      header('Cache-Control: max-age=1');
      // If you're serving to IE over SSL, then the following may be needed
      header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
      header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
      header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
      header ('Pragma: public'); // HTTP/1.0
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
      exit;
    }

    
    public function getExportdiarioactividades(){
         $array=array();
            $array['where']='';
            $array['limit']='';$array['order']='';
        
         $rst=Persona::ExportCuadroProductividadActividad();
        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Diario actividades',
          'tittle'=>'Reporte',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );
        array_unshift($rst['cabecera'],'','','');
        array_push($rst['cabecera'],'Total','Total');
        array_unshift($rst['cabecera1'],'N°','Área','Persona');
        array_push($rst['cabecera1'],'N° de Actividades Total','Total de Horas');
        
        $this->exportExcelCuadroProductividad($propiedades,'',$rst['cabecera'],$rst['cabecera1'],$rst['data']); 

    }
    
    public function exportExcelCuadroProductividad($propiedades,$estilos,$cabecera,$cabecera1,$data){
        /*style*/
        $styleThinBlackBorderAllborders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleAlignmentBold= array(
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleAlignment= array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        /*end style*/

      $head=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');

      /*instanciar phpExcel*/            
      $objPHPExcel = new PHPExcel();
      /*end instanciar phpExcel*/

      /*configure*/
      $objPHPExcel->getProperties()->setCreator($propiedades['creador'])
                                  ->setSubject($propiedades['subject']);

      $objPHPExcel->getDefaultStyle()->getFont()->setName($propiedades['font-name']);
      $objPHPExcel->getDefaultStyle()->getFont()->setSize($propiedades['font-size']);
      $objPHPExcel->getActiveSheet()->setTitle($propiedades['tittle']);
      /*end configure*/

      /*set up structure*/

        
      array_unshift($data,(object) $cabecera1);
      array_unshift($data,(object) $cabecera);
      

      foreach($data as $key => $value){          
        $cont = 0;
        $auxi=1;
        $auxi1=0;
        $auxi2=0;
        $value_aux=json_decode(json_encode($value), true);
        if ($key>1){
        $auxi=$value->envio_actividad; 
    
        }
        if($key == 0){ // set style to header
         end($value);       
          $objPHPExcel->getActiveSheet()->getStyle('A1:'.$head[key($value)].'1')->applyFromArray($styleThinBlackBorderAllborders);
          $objPHPExcel->getActiveSheet()->getStyle('A2:'.$head[key($value)].'2')->applyFromArray($styleThinBlackBorderAllborders);
          
        }
        $a=0;
        foreach($value as $index => $val){

          $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($head[$cont])->setAutoSize(true);
          
          if($index == 'norden' && $key > 1){ //set orden in excel
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $key-1);                
          }
          else if ($index=='envio_actividad' ){}
          else if ( $index == 'e1' or $index == 'e2' or $index == 'e3' or $index == 'e4' or $index == 'e5' or $index == 'e6' or $index == 'e7' or $index == 'e8' or
                $index == 'e9' or $index == 'e10' or $index == 'e11' or $index == 'e12' or $index == 'e13' or $index == 'e14' or $index == 'e15' or $index == 'e16' or
                $index == 'e17' or $index == 'e18' or $index == 'e19' or $index == 'e20' or $index == 'e21' or $index == 'e22' or $index == 'e23' or $index == 'e24' or
                $index == 'e25' or $index == 'e26' or $index == 'e27' or $index == 'e28' or $index == 'e29' or $index == 'e30' or $index == 'e31' or $index == 'e32')
              { 
              $cont--;
              $auxi1=$value_aux[$index];
              }
          else if ( $index == 'v1' or $index == 'v2' or $index == 'v3' or $index == 'v4' or $index == 'v5' or $index == 'v6' or $index == 'v7' or $index == 'v8' or
                $index == 'v9' or $index == 'v10' or $index == 'v11' or $index == 'v12' or $index == 'v13' or $index == 'v14' or $index == 'v15' or $index == 'v16' or
                $index == 'v17' or $index == 'v18' or $index == 'v19' or $index == 'v20' or $index == 'v21' or $index == 'v22' or $index == 'v23' or $index == 'v24' or
                $index == 'v25' or $index == 'v26' or $index == 'v27' or $index == 'v28' or $index == 'v29' or $index == 'v30' or $index == 'v31' or $index == 'v32')
              { 
              $cont--;
              $auxi2=$value_aux[$index];
              }
          else{ //poblate info
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $val);

            if ($key>1 && ($val>=6  or $auxi==0 or $auxi1>=1) && $index != 'persona' && $index != 'area' && $index != 'f_total' && $index != 'h_total' && 
                $index != 'f1' && $index != 'f2' && $index != 'f3' && $index != 'f4' && $index != 'f5' && $index != 'f6' && $index != 'f7' && $index != 'f8' &&
                $index != 'f9' && $index != 'f10' && $index != 'f11' && $index != 'f12' && $index != 'f13' && $index != 'f14' && $index != 'f15' && $index != 'f16' &&
                $index != 'f17' && $index != 'f18' && $index != 'f19' && $index != 'f20' && $index != 'f21' && $index != 'f22' && $index != 'f23' && $index != 'f24' &&
                $index != 'f25' && $index != 'f26' && $index != 'f27' && $index != 'f28' && $index != 'f29' && $index != 'f30' && $index != 'f31' && $index != 'f32'){
            $objPHPExcel->getActiveSheet()->getStyle($head[$cont-1].($key + 1).':'.$head[$cont].($key + 1), $val)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('7BF7AE');            
            }
            else if ($key>1 && (($val>=1 && $val<=5)  or substr($val, 3, 2)!=0) && $index != 'persona' && $index != 'area' && $index != 'f_total' && $index != 'h_total' && 
                $index != 'f1' && $index != 'f2' && $index != 'f3' && $index != 'f4' && $index != 'f5' && $index != 'f6' && $index != 'f7' && $index != 'f8' &&
                $index != 'f9' && $index != 'f10' && $index != 'f11' && $index != 'f12' && $index != 'f13' && $index != 'f14' && $index != 'f15' && $index != 'f16' &&
                $index != 'f17' && $index != 'f18' && $index != 'f19' && $index != 'f20' && $index != 'f21' && $index != 'f22' && $index != 'f23' && $index != 'f24' &&
                $index != 'f25' && $index != 'f26' && $index != 'f27' && $index != 'f28' && $index != 'f29' && $index != 'f30' && $index != 'f31' && $index != 'f32'){
            $objPHPExcel->getActiveSheet()->getStyle($head[$cont-1].($key + 1).':'.$head[$cont].($key + 1), $val)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFA027');
            }
            else if ($key>1 && $val==0 && substr($val, 3, 2)==0  && $auxi2!=5 && $auxi2!=6 && $index != 'persona' && $index != 'area' && $index != 'f_total' && $index != 'h_total' && 
                $index != 'f1' && $index != 'f2' && $index != 'f3' && $index != 'f4' && $index != 'f5' && $index != 'f6' && $index != 'f7' && $index != 'f8' &&
                $index != 'f9' && $index != 'f10' && $index != 'f11' && $index != 'f12' && $index != 'f13' && $index != 'f14' && $index != 'f15' && $index != 'f16' &&
                $index != 'f17' && $index != 'f18' && $index != 'f19' && $index != 'f20' && $index != 'f21' && $index != 'f22' && $index != 'f23' && $index != 'f24' &&
                $index != 'f25' && $index != 'f26' && $index != 'f27' && $index != 'f28' && $index != 'f29' && $index != 'f30' && $index != 'f31' && $index != 'f32'){
            $objPHPExcel->getActiveSheet()->getStyle($head[$cont-1].($key + 1).':'.$head[$cont].($key + 1), $val)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FE4E4E');
            }
            else if ($key>1 &&  $val==0 && ($auxi2==5 or $auxi2==6) && $index != 'persona' && $index != 'area' && $index != 'f_total' && $index != 'h_total' && 
                $index != 'f1' && $index != 'f2' && $index != 'f3' && $index != 'f4' && $index != 'f5' && $index != 'f6' && $index != 'f7' && $index != 'f8' &&
                $index != 'f9' && $index != 'f10' && $index != 'f11' && $index != 'f12' && $index != 'f13' && $index != 'f14' && $index != 'f15' && $index != 'f16' &&
                $index != 'f17' && $index != 'f18' && $index != 'f19' && $index != 'f20' && $index != 'f21' && $index != 'f22' && $index != 'f23' && $index != 'f24' &&
                $index != 'f25' && $index != 'f26' && $index != 'f27' && $index != 'f28' && $index != 'f29' && $index != 'f30' && $index != 'f31' && $index != 'f32'){
            $objPHPExcel->getActiveSheet()->getStyle($head[$cont-1].($key + 1).':'.$head[$cont].($key + 1), $val)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF66');
            }
            
           }

          $cont++;
        }          
      }
      /*end set up structure*/

      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel5)
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="reporte.xls"'); // file name of excel
      header('Cache-Control: max-age=0');
      // If you're serving to IE 9, then the following may be needed
      header('Cache-Control: max-age=1');
      // If you're serving to IE over SSL, then the following may be needed
      header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
      header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
      header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
      header ('Pragma: public'); // HTTP/1.0
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
      exit;
    }
}
