<?php

class MapsController extends BaseController
{
  protected $_errorController;
  /**
   * Valida sesion activa
   */
  public function __construct(ErrorController $ErrorController)
  {
      $this->beforeFilter('auth');
      $this->_errorController = $ErrorController;
  }
  

  public function postRutasactivas() //Importante que los nombres de los metodos solo deben ser Mayuscula al iniciar!
  {
      $lat_lng = MapsProcesos::ReporteRALatLng();
      $rst = MapsProcesos::ReporteRutasActivas();
      return Response::json(
          array(
              'rst'=>1,
              'lat_lng'=>$lat_lng,
              'datos'=>$rst
          )
      );
  }
  
  public function postGrabarrutadetamaps()
  {
    if ( Request::ajax() ) {

        if(Input::get('fecha_programada') >= date("Y-m-d")) {
          $mapsrd = new MapsRutaDetalle;
          $mapsrd->ruta_id = Input::get('ruta_id');
          $mapsrd->ruta_detalle_id = Input::get('ruta_detalle_id');
          $mapsrd->carga_incidencia_id = Input::get('carga_incidencia_id');
          $mapsrd->fecha_inicio = Input::get('fecha_inicio');
          $mapsrd->fecha_programada = Input::get('fecha_programada');
          $mapsrd->fecha_histo_progra = '1:'.Input::get('fecha_programada');
          $mapsrd->estado = 1;
          $mapsrd->usuario_created_at = Auth::user()->id;
          $mapsrd->save();

          return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente'));
        } else {
          return Response::json(array('rst'=>2, 'msj'=>'La fecha Programada debe ser mayor a la actual'));
        }
          
    }
  }

  public function postModificarrutadetamaps()
  {
    if ( Request::ajax() ) {

      if(Input::get('fecha_programada') >= date("Y-m-d")) {
        $rdmid = Input::get('id');

        $select = "SELECT fecha_histo_progra 
                    FROM rutas_detalle_mapas
                      WHERE id = ".$rdmid;
        $rutas_detalle_mapas = DB::select($select);
        $fecha_histo_progra = $rutas_detalle_mapas[0]->fecha_histo_progra;

        $arr_fhp = explode("|", $fecha_histo_progra);
        $con = count($arr_fhp);

        $c_fecha_histo_progra = $fecha_histo_progra.'|'.($con+1).':'.Input::get('fecha_programada');
        
        $mapsrd = MapsRutaDetalle::find($rdmid);
        $mapsrd->fecha_programada = Input::get('fecha_programada');
        $mapsrd->fecha_histo_progra = $c_fecha_histo_progra;
        $mapsrd->estado = 1;
        $mapsrd->usuario_updated_at = Auth::user()->id;
        $mapsrd->save();

        return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
      } else {
        return Response::json(array('rst'=>2, 'msj'=>'La fecha Programada debe ser mayor a la actual'));
      }
    }
  }
  
      public function postModificaprogramacion()
  {
        if ( Request::ajax() ) {

        $mapsrd = MapsRutaDetalle::find(Input::get('id'));
        $mapsrd->vehiculo_id = Input::get('vehiculo');
        $mapsrd->persona_id = Input::get('persona_id');
        $mapsrd->usuario_updated_at = Auth::user()->id;
        $mapsrd->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente'));
        }
  }


  public function postListavehiculo() {
        $retorno = array(
            'rst' => 1
        );

        $url = 'http://www.muniindependencia.gob.pe/ceteco/index.php?opcion=moviles';
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_ENCODING => 'gzip,deflate',
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        $output = curl_exec($ch);
        curl_close($ch);

        $r = json_decode(utf8_encode($output), true);

        $html = "";


        $n = 1;
        if (isset($r["moviles"]) AND count($r["moviles"]) > 0) {
            $html .= "<option value=''>.::Seleccione::.</option>";
            foreach ($r["moviles"] as $rr) {
                $html .= "<option value='2'>" . $rr['halcon'] . "</option>";
            }
        }

        $retorno["data"] = $html;

        return Response::json($retorno);
    }
    
          public function postModificaprogramacionmasivo(){
          
        if ( Request::ajax() ) {
            $id = Input::get('id');
            $vehiculo = Input::get('vehiculo');
            $persona_id = Input::get('persona_id');
            for ($i = 0; $i < count($id); $i++) {
                $mapsrd = MapsRutaDetalle::find($id[$i]);
                $mapsrd->vehiculo_id = $vehiculo[$i];
                $mapsrd->persona_id = $persona_id[$i];
                $mapsrd->usuario_updated_at = Auth::user()->id;
                $mapsrd->save();
            }

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente'));
        }
  }


}
