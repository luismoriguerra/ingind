<?php

class IndedocsController extends \BaseController {

        
    public function postListadocumentosindedocs()
    {
      
      $area=Auth::user()->area_id;
      //$area=32;
      $AreaIntera=AreaInterna::where('area_id','=',$area)->first();
      $tipoDocumento=Input::get('tipo_documento');
      $fecha=Input::get('fechaI');
        $buscar=array('-');
        $reemplazar=array('.');
        $fechaActualizada=str_replace($buscar, $reemplazar, $fecha);
      
      $retorno=array(
                  'rst'=>1
               );

      $url ='https://www.muniindependencia.gob.pe/repgmgm/index.php?opcion=documento&area='.$AreaIntera->area_id_indedocs.'&tipo='.$tipoDocumento.'&fecha='.$fechaActualizada;
      $curl_options = array(
                    //reemplazar url 
                    CURLOPT_URL => $url,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_FOLLOWLOCATION => TRUE,
                    CURLOPT_ENCODING => 'gzip,deflate',
            );
 
            $ch = curl_init();
            curl_setopt_array( $ch, $curl_options );
            $output = curl_exec( $ch );
            curl_close($ch);

      $r = json_decode(utf8_encode($output),true);
      
      $html="";
      
      
      $n=1;
       if(isset($r["documento"]) AND count($r["documento"])>0){
      foreach ($r["documento"] as $rr) {
        $buscar=array(' - ');
        $reemplazar=array('-');
        $valor=str_replace($buscar, $reemplazar, $rr["Docu_cabecera"]);
        $html.="<tr>";
        $html.="<td>".$n."</td>";
        $html.="<td>".$valor."</td>";
        $html.='<td> <a class="btn btn-success" onClick="cargarNroDoc(\''.$valor.'\',\''.$rr["Documento_id"].'\')" data-toggle="modal" data-target="#indedocsModal">
                                                    <i class="fa fa-check fa-lg"></i>
                                                </a></td>';
        $html.="</tr>";
         $n++;
      }
       }
       if(!isset($r["documento"]) AND count($r["documento"])<1) {
         $html.="<h3 style='color:blue'><center>IndeDocs no disponible. Usar el Lápiz para digitar manualmente el Documento</center></h3>";
       }
      $retorno["data"]=$html;

      return Response::json( $retorno );
    }

    public function postListatipodocumentosindedocs()
    {
      $retorno=array(
                  'rst'=>1
               );

      $url ='https://www.muniindependencia.gob.pe/repgmgm/index.php?opcion=tipos';
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
            curl_setopt_array( $ch, $curl_options );
            $output = curl_exec( $ch );
            curl_close($ch);

      $r = json_decode(utf8_encode($output),true);
      
      $html="";
      
      
      $n=1;
      if(isset($r["tipos"]) AND count($r["tipos"])>0){
         foreach ($r["tipos"] as $rr) {
        $html.="<option value='".$rr['documentotipo_id']."'>".$rr['documentotipo_descripcion']."</option>";
      } 
      }
      
      $retorno["data"]=$html;

      return Response::json( $retorno );
    }
    
    
        public function Consulta()
    {
        if ( Request::ajax() ) {
            
            $actividad=Persona::RequestActividades();
            return Response::json(array('rst'=>1,'datos'=>$actividad)); 

        }
	
    }

 }
