<?php
class ReporteTramiteController extends BaseController
{
    public function postTramiteunico()
    {
      $array=array();
      $fecha='';
      $array['where']='';
      
      if( Input::has('tramite') AND Input::get('tramite')!='' ){
        $tramite=explode(" ",trim(Input::get('tramite')));
        for($i=0; $i<count($tramite); $i++){
          $array['where'].=" AND re.referido LIKE '%".$tramite[$i]."%' ";
        }
      }
      
      $r = ReporteTramite::TramiteUnico( $array );
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$r
          )
      );
    }

    public function postTramitedetalle()
    {
      $array=array();
      $array['where']='';

      if( Input::has('ruta_id') AND Input::get('ruta_id')!='' ){
        $array['where']=" AND r.id=".Input::get('ruta_id')." ";
      }

      $r = ReporteTramite::TramiteDetalle( $array );
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$r
          )
      );
    }
}
