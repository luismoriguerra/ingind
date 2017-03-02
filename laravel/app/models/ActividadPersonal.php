<?php

class ActividadPersonal extends Base
{
    public $table = "actividad_personal";
    
    public static function getNotificacionactividad($fecha='',$area='',$tipo=''){
        $query = 'SELECT CONCAT_WS(" ",p.paterno,p.materno,p.nombre) 
                as persona,a.nombre as area,CASE aa.ultimo_registro WHEN 1 THEN "X" WHEN 0 THEN "" ELSE aa.ultimo_registro END as ultimo_registro , aa.actividad, aa.minuto, aa.fecha_alerta
                FROM alertas_actividad aa
                INNER JOIN personas p on aa.persona_id=p.id
                INNER JOIN areas a on aa.area_id=a.id
                WHERE 1=1';

          $query.="";

          if($fecha != ''){
            list($fechaIni,$fechaFin) = explode(" - ", $fecha);
            $query.=' AND date(aa.fecha_alerta) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'" ';
          }
          if($area != ''){
            $query.=' AND aa.area_id IN ("'.$area.'") ';
          }
          if($tipo == '1'){
            $query.=' AND aa.ultimo_registro='.$tipo;
          }

          $query.=" ORDER BY a.id ";
          $result= DB::Select($query);
          
          return $result;
    }
}
