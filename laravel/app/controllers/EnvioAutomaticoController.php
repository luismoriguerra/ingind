<?php

class EnvioAutomaticoController extends \BaseController {

    /**
     * Display a listing of the resource.
     * GET /prueba
     *
     * @return Response
     */
    
    public function postVehiculoalertas()
    {
        $retorno = array('rst' => 1);

        $url ='http://www.muniindependencia.gob.pe/ceteco/index.php?opcion=moviles';
        $curl_options = array(
                            CURLOPT_URL => $url,
                            CURLOPT_HEADER => 0,
                            CURLOPT_RETURNTRANSFER => TRUE,
                            //CURLOPT_TIMEOUT => 0,
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_FOLLOWLOCATION => TRUE,
                            CURLOPT_ENCODING => 'gzip,deflate',
                        );

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        $output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode(utf8_encode($output),true);

        $html="";
        $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $html_table = '<table border="0" cellspacing="0" style="font-size: 11px; overflow:hidden; border:2px solid #EAE8E7; background:#fefefe; border-radius:5px;">
                          <thead>
                           <tr>
                             <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Fecha Día</th>
                             <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Cuadrante</th>
                             <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Placa</th>
                             <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Turno</th>
                             <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Gas. Ini</th>
                             <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Gas. Fin</th>
                             <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Klm. Ini</th>
                             <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Klm. Fin</th>
                            </tr>
                          </thead>
                          <tbody>';

        foreach ($result['moviles'] as $key => $lis) 
        {
            if(trim($lis['halcon']) == '')
                $style = 'background-color: #F95C4E; opacity: 0.9;';
            else if($lis['halcon'] == 'A PIE')
                $style = 'background-color: #F95C4E; opacity: 0.9;';
            else 
                $style = '';

            $html_table .= '<tr style="'.$style.'">
                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis['fecha'].'</td>
                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis['puesto_servicio'].'</td>
                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis['halcon'].'</td>
                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis['horario'].'</td>
                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis['gas_i'].'</td>
                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis['gas_f'].'</td>
                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis['km_i'].'</td>
                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis['km_f'].'</td>
                            </tr>';
        }

        $html_table .= '</tbody>
                        </table>';

        // A Quien va dirigido el correo
        $e = DB::select('select CONCAT(nombre, " ",paterno, " ", materno) as nombres, 
                            area_id, id, email, email_mdi
                            from personas
                            where area_id in (19, 38)
                            and rol_id in (9,8)
                            and estado=1
                            order by area_id;');
        
        foreach($e as $c => $li):
            if($c == 0){
                if(trim($li->email) != '' && trim($li->email_mdi) == '')
                    $email = $li->email;
                else if(trim($li->email) == '' && trim($li->email_mdi) != '')
                    $email = $li->email_mdi;
                else                    
                    $email = [$li->email, $li->email_mdi]; //'rusbelc02@gmail.com', 'jhonytin@gmail.com'
            }else{
                if(trim($li->email) != '' && trim($li->email_mdi) == '')
                    $email_2 = [$li->email, 'consultas.gmgm@gmail.com'];
                else if(trim($li->email) == '' && trim($li->email_mdi) != '')
                    $email_2 = [$li->email_mdi, 'consultas.gmgm@gmail.com'];
                else                    
                    $email_2 = [$li->email, $li->email_mdi, 'consultas.gmgm@gmail.com']; //'paezvallejohecthor@gmail.com', 'rcapchab@gmail.com'    
            }    
        endforeach;
        $email = $email;
        $email_copia = $email_2;
        //$email='rusbelc02@gmail.com';
        //$email_copia='consultas.gmgm@gmail.com';
        //$email_copia='rblas@muniindependencia.gob.pe';
        // --

        $plantilla = Plantilla::where('tipo', '=', '11')->first();
        $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'persona:', 'tabla:');
        $reemplazar = array('<b>'.ucwords($e[0]->nombres).'</b>', date('d'), $meses[date('n')], date("Y"), 'Rusbel Arteaga', $html_table);
        $parametros = array(
            'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
        );        

        if ($email != '')
        {
            DB::beginTransaction();
            try {
                Mail::send('notreirel', $parametros, function($message) use ($email, $email_copia) {
                        $message
                                ->to($email)
                                ->cc($email_copia)
                                ->subject('.::Unidades Moviles Operativas::.');
                    }
                );
            } catch (Exception $e) {
                //echo $qem[$k]->email."<br>";
                DB::rollback();
            }
            DB::commit();
        }

        $retorno["data"] = $html;
        return Response::json($retorno);
    }
    
