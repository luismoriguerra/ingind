<?php

class AsignacionController extends \BaseController
{
    public function postResponsable()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $rdid=Input::get('ruta_detalle_id');
            $personaId=Input::get('persona_id');
            
            DB::beginTransaction();
            $asignacion=new Asignacion;
            $asignacion['tipo']=1;
            $asignacion['idtipo']=$rdid;
            
            $rutaDetalle=RutaDetalle::find($rdid);
            $asignacion['persona_id_i']=$rutaDetalle->persona_responsable_id;
            $asignacion['persona_id_f']=$personaId;
            $rutaDetalle['persona_responsable_id']=$personaId;
            $rutaDetalle['usuario_updated_at']=Auth::user()->id;
            $rutaDetalle->save();

            $asignacion['usuario_created_at']=Auth::user()->id;
            $asignacion->save();
            DB::commit();
            
            $rpta['rst']=1;
            $rpta['msj']="Responsable Actualizado";
            return Response::json($rpta);
        }
    }

    public function postPersona()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $rdvid=Input::get('ruta_detalle_verbo_id');
            $personaId=Input::get('persona_id');

            DB::beginTransaction();
            $asignacion=new Asignacion;
            $asignacion['tipo']=2;
            $asignacion['idtipo']=$rdvid;

            $rutaDetalleVerbo=RutaDetalleVerbo::find($rdvid);
            $asignacion['persona_id_i']=trim($rutaDetalleVerbo->usuario_updated_at);
            $asignacion['persona_id_f']=$personaId;
            $rutaDetalleVerbo['usuario_updated_at']=$personaId;
            $rutaDetalleVerbo->save();

            $asignacion['usuario_created_at']=Auth::user()->id;
            $asignacion->save();
            DB::commit();

            $rpta['rst']=1;
            $rpta['msj']="Persona Actualizada";
            return Response::json($rpta);
        }
    }

    public function postUploadcargo()
    {
        //si la peticion es ajax
        if ( Request::ajax()){
            ini_set('memory_limit','128M');
            ini_set('set_time_limit', '300');
            ini_set('display_errors', true);
            
            //echo "X:".$_POST['norden'].$_POST['image'];

            //print_r(Input::all());

            $norden = Input::get('norden');
            $mFile = Input::get('image');

            
            $file = 'uc'.$norden;
            $url = "file/actividad/".date("Ymd")."-".$norden;

            if($fileName = $this->fileToFile($mFile,$url)){
                $idUsr = Auth::user()->id;
                $this->resizeImage($fileName,$fileName,1000);
                $mSql = "UPDATE actividad_personal SET cargo_dir = '$fileName', usuario_updated_at='".$idUsr."', updated_at = CURRENT_TIMESTAMP WHERE id = '$norden' LIMIT 1;";
                DB::update($mSql);
                $redimImg = true;
            }
 
            return Response::json(array('result'=>'1','red'=>$redimImg,'ruta'=>$fileName,'norden'=>$norden));
        }
    }

    public function fileToFile($file, $url){

        

        if ( !is_dir('file') ) {
            mkdir('file',0777);
        }
        if ( !is_dir('file/meta') ) {
            mkdir('file/actividad',0777);
        }
        //echo $file;
        list($type, $file) = explode(';', $file);
        list(, $type) = explode('/', $type);
        if ($type=='jpeg') $type='jpg';
        if (strpos($type,'document')!==False) $type='docx';
        if (strpos($type, 'sheet') !== False) $type='xlsx';
        if (strpos($type, 'pdf') !== False) $type='pdf';
        if ($type=='plain') $type='txt';
        list(, $file)      = explode(',', $file);
        $file = base64_decode($file);
        $url = $url.'.'.$type;
        file_put_contents($url , $file);
        return $url;
    } 

    function resizeImage($src,$destination,$maxSize=-1,$fillSaquare = FALSE, $quality = 100){
        /*
            ########### 
            MODO DE USO
            ########### 
            
                $src 
                    - Ruta de la imagen / URL de la imagen
                
                $destination
                    - ruta donde guardar imagen
                
                $maxSize [OPCIONAL]
                    - Tamaño maximo de pixeles (aplica de alto o ancho)
                
                $fillSaquare [OPCIONAL default:FALSE] 
                    - TRUE  : Rellena con blanco para generar el cuadrado
                    - FALSE : Redimensiona la imagen
                
                $quality [OPCIONAL default:100]
                    - Calidad de la imagen de 1 a 100%



            ########### 
            RESPUESTAS
            ########### 
            
                -2 = Archivo no existe
                -1 = Archivo invalido
                 0 = Error al guardar / destino inaccesible / permiso denegado
                 1 = Guardado

        */

        if("http://" != substr($src, 0,6) && "http://" != substr($src, 0,7)){
            if (!file_exists($src)) {
                return -2;
            }
        }

        ini_set('memory_limit','-1');

        $ext = explode(".", $src);
        $ext = strtolower($ext[count($ext)-1]);
        list($width, $height) = getimagesize($src);

        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $tImage = imagecreatefromjpeg($src);
                break;
            case 'png':
                $tImage = imagecreatefrompng($src);
                break;
            case 'gif':
                $tImage = imagecreatefromgif($src);
                break;
            default:
                return -1;
                break;
        }

        $width = imagesx( $tImage );
        $height = imagesy( $tImage );




        if($width > $height){
            $squareSize = $width;
        }else{
            $squareSize = $height;
        }

        if($maxSize != -1 && $squareSize>$maxSize){
            $squareSize = $maxSize;
        }


        if($width> $height) {
            $width_t=$squareSize;
            $height_t=round($height/$width*$squareSize);
            $offsetY=ceil(($width_t-$height_t)/2);
            $ossetX=0;
        } elseif($height> $width) {
            $height_t=$squareSize;
            $width_t=round($width/$height*$squareSize);
            $ossetX=ceil(($height_t-$width_t)/2);
            $offsetY=0;
        }
        else {
            $width_t=$height_t=$squareSize;
            $ossetX=$offsetY=0;
        }

        if(!$fillSaquare){
            $ossetX=$offsetY=0;
            $new = imagecreatetruecolor( $width_t , $height_t );
        }else{
            $new = imagecreatetruecolor( $squareSize , $squareSize );
        }


        $bg = imagecolorallocate ( $new, 255, 255, 255 );
        imagefill ( $new, 0, 0, $bg );
        imagecopyresampled( $new , $tImage , $ossetX, $offsetY, 0, 0, $width_t, $height_t, $width, $height );
        $status = 0;
            switch ($ext) {
                case 'jpg':
                case 'jpeg':
                    //header('Content-Type: image/jpeg');
                    if(imagejpeg($new, $destination, $quality))$status=1;
                    break;
                case 'png':
                    //header('Content-type: image/png'); 
                    if(imagepng($new, $destination))$status=1;
                    break;
                case 'gif':
                    //header('Content-Type: image/gif');
                    if(imagegif($new, $destination))$status=1;

                    break;
                default:
                    return -1;
                    break;
            }

        imagedestroy($new);
        return $status;

    }

}
