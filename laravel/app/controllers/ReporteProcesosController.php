<?php
class ReporteProcesosController extends \BaseController
{


    public function postProcesosarea()
    { 

        $fechaIni = (Input::has('fecha_ini') ? Input::get('fecha_ini') : '');
        $fechaFin = (Input::has('fecha_fin') ? Input::get('fecha_fin') : '');
        $areas = (Input::has('area_id') ? Input::get('area_id') : '');

        $areas = implode(",", $areas);

        $re = ReporteProceso::getReporteProceso($areas,$fechaIni,$fechaFin);
        return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Procesos cargados',
                    'datos' => $re
                )
            );
    }


    public function postTramitesarea()
    { 

        $fechaIni = (Input::has('fecha_ini') ? Input::get('fecha_ini') : '');
        $fechaFin = (Input::has('fecha_fin') ? Input::get('fecha_fin') : '');
        $areas = (Input::has('area_id') ? Input::get('area_id') : '');

        $areas = implode(",", $areas);

        $re = ReporteProceso::getReporteTramites($areas,$fechaIni,$fechaFin);
        return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Tramites cargados',
                    'datos' => $re
                )
            );
    }


}