<?php

class DocumentoDigital extends Base {
	protected $fillable = [];
    public $table = "doc_digital";
    public static $where =['id', 'titulo', 'asunto', 'cuerpo', 'plantilla_doc_id', 'area_id','persona_id','updated_f_comentario','usuario_f_updated_at'];
    public static $selec =['id', 'titulo', 'asunto', 'cuerpo', 'plantilla_doc_id', 'area_id','persona_id','updated_f_comentario','usuario_f_updated_at'];

    public static function getDocumentosDigitales(){
        if(Input::get('id')){
            return DB::table('doc_digital as dd')
                    ->join('plantilla_doc as pd', 'dd.plantilla_doc_id', '=', 'pd.id')
                    ->leftjoin('doc_digital_area as dda', function($leftjoin)
                    {
                        $leftjoin->on('dda.doc_digital_id', '=', 'dd.id')
                                ->where('dda.estado', '=', 1);
                    })
                    ->leftjoin('areas as a','dda.area_id', '=', 'a.id')
                    ->leftjoin('personas as p','dda.persona_id', '=', 'p.id')
                    ->select('dd.id', 'dd.titulo', 'dd.asunto', 'pd.descripcion as plantilla', 'dd.plantilla_doc_id' ,'a.nombre as area','dda.area_id as area_id','p.nombre as pnombre','p.paterno as ppaterno','p.materno as pmaterno','dd.cuerpo','dd.tipo_envio','dda.persona_id','dda.tipo','dd.envio_total','pd.tipo_documento_id')
                    ->where( 

                        function($query){                    
                            if ( Input::get('id') ) {
                                $query->where('dd.id','=',Input::get('id'));
                            }
                            else{
                                $usu_id=Auth::user()->id;
                                $sql="  SELECT count(id) cant
                                        FROM cargo_persona
                                        WHERE estado=1
                                        AND cargo_id=12
                                        AND persona_id=".$usu_id;
                                $csql=DB::select($sql);
                                if( $csql[0]->cant==0 ){
                                    //$query->where('dd.area_id','=',Auth::user()->area_id);
                                    $query->whereRaw('dd.area_id IN (
                                        SELECT DISTINCT(a.id)
                                        FROM area_cargo_persona acp
                                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                        WHERE acp.estado=1
                                        AND cp.persona_id= '.$usu_id.'
                                    )');
                                }
                            }
                            $query->where('dd.estado','=',1);
                        }
                    )
//                    ->orderBy('dd.id')
                    ->get();
        }else{
            return DB::table('doc_digital_temporal as dd')
            		->join('plantilla_doc as pd', 'dd.plantilla_doc_id', '=', 'pd.id')
                        ->leftjoin('personas as p','p.id','=','dd.usuario_created_at')
                        ->leftjoin('personas as p1','p1.id','=','dd.usuario_updated_at')
                    ->select(DB::raw('DATE(dd.created_at)as created_at'),DB::raw('CONCAT_WS(" ",p1.paterno,p1.materno,p1.nombre) as persona_u'),
                        DB::raw('CONCAT_WS(" ",p.paterno,p.materno,p.nombre) as persona_c'),'dd.id', 'dd.titulo', 'dd.asunto', 'pd.descripcion as plantilla','dd.estado'
                        ,DB::raw('(SELECT COUNT(r.id) '
                                . 'FROM rutas r '
                                . 'INNER JOIN rutas_detalle as rd on r.id=rd.ruta_id and rd.estado=1 and rd.condicion=0'
                                . ' INNER JOIN rutas_detalle_verbo as rdv on rdv.ruta_detalle_id=rd.id and rdv.estado=1 '
                                . 'where r.estado=1 AND dd.id=rdv.doc_digital_id ) AS rutadetallev'),
                        DB::raw('(SELECT COUNT(r.id) '
                                . 'FROM rutas r '
                                . 'where r.estado=1 AND dd.id=r.doc_digital_id ) AS ruta')    
                            )
                   	
                   	->where( 
                        function($query){
                            if(Auth::user()->vista_doc==0){
                                $query->where('dd.usuario_created_at','=',Auth::user()->id);
                            }
                                $query->where('dd.estado','=','1');
                            
                            $usu_id=Auth::user()->id;
/*                            $sql="  SELECT count(id) cant
                                    FROM cargo_persona
                                    WHERE estado=1
                                    AND cargo_id=12
                                    AND persona_id=".Auth::user()->id;
                            $csql=DB::select($sql);
                            if( $csql[0]->cant==0 ){*/
                                //$query->where('dd.area_id','=',Auth::user()->area_id);
                                $query->whereRaw('dd.area_id IN (
                                        SELECT DISTINCT(a.id)
                                        FROM area_cargo_persona acp
                                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                        WHERE acp.estado=1
                                        AND cp.persona_id= '.$usu_id.'
                                    )');
                                $fin = date('Y-m-d');
                                $inicio = strtotime('-20 day', strtotime($fin));
                                $inicio = date('Y-m-d', $inicio);
                                $query->whereRaw('  ((DATE(dd.created_at) BETWEEN "'.$inicio.'" AND "'.$fin.'")
                                                    or ((SELECT COUNT(r.id) 
                                                    FROM rutas r 
                                                    where r.estado=1 AND dd.id=r.doc_digital_id)=0 AND 

                                                    (SELECT COUNT(r.id)
                                                    FROM rutas r 
                                                    INNER JOIN rutas_detalle as rd on r.id=rd.ruta_id and rd.estado=1 and rd.condicion=0
                                                    INNER JOIN rutas_detalle_verbo as rdv on rdv.ruta_detalle_id=rd.id and rdv.estado=1
                                                    where r.estado=1 AND dd.id=rdv.doc_digital_id)=0
                                                    ))');
                            /* }*/
                        }
                    )
//                    ->orderBy('ruta','desc') 
//                    ->orderBy('rutadetallev','desc')
                    ->get();            
        } 
    }
    
