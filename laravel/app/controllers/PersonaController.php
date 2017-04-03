<?php

class PersonaController extends BaseController
{
    /**
     *
     * @return Response
     * muestra todas personas
     */
    public function index()
    {
        if (Input::has('sort')) {
            list($sortCol, $sortDir) = explode('|', Input::get('sort'));
            $query = Persona::orderBy($sortCol, $sortDir);
        } else {
            $query = Persona::orderBy('id', 'asc');
        }

        if (Input::has('filter')) {
            $filter=Input::get('filter');
            $query->where(function($q) use($filter) {
                $value = "%{$filter}%";
                $q->where('paterno', 'like', $value)
                    ->orWhere('materno', 'like', $value)
                    ->orWhere('nombre', 'like', $value)
                    ->orWhere('dni', 'like', $value);
            });
        }
        $perPage = Input::has('per_page') ? (int) Input::get('per_page') : null;
        return Response::json($query->paginate($perPage));
    }
    /**
     * consultar persona por dni
     */
    public function getPordni($dni){
        return Persona::where('dni',$dni)->first();
    }
    /**
     * cargar personas
     * POST /persona/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
       /* if ( Request::ajax() ) {
            $personas = Persona::getCargar(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$personas));
        }*/
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

   

             if( Input::has("paterno") ){
                $paterno=Input::get("paterno");
                if( trim( $paterno )!='' ){
                    $array['where'].=" AND p.paterno LIKE '%".$paterno."%' ";
                }
            }

            if( Input::has("materno") ){
                $materno=Input::get("materno");
                if( trim( $materno )!='' ){
                    $array['where'].=" AND p.materno LIKE '%".$materno."%' ";
                }
            }

            if( Input::has("nombre") ){
                $nombre=Input::get("nombre");
                if( trim( $nombre )!='' ){
                    $array['where'].=" AND p.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("dni") ){
                $dni=Input::get("dni");
                if( trim( $dni )!='' ){
                    $array['where'].=" AND p.dni LIKE '%".$dni."%' ";
                }
            }

            if( Input::has("sexo") ){
                $sexo=Input::get("sexo");
                if( trim( $sexo )!='' ){
                    $array['where'].=" AND p.sexo='".$sexo."' ";
                }
            }


            if( Input::has("email") ){
                $email=Input::get("email");
                if( trim( $email )!='' ){
                    $array['where'].=" AND p.email LIKE '%".$email."%' ";
                }
            }


            if( Input::has("fecha_nacimiento") ){
                $fecha_nacimiento=Input::get("fecha_nacimiento");
                if( trim( $fecha_nacimiento )!='' ){
                    $array['where'].=" AND p.fecha_nacimiento LIKE '%".$fecha_nacimiento."%' ";
                }
            }

            if( Input::has("password") ){
                $password=Input::get("password");
                if( trim( $password )!='' ){
                    $array['where'].=" AND p.password='".$password."' ";
                }
            }


            if( Input::has("area") ){
                $area=Input::get("area");
                if( trim( $area )!='' ){
                    $array['where'].=" AND a.nombre LIKE '%".$area."%' ";
                }
            }

            if( Input::has("rol") ){
                $rol=Input::get("rol");
                if( trim( $rol )!='' ){
                    $array['where'].=" AND r.nombre LIKE '%".$rol."%' ";
                }
            }
            

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND p.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY p.nombre ";

            $cant  = Persona::getCargarCount( $array );
            $aData = Persona::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }

