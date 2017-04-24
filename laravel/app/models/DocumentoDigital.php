<?php

class DocumentoDigital extends Base {
	protected $fillable = [];
    public $table = "doc_digital";
    public static $where =['id', 'titulo', 'asunto', 'cuerpo', 'plantilla_doc_id', 'area_id','persona_id'];
    public static $selec =['id', 'titulo', 'asunto', 'cuerpo', 'plantilla_doc_id', 'area_id','persona_id'];

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
                    ->select('dd.id', 'dd.titulo', 'dd.asunto', 'pd.descripcion as plantilla', 'dd.plantilla_doc_id' ,'a.nombre as area','dda.area_id as area_id','p.nombre as pnombre','p.paterno as ppaterno','p.materno as pmaterno','dd.cuerpo','dd.tipo_envio','dda.persona_id','dda.tipo','dd.envio_total')
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
                    ->orderBy('dd.id')
                    ->get();
        }else{
            return DB::table('doc_digital as dd')
            		->join('plantilla_doc as pd', 'dd.plantilla_doc_id', '=', 'pd.id')
                        ->leftjoin('personas as p','p.id','=','dd.usuario_created_at')
                        ->leftjoin('personas as p1','p1.id','=','dd.usuario_updated_at')
                    ->select(DB::raw('CONCAT_WS(" ",p1.paterno,p1.materno,p1.nombre) as persona_u'),
                        DB::raw('CONCAT_WS(" ",p.paterno,p.materno,p.nombre) as persona_c'),'dd.id', 'dd.titulo', 'dd.asunto', 'pd.descripcion as plantilla','dd.estado',
                        DB::raw('(SELECT COUNT(r.id) FROM rutas r where r.doc_digital_id=dd.id) AS ruta'),
                        DB::raw('(SELECT COUNT(rdv.id) FROM rutas_detalle_verbo rdv where rdv.doc_digital_id=dd.id) AS rutadetallev'))
                   	->where( 
                        function($query){                          
                            if(Input::get('activo')){
                                $query->where('dd.estado','=','1');
                            } else {
                                 $query->where('dd.estado','=','1');
                            }
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
                            /* }*/
                        }
                    )
                    ->orderBy('ruta','desc') 
                    ->orderBy('rutadetallev','desc')
                    ->get();            
        } 
    }


    public static function Correlativo(){
        if(Input::get('tipo_corre')==2){
    	$año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
    	/*$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";*/
        $sql = "SELECT IFNULL(LPAD(MAX(dd.correlativo)+1,6,'0'),LPAD(1,6,'0')) as correlativo 
                FROM doc_digital dd 
                INNER JOIN plantilla_doc pd on dd.plantilla_doc_id=pd.id 
                AND pd.tipo_documento_id=".Input::get('tipo_doc')." 
                AND pd.area_id= ".Auth::user()->area_id.
                " WHERE dd.estado=1 
                AND YEAR(dd.created_at)=YEAR(CURDATE())
                ORDER BY dd.correlativo DESC LIMIT 1";
    	$r= DB::select($sql);
        return (isset($r[0])) ? $r[0] : $r2[0];}
        
        else if(Input::get('tipo_corre')==1){
    	$año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
    	/*$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";*/
        $sql = "SELECT IFNULL(LPAD(MAX(dd.correlativo)+1,6,'0'),LPAD(1,6,'0')) as correlativo from doc_digital dd 
                INNER JOIN plantilla_doc pd on dd.plantilla_doc_id=pd.id and pd.tipo_documento_id=".Input::get('tipo_doc')." and dd.persona_id= ".Auth::user()->id.
                " WHERE dd.estado=1 
                AND YEAR(dd.created_at)=YEAR(CURDATE())
                ORDER BY dd.correlativo DESC LIMIT 1";
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

}
