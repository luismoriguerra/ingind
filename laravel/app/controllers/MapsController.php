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
    }
  }

  public function postModificarrutadetamaps()
  {
    if ( Request::ajax() ) {

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
    }
  }

}
