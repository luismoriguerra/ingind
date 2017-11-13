<?php

class FichaProcesoController extends \BaseController {

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

    public function postCreate() {
        if (Request::ajax()) {
            if(Input::get('ficha_proceso_respuesta_id')!=''){
                $ficha= FichaProcesoRespuesta::find(Input::get('ficha_proceso_respuesta_id'));
                for($i=1;$i<=4;$i++){
                    $ficha['r'.$i] = Input::get('r'.$i);
                }
            }else{
                $ficha=new FichaProcesoRespuesta;
                for($i=1;$i<=4;$i++){
                    $ficha['r'.$i] = Input::get('r'.$i);
                }
                $ficha['ficha_proceso_id'] = Input::get('ficha_proceso_id');
                $ficha['usuario_created_at'] = Auth::user()->id;
                
            }
            $ficha->save();    
            
            DB::table('ficha_proceso_detalle')
                ->where('usuario_created_at', '=', Auth::user()->id)
                ->where('ficha_proceso_id', '=', Input::get('ficha_proceso_id'))
                ->update(
                    array(
                        'estado'=>0,
                        'check'=>0,
                        'usuario_updated_at' => Auth::user()->id,
                    )
                );
                                    
            $ruta_flujo_id=Input::get('ruta_flujo_id');
            $check=Input::get('check');
            $estado=Input::get('estado');
            for($i=0;$i<count($ruta_flujo_id);$i++){
                    $fpd= FichaProcesoDetalle::where('ruta_flujo_id','=',$ruta_flujo_id[$i])
                                              ->where('usuario_created_at','=',Auth::user()->id)
                                              ->where('ficha_proceso_id','=',Input::get('ficha_proceso_id'))->first();
                if($fpd){
                    $fpd->estado=$estado[$i];
                    $fpd->check=$check[$i];
                    $fpd->usuario_created_at= Auth::user()->id;
                    $fpd->save();
                }else{
                    $fpd=new FichaProcesoDetalle;
                    $fpd->ruta_flujo_id=$ruta_flujo_id[$i];
                    $fpd->check=$check[$i];
                    $fpd->estado=$estado[$i];
                    $fpd->ficha_proceso_id=Input::get('ficha_proceso_id');
                    $fpd->usuario_created_at= Auth::user()->id;
                    $fpd->save();
                }  
            }
            
            return Response::json(
                            array(
                                'rst' => 1,
                                'msj' => "Registrado Correctamente",
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
            $result = FichaProceso::getCargar();
            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $result,
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
