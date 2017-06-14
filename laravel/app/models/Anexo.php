<?php

class Anexo extends Base {
	protected $fillable = [];
    public $table="tramites_anexo";
    
	public static function getAnexosbyTramite(){
        $sql = "select ta.id codigoanexo,ta.nombre nombreanexo,ta.fecha_anexo fechaingreso,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) usuarioregistrador,
            ta.estado estado,ta.obeservacion observacion,'' area 
            from tramites_anexo ta 
            inner join tramites t on ta.tramite_id=t.id 
            inner join personas p on ta.persona_id=p.id where ta.estado=1";

        if(Input::get('idtramite')){
            $sql.=" and ta.tramite_id='".Input::get('idtramite')."'";
        }

        if(Input::get('buscar')){
            $sql.=" and (ta.id='".Input::get('buscar')."' or ta.nombre LIKE '%".Input::get('buscar')."%')";
        }

        $r= DB::select($sql);
        return $r;
    }

    public static function getDetalleAnexobyId(){
        $sql = "select ta.persona_id,ta.documento_id,ta.id codanexo,ta.fecha_anexo fechaanexo,ta.tramite_id codtramite,ta.estado estado,ta.obeservacion observ,ta.fecha_recepcion frecepcion,p.dni dnipersona,p.nombre nombrepersona,p.paterno apepersona,p.materno apempersona,
            ct.nombre_clasificador_tramite nombretramite,t.fecha_tramite fechatramite,'' area,e.ruc ruc,e.tipo_id tipoempresa,e.razon_social razonsocial,
            e.nombre_comercial nombcomercial,e.direccion_fiscal direcfiscal,e.telefono etelefono,
            CONCAT_WS(' ',p2.nombre,p2.paterno,p2.materno) representantelegal,t.tipo_documento_id idtipodoc,d.nombre tipodoc,t.documento numdoc,ta.nro_folios folios,ta.imagen img 
            from tramites_anexo ta 
            inner join tramites t on ta.tramite_id=t.id 
            left join empresas e on t.empresa_id=e.id 
            left join personas p2 on e.persona_id=p2.id 
            inner join documentos d on t.tipo_documento_id=d.id 
            inner join clasificador_tramite ct on t.clasificador_tramite_id=ct.id 
            inner join personas p on ta.persona_id=p.id where ta.estado=1 and ta.id=".Input::get('codanexo');
        $r= DB::select($sql);
        return $r;
    }
    
            public static function Correlativo(){
        
    	$año= date("Y");
        $r2=array(array('correlativo'=>'000001','ano'=>$año));
    	/*$sql = "SELECT LPAD(id+1,6,'0') as correlativo,'$año' ano FROM doc_digital ORDER BY id DESC LIMIT 1";*/
        $sql = "SELECT IFNULL(LPAD(MAX(ta.correlativo)+1,6,'0'),LPAD(1,6,'0')) as correlativo 
                FROM tramites_anexo ta 
                WHERE ta.estado=1 
                AND YEAR(ta.created_at)=YEAR(CURDATE())
                ORDER BY ta.correlativo DESC LIMIT 1";
    	$r= DB::select($sql);
        return (isset($r[0])) ? $r[0] : $r2[0];
        
    }
}
