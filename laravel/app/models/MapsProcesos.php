<?php

class MapsProcesos extends \Eloquent {

    protected $fillable = [];
    public $table = "carga_incidencias";


    public static function ReporteRALatLng() {
        $sSql = '';
        $sSql .= "SELECT max(ci.latitud) as latitud, max(ci.longitud) as longitud
                    FROM carga_incidencias ci
                    INNER JOIN rutas r ON ci.ruta_id = r.id AND r.estado = 1
                    INNER JOIN tablas_relacion tr ON r.tabla_relacion_id = tr.id AND tr.estado = 1
                    INNER JOIN rutas_detalle rd ON r.id = rd.ruta_id AND rd.estado = 1
                    WHERE ci.tipo = 'DESMONTE'
                        AND rd.area_id = 23
                        AND rd.fecha_inicio IS NOT NULL
                        AND rd.dtiempo_final IS NULL ";

        if (Input::has('fecha_ini') && Input::get('fecha_ini') && Input::has('fecha_fin') && Input::get('fecha_fin')) {
            $fecha_ini=Input::get('fecha_ini');
            $fecha_fin=Input::get('fecha_fin');
            $sSql .= "AND DATE_FORMAT(rd.fecha_inicio,'%Y/%m/%d') BETWEEN '" . $fecha_ini . "' AND '" . $fecha_fin . "' ";
        }
        //echo $sSql;
        $oData = DB::select($sSql);
        return $oData;
    }

    public static function ReporteRutasActivas() {
        $sSql = '';
        $sSql .= "SELECT rd.id, rd.ruta_id, tr.id_union, tr.fecha_tramite, rd.area_id, rd.fecha_inicio, ci.id as carga_incidencia_id,
                            ci.foto, ci.direccion, ci.tipo, ci.viapredio, ci.latitud, ci.longitud, rdm.id as rdm_id, rdm.fecha_programada,
                            rdm.vehiculo_id,rdm.persona_id,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) as persona
                    FROM carga_incidencias ci
                    INNER JOIN rutas r ON ci.ruta_id = r.id AND r.estado = 1
                    INNER JOIN tablas_relacion tr ON r.tabla_relacion_id = tr.id AND tr.estado = 1
                    INNER JOIN rutas_detalle rd ON r.id = rd.ruta_id AND rd.estado = 1
                    LEFT JOIN rutas_detalle_mapas rdm ON r.id = rdm.ruta_id AND rd.id = rdm.ruta_detalle_id
                    LEFT JOIN personas p ON p.id=rdm.persona_id                    
                    WHERE ci.tipo = 'DESMONTE'
                        AND rd.area_id = 23
                        AND rd.fecha_inicio IS NOT NULL
                        AND rd.dtiempo_final IS NULL ";

        if (Input::has('fecha_ini') && Input::get('fecha_ini') && Input::has('fecha_fin') && Input::get('fecha_fin')) {
            $fecha_ini=Input::get('fecha_ini');
            $fecha_fin=Input::get('fecha_fin');
            $sSql .= "AND DATE_FORMAT(rd.fecha_inicio,'%Y/%m/%d') BETWEEN '" . $fecha_ini . "' AND '" . $fecha_fin . "' ";
        }
        //echo $sSql;
        $oData = DB::select($sSql);
        return $oData;
    }

}
