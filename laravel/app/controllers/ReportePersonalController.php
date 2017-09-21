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
        try 
        {
            ini_set('max_execution_time', 300);

            $fecha_ini = Input::get('fecha_ini'); // 2017/09/01
            $fecha_fin = Input::get('fecha_fin'); // 2017/09/15

            $dias = $this->verDiasTranscurridos($fecha_ini, $fecha_fin);

            DB::table('sw_asistencias')->truncate();

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
            
            $sql = "SELECT a.foto, a.area, a.nombres, a.dni, a.cargo, a.regimen,
                                SUM(a.faltas) faltas, SUM(a.tardanza) tardanza, SUM(a.lic_sg) lic_sg, SUM(a.sancion_dici) sancion_dici,
                                SUM(a.lic_sindical) lic_sindical, SUM(a.descanso_med) descanso_med, SUM(a.min_permiso) min_permiso, SUM(a.comision) comision,
                                SUM(a.citacion) citacion, SUM(a.essalud) essalud, SUM(a.permiso) permiso, SUM(a.compensatorio) compensatorio,
                                SUM(a.onomastico) onomastico
                        FROM sw_asistencias a
                        GROUP BY a.area, a.nombres, a.dni, a.cargo;";

            $lis = DB::select($sql);

            return Response::json(
                        array(
                            'rst'=>1,
                            'reporte'=> $lis
                        )
                    );
        }
        catch (\Exception $e) 
        {
            DB::rollback();
            return Response::json(
                        array(
                            'rst'=>2,
                            'reporte'=> 'not_data'
                        )
                    );
        }
    }

}
