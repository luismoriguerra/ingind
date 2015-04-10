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
        $query = "SELECT r.id, s.nombre as software,  p.nombre as persona,
                 a.nombre as area, r.fecha_inicio,
                    (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=0) AS '0',
                    (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=1) AS '1',
                    (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=2) AS '2'
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
        $table = DB::table('rutas_detalle')
        ->where('ruta_id',array($rutaId))
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
