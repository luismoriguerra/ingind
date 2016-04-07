<?php

class PersonaController extends BaseController
{

    /**
     * cargar personas
     * POST /persona/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $personas = Persona::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$personas));
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
                'dni'      => 'required|min:8|unique:personas,dni',
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

            $persona = new Persona;
            $persona['paterno'] = Input::get('paterno');
            $persona['materno'] = Input::get('materno');
            $persona['nombre'] = Input::get('nombre');
            $persona['email'] = Input::get('email');
            $persona['dni'] = Input::get('dni');
            $persona['sexo'] = Input::get('sexo');
            $persona['password'] = Hash::make(Input::get('password'));
            if (Input::get('fecha_nac')<>'') 
            $persona['fecha_nacimiento'] = Input::get('fecha_nac');
            $persona['area_id'] = Input::get('area');
            $persona['rol_id'] = Input::get('rol');
            $persona['estado'] = Input::get('estado');
            $persona['usuario_created_at'] = Auth::user()->id;
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
                'dni'      => 'required|min:8|unique:personas,dni,'.Input::get('id'),
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
            $personaId = Input::get('id');
            $persona = Persona::find($personaId);
            $persona['paterno'] = Input::get('paterno');
            $persona['materno'] = Input::get('materno');
            $persona['nombre'] = Input::get('nombre');
            $persona['email'] = Input::get('email');
            $persona['dni'] = Input::get('dni');
            $persona['sexo'] = Input::get('sexo');
            $persona['area_id'] = Input::get('area');
            $persona['rol_id'] = Input::get('rol');
            if (Input::get('password')<>'') 
                $persona['password'] = Hash::make(Input::get('password'));
            if (Input::get('fecha_nac')<>'') 
            $persona['fecha_nacimiento'] = Input::get('fecha_nac');
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
                    'msj'=>'Registro actualizado correctamente',
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

}
