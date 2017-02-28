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
                    ->join('doc_digital_area as dda', 'dda.doc_digital_id', '=', 'dd.id')
                    ->join('areas as a','dda.area_id', '=', 'a.id')
                    ->join('personas as p','dda.persona_id', '=', 'p.id')
                    ->select('dd.id', 'dd.titulo', 'dd.asunto', 'pd.descripcion as plantilla', 'dd.plantilla_doc_id' ,'a.nombre as area','dda.area_id as area_id','p.nombre as pnombre','p.paterno as ppaterno','p.materno as pmaterno','dd.cuerpo','dd.tipo_envio','dda.persona_id','dda.tipo','dd.envio_total')
                    ->where( 

                        function($query){
                            if ( Input::get('id') ) {
                                $query->where('dd.id','=',Input::get('id'));
                            }
                            $sql="  SELECT count(id) cant
                                    FROM cargo_persona
                                    WHERE estado=1
                                    AND cargo_id=12
                                    AND persona_id=".Auth::user()->id;
                            $csql=DB::select($sql);
                            if( $csql[0]->cant==0 ){
                            $query->where('dd.area_id','=',Auth::user()->area_id);
                            }
                            $query->where('dd.estado','=',1);
                            $query->where('dda.estado','=',1);
                        }
                    )
                    ->orderBy('dd.id')
                    ->get();            
        }else{
            return DB::table('doc_digital as dd')
            		->join('plantilla_doc as pd', 'dd.plantilla_doc_id', '=', 'pd.id')
                    ->select('dd.id', 'dd.titulo', 'dd.asunto', 'pd.descripcion as plantilla','dd.estado',
                        DB::raw('(SELECT COUNT(r.id) FROM rutas r where r.doc_digital_id=dd.id) AS ruta'),
                        DB::raw('(SELECT COUNT(rdv.id) FROM rutas_detalle_verbo rdv where rdv.doc_digital_id=dd.id) AS rutadetallev'))
                   	->where( 
                        function($query){
/*                            $sql="  SELECT count(id) cant
                                    FROM cargo_persona
                                    WHERE estado=1
                                    AND cargo_id=12
                                    AND persona_id=".Auth::user()->id;
                            $csql=DB::select($sql);
                            if( $csql[0]->cant==0 ){*/
                                $query->where('dd.area_id','=',Auth::user()->area_id);
                            /* }*/
                        }
                    )
                    ->orderBy('ruta','desc') 
                    ->orderBy('rutadetallev','desc')
                    ->get();            
        }
    }


    public static function Correlativo(){
    	$año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
    	/*$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";*/
        $sql = "select LPAD(count(dd.id)+1,6,'0') as correlativo from doc_digital dd 
                inner join plantilla_doc pd on dd.plantilla_doc_id=pd.id and pd.tipo_documento_id=".Input::get('tipo_doc')."
                ORDER BY dd.id DESC LIMIT 1";
    	$r= DB::select($sql);
    	return (isset($r[0])) ? $r[0] : $r2[0];
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