    // 2017-11-29
    public function postVehiculoreporteauditoria()
    {
        $array = array();
        $array['usuario'] = Auth::user()->id;
        $retorno = array('rst' => 1);        

        $html="";
        $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $n = 1;
        $hoy = date('Y-m-d');
        
        $dia_validar = date('w', strtotime($hoy));
        if ( $dia_validar == 2 OR $dia_validar == 3 OR $dia_validar == 4 OR $dia_validar == 5 OR $dia_validar == 6) 
        {
            $date_now = date('Y-m-d');
            $Ssql = "SELECT CONCAT_WS(' ',p.paterno,p.materno,p.nombre) as persona,
                                a.nombre as area,
                                p.area_id, p.email, p.email_mdi,
                                p.id as persona_id,
                                COUNT(DISTINCT tai.id) as ti,
                                COUNT(DISTINCT tac.id) as tc,
                                COUNT(DISTINCT tai1.id) as ti1,COUNT(DISTINCT tac1.id) as tc1
                     FROM personas p
                     INNER JOIN areas a ON a.id=p.area_id
                     LEFT JOIN auditoria_acceso tai ON p.id=tai.persona_id 
                                        AND tai.estado=1 and tai.tipo=1 
                                        AND DATE(tai.created_at) BETWEEN '$date_now' AND '$date_now'
                     LEFT JOIN auditoria_acceso tac ON p.id=tac.persona_id 
                                        AND tac.estado=1 and tac.tipo=2
                                        AND DATE(tac.created_at) BETWEEN '$date_now' AND '$date_now'
                        LEFT JOIN auditoria_acceso tai1 ON tai.id=tai1.id 
                                        AND tai1.estado=1 and tai1.tipo=1 
                                        AND DATE(tai1.created_at)= '$date_now'
                        LEFT JOIN auditoria_acceso tac1 ON tac.id=tac1.id 
                                        AND tac1.estado=1 and tac1.tipo=2 
                                        AND DATE(tac1.created_at)= '$date_now'
                        WHERE  p.rol_id IN (8,9)
                                   AND p.estado=1
                                   GROUP BY p.id;";
            $reporte = DB::select($Ssql);

            foreach ($reporte as $val)
            {
                $html_table = '<table border="0" cellspacing="0" style="font-size: 11px; overflow:hidden; border:2px solid #EAE8E7; background:#fefefe; border-radius:5px;">
                                  <thead>
                                   <tr>
                                     <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">AREA</th>
                                     <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">N° Ingreso</th>
                                     <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">N° Consultas</th>
                                     <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">N° Ing. Total</th>
                                     <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">N° Con. Total</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                $html_table .= '<tr>
                                  <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->area.'</td>
                                  <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->ti.'</td>
                                  <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->tc.'</td>
                                  <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->ti1.'</td>
                                  <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->tc1.'</td>
                                </tr>';
                $html_table .= '</tbody>
                              </table>';                

                    // --
                    $repauditorias = NULL;
                    $Ssql = "SELECT o.nombre,
                                COUNT(DISTINCT tai.id) as ti,COUNT(DISTINCT tac.id) as tc 
                                FROM opciones o
                                LEFT JOIN auditoria_acceso tai ON o.id=tai.opcion_id and tai.estado=1 and tai.tipo=1  
                                    AND tai.persona_id= ".$val->persona_id."  AND DATE(tai.created_at) BETWEEN '$date_now' AND '$date_now'
                                LEFT JOIN auditoria_acceso tac ON o.id=tac.opcion_id and tac.estado=1 and tac.tipo=2  
                                    AND tac.persona_id= ".$val->persona_id."  AND DATE(tac.created_at) BETWEEN '$date_now' AND '$date_now'
                                GROUP BY o.id HAVING ti>0 or tc>0;";
                    $repauditorias = DB::select($Ssql);
                    
                    $html_table_deta = '<table border="0" cellspacing="0" style="font-size: 11px; overflow:hidden; border:2px solid #EAE8E7; background:#fefefe; border-radius:5px;">
                                      <thead>
                                       <tr>
                                         <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">N°</th>
                                         <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Opción</th>
                                         <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">N° T. Ingreso</th>
                                         <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">N° T. Consultas</th>
                                        </tr>
                                      </thead>
                                      <tbody>';
                    if($repauditorias != NULL)
                    {
                        foreach ($repauditorias as $key => $lis) 
                        {
                            $html_table_deta .= '<tr>
                                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$n.'</td>
                                              <td style="padding:5px 10px 3px; text-align:left; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis->nombre.'</td>
                                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis->ti.'</td>
                                              <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$lis->tc.'</td>                                  
                                            </tr>';
                            $n++;
                        }
                    }
                    else
                         $html_table_deta .= '<tr>
                                              <td colspan="4" style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;"> No existe detalles disponibles. </td>
                                            </tr>';

                    $html_table_deta .= '</tbody>
                                    </table>';
                    // --
                                                    
                if(trim($val->email) != '')
                    $email = trim($val->email);
                else
                    $email = 'consultas.gmgm@gmail.com';

                if(trim($val->email_mdi) != '')
                    $email_copia = trim($val->email_mdi);
                else
                    $email_copia = 'consultas.gmgm@gmail.com';

                //$email='rusbelc02@gmail.com';
                //$email_copia='consultas.gmgm@gmail.com';
                // --

                // Mensaje de Auditoría
                if($val->ti == 0 && $val->tc == 0)
                    $mensaje = '<div style="padding: 5px 5px; color: #a94442; font-size: 11px; overflow:hidden; border:2px solid #ebccd1; background-color:#f2dede; border-radius:5px;">
                                    Usted no esta ingresando al sistema, por favor debe regular sus ingresos.
                                  </div>';
                else if($val->ti <= 1 || $val->tc <= 1)
                    $mensaje = '<div style="padding: 5px 5px; color: #8a6d3b;; font-size: 11px; overflow:hidden; border:2px solid #faebcc; background-color:#fcf8e3;; border-radius:5px;">
                                    Usted no esta ingresando al sistema de manera continua..
                                  </div>';
                else
                    $mensaje = '';
                // --

                $nota = '<br>
                          <div style="padding: 5px 5px;  font-size: 12px; overflow:hidden; border:2px solid #EAE8E7; border-radius:5px;">
                            <p>
                            <strong>NOTA:</strong><br/>
                              Se recomienda que ingrese y sonsulte diariamente al sistema de procesos para controlar y administrar la gestión de los tramites y la operatividad de su gestión.
                              <br/>
                              Accesos recomendados: (Menú) -> (Opción)
                              <ul>
                              <li>Reporte -> R. Personal ADM</li>
                              <li>Reporte -> R. Total de Procesos</li>
                              <li>Reporte -> Bandeja inconcluso por area</li>
                              <li>Reporte -> Lista de Procesos</li>
                              <li>Reporte -> Documentos de Plataforma</li>

                              <li>Actividad Personal -> R. Diario de Actividades</li>
                              <li>Actividad Personal -> R. Actividades Asignadas</li>
                              <li>Actividad Personal -> R. Producción de Usuario</li>
                              </ul>
                            </p>
                          </div>';


                $plantilla = Plantilla::where('tipo', '=', '12')->first();
                $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'persona:', 'tabla:', 'tabla_deta:', 'Mensaje:', 'Nota:');
                $reemplazar = array('<b>'.ucwords($val->persona).'</b>', date('d'), $meses[date('n')], date("Y"), 'Rusbel Arteaga', $html_table, $html_table_deta, $mensaje, $nota);
                $parametros = array(
                    'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
                );        

                if ($email != '')
                {
                    DB::beginTransaction();
                    try {
                        Mail::send('notreirel', $parametros, function($message) use ($email, $email_copia) {
                                $message
                                        ->to($email)
                                        ->cc($email_copia)
                                        ->subject('.:: Reporte de Auditoria Personal ::.');
                            }
                        );
                    } catch (Exception $e) {
                        //echo $qem[$k]->email."<br>";
                        DB::rollback();
                    }
                    DB::commit();
                }
            }
        }

