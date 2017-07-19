<?php

class InmuebleController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    public function postCreateinmueble() {
        if (Request::ajax()) {
            $Aperturas = DB::table('inventario_apertura')->where('estado', 1)->get();
            $fechaini = strtotime(date('Y-m-d', strtotime($Aperturas[0]->fecha_inicio)));
            $fechafin = strtotime(date('Y-m-d', strtotime($Aperturas[0]->fecha_fin)));
            $fechaAct = strtotime(date('Y-m-d', strtotime(date('Y-m-d'))));
            $rst = 0;
            $msj = '';
            
            if ($fechaAct >= $fechaini && $fechaAct <= $fechafin) {
                $inmueble_valida = DB::table('inventario_inmueble')
                                    ->whereIn('cod_patrimonial', array(Input::get('codpatrimonial')))->first();
                   
                if($inmueble_valida){
                  $Inmueble=Inmueble::find($inmueble_valida->id);  
                } else {
                   $Inmueble = new Inmueble();  
                }

                $Inmueble['cod_interno'] = Input::get('codinterno');
                $Inmueble['inventario_apertura_id'] = $Aperturas[0]->id;
                $Inmueble['descripcion'] = Input::get('descripcion');
                $Inmueble['observacion'] = Input::get('observacion');
                $Inmueble['area_id'] = Input::get('area');
                $Inmueble['piso'] = Input::get('piso');
                $Inmueble['persona_id'] = Auth::user()->id;
                $Inmueble['inventario_local_id'] = Input::get('local');
                $Inmueble['modalidad_id'] = Input::get('modalidad');

                if (Input::has('oficina')) {
                    $Inmueble['oficina'] = Input::get('oficina');
                }

                if (Input::has('marca')) {
                    $Inmueble['marca'] = Input::get('marca');
                }

                if (Input::has('modelo')) {
                    $Inmueble['modelo'] = Input::get('modelo');
                }

                if (Input::has('tipo')) {
                    $Inmueble['tipo'] = Input::get('tipo');
                }

                $Inmueble['color'] = Input::get('color');
                $Inmueble['serie'] = Input::get('serie');
                $Inmueble['fecha_creacion'] = Input::get('fecha');
                $Inmueble['situacion'] = Input::get('estado');
                $Inmueble['created_at'] = date('Y-m-d H:i:s');
                $Inmueble['usuario_created_at'] = Auth::user()->id;
                $Inmueble->save();
                if (Input::has('codpatrimonial')) {
                    $Inmueble['cod_patrimonial'] = Input::get('codpatrimonial');
                } else {
                    $Inmueble['cod_patrimonial'] = '0-' . $Inmueble->id;
                }
                $Inmueble->save();

                if ($Inmueble->id) {

                    /* last area where inmueble was its cancel because now it will be a new registry */
                    $inm_area = DB::table('inventario_inmueble_area')
                                    ->whereIn('cod_patrimonial', array($Inmueble->cod_patrimonial))->get();
                    foreach ($inm_area as $key => $value) {
                        if ($value->ultimo = 1) {
                            $update = InmuebleArea::find($value->id);
                            $update['ultimo'] = 0;
                            $update->save();
                        }
                    }
                    /* last area o registry of inmueble */

                    $Inmueble_area = new InmuebleArea();
                    $Inmueble_area['inventario_apertura_id'] = $Inmueble->inventario_apertura_id;
                    $Inmueble_area['modalidad_id'] = $Inmueble->modalidad_id;
                    $Inmueble_area['cod_patrimonial'] = $Inmueble->cod_patrimonial;
                    $Inmueble_area['cod_interno'] = $Inmueble->cod_interno;
                    $Inmueble_area['inventario_inmueble_id'] = $Inmueble->id;
                    $Inmueble_area['inventario_local_id'] = $Inmueble->inventario_local_id;
                    $Inmueble_area['area_id'] = $Inmueble->area_id;
                    $Inmueble_area['piso'] = $Inmueble->piso;
                    $Inmueble_area['persona_id'] = Auth::user()->id;
                    $Inmueble_area['color'] = $Inmueble->color;
                    $Inmueble_area['observacion'] = $Inmueble->observacion;
                    $Inmueble_area['descripcion'] = $Inmueble->descripcion;
                    $Inmueble_area['serie'] = $Inmueble->serie;
                    $Inmueble_area['fecha_creacion'] = $Inmueble->fecha_creacion;
                    $Inmueble_area['situacion'] = $Inmueble->situacion;
                    $Inmueble_area['created_at'] = $Inmueble->created_at;
                    $Inmueble_area['usuario_created_at'] = Auth::user()->id;
                    
                   if (Input::has('oficina')) {
                        $Inmueble_area['oficina'] = Input::get('oficina');
                    }

                    if (Input::has('marca')) {
                        $Inmueble_area['marca'] = Input::get('marca');
                    }

                    if (Input::has('modelo')) {
                        $Inmueble_area['modelo'] = Input::get('modelo');
                    }

                    if (Input::has('tipo')) {
                        $Inmueble_area['tipo'] = Input::get('tipo');
                    }
                    $Inmueble_area->save();

                    $rst = 1;
                    $msj = 'Registro realizado correctamente';
                } else {

                    $rst = 2;
                    $msj = 'Error al Registrar';
                }
            } else {
                $rst = 3;
                $msj = 'El registro se encuentra fuera de fecha';
            }

            return Response::json(
                            array(
                                'rst' => $rst,
                                'msj' => $msj,
                            )
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCargar() {
        if (Request::ajax()) {
            $area=Auth::user()->area_id;
            $inmueble = Inmueble::getCargar($area);
            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $inmueble,
                            )
            );
        }
    }

    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
