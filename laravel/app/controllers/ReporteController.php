<?php

class ReporteController extends BaseController
{

    /**
     * Listar registro de actividades con estado 1
     * POST reporte/rutaxtramite
     *
     * @return Response
     */
    public function postRutaxtramite()
    {
        $flujoId = Input::get('flujo_id');
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
                WHERE r.flujo_id=?";

        $table=DB::select($query, array($flujoId));

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * Listar registro de actividades con estado 1
     * POST reporte/rutaxtramite
     *
     * @return Response
     */
    public function postRutaxtramitedetalle()
    {

        $rutaId=Input::get('ruta_id');
        $table = DB::table('rutas_detalle as rd')
                    ->join('rutas_detalle_verbo as v','rd.id','=','v.ruta_detalle_id')
                    ->join('areas as a','rd.area_id','=','a.id')
                    ->join('tiempos as t','rd.tiempo_id','=','t.id')
                    ->where('ruta_id',array($rutaId))
                    ->select(
                        'rd.id',
                        'rd.ruta_id',
                        DB::RAW('ifnull(a.nombre,"") as area'),
                        DB::RAW('ifnull(t.nombre,"") as tiempo'),
                        DB::RAW('ifnull(rd.dtiempo,"") as dtiempo'),
                        DB::RAW('ifnull(rd.fecha_inicio,"") as fecha_inicio'),
                        DB::RAW('ifnull(rd.dtiempo_final,0) as dtiempo_final'),
                        'rd.norden',
                        'rd.alerta',
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
                    ->orderBy('rd.norden','ASC')
                    ->get();

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * Listar registro de actividades con estado 1
     * POST reporte/tecnicoofficetrack
     *
     * @return Response
     */
    public function postTecnicoofficetrack()
    {
        

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * Listar registro de actividades con estado 1
     * POST reporte/estadoofficetrack
     *
     * @return Response
     */
    public function postEstadoOfficetrack()
    {
        //recibir los parametros y enviarlos al modelo, ahi ejecutar el query

    
        return Response::make($output, 200, $headers);
    }


}