        $retorno["data"] = $html;
        return Response::json($retorno);
    }
    // --
    public function postReportepersonaladmjefe()
    {
        $array = array();
        $array['usuario'] = Auth::user()->id;
        $retorno = array('rst' => 1);        

        $html="";
        $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $n = 1;
        // $hoy ='2018-01-22'; 
        $hoy = date('Y-m-d');
        
        $dia_validar = date('w', strtotime($hoy));
        if ( $dia_validar == 1) // Proceso ejecuta L = 1
        {            
            // --
            ini_set('max_execution_time', 300);
            $areas_ex = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/consul.php?opcion=area");

            DB::table('sw_asistencias')->where('usuario_created_at', '=', Auth::user()->id)->delete();
            /*
            $array = array(
                        'area' => array(
                            array(
                                "id" => "240000",
                                "area" => "GMGM",
                            ),
                            array(
                                "id" => "210000",
                                "area" => "seguimiento",
                            ),
                        )
                    );
            $areas_externo = json_decode(json_encode($array));
            */
            $areas_externo = json_decode(utf8_encode($areas_ex));        

            foreach ($areas_externo->area as $aer)
            {
              //if ($aer->id != '140000') {                  
                $fecha_ini = date('Y/m/d', strtotime('-7 day', strtotime($hoy))); // 2018/02/05
                $fecha_fin = date('Y/m/d', strtotime('-1 day', strtotime($hoy))); // 2018/02/11

                $dias=20-1;
                $fecha_i = str_replace('/', '-', $fecha_ini);
                $fecha_f = str_replace('/', '-', $fecha_fin);
                $fecha_iaux =$fecha_i;
                $fecha_faux = date("Y-m-d", strtotime($fecha_i ."+".$dias." days"));

                  while ( $fecha_iaux <= $fecha_f ) {

                      if( $fecha_faux>$fecha_f ){
                          $fecha_faux=$fecha_f;
                      }

                      $fini=date("Y/m/d",strtotime($fecha_iaux));
                      $ffin=date("Y/m/d",strtotime($fecha_faux));

                      $res = file_get_contents("http://10.0.120.13:8088/spersonal/consulta.php?inicio=".$fini.""."&fin=".$ffin."&area=".$aer->id);
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
                        //echo $obj;
                      }

                      $fecha_iaux= date("Y-m-d", strtotime($fecha_faux ."+1 days"));
                      $fecha_faux= date("Y-m-d", strtotime($fecha_iaux ."+".$dias." days"));
                  }

                  $sql = "UPDATE sw_asistencias sa
                              INNER JOIN personas p ON sa.dni=p.dni
                              SET sa.persona_id = p.id;";
                  DB::update($sql);

                  DB::table('sw_asistencias')
                      ->whereNull('persona_id')
                      ->update(array('persona_id' => 1272));
              //} // Cierra IF area              
            }


                $Ssql = "SELECT sw.*,
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
                                    AND rdv.updated_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                    GROUP BY rdv.usuario_updated_at
                            ) AS t ON t.persona_id=sw.persona_id
                            LEFT JOIN (SELECT ROUND((SUM(ap.ot_tiempo_transcurrido) / 60), 2) cant_act, ap.persona_id
                                    FROM actividad_personal ap
                                    WHERE ap.persona_id=ap.usuario_created_at
                                    AND ap.fecha_inicio BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                    GROUP BY ap.persona_id
                                ) AS ca ON ca.persona_id=sw.persona_id
                            LEFT JOIN (SELECT COUNT(r.id) total_tramites, r.usuario_created_at persona_id
                                    FROM rutas r
                                    WHERE r.created_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                    AND r.estado=1
                                    GROUP BY r.usuario_created_at
                                ) AS tt ON tt.persona_id=sw.persona_id
                            LEFT JOIN (SELECT COUNT(dd.id) docu, dd.usuario_created_at persona_id
                                    FROM doc_digital_temporal dd
                                    WHERE dd.created_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                    AND dd.estado = 1
                                    GROUP BY dd.usuario_created_at
                                ) AS doc ON doc.persona_id=sw.persona_id; ";
                $reporte = DB::select($Ssql);                  

                $html_table_header = '<table border="0" cellspacing="0" style="font-size: 11px; overflow:hidden; border:2px solid #EAE8E7; background:#fefefe; border-radius:5px;">
                                      <thead>
                                        <tr>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#009A0D), to(#e8eaeb));" colspan="6">DATOS PERSONALES</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#0D7BE8), to(#e8eaeb));" colspan="7">DETALLES DE ASISTENCIA</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#935799), to(#e8eaeb));" colspan="6">PERMISOS / PAPELETAS</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#CC9C0D), to(#e8eaeb));" colspan="4">PROCESO FLUJOS</th>
                                        </tr>
                                        <tr>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Foto</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Area</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Nombres</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Dni</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Cargo / Puesto</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Regimen Lab.</th>      

                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Faltas</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Trd</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Lic S.G</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Sancion Dici</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Lic. Sindical</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Dcso. Med</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Min. Perm</th>

                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Com.</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Cit.</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Essld</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Perm</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Compem</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Ono</th>

                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">H.Act.</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Tarea</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">T.Trami</th>
                                          <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Doc</th>
                                        </tr>
                                      </thead>
                                      <tbody>';
                $html_table_footer= '</tbody>
                                </table>';

                $html_table_body = '';
                $arr_persona_id = array();
                $c = 0;
                $area = '';          
                foreach ($reporte as $value) // Abre For Reporte
                {
                    $acu_asiste = 0;
                    $acu_asiste = $acu_asiste + $value->faltas;
                    $acu_asiste = $acu_asiste + $value->tardanza;
                    $acu_asiste = $acu_asiste + $value->lic_sg;
                    $acu_asiste = $acu_asiste + $value->sancion_dici;
                    $acu_asiste = $acu_asiste + $value->lic_sindical;
                    $acu_asiste = $acu_asiste + $value->descanso_med;
                    $acu_asiste = $acu_asiste + $value->min_permiso;
                    $acu_asiste = $acu_asiste + $value->comision;
                    $acu_asiste = $acu_asiste + $value->citacion;
                    $acu_asiste = $acu_asiste + $value->essalud;
                    $acu_asiste = $acu_asiste + $value->permiso;
                    $acu_asiste = $acu_asiste + $value->compensatorio;
                    $acu_asiste = $acu_asiste + $value->onomastico;
                    array_push($arr_persona_id, $value->persona_id);

                    $c++; 
                    if($c == 1) {
                      $area = $value->area;
                    }               
                    
                    if($area != $value->area) {
                      /*
                      $sql = '';
                      $sql = "SELECT area_id, id, IFNULL(email, '') as email, email_mdi, CONCAT_ws(' ', paterno, materno, nombre) AS nombres
                                FROM personas
                                  WHERE id = ".$value->persona_id."
                                and rol_id in (9,8)
                                and estado=1;";
                      $perso = DB::select($sql);
                      */          
                      $perso = DB::table('personas')
                                  ->select('area_id', 'id', DB::raw("IFNULL(email, '') as email"), 'email_mdi', DB::raw("CONCAT_ws(' ', paterno, materno, nombre) AS nombres"))
                                  ->where('estado', '1')
                                  ->whereIn('rol_id', [9, 8])
                                  ->whereIn('id', $arr_persona_id)
                                  ->get();

                      if (count($perso) > 0) 
                      {
                        $nombre_jefe = $perso[0]->nombres;
                        if(trim($perso[0]->email) != '')
                            $correo_jefe = trim($perso[0]->email);
                        else
                            $correo_jefe = ''; // Caso no tenga correo

                        if(trim($perso[0]->email_mdi) != '')
                            $correo_jefe_copia = trim($perso[0]->email_mdi);
                        else
                            $correo_jefe_copia = '';
                        
                        $html_table = $html_table_header.$html_table_body.$html_table_footer;
                        // --
                        $email = $correo_jefe;
                        $email_copia = $correo_jefe_copia;

                        $nota = '<br>
                                  <div style="padding: 5px 5px;  font-size: 12px; overflow:hidden; border:2px solid #EAE8E7; border-radius:5px;">
                                    <p>
                                    <strong>NOTA:</strong><br/>
                                      Se recomienda no incumplir las normas del trabajo, para una mejor calificación para usted.
                                    </p>
                                  </div>';

                        $plantilla = Plantilla::where('tipo', '=', '13')->first();
                        $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'persona:', 'tabla:', 'Nota:');
                        $reemplazar = array('<b>'.$nombre_jefe.'</b>', date('d'), $meses[date('n')], date("Y"), 'Rusbel Arteaga', $html_table, $nota);
                        $parametros = array(
                            'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
                        );
                        
                        if ($email != '' && $html_table_body!='') {
                            try {
                              //if($email != 'elica49@hotmail.com') { // Por mientritas
                                Mail::send('notreirel', $parametros, function($message) use ($email, $email_copia) {
                                                $message->to($email);
                                                if($email_copia != ''){
                                                   $message ->cc($email_copia);
                                                }
                                                   $message->subject('.:: Reporte de Asistencia de Personal ::.');
                                    }
                                );
                              //}
                            } catch (Exception $e) {
                                //echo $qem[$k]->email."<br>";
                            }
                        }                        
                      }
                      $html_table_body='';

                      $area = $value->area;
                      //$persona_id = $value->persona_id;
                      unset($arr_persona_id);
                      $arr_persona_id = array();
                    }

                    $html_table_body .= '<tr>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;"><img width="100" height="100" src="'.$value->foto.'"/></td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->area.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->nombres.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->dni.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->cargo.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->regimen.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->faltas.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->tardanza.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->lic_sg.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->sancion_dici.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->lic_sindical.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->descanso_med.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->min_permiso.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->comision.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->citacion.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->essalud.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->permiso.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->compensatorio.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->onomastico.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->cant_act.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->tareas.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->total_tramites.'</td>
                                      <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$value->docu.'</td>
                                    </tr>';                      
    
                } // Cierra for Reporte  

                    $perso = DB::table('personas')
                                  ->select('area_id', 'id', DB::raw("IFNULL(email, '') as email"), 'email_mdi', DB::raw("CONCAT_ws(' ', paterno, materno, nombre) AS nombres"))
                                  ->where('estado', '1')
                                  ->whereIn('rol_id', [9, 8])
                                  ->whereIn('id', $arr_persona_id)
                                  ->get();

                    if (count($perso) > 0) 
                    {
                      $nombre_jefe = $perso[0]->nombres;
                      if(trim($perso[0]->email) != '')
                          $correo_jefe = trim($perso[0]->email);
                      else
                          $correo_jefe = ''; // Caso no tenga correo

                      if(trim($perso[0]->email_mdi) != '')
                          $correo_jefe_copia = trim($perso[0]->email_mdi);
                      else
                          $correo_jefe_copia = '';
                      
                      $html_table = $html_table_header.$html_table_body.$html_table_footer;
                      // --
                      $email = $correo_jefe;
                      $email_copia = $correo_jefe_copia;

                      $nota = '<br>
                                <div style="padding: 5px 5px;  font-size: 12px; overflow:hidden; border:2px solid #EAE8E7; border-radius:5px;">
                                  <p>
                                  <strong>NOTA:</strong><br/>
                                    Se recomienda no incumplir las normas del trabajo, para una mejor calificación para usted.
                                  </p>
                                </div>';

                      $plantilla = Plantilla::where('tipo', '=', '13')->first();
                      $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'persona:', 'tabla:', 'Nota:');
                      $reemplazar = array('<b>'.$nombre_jefe.'</b>', date('d'), $meses[date('n')], date("Y"), 'Rusbel Arteaga', $html_table, $nota);
                      $parametros = array(
                          'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
                      );
                      //echo 'email '.$email;
                      if ($email != '' && $html_table_body!='') {
                          try {
                              Mail::send('notreirel', $parametros, function($message) use ($email, $email_copia) {
                                              $message->to($email);
                                              if($email_copia != ''){
                                                 $message ->cc($email_copia);
                                              }
                                                 $message->subject('.:: Reporte de Asistencia de Personal ::.');
                                  }
                              );
                          } catch (Exception $e) {
                              //echo $qem[$k]->email."<br>";
                          }
                      }                        
                    }
                    
          // DB::commit();
        }

        $retorno["data"] = $html;
        return Response::json($retorno);
    }
    
    // 2018-01-03
    public function postReportepersonaladm()
    {
        $array = array();
        $array['usuario'] = Auth::user()->id;
        $retorno = array('rst' => 1);        

        $html="";
        $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $n = 1;
        $hoy = date('Y-m-d');
        
        $dia_validar = date('w', strtotime($hoy));
        if ( $dia_validar == 2 OR $dia_validar == 3 OR $dia_validar == 4 OR $dia_validar == 5 OR $dia_validar == 6) // Proceso ejecuta L - V
        {
            DB::beginTransaction();
            // --
            ini_set('max_execution_time', 300);

            $fecha_ini = date('Y/m/d', strtotime('-1 day')); // 2017/09/01
            $fecha_fin = date('Y/m/d', strtotime('-1 day')); // 2017/09/15
            $area_ws = ''; // 240000 = Modernización

            $dias=20-1;
            $fecha_i = str_replace('/', '-', $fecha_ini);
            $fecha_f = str_replace('/', '-', $fecha_fin);
            $fecha_iaux =$fecha_i;
            $fecha_faux = date("Y-m-d", strtotime($fecha_i ."+".$dias." days"));

            if($area_ws <> 0)
                $bus_area = "&area=".$area_ws;
            else
                $bus_area = "";
            
            DB::table('sw_asistencias')->where('usuario_created_at', '=', Auth::user()->id)->delete();

            while ( $fecha_iaux <= $fecha_f ) {
                
                if( $fecha_faux>$fecha_f ){
                    $fecha_faux=$fecha_f;
                }

                $fini=date("Y/m/d",strtotime($fecha_iaux));
                $ffin=date("Y/m/d",strtotime($fecha_faux));

                $res = file_get_contents("http://10.0.120.13:8088/spersonal/consulta.php?inicio=".$fini.""."&fin=".$ffin.$bus_area);
                $result = json_decode(utf8_encode($res));

                foreach($result->reporte as $key => $lis) 
                {
                    
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

                   
                }

                $fecha_iaux= date("Y-m-d", strtotime($fecha_faux ."+1 days"));
                $fecha_faux= date("Y-m-d", strtotime($fecha_iaux ."+".$dias." days"));
            }

            $sql = "UPDATE sw_asistencias sa
                        INNER JOIN personas p ON sa.dni=p.dni
                        SET sa.persona_id = p.id;";
            DB::update($sql);

            DB::table('sw_asistencias')
                ->whereNull('persona_id')
                ->update(array('persona_id' => 1272));
            // --


            $Ssql = "SELECT sw.*,
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
                                AND rdv.updated_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                GROUP BY rdv.usuario_updated_at
                        ) AS t ON t.persona_id=sw.persona_id
                        LEFT JOIN (SELECT ROUND((SUM(ap.ot_tiempo_transcurrido) / 60), 2) cant_act, ap.persona_id
                                FROM actividad_personal ap
                                WHERE ap.persona_id=ap.usuario_created_at
                                AND ap.fecha_inicio BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                GROUP BY ap.persona_id
                            ) AS ca ON ca.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(r.id) total_tramites, r.usuario_created_at persona_id
                                FROM rutas r
                                WHERE r.created_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                AND r.estado=1
                                GROUP BY r.usuario_created_at
                            ) AS tt ON tt.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(dd.id) docu, dd.usuario_created_at persona_id
                                FROM doc_digital_temporal dd
                                WHERE dd.created_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                AND dd.estado = 1
                                GROUP BY dd.usuario_created_at
                            ) AS doc ON doc.persona_id=sw.persona_id; ";
            $reporte = DB::select($Ssql);

            
            foreach ($reporte as $val)
            {
              $acu_asiste = 0;
              $html_table = '';
              $acu_asiste = $acu_asiste + $val->faltas;
              $acu_asiste = $acu_asiste + $val->tardanza;
              $acu_asiste = $acu_asiste + $val->lic_sg;
              $acu_asiste = $acu_asiste + $val->sancion_dici;
              $acu_asiste = $acu_asiste + $val->lic_sindical;
              $acu_asiste = $acu_asiste + $val->descanso_med;
              $acu_asiste = $acu_asiste + $val->min_permiso;
              $acu_asiste = $acu_asiste + $val->comision;
              $acu_asiste = $acu_asiste + $val->citacion;
              $acu_asiste = $acu_asiste + $val->essalud;
              $acu_asiste = $acu_asiste + $val->permiso;
              $acu_asiste = $acu_asiste + $val->compensatorio;
              $acu_asiste = $acu_asiste + $val->onomastico;
              
              if($acu_asiste > 0)
              {
                  $html_table = '<table border="0" cellspacing="0" style="font-size: 11px; overflow:hidden; border:2px solid #EAE8E7; background:#fefefe; border-radius:5px;">
                                  <thead>
                                    <tr>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#009A0D), to(#e8eaeb));" colspan="6">DATOS PERSONALES</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#0D7BE8), to(#e8eaeb));" colspan="7">DETALLES DE ASISTENCIA</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#935799), to(#e8eaeb));" colspan="6">PERMISOS / PAPELETAS</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#CC9C0D), to(#e8eaeb));" colspan="4">PROCESO FLUJOS</th>
                                    </tr>
                                    <tr>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Foto</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Area</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Nombres</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Dni</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Cargo / Puesto</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Regimen Lab.</th>      
                                      
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Faltas</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Trd</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Lic S.G</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Sancion Dici</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Lic. Sindical</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Dcso. Med</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Min. Perm</th>
                                      
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Com.</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Cit.</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Essld</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Perm</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Compem</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Ono</th>

                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">H.Act.</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Tarea</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">T.Trami</th>
                                      <th style="padding:3px 10px 3px; text-align:center; padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;">Doc</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                  
                  $html_table .= '<tr>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;"><img width="100" height="100" src="'.$val->foto.'"/></td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->area.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->nombres.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->dni.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->cargo.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->regimen.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->faltas.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->tardanza.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->lic_sg.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->sancion_dici.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->lic_sindical.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->descanso_med.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->min_permiso.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->comision.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->citacion.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->essalud.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->permiso.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->compensatorio.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->onomastico.'</td>

                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->cant_act.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->tareas.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->total_tramites.'</td>
                                    <td style="padding:5px 10px 3px; text-align:center; border-top:1px solid #fefefe; border-right:1px solid #fefefe;">'.$val->docu.'</td>
                                  </tr>';

                  $html_table .= '</tbody>
                                </table>';                
                                            
                  $persona = Persona::where('personas.id','=',$val->persona_id)
                                    ->select(DB::raw("IFNULL((SELECT p2.email_mdi
                                             FROM personas p2 
                                             where p2.area_id=personas.area_id
                                             and p2.rol_id in (9,8)
                                             and p2.estado=1
                                             LIMIT 0,1),'') as email_jefe"),'personas.id','personas.email_mdi')->first();
          
                  if(trim($persona->email_jefe) != '')
                      $email_copia = trim($persona->email_jefe);
                  else
                      $email_copia = '';

                  if(trim($persona->email_mdi) != '')
                      $email = trim($persona->email_mdi);
                  else
                      $email = '';

//                  $email='rcapchab@gmail.com';
//                  $email_copia='';
                  // --
                              
                  $nota = '<br>
                            <div style="padding: 5px 5px;  font-size: 12px; overflow:hidden; border:2px solid #EAE8E7; border-radius:5px;">
                              <p>
                              <strong>NOTA:</strong><br/>
                                Se recomienda no incumplir las normas del trabajo, para una mejor calificación para usted.
                              </p>
                            </div>';


                  $plantilla = Plantilla::where('tipo', '=', '13')->first();
                  $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'persona:', 'tabla:', 'Nota:');
                  $reemplazar = array('<b>'.ucwords($val->nombres).'</b>', date('d'), $meses[date('n')], date("Y"), 'Rusbel Arteaga', $html_table, $nota);
                  $parametros = array(
                      'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
                  );        

                    $alertanotiadm= new AlertaNotificacionAdm;
                    $alertanotiadm->persona_id = $val->persona_id;
                    $alertanotiadm->dni = $val->dni;
                    $alertanotiadm->faltas = $val->faltas;
                    $alertanotiadm->tardanza = $val->tardanza;
                    $alertanotiadm->lic_sg = $val->lic_sg;
                    $alertanotiadm->sancion_dici = $val->sancion_dici;
                    $alertanotiadm->lic_sindical = $val->lic_sindical;
                    $alertanotiadm->descanso_med = $val->descanso_med;
                    $alertanotiadm->min_permiso = $val->min_permiso;
                    $alertanotiadm->comision = $val->comision;
                    $alertanotiadm->citacion = $val->citacion;
                    $alertanotiadm->essalud = $val->essalud;
                    $alertanotiadm->permiso = $val->permiso;
                    $alertanotiadm->compensatorio = $val->compensatorio;
                    $alertanotiadm->onomastico = $val->onomastico;
                    $alertanotiadm->estado = 1;
                    $alertanotiadm->usuario_created_at = Auth::user()->id;
                    $alertanotiadm->save();

                  if ($email != '')
                  {
                     
                      try {
                          Mail::send('notreirel', $parametros, function($message) use ($email, $email_copia) {
                                  $message
                                          ->to($email);
                                          if($email_copia != ''){
                                             $message ->cc($email_copia);
                                          }
                                          $message->subject('.:: Reporte de Asistencia de Personal ::.');
                              }
                          );
                      } catch (Exception $e) {
                          //echo $qem[$k]->email."<br>";
                         
                      }
                   
                  }
              } // Cierra IF
            }
            DB::commit();
        }

        $retorno["data"] = $html;
        return Response::json($retorno);
    }
    // --
    

    public function postActividadesdiariasalertasjefe() {
        $array = array();
        $array['usuario'] = Auth::user()->id;

        $retorno = array(
            'rst' => 1
        );

        $html = "";
        $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $n = 1;

        $hoy = date('Y-m-d');
        $dia_validar = date('w', strtotime($hoy));
        if ($dia_validar == 1) {

            $listar = Area::getAreaNotificacion();
           
            foreach ($listar as $value) {
                
            $fechaFin = strtotime('-1 day', strtotime($hoy));
            $fechaFin = date('Y-m-d', $fechaFin);
            $fechaIni = strtotime('-7 day', strtotime($hoy));
            $fechaIni = date('Y-m-d', $fechaIni);

            $sSql = '';
            $sSqls = '';
            $cl = '';
            $left = '';
            $validar = [];
            $f_fecha = '';
            $cabecera = [];

            $f_fecha .= " AND DATE(ap.fecha_inicio) BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "' ";


            $fechaIni_ = strtotime($fechaIni);
            $fechaFin_ = strtotime($fechaFin);
            $fecha = date_create($fechaIni);
            $n = 1;
            for ($i = $fechaIni_; $i <= $fechaFin_; $i += 86400) {
                $cl .= ",COUNT(ap$n.id) AS f$n,IFNULL(SEC_TO_TIME(ABS(SUM(ap$n.ot_tiempo_transcurrido)) * 60),'00:00')  h$n, IFNULL(SUM(ap$n.ot_tiempo_transcurrido),0) v$n,ExoneraFecha(STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y'),p.id) as e$n";
                $left .= "LEFT JOIN actividad_personal ap$n on ap$n.id=ap.id AND  DATE(ap.fecha_inicio) = STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y')";
                $n++;
                array_push($validar,date('w', strtotime(date_format($fecha, 'Y-m-d'))));
                array_push($cabecera, date_format($fecha, 'Y-m-d'));
                date_add($fecha, date_interval_create_from_date_string('1 days'));
            }

            $sSql .= "SELECT a.nombre as area,CONCAT_WS(' ',p.paterno,p.materno,p.nombre) as persona,p.envio_actividad ";
            $sSql .= $cl;
            $sSql .= ",COUNT(ap.id) AS f_total,IFNULL(SEC_TO_TIME(ABS(SUM(ap.ot_tiempo_transcurrido)) * 60),'00:00')  h_total";
            $sSql .= " FROM personas p
                 INNER JOIN areas a on p.area_id=a.id
                 LEFT JOIN actividad_personal ap on ap.persona_id=p.id AND ap.estado=1 AND ap.usuario_created_at=ap.persona_id " . $f_fecha;
            $sSql .= $left;
            $sSql .= " WHERE p.estado=1 AND p.rol_id NOT IN (8,9)";


            $sSql .= " AND (p.area_id=".$value->id." OR FIND_IN_SET(p.area_id,
                        (SELECT p2.area_responsable
                         FROM personas p2 
                         WHERE p2.rol_id IN (6,8,9) AND p2.estado=1 AND p2.area_id=".$value->id."
                        )))";

            $sSql .= " GROUP BY p.id";
            
            $oData['cabecera'] = $cabecera;
            $oData['validar'] = $validar;
            $oData['data'] = DB::select($sSql);
            

//                foreach ($actividades as $value) {

            $html = "";
            $html_cabecera = "";
            $html_table = "";
            $pos = 0;
            $html_cabecera .= "<tr>";
            $html_cabecera .= "<th colspan='2'></th>";
            $n = 0;
            foreach ($oData['cabecera'] as $cabecera) {

                $html_cabecera .= "<th colspan='2'>" . $cabecera . "</th>";
                $n++;
            }
            $html_cabecera .= "<th colspan='2'>TOTAL</th>";
            $html_cabecera .= "</tr>";

            $html_cabecera .= "<tr>";
            $html_cabecera .= "<th>N°</th>";
//                $html_cabecera .= "<th>Area</th>";
            $html_cabecera .= "<th>Persona</th>";
            $n = 0;
            foreach ($oData['cabecera'] as $cabecera) {

                $html_cabecera .= "<th >N° A.</th>";
                $html_cabecera .= "<th >N° H.</th>";
                $n++;
            }

            $html_cabecera .= "<th>N° Acti. Total</th>";
            $html_cabecera .= "<th>Total de Horas</th>";
            $html_cabecera .= "</tr>";

            $array = json_decode(json_encode($oData['data']), true);
            $validar = json_decode(json_encode($oData['validar']), true);
            foreach ($array as $data) {
                $pos++;
                $html .= "<tr>";
                $html .= "<td>" . $pos . "</td>";
//                     $html .="<td>" . $data->area . "</td>" ;
                $html .= "<td>" . $data['persona'] . "</td>";

                for ($i = 1; $i <= $n; $i++) {
                    $hora = $data['h' . $i];
                    if($data['v'.$i]>=360 or $data['envio_actividad']==0 or $data['e'.$i]>=1){
                        $style=';background-color:#7BF7AE';
                    }
                    else if($data['v'.$i]>0 AND $data['v'.$i]<360 AND $data['envio_actividad']==1){
                        $style=';background-color:#FFA027';
                    }
                    else if($data['v'.$i]==0 AND $data['envio_actividad']==1){
                        $style=';background-color:#FE4E4E';   
                    }
                    if(($validar[$i-1]==6 || $validar[$i-1]==0) && ($data['envio_actividad']!=0 && $data['e'.$i]!=1)){
                        $style=';background-color:#ffff66';   
                    }
                    
                    $html .= '<td style="' . $style . '">' . $data['f' . $i] . '</td>';
                    $html .= '<td style="' . $style . '">' . $hora . "</td>";
                }

                $hora_t = substr($data['h_total'], 0, 5);

                $html .= '<td>' . $data['f_total'] . "</td>";
                $html .= '<td>' . $hora_t . "</td>";


                $html .= "</tr>";
            }
            $html_table .= '<table border="1" cellspacing="0">  ';
            $html_table .= ' <thead>';
            $html_table .= $html_cabecera;
            $html_table .= ' </thead>';
            $html_table .= '<tbody>';
            $html_table .= $html;
            $html_table .= '</tbody>';
            $html_table .= '</table >';
            
//                }
             $sSqls.= "  SELECT CONCAT_WS(' ',p.paterno,p.materno,p.nombre)as persona,IFNULL(CONCAT(p.email,',',p.email_mdi),',') as email_jefe,a.nombre as area,
			(SELECT CONCAT(email,',',email_mdi)
                         FROM personas 
                         where area_id in (53)
                         and rol_id in (9,8)
                         and estado=1
                         order by area_id
                         LIMIT 0,1) email_personal
                         FROM personas p
			 INNER JOIN areas a on p.area_id=a.id
                         where area_id=".$value->id;
                     
              $sSqls.= " and rol_id in (9,8)
                         and p.estado=1
                         LIMIT 0,1";

            $jefe = DB::select($sSqls);
            
            $plantilla = Plantilla::where('tipo', '=', '10')->first();
            $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'persona:', 'tabla:');
            $reemplazar = array('<b>'.$jefe[0]->persona.' - '.$jefe[0]->area.'</b>', date('d'), $meses[date('n')], date("Y"),$jefe[0]->persona,$html_table);
            $parametros = array(
                'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
            );
            
            $emailpersonal = explode(",", $jefe[0]->email_personal);
            $emailjefe = array();
            $emailjefeauxi = explode(",", $jefe[0]->email_jefe);
            
            
            if (trim($emailjefeauxi[0]) != '') {
                array_push($emailjefe, $emailjefeauxi[0]);
            }
            if (trim($emailjefeauxi[1]) != '') {
                array_push($emailjefe, $emailjefeauxi[1]);
            }

