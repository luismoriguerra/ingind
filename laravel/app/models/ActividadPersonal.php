<?php

class ActividadPersonal extends Base
{
    public $table = "actividad_personal";
    
    public static function getNotificacionactividad($fecha='',$area='',$tipo=''){
        $query = 'SELECT CONCAT_WS(" ",p.paterno,p.materno,p.nombre) 
                as persona,a.nombre as area, aa.actividad, aa.minuto, aa.fecha_alerta
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
    
        public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(ap.id) cant
                FROM actividad_personal ap
                INNER JOIN actividad_categorias ac ON ac.id=ap.actividad_categoria_id
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT ap.id,replace(ap.actividad,'\n',' ')  as actividad,f.nombre as categoria, ap.estado
                FROM actividad_personal ap
                INNER JOIN rutas r ON r.id=ap.ruta_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
}