    public function postCargarp()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $personas = Persona::getCargarp();
            return Response::json(array('rst'=>1,'datos'=>$personas));
        }
    }
    /**
     * cargar personas, mantenimiento
     * POST /persona/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $personas=array();
            if ( Input::has('estado_persona') ) {
                $personas = Persona::getPersonas();
            }
            elseif ( Input::has('apellido_nombre') ) {
                $personas = Persona::getApellidoNombre();
            }
            else{
                $personas = Persona::getCargoArea();
            }
            
            return Response::json(array('rst'=>1,'datos'=>$personas));
        }
    }

     public function postGetuserbyid()
    {
        //si la peticion es ajax
       if ( Request::ajax() ) {
            $a      = new Persona;
            $data = $a->getPersonById();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $data
                )
            );
        }
    }
    /**
     * Store a newly created resource in storage.
     * POST /persona/cargarareas
     *
     * @return Response
     */
    public function postCargarareas()
    {
        $personaId = Input::get('persona_id');
        $areas = Persona::getAreas($personaId);
        return Response::json(array('rst'=>1,'datos'=>$areas));
    }
    /**
     * Store a newly created resource in storage.
     * POST /persona/crear
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
                'paterno' => $required.'|'.$regex,
                'materno' => $required.'|'.$regex,
                'email' => 'required|email|unique:personas,email',
                'password'      => 'required|min:6',
                'dni'      => 'required|numeric|min:8|unique:personas,dni',
            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Texto',
                'exists'       => ':attribute ya existe',
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
            $rol = Input::get('rol');$rst='';
            if ($rol==9 or $rol==8) {
                $rst=Persona::BuscarJefe(Input::get('area'));
                if($rst>=1){
                return Response::json(
                    array(
                    'rst'=>3,
                    'msj'=>'Área con Gerente, Inhabilitar y volver a crear',
                    )
                );
                }else {
                 Persona::ActualizarResponsable(Input::get('area'));   
                }
            }
            
            $persona = new Persona;
            $persona['paterno'] = Input::get('paterno');
            $persona['materno'] = Input::get('materno');
            $persona['nombre'] = Input::get('nombre');
            $persona['email'] = Input::get('email');
            $persona['dni'] = Input::get('dni');
            $persona['sexo'] = Input::get('sexo');
            $persona['password'] = Input::get('password');
            if (Input::get('fecha_nacimiento')<>'') 
            $persona['fecha_nacimiento'] = Input::get('fecha_nacimiento');        
            if ($rol==9 or $rol==8){
            $persona['responsable_asigt']=1;
            $persona['responsable_dert']=1;}
            $persona['area_id'] = Input::get('area');
            $persona['rol_id'] = Input::get('rol');
            $persona['estado'] = Input::get('estado');
            $persona['usuario_created_at'] = Auth::user()->id;
            $persona['verified'] = true;
            $persona['token'] = null;
            $persona->save();
            $personaId = $persona->id;
            //si es cero no seguir, si es 1 ->estado se debe copiar de celulas
            $estado = Input::get('estado');
            if ($estado == 0 ) {
                return Response::json(
                    array(
                    'rst'=>1,
                    'msj'=>'Registro actualizado correctamente',
                    )
                );
            }
            
            if (Input::has('cargos_selec')) {
                $cargos=Input::get('cargos_selec');
                $cargos = explode(',', $cargos);
                if (is_array($cargos)) {
                    for ($i=0; $i<count($cargos); $i++) {
                        $cargoId = $cargos[$i];
                        $cargo = Cargo::find($cargoId);
                        $persona->cargos()->save($cargo, 
                            array(
                                'estado' => 1,
                                'usuario_created_at' => Auth::user()->id
                                )
                            );
                        $areas = Input::get('areas'.$cargoId);

                        //busco el id
                        $cargoPersona = DB::table('cargo_persona')
                                        ->where('persona_id', '=', $personaId)
                                        ->where('cargo_id', '=', $cargoId)
                                        ->first();

                        for ($j=0; $j<count($areas); $j++) {
                            //recorrer las areas y buscar si exten
                            $areaId = $areas[$j];
                            DB::table('area_cargo_persona')->insert(
                                array(
                                    'area_id' => $areaId,
                                    'cargo_persona_id' => $cargoPersona->id,
                                    'estado' => 1,
                                    'usuario_created_at' => Auth::user()->id
                                )
                            );
                        }
                    }
                } else {
                    $cargoId = $cargos;
                    $cargo = Cargo::find($cargoId);
                    $persona->cargos()->save($cargo, 
                        array(
                            'estado' => 1,
                            'usuario_created_at' => Auth::user()->id
                            )
                        );
                    $areas = Input::get('areas'.$cargoId);

                    //busco el id
                    $cargoPersona = DB::table('cargo_persona')
                                    ->where('persona_id', '=', $personaId)
                                    ->where('cargo_id', '=', $cargoId)
                                    ->first();

                    for ($j=0; $j<count($areas); $j++) {
                        //recorrer las areas y buscar si exten
                        $areaId = $areas[$j];

                        DB::table('area_cargo_persona')->insert(
                            array(
                                'area_id' => $areaId,
                                'cargo_persona_id' => $cargoPersona->id,
                                'estado' => 1,
                                'usuario_created_at' => Auth::user()->id
                            )
                        );
                        
                    }
                }
            }
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro realizado correctamente'.$personaId,
                )
            );
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /persona/editar
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
                'paterno' => $required.'|'.$regex,
                'materno' => $required.'|'.$regex,
                'email' => 'required|email|unique:personas,email,'.Input::get('id'),
                'dni'      => 'required|numeric|min:8|unique:personas,dni,'.Input::get('id'),
                //'password'      => 'required|min:6',
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
            
            $rol = Input::get('rol');$rst='';
            if ($rol==9 or $rol==8) {
                $rst=Persona::BuscarJefe(Input::get('area'));
                if($rst>=1){
                return Response::json(
                    array(
                    'rst'=>3,
                    'msj'=>'Área con Gerente, Inhabilitar y volver a actualizar',
                    )
                );
                }else {
                 Persona::ActualizarResponsable(Input::get('area'));   
                }
            }
            
            $personaId = Input::get('id');
            $persona = Persona::find($personaId);
            if ($rol==9 or $rol==8){
            $persona['responsable_asigt']=1;
            $persona['responsable_dert']=1;}
            $persona['paterno'] = Input::get('paterno');
            $persona['materno'] = Input::get('materno');
            $persona['nombre'] = Input::get('nombre');
            $persona['email'] = Input::get('email');
            $persona['dni'] = Input::get('dni');
            $persona['sexo'] = Input::get('sexo');
            $persona['area_id'] = Input::get('area');
            $persona['rol_id'] = Input::get('rol');
            if (Input::has('password'))
                $persona['password'] = Input::get('password');
            if (Input::has('fecha_nacimiento'))
                $persona['fecha_nacimiento'] = Input::get('fecha_nacimiento');

            $persona['estado'] = Input::get('estado');
            $persona['usuario_updated_at'] = Auth::user()->id;
            $persona->save();
            
            $cargos = Input::get('cargos_selec');
            $estado = Input::get('estado');

            DB::table('cargo_persona')
                ->where('persona_id', $personaId)
                ->update(array('estado' => 0));

            if ($estado == 0 ) {
                return Response::json(
                    array(
                    'rst'=>1,
                    'msj'=>'Registro actualizado correctamente.',
                    )
                );
            }
            
            if ($cargos) {//si selecciono algun cargo
                $cargos = explode(',', $cargos);
                $areas=array();

                //recorrer os cargos y verificar si existen
                for ($i=0; $i<count($cargos); $i++) {
                    $cargoId = $cargos[$i];
                    $cargo = Cargo::find($cargoId);
                    $cargoPersona = DB::table('cargo_persona')
                                    ->where('persona_id', '=', $personaId)
                                    ->where('cargo_id', '=', $cargoId)
                                    ->first();
                    $fechIng = '';
                    $fechaRet = '';
                    if (is_null($cargoPersona)) {
                        $persona->cargos()->save(
                            $cargo,
                            array(
                                'estado'=>1,
                                'usuario_created_at' => Auth::user()->id/*,
                                'fecha_ingreso'=>$fechIng,
                                'fecha_retiro'=>$fechaRet*/
                            )
                        );
                    } else {
                        DB::table('cargo_persona')
                            ->where('persona_id', '=', $personaId)
                            ->where('cargo_id', '=', $cargoId)
                            ->update(
                                array(
                                    'estado'=>1,
                                    'usuario_updated_at' => Auth::user()->id/*,
                                    'fecha_ingreso'=>$fechIng,
                                    'fecha_retiro'=>$fechaRet*/
                                )
                            );
                    }
                    //busco el id
                    $cargoPersona = DB::table('cargo_persona')
                                    ->where('persona_id', '=', $personaId)
                                    ->where('cargo_id', '=', $cargoId)
                                    ->first();
                    DB::table('area_cargo_persona')
                            //->where('area_id', '=', $areaId)
                            ->where('cargo_persona_id', '=', $cargoPersona->id)
                            ->update(
                                array(
                                    'estado' => 0,
                                    'usuario_updated_at' => Auth::user()->id
                                    )
                                );
                    //almacenar las areas seleccionadas
                    $areas = Input::get('areas'.$cargoId);
                    for ($j=0; $j<count($areas); $j++) {
                        //recorrer las areas y buscar si exten
                        $areaId = $areas[$j];
                        $areaCargoPersona=DB::table('area_cargo_persona')
                                ->where('area_id', '=', $areaId)
                                ->where('cargo_persona_id', $cargoPersona->id)
                                ->first();
                        if (is_null($areaCargoPersona)) {
                            DB::table('area_cargo_persona')->insert(
                                array(
                                    'area_id' => $areaId,
                                    'cargo_persona_id' => $cargoPersona->id,
                                    'estado' => 1,
                                    'usuario_created_at' => Auth::user()->id
                                )
                            );
                        } else {
                            DB::table('area_cargo_persona')
                            ->where('area_id', '=', $areaId)
                            ->where('cargo_persona_id', '=', $cargoPersona->id)
                            ->update(
                                array(
                                    'estado' => 1,
                                    'usuario_updated_at' => Auth::user()->id
                                ));
                        }
                    }
                }
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
     * POST /persona/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {
            $persona = Persona::find(Input::get('id'));
            $persona->estado = Input::get('estado');
            $persona->usuario_updated_at = Auth::user()->id;
            $persona->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

    public function postExoneranotif()
    {

        if ( Request::ajax() ) {
            $persona = Persona::find(Input::get('idpersona'));
            $persona->fecha_ini_exonera = Input::get('fechaini');
            $persona->fecha_fin_exonera = Input::get('fechafin');
            $persona->usuario_updated_at = Auth::user()->id;
            $persona->save();


            /*disable old dates*/
            $OldDates = DB::table('persona_exoneracion')
                ->where('persona_id', '=', $persona->id)
                ->where('estado',1)
                ->get();
            if(count($OldDates)>0){
                foreach ($OldDates as $key => $value) {
                    $Changed = PersonaExoneracion::find($value->id);
                    $Changed->estado = 0;
                    $Changed->save();
                }                
            }
            /*end disable old dates*/

            $persona_exo = new PersonaExoneracion();
            $persona_exo->persona_id = $persona->id;
            $persona_exo->fecha_ini_exonera = Input::get('fechaini');
            $persona_exo->fecha_fin_exonera =  Input::get('fechafin');
            if(Input::has('observ')){
                $persona_exo->observacion =  Input::get('observ');
            }
            $persona_exo->created_at = date("Y-m-d H:i:s");
            $persona_exo->usuario_created_at = Auth::user()->id;
            $persona_exo->save();

            /*if validate fechas y estado envio*/
/*            if($persona->fecha_ini_exonera != '' && $persona->fecha_fin_exonera != ''){
                $actual = date('Y-m-d ');
                $inicial = date('Y-m-d',strtotime($persona->fecha_ini_exonera));
                $final = date('Y-m-d',strtotime($persona->fecha_fin_exonera));
                if($inicial <= $actual && $actual <= $final){
                    $persona->envio_actividad = 0;
                    $persona->usuario_updated_at = Auth::user()->id;
                    $persona->save();
                }
            }*/
            /*end validate fechas y estado envio*/

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

    public function postDeleteexonera(){
        if ( Request::ajax() ) {
            $persona_exonera=PersonaExoneracion::find(Input::get('id'));
            $persona_exonera->estado = 0;
            $persona_exonera->save();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'msj'=>'Registro eliminado correctamente',
                )
            );
        }
    }

    public function postGetexoneracion()
    {
        if ( Request::ajax() ) {
            $r=Persona::getExoneraciones();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $r
                )
            );
        }
    }

    
        public function postAlertasactividad()
    {

        if ( Request::ajax() ) {
            $persona = Persona::find(Input::get('id'));
            $persona->envio_actividad = Input::get('estado');
            $persona->usuario_updated_at = Auth::user()->id;
            $persona->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }


     public function postEstadoasigt()
    {

        if ( Request::ajax() ) {
            $persona = Persona::find(Input::get('id'));

            /*validate if already there is a responsable*/
            if(Input::get('estado')==1){
                $responsable = DB::table('personas')
                    ->where('area_id', '=', $persona->area_id)
                    ->where('responsable_asigt',1)
                    ->where('estado',1)
                    ->get();

                if(count($responsable)>0){
                    foreach ($responsable as $key => $value) {
                        $Asignado = Persona::find($value->id);
                        $Asignado->responsable_asigt=0;
                        $Asignado->usuario_updated_at = Auth::user()->id;
                        $Asignado->save();
                    }
                }         
            }
            /*end validate if already there is a responsable*/

            $persona->responsable_asigt = Input::get('estado');
            $persona->usuario_updated_at = Auth::user()->id;
            $persona->save();
            
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

     public function postEstadodervt()
    {

        if ( Request::ajax() ) {
            $persona = Persona::find(Input::get('id'));

             /*validate if already there is a responsable*/
            if(Input::get('estado')==1){
                $responsable = DB::table('personas')
                    ->where('area_id', '=', $persona->area_id)
                    ->where('responsable_dert',1)
                    ->where('estado',1)
                    ->get();

                if(count($responsable)>0){
                    foreach ($responsable as $key => $value) {
                        $Asignado = Persona::find($value->id);
                        $Asignado->responsable_dert=0;
                        $Asignado->usuario_updated_at = Auth::user()->id;
                        $Asignado->save();
                    }
                }
            }
            /*end validate if already there is a responsable*/

            $persona->responsable_dert = Input::get('estado');
            $persona->usuario_updated_at = Auth::user()->id;
            $persona->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

    public function postAlertasactividadarea(){
      $r=Persona::AlertasActividadArea();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );  
    }

}