//            $emailpersonal = 'rcapchab@gmail.com';
//            $emailjefe = array('rcapchab@gmail.com'); 


            DB::beginTransaction();

//                $update = 'update alertas_actividad set ultimo_registro=0 where persona_id=' . $value->persona_id;
//                DB::update($update);
//                
//                $insert = 'INSERT INTO alertas_actividad (persona_id,area_id,actividad, minuto, fecha_alerta) 
//                     VALUES (' . $value->persona_id . ',' . $value->area_id . ',' . $value->actividad . ',' . $value->minuto . ',"' . date("Y-m-d h:m:s") . '")';
////                echo $insert;
//                DB::insert($insert);

            try {
                Mail::send('notreirel', $parametros, function($message) use ($emailpersonal, $emailjefe) {
                    $message
                            ->to($emailjefe)
                            ->cc($emailpersonal)
                            ->subject('.::Aviso de Actividad de la Semana::.');
                }
                );
            } catch (Exception $e) {
                //echo $qem[$k]->email."<br>";
                DB::rollback();
            }
            DB::commit();

            $n++;
           }
        }
        $retorno["data"] = $html_table;

        return Response::json($retorno);
    }

    public function postActividadesdiariasalertas() {
        $array = array();
        $array['usuario'] = Auth::user()->id;

        $retorno = array(
            'rst' => 1
        );

        $html = "";
        $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $n = 1;
        $hoy = date('Y-m-d');
        $ayer = strtotime('-1 day', strtotime($hoy));
        $ayer = date('Y-m-d', $ayer);

        $dia_validar = date('w', strtotime($hoy));
        
        $fecha_no_laborable = 'select count(id) as cantidad
                                from fechas_laborables
                                where fecha="'. $ayer.'" and estado=1';
        $estado_fecha = DB::select($fecha_no_laborable);

        if($estado_fecha[0]->cantidad==0){
        if ( $dia_validar == 2 OR $dia_validar == 3 OR $dia_validar == 4 OR $dia_validar == 5 OR $dia_validar == 6) {

            $Ssql = "SELECT p.id as persona_id,p.area_id,a.nombre as area,
                    CONCAT_WS(' ',p.paterno,p.materno,p.nombre) as persona, p.email,p.email_mdi,
                    COUNT(ap.id) AS 'actividad',IFNULL(SUM(ap.ot_tiempo_transcurrido),0) as 'minuto',
                    IF(COUNT(ap.id)>=5,1,0) as val_acti,
                    IF(IFNULL(SUM(ap.ot_tiempo_transcurrido),0)>=360,1,0) as val_minu,
                     (SELECT CONCAT(email,',',email_mdi)
                         FROM personas 
                         where area_id in (53)
                         and rol_id in (9,8)
                         and estado=1
                         order by area_id
                         LIMIT 0,1) email_personal,
                       IFNULL((SELECT CONCAT(email,',',email_mdi)
                         FROM personas 
                         where area_id=p.area_id
                         and rol_id in (9,8)
                         and estado=1
                         LIMIT 0,1),',') email_jefe
                    FROM personas p
                    INNER JOIN areas a on p.area_id=a.id and area_gestion=1
                    LEFT JOIN actividad_personal ap on ap.persona_id=p.id  and DATE(ap.fecha_inicio)= '$ayer' AND ap.usuario_created_at=ap.persona_id AND ap.estado=1
                    WHERE p.estado=1 
                    AND p.rol_id NOT IN (8,9)
                    AND p.envio_actividad=1
                    AND IFNULL(p.modalidad,1)!=2
                    AND '$ayer' NOT BETWEEN DATE(IFNULL(p.fecha_ini_exonera,CURDATE()))  AND DATE(IFNULL(p.fecha_fin_exonera,CURDATE()))
                    GROUP BY p.id
                    HAVING val_minu=0";

            $actividades = DB::select($Ssql);

            foreach ($actividades as $value) {

                $html .= "<tr>";
                $html .= "<td>" . $n . "</td>";
                $html .= "<td>" . $value->area . "</td>";
                $html .= "<td>" . $value->persona . "</td>";
                $html .= "<td>" . $value->actividad . "</td>";
                $html .= "<td>" . $value->minuto . "</td>";
                $html .= "<td>" . $value->email_mdi . "</td>";
                $html .= "</tr>";
                $texto = '';

                if ($value->minuto > 0) {
                    $texto = 'Ud. incumplió con la responsabilidad de registrar la cantidad mínima de minutos la cual es: 480 minutos por día (8 horas). Usted ha registrado: ' . $value->minuto . ' minuto(s).';
                }
                
                if ($value->minuto == 0) {
                    $texto = 'Ud. incumplió con la responsabilidad de registrar sus actividades, la cantidad mínima de minutos es: 480 minutos por día (8 horas). Usted ha registrado: ' . $value->minuto . ' minuto(s).';
                }
//                if ($value->val_acti == 0 AND $value->val_minu == 1) {
//                    $texto = 'la cantidad mínima de actividades la cual es 5 actividades por día. Usted ha registrado: '.$value->actividad.' actividad(es).';
//                }
//                if ($value->val_acti == 0 AND $value->val_minu == 0) {
//                    $texto = 'la cantidad mínima de actividades y minutos la cual es: 360 minutos por día (6 horas) y 5 actividades por día.'
//                            . ' Usted ha registrado: '.$value->minuto.' minuto(s) y '.$value->actividad.' actividad(es).';
//                }

                $plantilla = Plantilla::where('tipo', '=', '9')->first();
                $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'persona:', 'fechaayer:', 'actividades:');
                $reemplazar = array('<b>'.$value->persona.' - '.$value->area.'</b>', date('d'), $meses[date('n')], date("Y"), $value->persona, $ayer, $texto);
                $parametros = array(
                    'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
                );

                $email = array();
                if (trim($value->email_mdi) != '') {
                    array_push($email, $value->email_mdi);
                }
                if (trim($value->email) != '') {
                    array_push($email, $value->email);
                }
                $emailpersonal = explode(",", $value->email_personal);


                $emailjefe = array();
                $emailjefeauxi = explode(",", $value->email_jefe);

                if (trim($emailjefeauxi[0]) != '') {
                    array_push($emailjefe, $emailjefeauxi[0]);
                }
                if (trim($emailjefeauxi[1]) != '') {
                    array_push($emailjefe, $emailjefeauxi[1]);
                }

//                $email = 'rcapchab@gmail.com';
//                $emailpersonal = 'rcapchab@gmail.com';
//                $emailjefe=array('rcapchab@gmail.com');

                DB::beginTransaction();

                $update = 'update alertas_actividad set ultimo_registro=0 where persona_id=' . $value->persona_id;
                DB::update($update);

                $insert = 'INSERT INTO alertas_actividad (persona_id,area_id,actividad, minuto, fecha_alerta) 
                     VALUES (' . $value->persona_id . ',' . $value->area_id . ',' . $value->actividad . ',' . $value->minuto . ',"' . date("Y-m-d h:m:s") . '")';
//                echo $insert;
                DB::insert($insert);

                try {
                    Mail::send('notreirel', $parametros, function($message) use ($email, $emailjefe) {
                        $message
                                ->to($email)
                                ->cc($emailjefe)
                                ->subject('.::Aviso de Actividad::.');
                    }
                    );
                } catch (Exception $e) {
                    //echo $qem[$k]->email."<br>";
                    DB::rollback();
                }
                DB::commit();

                $n++;
            }
        }
        }
        $retorno["data"] = $html;

        return Response::json($retorno);
    }

    public function postContratacionesalertas() { //Envia correos masivos
        $array = array();
        $array['usuario'] = Auth::user()->id;

        $retorno = array(
            'rst' => 1
        );

        $html = "";
        $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $n = 1;

        $Ssql = "SELECT c.id,c.area_id,1 as titulo,c.titulo as descripcion,a.nombre as area,CONCAT(p.paterno,' ',p.materno,' ',p.nombre) as persona,p.id persona_id,1 as tipo,
                p.email,p.email_mdi,c.fecha_aviso,c.programacion_aviso,c.fecha_inicio,c.fecha_fin
                FROM contratacion c
                INNER JOIN areas a on c.area_id=a.id
                INNER JOIN personas p on p.area_id=a.id and rol_id in (9,8) 
                LEFT JOIN alertas_contratacion ac ON ac.general_id=c.id AND ac.tipo_id=1 AND ac.ultimo_registro=1
                WHERE c.estado=1 
                AND 
                (c.fecha_aviso=curdate() OR
                ADDDATE(ac.fecha_alerta,INTERVAL c.programacion_aviso day)=curdate()
                ) AND  ISNULL(c.fecha_conformidad)

                UNION

                SELECT cr.id,c.area_id,c.titulo,cr.texto,a.nombre as area,CONCAT(p.paterno,' ',p.materno,' ',p.nombre) as persona,p.id persona_id,2 as tipo,
                p.email,p.email_mdi,cr.fecha_aviso,cr.programacion_aviso,cr.fecha_inicio,cr.fecha_fin
                FROM contra_reque cr
                INNER JOIN contratacion c on cr.contratacion_id=c.id
                INNER JOIN areas a on c.area_id=a.id
                INNER JOIN personas p on p.area_id=a.id and rol_id in (9,8) 
                LEFT JOIN alertas_contratacion ac ON ac.general_id=cr.id AND ac.tipo_id=2 AND ac.ultimo_registro=1
                WHERE  cr.estado=1 AND 
                (cr.fecha_aviso=curdate() OR
                ADDDATE(ac.fecha_alerta,INTERVAL cr.programacion_aviso day)=curdate()
                ) AND  ISNULL(cr.fecha_conformidad)";

        $contratacion = DB::select($Ssql);

        $sql = 'select area_id,id,email, email_mdi
            from personas
            where area_id in (29)
            and rol_id in (9,8)
            and estado=1
            order by area_id;';
        $e = DB::select($sql);

        foreach ($contratacion as $value) {

            $html .= "<tr>";
            $html .= "<td>" . $n . "</td>";
            $html .= "<td>" . $value->descripcion . "</td>";
            $html .= "<td>" . $value->area . "</td>";
            $html .= "<td>" . $value->persona . "</td>";
            $html .= "<td>" . $value->email . "</td>";
            $html .= "<td>" . $value->email_mdi . "</td>";
            $html .= "</tr>";
            if ($value->tipo == 1) {
                $contratacion = 'Contratación: ' . $value->descripcion;
                $descripcion = 'Contratación con el titulo; ' . $value->descripcion;
                'mencionado arriba.';
                $fechafin = $value->fecha_fin;
            }
            if ($value->tipo == 2) {
                $contratacion = 'Detalle de Contratación: ' . $value->descripcion;
                $descripcion = 'Detalle de Contratación: ' . $value->descripcion;
                $fechafin = $value->fecha_fin . ', correspondiente a la Contratación: ' . $value->titulo;
            }

            $plantilla = Plantilla::where('tipo', '=', '5')->first();
            $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'contratacion:', 'descripcion:', 'fechainicio:', 'fechafinal:');
            $reemplazar = array($value->persona, date('d'), $meses[date('n')], date("Y"), $contratacion, $descripcion, $value->fecha_inicio, $fechafin);
            $parametros = array(
                'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
            );

            $email = $value->email;
            $email_copia = [$e[0]->email, $e[0]->email_mdi];

//        $email='rcapchab@gmail.com';
//        $email_copia='consultas.gmgm@gmail.com';
            if ($email != '') {

                DB::beginTransaction();
                $update = 'update alertas_contratacion set ultimo_registro=0
                     where general_id=' . $value->id . ' and tipo_id=' . $value->tipo;
                DB::update($update);

                $insert = 'INSERT INTO alertas_contratacion (persona_id,area_id,tipo_id,general_id,fecha_alerta) 
                     VALUES (' . $value->persona_id . ',' . $value->area_id . ',' . $value->tipo . ',' . $value->id . ',"' . date("Y-m-d") . '")';
                DB::insert($insert);

                try {
                    Mail::send('notreirel', $parametros, function($message) use ($email, $email_copia) {
                        $message
                                ->to($email)
                                ->cc($email_copia)
                                ->subject('.::Notificación::.');
                    }
                    );
                } catch (Exception $e) {
                    //echo $qem[$k]->email."<br>";
                    DB::rollback();
                }
                DB::commit();
            }
            $n++;
        }
        $retorno["data"] = $html;

        return Response::json($retorno);
    }

    public function postNotidocplataformaalertas() {
        $array = array();
        $array['usuario'] = Auth::user()->id;
        $array['limit'] = '';
        $array['order'] = '';
        $array['id_union'] = '';
        $array['id_ant'] = '';
        $array['referido'] = ' LEFT ';
        $array['solicitante'] = '';
        $array['areas'] = '';
        $array['proceso'] = '';
        $array['tiempo_final'] = '';

        $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $n = 1;

        $rst = Reporte::Docplataformaalertaenvio();

        foreach ($rst as $key => $value) {

            $alerta = explode("|", $value->alerta);
            $texto = "";
            $tipo = 0;
            $tipo_plat = 0;

            DB::beginTransaction();

            if ($alerta[1] == '') {
                $tipo = 1;
                $tipo_plat = 6;
                $texto = ".::Notificación::.";
            } elseif ($alerta[1] != '' AND $alerta[1] == 1) {
                $tipo = $alerta[1] + 1;
                $tipo_plat = 7;
                $texto = ".::Reiterativo::.";
            } elseif ($alerta[1] != '' AND $alerta[1] == 2) {
                $tipo = $alerta[1] + 1;
                $texto = ".::Relevo::.";
                $tipo_plat = 8;
            } elseif ($alerta[1] != '' AND $alerta[1] == 3) {
                $tipo = 1;
                $texto = ".::Notificación::.";
                $tipo_plat = 6;
            }

            $retorno['texto'][] = $texto;
            $retorno['tipo'][] = $tipo;

            if (trim($alerta[0]) == '' OR $alerta[0] != DATE("Y-m-d")) {
                $retorno['retorno'] = $alerta[0];
                $plantilla = Plantilla::where('tipo', '=', $tipo_plat)->first();
                $buscar = array('persona:', 'dia:', 'mes:', 'año:', 'tramite:', 'area:');
                $reemplazar = array($value->persona, date('d'), $meses[date('n')], date("Y"), $value->plataforma, $value->area);
                $parametros = array(
                    'cuerpo' => str_replace($buscar, $reemplazar, $plantilla->cuerpo)
                );

//            $value->email_mdi='jorgeshevchenk1988@gmail.com';
//            $value->email='rcapchab@gmail.com';
//            $value->email_seguimiento='jorgeshevchenk@gmail.com,jorgesalced0@gmail.com';

                $email = array();
                if (trim($value->email_mdi) != '') {
                    array_push($email, $value->email_mdi);
                }
                if (trim($value->email) != '') {
                    array_push($email, $value->email);
                }
                $emailseguimiento = explode(",", $value->email_seguimiento);
                try {
                    if (count($email) > 0) {

                        Mail::send('notreirel', $parametros, function($message) use( $email, $emailseguimiento, $texto ) {
                            $message
                                    ->to($email)
                                    ->cc($emailseguimiento)
                                    ->subject($texto);
                        }
                        );
                        $alerta = new Alerta;
                        $alerta['ruta_id'] = $value->ruta_id;
                        $alerta['ruta_detalle_id'] = $value->ruta_detalle_id;
                        $alerta['persona_id'] = $value->persona_id;
                        $alerta['tipo'] = $tipo;
                        $alerta['fecha'] = DATE("Y-m-d");
                        $alerta['clasificador'] = 2;
                        $alerta->save();
                        $retorno['persona_id'][] = $value->persona_id;
                    }
                } catch (Exception $e) {
                    DB::rollback();
                    $retorno['id_union'][] = $value->plataforma;
                    //echo $qem[$k]->email."<br>";
                }
                DB::commit();
            }
        }

        return Response::json(
                        array(
                            'rst' => 1,
                            'datos' => $rst
                        )
        );
    }

    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /prueba/create
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /prueba
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     * GET /prueba/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /prueba/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /prueba/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /prueba/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
