<?php

class TablaRelacionController extends \BaseController
{

    public function postPlataforma()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$cargar         = TablaRelacion::getPlataforma();

                $array=array();
                $array['where']='';$array['usuario']=Auth::user()->id;
                $array['limit']='';$array['order']='';
                
                if (Input::has('draw')) {
                    if (Input::has('order')) {
                        $inorder=Input::get('order');
                        $incolumns=Input::get('columns');
                        /*$array['order']=  ' ORDER BY '.
                                          $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                          $inorder[0]['dir'];*/
                    }

                    //$array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
                    $aParametro["draw"]=Input::get('draw');
                }
                /************************************************************/

                if( Input::has("tramite") ){
                    $tramite=Input::get("tramite");
                    if( trim( $tramite )!='' ){
                        $array['where'].=" AND tr.id_union LIKE '%".$tramite."%' ";
                    }
                }

                if( Input::has("proceso") ){
                    $proceso=Input::get("proceso");
                    if( trim( $proceso )!='' ){
                        $array['where'].=" AND f.nombre LIKE '%".$proceso."%' ";
                    }
                }

                if( Input::has("fecha_inicio") ){
                    $fecha_inicio=Input::get("fecha_inicio");
                    if( trim( $fecha_inicio )!='' ){
                        $array['where'].=" AND DATE(rd2.fecha_inicio)='".$fecha_inicio."' ";
                    }
                }

                $usuario=Auth::user()->id;
                $cargopersona= CargoPersona::where('cargo_id','12')
                                ->where('persona_id',$usuario)
                                ->where('estado','1')
                                ->get();
                $area="";
                if( count($cargopersona)==0 ){
                    $sql="SELECT GROUP_CONCAT(DISTINCT(a.id) ORDER BY a.id) areas
                    FROM area_cargo_persona acp
                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                    WHERE acp.estado=1
                    AND cp.persona_id= ".$usuario;
                    $totalareas=DB::select($sql);
                    $areas = $totalareas[0]->areas;
                    $array['where'].=" AND rd2.area_id IN (".$areas.") ";
                }

                $array['order']=" ORDER BY rd2.fecha_inicio DESC ";

                //$cant  = TablaRelacion::getPlataformaCount( $array );
                $aData = TablaRelacion::getPlataforma( $array );
                $cant= count($aData);
                $max= Input::get('start')+Input::get('length');

                if( $cant-($cant%10) == Input::get('start') AND $cant%10>0 ){
                $max=$cant;
                }

                $r2= array();
                if( $cant>10 ){
                    for ($i=Input::get('start'); $i < $max; $i++) { 
                      array_push($r2, $aData[$i]);
                    }
                }
                else{
                $r2=$aData;
                }


                $aParametro['rst'] = 1;
                $aParametro["recordsTotal"]=$cant;
                $aParametro["recordsFiltered"]=$cant;
                $aParametro['data'] = $r2;
                $aParametro['msj'] = "No hay registros aún";
                return Response::json($aParametro);

            /*return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );*/
        }
    }

    public function postRelacion()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tr             = new TablaRelacion;
            $cargar         = Array();
            $cargar         = $tr->getRelacion();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postRelacionunico()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tr             = new TablaRelacion;
            $cargar         = Array();
            $cargar         = $tr->getRelacionunico();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postRutaflujo()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $rf             = new RutaFlujo;
            $cargar         = Array();
            $cargar         = $rf->getRutaFlujoProduccion();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postGuardar()
    {
        if( Request::ajax() ) {
            $tr         = new TablaRelacion;
            $datos      = array();
            $datos      = $tr->guardarRelacion();

            return Response::json(
                array(
                    'rst'    => 1,
                    'id'     => $datos->id,
                    'codigo' => Input::get('codigo')
                )
            );
        }
    }

    public function postEditasignado(){
        if( Request::ajax() ) {
           $tabla_relacion = TablaRelacion::find(Input::get('id'));
           $tabla_relacion->id_union = Input::get('nombret');
           $tabla_relacion->usuario_updated_at = Auth::user()->id;
           $tabla_relacion->save();

           if($tabla_relacion->id){
             $ruta = Ruta::where('tabla_relacion_id','=',$tabla_relacion->id)->get();
             if($ruta[0]){
                $referido = Referido::where('ruta_id','=',$ruta[0]->id)->whereNull('ruta_detalle_id')->get();
                if($referido[0]){
                    $referido[0]->referido = Input::get('nombret');
                    $referido[0]->usuario_updated_at = Auth::user()->id;
                    $referido[0]->save();
                }
             }
           }

            return Response::json(
                array(
                    'rst'    => 1,
                    'msj'=>'Registro actualizado correctamente.'
                )
            );
        }
    }


    public function postTramites()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$cargar         = TablaRelacion::getPlataforma();

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

                if( Input::has('id_union') AND Input::get('id_union')!='' ){
                  $id_union=explode(" ",trim(Input::get('id_union')));
                  for($i=0; $i<count($id_union); $i++){
                    $array['where'].=" AND tr.id_union LIKE '%".$id_union[$i]."%' ";
                  }
                }

                if( Input::has("usuario") ){
                    $usuario=Input::get("usuario");
                    if( trim( $usuario )!='' ){
                        $array['where'].=" AND CONCAT_WS(p.nombre,p.paterno,p.materno) LIKE '%".$usuario."%' ";
                    }
                }

                if( Input::has("fecha_tramite") ){
                    $fecha_t=Input::get("fecha_tramite");
                    if( trim( $fecha_inicio )!='' ){
                        $array['where'].=" AND DATE(tr.fecha_tramite)='".$fecha_t."' ";
                    }
                }

                $array['order']=" ORDER BY tr.fecha_tramite DESC ";

                $cant  = TablaRelacion::getTramitesCount( $array );
                $aData = TablaRelacion::getTramites( $array );

                $aParametro['rst'] = 1;
                $aParametro["recordsTotal"]=$cant;
                $aParametro["recordsFiltered"]=$cant;
                $aParametro['data'] = $aData;
                $aParametro['msj'] = "No hay registros aún";
                return Response::json($aParametro);
        }
    }

      public function postTramitesuser()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$cargar         = TablaRelacion::getPlataforma();

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

                if( Input::has('id_union') AND Input::get('id_union')!='' ){
                  $id_union=explode(" ",trim(Input::get('id_union')));
                  for($i=0; $i<count($id_union); $i++){
                    $array['where'].=" AND tr.id_union LIKE '%".$id_union[$i]."%' ";
                  }
                }

                if( Input::has("usuario") ){
                    $usuario=Input::get("usuario");
                    if( trim( $usuario )!='' ){
                        $array['where'].=" AND CONCAT_WS(p.nombre,p.paterno,p.materno) LIKE '%".$usuario."%' ";
                    }
                }

                if( Input::has("fecha_tramite") ){
                    $fecha_t=Input::get("fecha_tramite");
                    if( trim( $fecha_inicio )!='' ){
                        $array['where'].=" AND DATE(tr.fecha_tramite)='".$fecha_t."' ";
                    }
                }
                
                $array['order']=" ORDER BY tr.fecha_tramite DESC ";

                $cant  = TablaRelacion::getTramitesUserCount( $array );
                $aData = TablaRelacion::getTramitesUser( $array );

                $aParametro['rst'] = 1;
                $aParametro["recordsTotal"]=$cant;
                $aParametro["recordsFiltered"]=$cant;
                $aParametro['data'] = $aData;
                $aParametro['msj'] = "No hay registros aún";
                return Response::json($aParametro);
        }
    }

}
