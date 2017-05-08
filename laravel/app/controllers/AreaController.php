<?php
use Chat\Repositories\User\UserRepository;
use Chat\Repositories\Area\AreaRepository;
class AreaController extends \BaseController
{
    protected $_errorController;
    /**
     * @var Chat\Repositories\AreaRepository
     */
    private $areaRepository; 
    /**
      * @var Chat\Repositories\UserRepository
     */
    private $userRepository;
    /**
     *
     */    
    public function __construct(
        ErrorController $ErrorController,
        AreaRepository $areaRepository,
        UserRepository $userRepository
    ) {
        $this->beforefilter('auth');
        $this->_errorController = $ErrorController;
        $this->areaRepository = $areaRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing.
     *
     * @return Response
     */
    public function index() {
        $areas = $this->areaRepository->getAllActives();
        $response=[
            'areas' => $areas,
        ];
        return Response::json($response);
    }
    /**
     * Display a listing of user conversations.
     *
     * @return Response
     */
    public function show($area_id){
        $keys = Redis::keys("laravel:*");
        $user=[];
        for ($i=0; $i < count($keys); $i++) {
            $temporal=Redis::get($keys[$i]) ;
            $temporal = unserialize($temporal);
            $temporal = unserialize($temporal);
            foreach ($temporal as $key => $value) {               
                if (substr($key,0,6)=='login_') {
                    $user[]=$value;
                }
            }
        }
        $usuarios = $this->userRepository->getAllExceptFromArea(Auth::user()->id,$area_id);
        $response=['users'=>$usuarios,'consesion'=>$user];
        return Response::json($response);
    }

     /**
     * cargar areas, mantenimiento
     * POST /area/cargar
     *
     * @return Response
     */

    public function postCargar()
    {
        if ( Request::ajax() ) {
            /*********************FIJO*****************************/
            $array=array();
            $array['where']='';$array['usuario']=Auth::user()->id;
            $array['limit']='';$array['order']='';
            
            if (Input::has('draw')) {
                if (Input::has('order')) {
                    $inorder=Input::get('order');
                    $incolumns=Input::get('columns');
                    $array['order']=  ' ORDER BY '.
                                      $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                      $inorder[0]['dir'];
                }

                $array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
                $aParametro["draw"]=Input::get('draw');
            }
            /************************************************************/

            if( Input::has("nombre") ){
                $nombre=Input::get("nombre");
                if( trim( $nombre )!='' ){
                    $array['where'].=" AND a.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("nemonico") ){
                $nemonico=Input::get("nemonico");
                if( trim( $nemonico )!='' ){
                    $array['where'].=" AND a.nemonico LIKE '%".$nemonico."%' ";
                }
            }


            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND a.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY a.nombre ";

            $cant  = Area::getCargarCount( $array );
            $aData = Area::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";   
            return Response::json($aParametro);

        }
    }
    /**
     * Store a newly created resource in storage.
     * POST /area/listar
     *
     * @return Response
     */
    public function postListar()
    {
        if ( Request::ajax() ) {
            $a      = new Area;
            $listar = Array();
            $listar = $a->getArea();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

    public function postListara()
    {
        if ( Request::ajax() ) {
            $a      = new Area;
            $listar = Array();
            $listar = $a->getListar();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

    /**
     * 
     */
    public function postImagen()
    {
        if (Input::hasFile('upload_imagen')) {
            if ( Input::file('upload_imagen')->isValid() ) {
                $areaId = Input::get('upload_id');
                $file = Input::file('upload_imagen');
                $tmpArchivo = $file->getRealPath();
                $extension = $file->getClientOriginalExtension();
                //$name = $file->getClientOriginalName();
                $name = 'a'.$areaId.'.'.$extension;
                $destinationPath='img/admin/area';
                if ($file->move($destinationPath,$name)){
                    $areas = Area::find($areaId);
                    $areas->imagen = $name;
                    $areas->save();
                    return Response::json(
                        array(
                            'rst'   => 1,
                            'datos' => 'Se subio con exito'
                        )
                    );
                } else {
                    return Response::json(
                        array(
                            'rst'   => 0,
                            'datos' => 'No se subio con exito'
                        )
                    );
                }
            }
        }
        return Response::json(
            array(
                'rst'   => 0,
                'datos' => 'No se subio con exito'
            )
        );
    }
    /**
     * 
     */
    public function postImagenc()
    {
        if (Input::hasFile('upload_imagenc')) {
            if ( Input::file('upload_imagenc')->isValid() ) {
                $areaId = Input::get('upload_idc');
                $file = Input::file('upload_imagenc');
                $tmpArchivo = $file->getRealPath();
                $extension = $file->getClientOriginalExtension();
                //$name = $file->getClientOriginalName();
                $name = 'a'.$areaId.'c.'.$extension;
                $destinationPath='img/admin/area';
                if ($file->move($destinationPath,$name)){
                    $areas = Area::find($areaId);
                    $areas->imagenc = $name;
                    $areas->save();
                    return Response::json(
                        array(
                            'rst'   => 1,
                            'datos' => 'Se subio con exito'
                        )
                    );
                } else {
                    return Response::json(
                        array(
                            'rst'   => 0,
                            'datos' => 'No se subio con exito'
                        )
                    );
                }
            }
        }
        return Response::json(
            array(
                'rst'   => 0,
                'datos' => 'No se subio con exito'
            )
        );
    }
    /**
     * 
     */
    public function postImagenp()
    {
        if (Input::hasFile('upload_imagenp')) {
            if ( Input::file('upload_imagenp')->isValid() ) {
                $areaId = Input::get('upload_idp');
                $file = Input::file('upload_imagenp');
                $tmpArchivo = $file->getRealPath();
                $extension = $file->getClientOriginalExtension();
                //$name = $file->getClientOriginalName();
                $name = 'a'.$areaId.'p.'.$extension;
                $destinationPath='img/admin/area';
                if ($file->move($destinationPath,$name)){
                    $areas = Area::find($areaId);
                    $areas->imagenp = $name;
                    $areas->save();
                    return Response::json(
                        array(
                            'rst'   => 1,
                            'datos' => 'Se subio con exito'
                        )
                    );
                } else {
                    return Response::json(
                        array(
                            'rst'   => 0,
                            'datos' => 'No se subio con exito'
                        )
                    );
                }
            }
        }
        return Response::json(
            array(
                'rst'   => 0,
                'datos' => 'No se subio con exito'
            )
        );
    }
    /**
     * Store a newly created resource in storage.
     * POST /area/crear
     *
     * @return Response
     */
    public function postCrear()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre' => $required.'|'.$regex,
            );
            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json(
                    array(
                    'rst'=>2,
                    'msj'=>$validator->messages(),
                    )
                );
            }

            $areas = new Area;
            $areas->nombre = Input::get('nombre');
            $areas->nemonico = Input::get('nemonico');
            $areas->estado = Input::get('estado');
            $areas->usuario_created_at = Auth::user()->id;
            $areas->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro realizado correctamente',
                'area_id'=>$areas->id,
                )
            );
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /area/editar
     *
     * @return Response
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            $regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json(
                    array(
                    'rst'=>2,
                    'msj'=>$validator->messages(),
                    )
                );
            }

            $areaId = Input::get('id');
            $areas = Area::find($areaId);
            $areas->nombre = Input::get('nombre');
            $areas->nemonico = Input::get('nemonico');
            $areas->estado = Input::get('estado');
            $areas->usuario_updated_at = Auth::user()->id;
            $areas->save();
            if (Input::get('estado') == 0) {
                DB::table('area_cargo_persona')
                    ->where('area_id','=',$areaId)
                    ->update(
                        array(
                            'estado' => 0,
                            'usuario_updated_at' => Auth::user()->id
                        ));
            }
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /area/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {
            $areaId = Input::get('id');
            $area = Area::find($areaId);
            $area->usuario_updated_at = Auth::user()->id;
            $area->estado = Input::get('estado');
            $area->save();
            if (Input::get('estado') == 0) {
                DB::table('area_cargo_persona')
                    ->where('area_id','=',$areaId)
                    ->update(
                            array(
                                'estado' => 0,
                                'usuario_updated_at' => Auth::user()->id
                                )
                        );
            }
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

    public function postAreasgerencia()
    {
        if ( Request::ajax() ) {
            $area = Area::getAreasGerencia();
            return Response::json(
                array(
                'rst'=>1,
                'datos'=>$area,
                )
            );    

        }
    }
    
        public function postAreasgerenciapersona()
    {
        if ( Request::ajax() ) {
            $area = Area::getAreasGerenciaPersona();
            return Response::json(
                array(
                'rst'=>1,
                'datos'=>$area,
                )
            );    

        }
    }


    public function postPersonaarea(){
        if ( Request::ajax() ) {
            $datos = Area::getAllPersonsFromArea();
            return Response::json(
                array(
                'rst'=>1,
                'datos'=>$datos,
                )
            );    
        }
    }

}
