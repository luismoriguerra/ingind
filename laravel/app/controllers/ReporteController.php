<?php

class ReporteController extends BaseController
{

    /**
     * Cumplimiento de ruta por tramite
     * POST reporte/cumprutaxtramite
     *
     * @return Response
     */
    public function postCumprutaxtramite()
    {
        $flujoId = Input::get('flujo_id');
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);

        $query = "SELECT tr.id_union, r.id, s.nombre as software,
                p.nombre as persona, a.nombre as area, r.fecha_inicio,
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=1) AS 'error',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=2) AS 'corregido'
                FROM rutas r 
                JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id
                    JOIN softwares s ON tr.software_id=s.id
                JOIN personas p ON r.persona_id=p.id
                JOIN areas a ON r.area_id=a.id
                WHERE r.fecha_inicio BETWEEN '$fechaIni' AND 
                      DATE_ADD('$fechaFin',INTERVAL 1 DAY) AND r.flujo_id=?";

        $table=DB::select($query, array($flujoId));

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * Detalle del cumplimiento de ruta por tramite
     * POST reporte/rutaxtramite
     *
     * @return Response
     */
    public function postCumprutaxtramitedetalle()
    {

        $rutaId=Input::get('ruta_id');
        $table = DB::table('rutas as r')
                    ->join('rutas_detalle as rd','r.id','=','rd.ruta_id')
                    ->join('rutas_detalle_verbo as v','rd.id','=','v.ruta_detalle_id')
                    ->join('areas as a','rd.area_id','=','a.id')
                    ->join('tiempos as t','rd.tiempo_id','=','t.id')
                    ->where('ruta_id',array($rutaId))
                    ->select(
                        'rd.id',
                        'rd.ruta_id',
                        DB::RAW('ifnull(a.nombre,"") as area'),
                        DB::RAW('ifnull(t.nombre,"") as tiempo'),
                        DB::RAW('ifnull(dtiempo,"") as dtiempo'),
                        DB::RAW('ifnull(rd.fecha_inicio,"") as fecha_inicio'),
                        DB::RAW('ifnull(dtiempo_final,"") as dtiempo_final'),
                        'norden',
                        'alerta',
                        //'v.nombre as verbo',
                        //DB::RAW('ifnull(scaneo,"") as scaneo'),
                        //'finalizo',
                        DB::RAW("
                            GROUP_CONCAT( 
                                CONCAT(
                                    v.nombre,
                                    ' => ',
                                     IF(v.finalizo=0,'Pendiente','Finalizado')
                                ) SEPARATOR '<br>'
                            ) as verbo_finalizo
                        ")
                    )
                    ->groupBy('rd.id')
                    ->get();

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * Cumplimiento de are
     * POST reporte/tecnicoofficetrack
     *
     * @return Response
     */
    public function postCumparea()
    {
        $flujoId=Input::get('flujo_id');
        $areaId=Input::get('area_id');

        $query =  DB::table('rutas as r')
                    ->join('rutas_detalle as rd','r.id','=','rd.ruta_id')
                    ->join('rutas_detalle_verbo as v','rd.id','=','v.ruta_detalle_id')
                    ->join('tiempos as t','rd.tiempo_id','=','t.id')
                    ->join('tablas_relacion as tr','r.tabla_relacion_id','=','tr.id')
                    ->where('rd.flujo_id',array($flujoId))
                    ->where('rd.area_id',array($areaId))
                    ->select(
                        'tr.id_union',
                        'rd.id',
                        DB::RAW('ifnull(rd.norden,"") as norden'),
                        DB::RAW('ifnull(rd.fecha_inicio,"") as fecha_inicio'),
                        DB::RAW('ifnull(t.nombre,"") as tiempo'),
                        DB::RAW('ifnull(rd.dtiempo,"") as dtiempo'),
                        DB::RAW('ifnull(rd.dtiempo_final,"") as dtiempo_final'),
                        'norden',
                        'alerta',
                        //'v.nombre as verbo',
                        //DB::RAW('ifnull(scaneo,"") as scaneo'),
                        //'finalizo',
                        DB::RAW("
                            GROUP_CONCAT( 
                                    CONCAT(
                                            v.nombre,
                                            ' => ',
                                             IF(v.finalizo=0,'Pendiente','Finalizado')
                                    ) SEPARATOR '<br>'
                            ) AS verbo_finalizo
                        "),
                        DB::RAW("
                            CASE rd.alerta
                                WHEN '0' THEN 'Sin Alerta'
                                WHEN '1' THEN 'Alerta'
                                WHEN '2' THEN 'Alerta Validada'
                                ELSE '' 
                            END  AS alerta
                        ")
                    )
                    ->groupBy('rd.id')
                    ->get();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$query
            )
        );
    }
}
