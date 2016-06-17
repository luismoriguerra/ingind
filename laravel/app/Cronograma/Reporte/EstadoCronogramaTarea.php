<?php
namespace Cronograma\Reporte;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Plantilla;
use Helpers;
/**
* 
*/
class EstadoCronogramaTarea
{
    
    public static function getTotal($filtro=array())
    {
        $data=array();
        $sql = "SELECT
                -- Proceso
                -- PROCESO  N° DE PASOS     DIAS TOTAL  Fecha Inicio    Fecha Final
                f.nombre proceso, rda.pasos, rda.tiempo, cda.fi, cda.ff, rda.tiempo_total,
                -- Tramite 
                -- TRAMITE  PASO ACTUAL     DIAS    F INICIO    F FINAL     SEMAFORO
                tr.id_union tramite, rd.norden, CONCAT(t.apocope,': ',rd.dtiempo) tiempo_paso, cd.fecha_inicio, cd.fecha_fin,
                IF( cda.ff<CURDATE(),'1_FE0000',
                        IF( cd.fecha_fin<CURDATE(),'2_F8BB00', 
                                '3_75FF75'
                        )
                ) semaforo,
                -- TAREA Y RESPONSABLE
                -- TIPO DE TAREA    DESCRIPCION DE LA TAREA AREA    RESPONSABLE RECURSO
                ta.nombre tipo_tarea, cd.actividad descripcion, a.nemonico, CONCAT(p.paterno,' ',p.materno,', ',p.nombre) responsable, cd.recursos,
                r.id, rd.id ruta_detalle_id, cd.id carta_desglose_id,
                IFNULL(rd.fecha_inicio,'') fecha_inicio,
                rd.estado_ruta AS estado_ruta                    
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.condicion=0
                INNER JOIN carta_desglose cd ON cd.ruta_detalle_id=rd.id
                INNER JOIN areas a ON a.id=cd.area_id
                INNER JOIN personas p ON p.id=cd.persona_id
                INNER JOIN tipo_actividad ta ON ta.id=cd.tipo_actividad_id
                INNER JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id AND tr.estado=1
                INNER JOIN flujos f ON r.flujo_id=f.id 
                INNER JOIN tiempos t ON rd.tiempo_id=t.id
                INNER JOIN 
                ( SELECT rd2.ruta_id,COUNT(rd2.id) pasos,SUM(IF(rd2.tiempo_id=1,rd2.dtiempo,rd2.dtiempo*24)) tiempo_total,      
                    CONCAT(
                        IFNULL(CONCAT('Hora: ',SUM(IF(rd2.tiempo_id=1,rd2.dtiempo,NULL)),'<br>'),'') ,
                        IFNULL(CONCAT('Dia: ',SUM(IF(rd2.tiempo_id=2,rd2.dtiempo,NULL))),'') 
                    ) tiempo
                    FROM rutas_detalle rd2 
                    WHERE rd2.estado=1 
                    GROUP BY rd2.ruta_id
                ) rda ON rda.ruta_id=r.id
                INNER JOIN 
                ( SELECT cd2.carta_id, c2.ruta_id, MIN(cd2.fecha_inicio) fi, MAX(cd2.fecha_fin) ff
                    FROM cartas c2
                    INNER JOIN carta_desglose cd2 ON cd2.carta_id=c2.id
                    GROUP BY c2.id
                ) cda ON cda.ruta_id=r.id
                WHERE r.estado=1
                AND (
                        (rd.dtiempo_final IS NULL AND rd.fecha_inicio!='')
                         OR 
                        (rd.dtiempo_final!='' AND rd.fecha_inicio!='' AND rd.alerta_tipo>1 AND rd.alerta=1)
                    )
                ".$filtro['categoria']
                .$filtro['area']
                .$filtro['semaforo']
                .$filtro['tramite']
                .$filtro['fecha']."
                ORDER BY semaforo";
        try {
            //echo $sql;
            $data = DB::select($sql);

        } catch (Exception $e) {
            $data="error";
        }

        return $data;
    }
}
