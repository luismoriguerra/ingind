<?php

class ReportePersonalController extends BaseController
{   // extends \BaseController
    protected $_errorController;
    /**
     * Valida sesion activa
     */
    public function __construct(ErrorController $ErrorController)
    {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }

    public function postReportepersonal()
    {
        $fecha = explode('-', Input::get('fecha_ini'));

        $result = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/index.php?mes=".$fecha[1]."&anno=".$fecha[0]);

        return utf8_encode($result);
        /*
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
                //'datos' => array('data' => $rst)
            )
        );
        */
    }

    private function verDiasTranscurridos($fecha_ini, $fecha_fin)
    {
        $fecha_i = str_replace('/', '-', $fecha_ini);
        $fecha_f = str_replace('/', '-', $fecha_fin);
        $dias = (strtotime($fecha_i) - strtotime($fecha_f))/86400;
        $dias = abs($dias); 
        $dias = floor($dias);
        return ($dias + 1);
    }

    public function postReportepersonaladm()
    {
        //try 
        //{
            ini_set('max_execution_time', 300);

            $fecha_ini = Input::get('fecha_ini'); // 2017/09/01
            $fecha_fin = Input::get('fecha_fin'); // 2017/09/15

            $dias = $this->verDiasTranscurridos($fecha_ini, $fecha_fin);

            //DB::table('sw_asistencias')->truncate();
            DB::table('sw_asistencias')->where('usuario_created_at', '=', Auth::user()->id)->delete();

            if($dias <= 5)
            {
                $res = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/consulta.php?inicio=".$fecha_ini."&fin=".$fecha_fin);
                $result = json_decode(utf8_encode($res));

                foreach($result->reporte as $key => $lis) 
                {
                    DB::beginTransaction();
                    $obj = new ReportePersonal;
                    $obj->foto = $lis->foto;
                    $obj->area = $lis->AREA;
                    $obj->nombres = $lis->nombres_completos;
                    $obj->dni = $lis->dni;
                    $obj->cargo = $lis->cargo;
                    $obj->regimen = $lis->condicion;
                    $obj->faltas = $lis->FALTAS;
                    $obj->tardanza = $lis->TARDANZAS;
                    $obj->lic_sg = $lis->SLSG;
                    $obj->sancion_dici = $lis->Sancion_Dici;
                    $obj->lic_sindical = $lis->Licencia_Sindical;
                    $obj->descanso_med = $lis->DESCANSO_MEDICO;
                    $obj->min_permiso = $lis->MINPERMISO;
                    $obj->comision = $lis->comision;
                    $obj->citacion = $lis->CITACION;
                    $obj->essalud = $lis->ESSALUD;
                    $obj->permiso = $lis->PERMISO;
                    $obj->compensatorio = $lis->COMPENSATORIO;
                    $obj->onomastico = $lis->ONOMASTICO;

                    $obj->estado = 1;
                    $obj->usuario_created_at = Auth::user()->id;
                    $obj->save();

                    DB::commit();
                }
            }
            else
            {
                // // 2017/09/01 - 2017/09/15 = (01-05, 06-10)
                $fecha_i = str_replace('/', '-', $fecha_ini);
                $fecha_f = str_replace('/', '-', $fecha_fin);
                $con = 1;

                for($i=$fecha_i; $i<=$fecha_f; $i = date("Y-m-d", strtotime($i ."+ 1 days")))
                {
                    if($con == 1)
                        $fec_ini = $i;
                    if($con % 5 == 1)
                        $fec_ini = $i;

                    if($con % 5 == 0)
                    {
                        $fec_fin = $i;
                        $res = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/consulta.php?inicio=".$fec_ini."&fin=".$fec_fin);
                        $result = json_decode(utf8_encode($res));

                        foreach($result->reporte as $key => $lis) 
                        {
                            DB::beginTransaction();
                            $obj = new ReportePersonal;
                            $obj->foto = $lis->foto;
                            $obj->area = $lis->AREA;
                            $obj->nombres = $lis->nombres_completos;
                            $obj->dni = $lis->dni;
                            $obj->cargo = $lis->cargo;
                            $obj->regimen = $lis->condicion;
                            $obj->faltas = $lis->FALTAS;
                            $obj->tardanza = $lis->TARDANZAS;
                            $obj->lic_sg = $lis->SLSG;
                            $obj->sancion_dici = $lis->Sancion_Dici;
                            $obj->lic_sindical = $lis->Licencia_Sindical;
                            $obj->descanso_med = $lis->DESCANSO_MEDICO;
                            $obj->min_permiso = $lis->MINPERMISO;
                            $obj->comision = $lis->comision;
                            $obj->citacion = $lis->CITACION;
                            $obj->essalud = $lis->ESSALUD;
                            $obj->permiso = $lis->PERMISO;
                            $obj->compensatorio = $lis->COMPENSATORIO;
                            $obj->onomastico = $lis->ONOMASTICO;

                            $obj->estado = 1;
                            $obj->usuario_created_at = Auth::user()->id;
                            $obj->save();

                            DB::commit();
                        }
                    }
                    else
                        $fec_fin = $i;

                    $con++;
                }


                if(($con-1) % 5 <> 0)
                {
                    $res = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/consulta.php?inicio=".$fec_ini."&fin=".$fec_fin);
                    $result = json_decode(utf8_encode($res));

                    foreach($result->reporte as $key => $lis) 
                    {
                        DB::beginTransaction();
                        $obj = new ReportePersonal;
                        $obj->foto = $lis->foto;
                        $obj->area = $lis->AREA;
                        $obj->nombres = $lis->nombres_completos;
                        $obj->dni = $lis->dni;
                        $obj->cargo = $lis->cargo;
                        $obj->regimen = $lis->condicion;
                        $obj->faltas = $lis->FALTAS;
                        $obj->tardanza = $lis->TARDANZAS;
                        $obj->lic_sg = $lis->SLSG;
                        $obj->sancion_dici = $lis->Sancion_Dici;
                        $obj->lic_sindical = $lis->Licencia_Sindical;
                        $obj->descanso_med = $lis->DESCANSO_MEDICO;
                        $obj->min_permiso = $lis->MINPERMISO;
                        $obj->comision = $lis->comision;
                        $obj->citacion = $lis->CITACION;
                        $obj->essalud = $lis->ESSALUD;
                        $obj->permiso = $lis->PERMISO;
                        $obj->compensatorio = $lis->COMPENSATORIO;
                        $obj->onomastico = $lis->ONOMASTICO;

                        $obj->estado = 1;
                        $obj->usuario_created_at = Auth::user()->id;
                        $obj->save();

                        DB::commit();
                    }
                }
                
            }

            // Actualiza campo "persona_id" en base al "id" de la tabla "personas".            
            $sql = "UPDATE sw_asistencias sa
                        INNER JOIN personas p ON sa.dni=p.dni
                        SET sa.persona_id = p.id;";
            DB::update($sql);
            // --

            // Actualiza campo "persona_id" en base que no tenga asociado un "id" de la tabla "personas". 
            DB::table('sw_asistencias')
                ->whereNull('persona_id')
                ->update(array('persona_id' => 1));
            // --
            
            $fecha_ini = str_replace('/', '-', $fecha_ini);
            $fecha_fin = str_replace('/', '-', $fecha_fin);

            $sql = "SELECT sw.*,
                        ca.cant_act,
                        doc.docu,
                        tt.total_tramites,
                        t.tareas
                        FROM (
                            SELECT a.foto, a.area, a.nombres, a.dni, a.cargo, a.regimen,
                                                SUM(a.faltas) faltas, SUM(a.tardanza) tardanza, SUM(a.lic_sg) lic_sg, SUM(a.sancion_dici) sancion_dici,
                                                SUM(a.lic_sindical) lic_sindical, SUM(a.descanso_med) descanso_med, SUM(a.min_permiso) min_permiso, SUM(a.comision) comision,
                                                SUM(a.citacion) citacion, SUM(a.essalud) essalud, SUM(a.permiso) permiso, SUM(a.compensatorio) compensatorio,
                                                SUM(a.onomastico) onomastico, a.usuario_created_at,a.persona_id
                                FROM sw_asistencias a
                                WHERE NOT a.dni = '07135876'
                                AND a.usuario_created_at = '".Auth::user()->id."'
                                GROUP BY a.area, a.nombres, a.dni, a.cargo
                        ) sw
                        LEFT JOIN (SELECT COUNT(rdv.id) tareas, rdv.usuario_updated_at persona_id
                                FROM rutas_detalle_verbo rdv
                                WHERE rdv.finalizo=1 
                                AND rdv.updated_at BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'
                                GROUP BY rdv.usuario_updated_at
                        ) AS t ON t.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(ap.id) cant_act, ap.persona_id
                                FROM actividad_personal ap
                                WHERE ap.persona_id=ap.usuario_created_at
                                AND ap.fecha_inicio BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'
                                GROUP BY ap.persona_id
                            ) AS ca ON ca.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(r.id) total_tramites, r.usuario_created_at persona_id
                                FROM rutas r
                                WHERE r.created_at BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'
                                AND r.estado=1
                                GROUP BY r.usuario_created_at
                            ) AS tt ON tt.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(dd.id) docu, dd.usuario_created_at persona_id
                                FROM doc_digital dd
                                WHERE dd.created_at BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'
                                AND dd.estado = 1
                                GROUP BY dd.usuario_created_at
                            ) AS doc ON doc.persona_id=sw.persona_id; ";

            $lis = DB::select($sql);

            return Response::json(
                        array(
                            'rst'=>1,
                            'reporte'=> $lis
                        )
                    );
        /*}
        catch (\Exception $e) 
        {
            DB::rollback();
            return Response::json(
                        array(
                            'rst'=>2,
                            'reporte'=> 'not_data'
                        )
                    );
        }*/
    }

}
