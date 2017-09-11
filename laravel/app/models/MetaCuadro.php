<?php

class MetaCuadro extends Base
{
    public $table = "metas_cuadro";
    public static $where =['id' , 'meta_id' , 'anio', 'actividad', 'fecha','fecha_add', 'estado'];
    public static $selec =['id' , 'meta_id' , 'anio', 'actividad', 'fecha','fecha_add', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(mc.id) cant
                FROM metas_cuadro mc
                INNER JOIN metas m on mc.meta_id=m.id
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT mc.id,mc.meta_id, mc.actividad,mc.fecha,IFNULL(mc.fecha_add,'') as fecha_add, mc.anio, mc.estado,m.nombre as meta
                FROM metas_cuadro mc
                INNER JOIN metas m on mc.meta_id=m.id
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

     
        public function getMetaCuadro($array )
    {
        $sSql=" SELECT   m.id as meta_id,m.nombre,IFNULL(m.fecha_add,m.fecha) as mf,m.fecha as mf_me,
			 mc.id as meta_cuadro_id,mc.actividad,IFNULL(mc.fecha_add,mc.fecha) as af,mc.fecha as af_ac,
                         mf1.id as id_d,mf1.comentario as d,IFNULL(mf1.fecha_add,mf1.fecha) as df,mf1.fecha as df_de,
                         mf2.id as id_p,mf2.comentario as p,IFNULL(mf2.fecha_add,mf2.fecha) as pf,mf2.fecha as pf_pa,
			(SELECT CONCAT_WS('|',GROUP_CONCAT(ma.ruta),GROUP_CONCAT(ma.id))
			 FROM metas_archivo ma
			 WHERE  ma.tipo_avance=4 AND ma.avance_id=mf2.id AND ma.estado=1
			 GROUP BY ma.avance_id) as a_p,
			(SELECT CONCAT_WS('|',GROUP_CONCAT(dd.titulo),GROUP_CONCAT(md.id),GROUP_CONCAT(md.doc_digital_id))
			 FROM metas_docdigital md
			 INNER JOIN doc_digital dd ON md.doc_digital_id=dd.id
			 WHERE  md.tipo_avance=4 AND md.avance_id=mf2.id AND md.estado=1
			 GROUP BY md.avance_id) as d_p,
			(SELECT CONCAT_WS('|',GROUP_CONCAT(ma.ruta),GROUP_CONCAT(ma.id))
			 FROM metas_archivo ma
			 WHERE  ma.tipo_avance=3 AND ma.avance_id=mf1.id AND ma.estado=1
			 GROUP BY ma.avance_id) as a_d,
                        (SELECT CONCAT_WS('|',GROUP_CONCAT(dd.titulo),GROUP_CONCAT(md.id),GROUP_CONCAT(md.doc_digital_id))
			 FROM metas_docdigital md
			 INNER JOIN doc_digital dd ON md.doc_digital_id=dd.id
			 WHERE  md.tipo_avance=3 AND md.avance_id=mf1.id AND md.estado=1
			 GROUP BY md.avance_id) as d_d,
			(SELECT CONCAT_WS('|',GROUP_CONCAT(ma.ruta),GROUP_CONCAT(ma.id),GROUP_CONCAT(ma.valida))
			 FROM metas_archivo ma
			 WHERE  ma.tipo_avance=2 AND ma.avance_id=mc.id AND ma.estado=1
			 GROUP BY ma.avance_id) as a_a,
			(SELECT CONCAT_WS('|',GROUP_CONCAT(CONCAT_WS(' - ',DATE(md.created_at),dd.titulo)),GROUP_CONCAT(md.id),GROUP_CONCAT(md.doc_digital_id),GROUP_CONCAT(md.valida))
			 FROM metas_docdigital md
			 INNER JOIN doc_digital dd ON md.doc_digital_id=dd.id
			 WHERE  md.tipo_avance=2 AND md.avance_id=mc.id AND md.estado=1
			 GROUP BY md.avance_id) as d_a,
			(SELECT CONCAT_WS('|',GROUP_CONCAT(ma.ruta),GROUP_CONCAT(ma.id))
			 FROM metas_archivo ma
			 WHERE  ma.tipo_avance=1 AND ma.avance_id=m.id AND ma.estado=1
                         GROUP BY ma.avance_id) as a_m,
			(SELECT CONCAT_WS('|',GROUP_CONCAT(ma.ruta),GROUP_CONCAT(ma.id),GROUP_CONCAT(ma.fecha_id))
			 FROM metas_archivo ma
			 WHERE  ma.tipo_avance=5 AND ma.avance_id=m.id AND ma.estado=1
                         GROUP BY ma.avance_id) as a_q,
			(SELECT CONCAT_WS('|',GROUP_CONCAT(dd.titulo),GROUP_CONCAT(md.id),GROUP_CONCAT(md.doc_digital_id),GROUP_CONCAT(md.fecha_id))
			 FROM metas_docdigital md
			 INNER JOIN doc_digital dd ON md.doc_digital_id=dd.id
			 WHERE  md.tipo_avance=5 AND md.avance_id=m.id AND md.estado=1
			 GROUP BY md.avance_id) as d_q,
                        (SELECT CONCAT_WS('|',GROUP_CONCAT(dd.titulo),GROUP_CONCAT(md.id),GROUP_CONCAT(md.doc_digital_id))
			 FROM metas_docdigital md
			 INNER JOIN doc_digital dd ON md.doc_digital_id=dd.id
			 WHERE  md.tipo_avance=1 AND md.avance_id=m.id AND md.estado=1
			 GROUP BY md.avance_id) as d_m,
			(SELECT CONCAT_WS('|',
                         f.nombre,
                        COUNT(DISTINCT(r.id)),
                        COUNT(DISTINCT(IF(ISNULL(rd.dtiempo_final),r.id,NULL))),
                        COUNT(DISTINCT(r.id))-COUNT(DISTINCT(IF(ISNULL(rd.dtiempo_final),r.id,NULL))) )
                        FROM rutas r
                        INNER JOIN rutas_detalle rd ON r.id=rd.ruta_id and rd.estado=1
                        INNER JOIN flujos f ON r.flujo_id=f.id
                        WHERE r.ruta_flujo_id=mc.ruta_flujo_id and r.estado=1
                        GROUP BY f.id)  as a_proceso,
                        (SELECT GROUP_CONCAT(DISTINCT(r.id))
                        FROM rutas r
                        INNER JOIN rutas_detalle rd ON r.id=rd.ruta_id and rd.estado=1
			INNER JOIN flujos f ON r.flujo_id=f.id
                        WHERE r.ruta_flujo_id=mc.ruta_flujo_id and r.estado=1
                        GROUP BY f.id) as a_proceso_id
                FROM metas_cuadro mc
                INNER JOIN metas m on mc.meta_id=m.id
                LEFT JOIN metas_fechavencimiento mf1 on mc.id=mf1.meta_cuadro_id and mf1.tipo=1 and mf1.estado=1
                LEFT JOIN metas_fechavencimiento mf2 on mc.id=mf2.meta_cuadro_id and mf2.relacion_id=mf1.id and mf2.estado=1 and mf2.tipo=2
                WHERE mc.estado=1
                ";
        $sSql.= $array['where'];
        $sSql.="ORDER BY m.id,mc.id,id_d,mf2.fecha,mf1.fecha DESC";
        $oData = DB::select($sSql);
        return $oData;
    }
    
            public static function getCumplimientoMeta($array) {
        $sql='';
        $sql.=" SELECT 
                m.nombre as meta
                ,mc.id
                ,mc.actividad
                ,mc.fecha
                -- ,COUNT( DISTINCT ma.id) as archivo
                -- ,COUNT( DISTINCT md.id) as documento
                ,TRUNCATE((IF(COUNT( DISTINCT ma.id)>=1,100,0)+ IF(COUNT( DISTINCT md.id)>=1,100,0))/2,1) as porcentaje
                ,CASE 
                WHEN  (IF(COUNT( DISTINCT ma.id)>=1,100,0)+ IF(COUNT( DISTINCT md.id)>=1,100,0))/2=100 THEN 'SI'
                WHEN  (IF(COUNT( DISTINCT ma.id)>=1,100,0)+ IF(COUNT( DISTINCT md.id)>=1,100,0))/2<99 AND CURDATE()>mc.fecha THEN 'NO' 
                WHEN  ((IF(COUNT( DISTINCT ma.id)>=1,100,0)+ IF(COUNT( DISTINCT md.id)>=1,100,0))/2<100) AND DATE_SUB(mc.fecha, INTERVAL 6 day)>CURDATE()  THEN 'A TIEMPO' 
                WHEN  ((IF(COUNT( DISTINCT ma.id)>=1,100,0)+ IF(COUNT( DISTINCT md.id)>=1,100,0))/2<100) AND mc.fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 5 day) AND CURDATE()   THEN 'ALERTA' 

                ELSE '' END estado,
                -- COUNT(DISTINCT mf.id) desglose,
                -- COUNT(DISTINCT ma1.id) archivo,
                -- COUNT(DISTINCT md1.id) documento,
                TRUNCATE(IF(COUNT(DISTINCT ma1.id)>1,1,COUNT(DISTINCT ma1.id))/COUNT(DISTINCT mf.id)/2 + IF(COUNT(DISTINCT md1.id)>1,1,COUNT(DISTINCT md1.id))/COUNT(DISTINCT mf.id)/2,1)*100 as des_por
                FROM metas_cuadro mc
                INNER JOIN metas m ON m.id=mc.meta_id
                INNER JOIN metas_fechavencimiento mf ON mf.meta_cuadro_id=mc.id AND mf.tipo=1 and mf.estado=1
                LEFT JOIN metas_archivo ma ON ma.avance_id=mc.id AND ma.tipo_avance=2 AND ma.estado=1 AND (ma.valida=1 OR ma.valida=2)
                LEFT JOIN metas_docdigital md ON md.avance_id=mc.id AND md.tipo_avance=2 AND md.estado=1 AND (md.valida=1 OR md.valida=2)

                LEFT JOIN metas_archivo ma1 ON ma1.avance_id=mf.id AND ma1.tipo_avance=3 AND ma1.estado=1 AND (ma1.valida=1 OR ma1.valida=2)
                LEFT JOIN metas_docdigital md1 ON md1.avance_id=mf.id AND md1.tipo_avance=3 AND md1.estado=1 AND (md1.valida=1 OR md1.valida=2)";
        $sql.= "WHERE 1=1";
        $sql.= $array['where'];
        $sql.=" GROUP BY mc.id
                ORDER BY m.id,mc.actividad
                ";
        $r =DB::select($sql);
        return $r;
    }
    
        public static function CargarSustento() {
        $sSql1 = '';
        $sSql2 = '';
        $filtro1='';$filtro2='';
        $oData=[];
        if (Input::has('id') && Input::get('id')) {
//            $id = Input::get('id');
            $filtro1.= " AND ma.avance_id = ".Input::get('id');
            $filtro2.= " AND md.avance_id = ".Input::get('id');
        }
        
        $sSql2 .= "SELECT md.id,CONCAT_WS(' - ',DATE(md.created_at),dd.titulo) as titulo,md.avance_id as metacuadro_id,md.doc_digital_id,md.valida
                   FROM metas_docdigital md
                   INNER JOIN doc_digital dd ON dd.id=md.doc_digital_id 
                   WHERE md.tipo_avance=2 
                   AND md.estado=1 ".$filtro2;
        
        $sSql1 .= "SELECT ma.id,ma.ruta,ma.avance_id as metacuadro_id,ma.valida
                   FROM metas_archivo ma
                   WHERE ma.tipo_avance=2 
                   AND ma.estado=1 ".$filtro1;
        
        $oData['archivos'] = DB::select($sSql1);
        $oData['documentos'] = DB::select($sSql2);
        return $oData;
    }
}
