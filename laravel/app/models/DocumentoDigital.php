<?php

class DocumentoDigital extends Base {
	protected $fillable = [];
    public $table = "doc_digital";
    public static $where =['id', 'titulo', 'asunto', 'cuerpo', 'plantilla_doc_id', 'area_id','persona_id'];
    public static $selec =['id', 'titulo', 'asunto', 'cuerpo', 'plantilla_doc_id', 'area_id','persona_id'];

    public static function getDocumentosDigitales(){
        return DB::table('doc_digital as dd')
        		->join('plantilla_doc as pd', 'dd.plantilla_doc_id', '=', 'pd.id')
        		/*->join('doc_digital_area as dda', 'dda.doc_digital_id', '=', 'dd.id')
        		->join('areas as a','dda.area_id', '=', 'a.id')
        		->join('personas as p','dda.persona_id', '=', 'p.id')*/
                /*->select('dd.id', 'dd.titulo', 'dd.asunto', 'pd.descripcion as plantilla', 'a.nombre as area','p.nombre as pnombre','p.paterno as ppaterno','p.materno as pmaterno')*/
                ->select('dd.id', 'dd.titulo', 'dd.asunto', 'pd.descripcion as plantilla')
               	->where( 
                    function($query){
                    	if ( Input::get('id') ) {
                            $query->where('dd.id','=',Input::get('id'));
                        }
                        $query->where('dd.persona_id','=',Auth::user()->id);
                    }
                )
                ->orderBy('dd.id')
                ->get();
    }


    public static function Correlativo(){
    	$año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
    	$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";
    	$r= DB::select($sql);
    	return (isset($r[0])) ? $r[0] : $r2[0];
    }

}
