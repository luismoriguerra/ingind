<?php

class MetaCuadroController extends \BaseController {

    protected $_errorController;

    /**
     * Valida sesion activa
     */
    public function __construct(ErrorController $ErrorController) {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }

    /**
     * cargar verbos, mantenimiento
     * POST /rol/cargar
     *
     * @return Response
     */
    
    public function postListarvencimiento1() {
        if (Request::ajax()) {
            $array = array();
            $array['where'] = '';

            if (Input::has("id")) {
                $meta_cuadro_id = Input::get("id");
                if (trim($meta_cuadro_id) != '') {
                    $array['where'] .= " AND mf.meta_cuadro_id=" . $meta_cuadro_id;
                    $array['where'] .= " AND mf.tipo=1";
                }
            }


            $a = new MetaFechaVencimiento;
            $listar = Array();
            $listar = $a->getCargar($array);

            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $listar
                            )
            );
        }
    }

    public function postListarvencimiento2() {
        if (Request::ajax()) {
            $array = array();
            $array['where'] = '';

            if (Input::has("id")) {
                $meta_cuadro_id = Input::get("id");
                if (trim($meta_cuadro_id) != '') {
                    $array['where'] .= " AND mf.meta_cuadro_id=" . $meta_cuadro_id;
                    $array['where'] .= " AND mf.tipo=2";
                }
            }
            $a = new MetaFechaVencimiento;
            $listar = Array();
            $listar = $a->getCargar($array);

            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $listar
                            )
            );
        }
    }

    public function postCargar() {
        if (Request::ajax()) {
            /*             * *******************FIJO**************************** */
            $array = array();
            $array['where'] = '';
            $array['usuario'] = Auth::user()->id;
            $array['limit'] = '';
            $array['order'] = '';

            if (Input::has('draw')) {
                if (Input::has('order')) {
                    $inorder = Input::get('order');
                    $incolumns = Input::get('columns');
                    $array['order'] = ' ORDER BY ' .
                            $incolumns[$inorder[0]['column']]['name'] . ' ' .
                            $inorder[0]['dir'];
                }

                $array['limit'] = ' LIMIT ' . Input::get('start') . ',' . Input::get('length');
                $aParametro["draw"] = Input::get('draw');
            }
            /*             * ********************************************************* */

            if (Input::has("actividad")) {
                $actividad = Input::get("actividad");
                if (trim($actividad) != '') {
                    $array['where'] .= " AND mc.actividad LIKE '%" . $actividad . "%' ";
                }
            }

            if (Input::has("estado")) {
                $estado = Input::get("estado");
                if (trim($estado) != '') {
                    $array['where'] .= " AND mc.estado='" . $estado . "' ";
                }
            }

            $array['order'] = " ORDER BY m.id";

            $cant = MetaCuadro::getCargarCount($array);
            $aData = MetaCuadro::getCargar($array);

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"] = $cant;
            $aParametro["recordsFiltered"] = $cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);
        }
    }

    /**
     * cargar verbos, mantenimiento
     * POST /rol/listar
     *
     * @return Response
     */
    public function postListarmetacuadro() {
        if (Request::ajax()) {
            $array = array();
            $array['where'] = '';
            
            if (Input::has("meta")) {
                $metaId=implode("','",Input::get('meta'));
                    $array['where'] .= " AND m.id IN ('".$metaId."')";

            }
            $a = new MetaCuadro;
            $listar = Array();
            $listar = $a->getMetaCuadro($array);

            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $listar
                            )
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /rol/crear
     *
     * @return Response
     */
    public function postCrear() {
        if (Request::ajax()) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'actividad' => $required . '|' . $regex,
            );

            $mensaje = array(
                'required' => ':attribute Es requerido',
                'regex' => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

//            if ($validator->fails()) {
//                return Response::json(array('rst' => 2, 'msj' => $validator->messages()));
//            }

            $metacuadro = new MetaCuadro;
            $metacuadro->meta_id = Input::get('meta');
            $metacuadro->anio = Input::get('anio');
            $metacuadro->actividad = Input::get('actividad');
            $metacuadro->estado = Input::get('estado');
            $metacuadro->usuario_created_at = Auth::user()->id;
            $metacuadro->save();

            
            $f1id = Input::get('f1id');
            $fecha1 = Input::get('fecha1');
            $comentario1 = Input::get('comentario1');
            
            $f2id = Input::get('f2id');
            $fecha2 = Input::get('fecha2');
            $comentario2 = Input::get('comentario2');
            $fecha_relacion2 = Input::get('fecha_relacion2');
            
            for ($i = 0; $i < count($fecha1); $i++) {
                if ($f1id[$i] == '') {
                    $metafecha = new MetaFechaVencimiento;
                    $metafecha->meta_cuadro_id = $metacuadro->id;
                    $metafecha->fecha = $fecha1[$i];
                    $metafecha->comentario = $comentario1[$i];
                    $metafecha->tipo = 1;
                }
                if (($f1id[$i] !== '')) {
                    $metafechaId = $f1id[$i];
                    $metafecha = MetaFechaVencimiento::find($metafechaId);
                    $metafecha->fecha = $fecha1[$i];
                    $metafecha->comentario = $comentario1[$i];
                    $metafecha->tipo = 1;
                }
                $metafecha->save();
            }

            for ($i = 0; $i < count($fecha2); $i++) {
                if ($f2id[$i] == '') {
                    $metafecha = new MetaFechaVencimiento;
                    $metafecha->meta_cuadro_id = $metacuadro->id;
                    $metafecha->fecha = $fecha2[$i];
                    $metafecha->comentario = $comentario2[$i];
                    $metafecha->relacion_id = $fecha_relacion2[$i];
                    $metafecha->tipo = 2;
                }
                if (($f2id[$i] !== '')) {
                    $metafechaId = $f2id[$i];
                    $metafecha = MetaFechaVencimiento::find($metafechaId);
                    $metafecha->fecha = $fecha2[$i];
                    $metafecha->comentario = $comentario2[$i];
                    $metafecha->relacion_id = $fecha_relacion2[$i];
                    $metafecha->tipo = 2;
                }
                $metafecha->save();
            }

            return Response::json(array('rst' => 1, 'msj' => 'Registro realizado correctamente', 'metacuadro_id' => $metacuadro->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /rol/editar
     *
     * @return Response
     */
    public function postEditar() {
        if (Request::ajax()) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'actividad' => $required . '|' . $regex,
            );

            $mensaje = array(
                'required' => ':attribute Es requerido',
                'regex' => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

//            if ($validator->fails()) {
//                return Response::json(array('rst' => 2, 'msj' => $validator->messages()));
//            }

            $metacuadroId = Input::get('id');
            $metacuadro = MetaCuadro::find($metacuadroId);
            $metacuadro->meta_id = Input::get('meta');
            $metacuadro->anio = Input::get('anio');
            $metacuadro->actividad = Input::get('actividad');
            $metacuadro->estado = Input::get('estado');
            $metacuadro->usuario_updated_at = Auth::user()->id;
            $metacuadro->save();

            $f1id = Input::get('f1id');
            $fecha1 = Input::get('fecha1');
            $comentario1 = Input::get('comentario1');
            
            $f2id = Input::get('f2id');
            $fecha2 = Input::get('fecha2');
            $comentario2 = Input::get('comentario2');
            $fecha_relacion2 = Input::get('fecha_relacion2');
            
            for ($i = 0; $i < count($fecha1); $i++) {
                if ($f1id[$i] == '') {
                    $metafecha = new MetaFechaVencimiento;
                    $metafecha->meta_cuadro_id = $metacuadro->id;
                    $metafecha->fecha = $fecha1[$i];
                    $metafecha->comentario = $comentario1[$i];
                    $metafecha->tipo = 1;
                }
                if (($f1id[$i] !== '')) {
                    $metafechaId = $f1id[$i];
                    $metafecha = MetaFechaVencimiento::find($metafechaId);
                    $metafecha->fecha = $fecha1[$i];
                    $metafecha->comentario = $comentario1[$i];
                    $metafecha->tipo = 1;
                }
                $metafecha->save();
            }

            for ($i = 0; $i < count($fecha2); $i++) {
                if ($f2id[$i] == '') {
                    $metafecha = new MetaFechaVencimiento;
                    $metafecha->meta_cuadro_id = $metacuadro->id;
                    $metafecha->fecha = $fecha2[$i];
                    $metafecha->comentario = $comentario2[$i];
                    $metafecha->relacion_id = $fecha_relacion2[$i];
                    $metafecha->tipo = 2;
                }
                if (($f2id[$i] !== '')) {
                    $metafechaId = $f2id[$i];
                    $metafecha = MetaFechaVencimiento::find($metafechaId);
                    $metafecha->fecha = $fecha2[$i];
                    $metafecha->comentario = $comentario2[$i];
                    $metafecha->relacion_id = $fecha_relacion2[$i];
                    $metafecha->tipo = 2;
                }
                $metafecha->save();
            }

            return Response::json(array('rst' => 1, 'msj' => 'Registro actualizado correctamente'));
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /rol/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado() {

        if (Request::ajax()) {

            $metacuadro = MetaCuadro::find(Input::get('id'));
            $metacuadro->usuario_created_at = Auth::user()->id;
            $metacuadro->estado = Input::get('estado');
            $metacuadro->save();

            return Response::json(
                            array(
                                'rst' => 1,
                                'msj' => 'Registro actualizado correctamente',
                            )
            );
        }
    }

    public function postListarmeta() {
        if (Request::ajax()) {
            $a = new MetaCuadro;
            $listar = Array();
            $listar = $a->getMeta();

            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $listar
                            )
            );
        }
    }
    
        public function postListarfecha1() {
        if (Request::ajax()) {
            $a = new MetaFechaVencimiento;
            $listar = Array();
            $listar = $a->getFecha1();

            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $listar
                            )
            );
        }
    }
    
        public function fileToFile($file,$id, $url){
        if ( !is_dir('file') ) {
            mkdir('file',0777);
        }
        if ( !is_dir('file/meta') ) {
            mkdir('file/meta',0777);
        }
        if ( !is_dir('file/meta/'.$id) ) {
            mkdir('file/meta/'.$id,0777);
        }

        list($type, $file) = explode(';', $file);
        list(, $type) = explode('/', $type);
        if ($type=='jpeg') $type='jpg';
        if (strpos($type,'document')!==False) $type='docx';
        if (strpos($type, 'sheet') !== False) $type='xlsx';
        if ($type=='plain') $type='txt';
        list(, $file)      = explode(',', $file);
        $file = base64_decode($file);
        file_put_contents($url , $file);
        return $url. $type;
    }
    
        public function postCreatedoc()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'doc_id' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

//            if ( $validator->fails() ) {
//                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
//            }

            //crear archivos
                $length=Input::get('doc_id');               
                $docid = Input::get('doc_id');
                $avance_id=Input::get('avance_id');
                $tipo_avance=Input::get('tipo_avance');
                
           
                for ($i=0; $i < count($length); $i++) {

                    $archivo = new MetaDocdigital;
                    $archivo->avance_id = $avance_id[$i];
                    $archivo->tipo_avance = $tipo_avance[$i];
                    $archivo->doc_digital_id = $docid[$i];
                    $archivo->usuario_created_at = Auth::user()->id;
                    $archivo->save();
                }

            return Response::json(array('rst' => 1, 'msj' => 'Documento registrado correctamente'));
        }
    }
    
        public function postCreate()
    {

        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'ruta' => $required . '|' . $regex,
            );

            $mensaje = array(
                'required' => ':attribute Es requerido',
                'regex' => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

//            if ($validator->fails()) {
//                return Response::json(array('rst' => 2, 'msj' => $validator->messages()));
//            }



            //crear archivos
                $length=Input::get('pago_nombre');               
                $nombre = Input::get('pago_nombre');
                $avance_id=Input::get('avance_id');
                $tipo_avance=Input::get('tipo_avance');
                
                $file = Input::get('pago_archivo');
                
                for ($i=0; $i < count($length); $i++) {
                    $url = "file/meta/a".date("Y")."/".date("Y-m-d")."-".$nombre[$i].'.';
                     $this->fileToFile($file[$i],'a'.date("Y"), $url);
                    
                    $ruta='a'.date('Y').'/'.date("Y-m-d").'-'.$nombre[$i];
                    $archivo = new MetaArchivo;
                    $archivo->avance_id = $avance_id[$i];
                    $archivo->tipo_avance = $tipo_avance[$i];
                    $archivo->ruta = $ruta;
                    $archivo->usuario_created_at = Auth::user()->id;
                    $archivo->save();
                }
               
    

            return Response::json(array('rst' => 1, 'msj' => 'Archivo registrado correctamente'));
        }

    }
    
        public function postEliminar() {

        if (Request::ajax()) {
            $carpeta=Input::get('carpeta');
            $nombre=Input::get('nombre');
            $metacuadro = MetaArchivo::find(Input::get('id'));
            $metacuadro->usuario_created_at = Auth::user()->id;
            $metacuadro->estado = 0;
            $metacuadro->save();
            
            unlink('file/meta/'.$carpeta.'/'.$nombre.'');
            return Response::json(
                            array(
                                'rst' => 1,
                                'msj' => 'Archivo eliminado correctamente',
                            )
            );
        }
    }
    
            public function postEliminardoc() {

        if (Request::ajax()) {

            $metacuadro = MetaDocdigital::find(Input::get('id'));
            $metacuadro->usuario_created_at = Auth::user()->id;
            $metacuadro->estado = 0;
            $metacuadro->save();
            
            return Response::json(
                            array(
                                'rst' => 1,
                                'msj' => 'Documento eliminado correctamente',
                            )
            );
        }
    }
    
}