        public static function getCargarCount( $array )
    {           
        $sSql=' select COUNT(dd.id) cant
                from `doc_digital_temporal` as `dd` 
                inner join `plantilla_doc` as `pd` on `dd`.`plantilla_doc_id` = `pd`.`id` 
                left join `personas` as `p` on `p`.`id` = `dd`.`usuario_created_at` 
                left join `personas` as `p1` on `p1`.`id` = `dd`.`usuario_updated_at` 
                WHERE `dd`.`estado`= 1 ';
        $sSql.= $array['where'];
        
        if(Auth::user()->vista_doc==0){
           $sSql.=" AND dd.usuario_created_at=".Auth::user()->id;
        }
        
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    
        public static function getCargar( $array )
    {  
        $sSql=' select 1 as tipo,DATE(dd.created_at)as created_at, CONCAT_WS(" ",p1.paterno,p1.materno,p1.nombre) as persona_u,dd.tipo_envio,
                CONCAT_WS(" ",p.paterno,p.materno,p.nombre) as persona_c,
                    (SELECT COUNT(r.id) 
                     FROM rutas r 
                     where r.estado=1 AND dd.id=r.doc_digital_id) as ruta,
                    (SELECT COUNT(r.id)
                     FROM rutas r 
                     INNER JOIN rutas_detalle as rd on r.id=rd.ruta_id and rd.estado=1 and rd.condicion=0
                     INNER JOIN rutas_detalle_verbo as rdv on rdv.ruta_detalle_id=rd.id and rdv.estado=1
                     where r.estado=1 AND dd.id=rdv.doc_digital_id) as rutadetallev,
                     `dd`.`id`, `dd`.`titulo`, `dd`.`asunto`, `pd`.`descripcion` as `plantilla`, `dd`.`estado` 
                from `doc_digital_temporal` as `dd` 
                inner join `plantilla_doc` as `pd` on `dd`.`plantilla_doc_id` = `pd`.`id` 
                left join `personas` as `p` on `p`.`id` = `dd`.`usuario_created_at` 
                left join `personas` as `p1` on `p1`.`id` = `dd`.`usuario_updated_at` 
                WHERE `dd`.`estado`= 1 ';
        $sSql.= $array['where'];
        
        if(Auth::user()->vista_doc==0){
           $sSql.=" AND dd.usuario_created_at=".Auth::user()->id;
        }
        
        $sSql.=$array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
            public static function getExportDocumento( $array )
    {  
        $sSql=' select 1 as norden,CONCAT_WS(" ",p.paterno,p.materno,p.nombre) as persona_c,CONCAT_WS(" ",p1.paterno,p1.materno,p1.nombre) as persona_u
                    , `dd`.`titulo`
                    , `dd`.`asunto`,DATE(dd.created_at)as created_at, `pd`.`descripcion` as `plantilla`,
                     @proceso:=(SELECT CONCAT(IFNULL((SELECT GROUP_CONCAT(DISTINCT f.nombre) 
                    FROM rutas r 
                    INNER JOIN rutas_detalle as rd on r.id=rd.ruta_id and rd.estado=1 and rd.condicion=0 
                    INNER JOIN rutas_detalle_verbo as rdv on rdv.ruta_detalle_id=rd.id and rdv.estado=1 
                    INNER JOIN flujos f ON f.id=r.flujo_id 
                    where r.estado=1 AND dd.id=rdv.doc_digital_id ),"-")," | ",
                    IFNULL((SELECT GROUP_CONCAT(DISTINCT f.nombre) 
                    FROM rutas r INNER JOIN flujos f ON r.flujo_id=f.id 
                    where r.estado=1 AND dd.id=r.doc_digital_id 
                    GROUP BY dd.id),"-")) ) as proceso,
                    CASE @proceso
                        WHEN "- | -" THEN "PENDIENTE"
                        ELSE "ASIGNADO"
                    END as asignacion
                from `doc_digital_temporal` as `dd` 
                inner join `plantilla_doc` as `pd` on `dd`.`plantilla_doc_id` = `pd`.`id` 
                left join `personas` as `p` on `p`.`id` = `dd`.`usuario_created_at` 
                left join `personas` as `p1` on `p1`.`id` = `dd`.`usuario_updated_at` 
                WHERE `dd`.`estado`= 1 ';
        $sSql.= $array['where'];
        if(Auth::user()->vista_doc==0){
           $sSql.=" AND dd.usuario_created_at=".Auth::user()->id;
        }
        $oData = DB::select($sSql);
        return $oData;
    }

      public static function getCargarRelacionAreaCount( $array )
    {   
        $documentos_area="";
        $usu_id=Auth::user()->id;
        $area_id=Auth::user()->area_id;
        if(Auth::user()->rol_id!=8 AND Auth::user()->rol_id !=9){
           $documentos_area="`dd`.`area_id`=".$area_id." OR "; 
        }
        $sSql=' select COUNT(DISTINCT dd.id) cant
                from `doc_digital_temporal` as `dd` 
		INNER JOIN `doc_digital_area` `dda` on `dda`.`doc_digital_id`=`dd`.`id` AND `dda`.`estado`=1 AND
		( '.$documentos_area.' `dda`.`area_id` IN  (
                                        SELECT DISTINCT(a.id)
                                        FROM area_cargo_persona acp
                                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                        WHERE acp.estado=1
                                        AND cp.persona_id='.$usu_id.'
                                    ))
                inner join `plantilla_doc` as `pd` on `dd`.`plantilla_doc_id` = `pd`.`id` 
                left join `personas` as `p` on `p`.`id` = `dd`.`usuario_created_at` 
                where (`dd`.`estado` = 1) ';
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    
        public static function getCargarRelacionArea( $array )
    {   
        $documentos_area="";
        $usu_id=Auth::user()->id;
        $area_id=Auth::user()->area_id;
        if(Auth::user()->rol_id!=8 AND Auth::user()->rol_id !=9){
           $documentos_area="`dd`.`area_id`=".$area_id." OR "; 
        }
        $sSql=' select 2 as tipo,DATE(dd.created_at)as created_at,
                CONCAT_WS(" ",p.paterno,p.materno,p.nombre) as persona_c,
                     `dd`.`id`, `dd`.`titulo`, `dd`.`asunto`, `pd`.`descripcion` as `plantilla`, `dd`.`estado` 
                from `doc_digital_temporal` as `dd` 
		INNER JOIN `doc_digital_area` `dda` on `dda`.`doc_digital_id`=`dd`.`id` AND `dda`.`estado`=1 AND
		( '.$documentos_area.' `dda`.`area_id` IN  (
                                        SELECT DISTINCT(a.id)
                                        FROM area_cargo_persona acp
                                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                        WHERE acp.estado=1
                                        AND cp.persona_id='.$usu_id.'
                                    ))
                inner join `plantilla_doc` as `pd` on `dd`.`plantilla_doc_id` = `pd`.`id` 
                left join `personas` as `p` on `p`.`id` = `dd`.`usuario_created_at` 
                where (`dd`.`estado` = 1)';
        $sSql.= $array['where'];
        $sSql.=' GROUP BY dd.id';
        $sSql.=$array['order'];
        $sSql.=$array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

    public static function Correlativo(){
        if(Input::get('tipo_corre')==2){
    	$año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
    	/*$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";*/
        $sql = "SELECT IFNULL(LPAD(MAX(dd.correlativo)+1,6,'0'),LPAD(1,6,'0')) as correlativo 
                FROM doc_digital_temporal dd 
                INNER JOIN plantilla_doc pd on dd.plantilla_doc_id=pd.id 
                AND pd.tipo_documento_id=".Input::get('tipo_doc')." 
                AND pd.area_id= ".Input::get('area_id').
                " WHERE dd.estado=1 
                AND YEAR(dd.created_at)=YEAR(CURDATE())";
    	$r= DB::select($sql);
        return (isset($r[0])) ? $r[0] : $r2[0];}
        
        else if(Input::get('tipo_corre')==1){
    	$año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
    	/*$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";*/
        $sql = "SELECT IFNULL(LPAD(MAX(dd.correlativo)+1,6,'0'),LPAD(1,6,'0')) as correlativo from doc_digital_temporal dd 
                INNER JOIN plantilla_doc pd on dd.plantilla_doc_id=pd.id and pd.area_id=".Input::get('area_id')." and pd.tipo_documento_id=".Input::get('tipo_doc')." and dd.persona_id= ".Auth::user()->id.
                " WHERE dd.estado=1 
                AND YEAR(dd.created_at)=YEAR(CURDATE())";
    	$r= DB::select($sql);
        return (isset($r[0])) ? $r[0] : $r2[0];}
        
        else if(Input::get('tipo_corre')==0){
    	$año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
    	/*$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";*/
        $sql = "SELECT IFNULL(LPAD(MAX(dd.correlativo)+1,6,'0'),LPAD(1,6,'0')) as correlativo from doc_digital_temporal dd 
                INNER JOIN plantilla_doc pd on dd.plantilla_doc_id=pd.id and pd.tipo_documento_id=".Input::get('tipo_doc')." WHERE dd.estado=1 
                AND YEAR(dd.created_at)=YEAR(CURDATE())";
    	$r= DB::select($sql);
        return (isset($r[0])) ? $r[0] : $r2[0];}
    }
    
         public static function getListarCount( $array )
    {
        $sSql=" select COUNT(dd.id) as cant
                from doc_digital dd
                WHERE 1=1";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    
    public static function getListar( $array )
    {
        $sSql=" select dd.id,dd.titulo,dd.asunto,dd.created_at
                from doc_digital dd
                WHERE 1=1";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        //echo $sSql;
        $oData = DB::select($sSql);
        return $oData;
    }
    
        public static function getEditarFecha( )
    {   $created=Input::get('fecha').' '.date ("h:i:s"); 
        $sSql="UPDATE doc_digital set "
                ." usuario_f_updated_at=".Auth::user()->id
                .", created_at='".$created
                ."', updated_f_comentario='".Input::get('comentario')
                ."' WHERE id=".Input::get('id');
        $oData = DB::update($sSql);
        
        $sSqla="UPDATE doc_digital_temporal set "
                ." usuario_f_updated_at=".Auth::user()->id
                .", created_at='".$created
                ."', updated_f_comentario='".Input::get('comentario')
                ."' WHERE id=".Input::get('id');
        $oDataa = DB::update($sSqla);
        
        return $oData;
    }
    
            public static function getCambiarEstadoDoc( )
    {   
        $sSql="UPDATE doc_digital set "
                ." titulo=CONCAT_WS('|',titulo,now()), 
                    estado='0',
                    usuario_updated_at='".Auth::user()->id."', 
                    updated_at= now() 
                    WHERE id=".Input::get('id');
        $oData = DB::update($sSql);
        
        $sSqla="UPDATE doc_digital_temporal set "
                ." titulo=CONCAT_WS('|',titulo,now()), 
                    estado='0',
                    usuario_updated_at='".Auth::user()->id."', 
                    updated_at= now() 
                    WHERE id=".Input::get('id');
        $oDataa = DB::update($sSqla);
        
        return $oData;
    }

    public static function getDocdigitalCount( $array )
    {   
        $sSql=" select COUNT(*) as cant FROM (SELECT `dd`.`id`, `dd`.`titulo`, `dd`.`asunto`, `pd`.`descripcion` as `plantilla`, `dd`.`estado`,
                 (SELECT COUNT(r.id) FROM rutas r where r.doc_digital_id=dd.id) AS ruta,
                 (SELECT COUNT(rdv.id) FROM rutas_detalle_verbo rdv where rdv.doc_digital_id=dd.id) AS rutadetallev
                 from `doc_digital` as `dd`
                 inner join `plantilla_doc` as `pd` on `dd`.`plantilla_doc_id` = `pd`.`id` ".$array['having'].") as tb1";

        $sSql.= $array['where'];
                //echo $sSql;
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getDocdigital( $array )
    {
        $sSql=" select `dd`.`id`, `dd`.`titulo`, `dd`.`asunto`, `pd`.`descripcion` as `plantilla`, `dd`.`estado`,
                 (SELECT COUNT(r.id) FROM rutas r where r.doc_digital_id=dd.id) AS ruta,
                 (SELECT COUNT(rdv.id) FROM rutas_detalle_verbo rdv where rdv.doc_digital_id=dd.id) AS rutadetallev
                 from `doc_digital` as `dd`
                 inner join `plantilla_doc` as `pd` on `dd`.`plantilla_doc_id` = `pd`.`id`";

        $sSql.= $array['where'].
                $array['having'].
                $array['order'].
                $array['limit'];

        $oData = DB::select($sSql);
        return $oData;
    }
    
    public static function getVerificarTitulo()
    {   
        $sSql=" SELECT * 
                FROM doc_digital 
                WHERE titulo = '".Input::get('titulofinal')."'"
                . "AND id !=".Input::get('id');
        $oData = DB::select($sSql);
        return $oData;
    }
    
        public static function getVerificarCorrelativo($csigla,$tipo_envio,$tipo_documento,$persona_id,$area_id,$correlativo,$id)
    {   
        $sSql=" SELECT COUNT(dd.id) as cant
                from doc_digital dd 
                INNER JOIN plantilla_doc pd on dd.plantilla_doc_id=pd.id ";
        if($csigla!=0){
            if($tipo_envio=3 OR $tipo_envio=5){
            $sSql.="and pd.tipo_documento_id=".$tipo_documento." and dd.persona_id=".$persona_id."";
            }   
            else{
            $sSql.="and pd.tipo_documento_id=".$tipo_documento." and pd.area_id=".$area_id;
            }  
         }
        else {
            $sSql.="and pd.tipo_documento_id=".$tipo_documento;
            }
            
         $sSql.=" WHERE dd.estado=1 
                and dd.correlativo='".$correlativo."'
                AND YEAR(dd.created_at)=YEAR(CURDATE()) AND dd.id!=".$id;
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

}
