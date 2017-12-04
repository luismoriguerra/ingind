<?php

class AuditoriaAcceso extends \Eloquent {

    public $table = "auditoria_acceso";
    
    public  static function getAuditoria(){
        
        $ruta=explode('.',URL::previous());
        if(Request::path()!='admin.inicio' and (Auth::user()->rol_id==8 or Auth::user()->rol_id==9)){
            $opcion= Opcion::where('ruta','like','%'.array_pop($ruta))->first();
            
            $auditoria=new AuditoriaAcceso;
            $auditoria->persona_id=Auth::user()->id;
            $auditoria->rol_id=Auth::user()->rol_id;
            $auditoria->opcion_id=@$opcion->id;
            $auditoria->tipo=2;
            $auditoria->usuario_created_at=Auth::user()->id;
            $auditoria->ruta=array_pop($ruta);
            $auditoria->save();
        }
    }
    
    public static function CuadroAuditoriaAcceso() {
        $sSql = '';
        $cl = '';
        $left = '';
        $tai_fecha = '';
        $tac_fecha='';
        $cabecera = [];

        if (Input::has('fecha') && Input::get('fecha')) {
            $fecha = Input::get('fecha');
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $tai_fecha .= " AND DATE(tai.created_at) BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "' ";
            $tac_fecha .= " AND DATE(tac.created_at) BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "' ";
        }

        $fechaIni_ = strtotime($fechaIni);
        $fechaFin_ = strtotime($fechaFin);
        $fecha = date_create($fechaIni);
        $n = 1;
        for ($i = $fechaIni_; $i <= $fechaFin_; $i += 86400) {
            $cl .= " ,COUNT(DISTINCT tai$n.id) as ti$n,COUNT(DISTINCT tac$n.id) as tc$n";
            $left .= " LEFT JOIN auditoria_acceso tai$n ON tai.id=tai$n.id and tai$n.estado=1 and tai$n.tipo=1 and DATE(tai$n.created_at)= STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y')";
            $left .= " LEFT JOIN auditoria_acceso tac$n ON tac.id=tac$n.id and tac$n.estado=1 and tac$n.tipo=2 and DATE(tac$n.created_at)= STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y')";
            $n++;
            array_push($cabecera, date_format($fecha, 'Y-m-d'));
            date_add($fecha, date_interval_create_from_date_string('1 days'));
        }

        $sSql .= "SELECT CONCAT_WS(' ',p.paterno,p.materno,p.nombre) as persona,
                  a.nombre as area,p.id as persona_id,
                  COUNT(DISTINCT tai.id) as ti,
                  COUNT(DISTINCT tac.id) as tc";
        $sSql .= $cl;
     //   $sSql .= ",COUNT(ap.id) AS f_total,IFNULL(SEC_TO_TIME(ABS(SUM(ap.ot_tiempo_transcurrido)) * 60),'00:00')  h_total,IFNULL(GROUP_CONCAT(ap.id),'0') id_total";
        $sSql .= " FROM personas p
                   INNER JOIN areas a ON a.id=p.area_id
                   LEFT JOIN auditoria_acceso tai ON p.id=tai.persona_id and tai.estado=1 and tai.tipo=1 " . $tai_fecha."
                   LEFT JOIN auditoria_acceso tac ON p.id=tac.persona_id and tac.estado=1 and tac.tipo=2 " . $tac_fecha;
        $sSql .= $left;
        $sSql .= " WHERE  p.rol_id IN (8,9)
                   AND p.estado=1
                   GROUP BY p.id";

        $oData['cabecera'] = $cabecera;
        $oData['data'] = DB::select($sSql);
        return $oData;
    }
    
    public static function CuadroDetalleAuditoriaAcceso() {
        $sSql = '';
        $tai_fecha = '';
        $tac_fecha='';


        if (Input::has('fi') && Input::has('ff') ) {
            $tai_fecha .= " AND DATE(tai.created_at) BETWEEN '" . Input::get('fi') . "' AND '" . Input::get('ff') . "' ";
            $tac_fecha .= " AND DATE(tac.created_at) BETWEEN '" . Input::get('fi') . "' AND '" . Input::get('ff') . "' ";
        }

        $sSql .= "SELECT o.nombre,
                    COUNT(DISTINCT tai.id) as ti,COUNT(DISTINCT tac.id) as tc 
                    FROM opciones o
                    LEFT JOIN auditoria_acceso tai ON o.id=tai.opcion_id and tai.estado=1 and tai.tipo=1  AND tai.persona_id=".Input::get('persona_id')."  " . $tai_fecha." 
                    LEFT JOIN auditoria_acceso tac ON o.id=tac.opcion_id and tac.estado=1 and tac.tipo=2  AND tac.persona_id=".Input::get('persona_id')."  " . $tac_fecha."  
                    GROUP BY o.id HAVING ti>0 or tc>0";

        $oData = DB::select($sSql);
        return $oData;
    }

    // --

    // --
}