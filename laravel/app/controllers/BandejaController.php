<?php
class BandejaController extends BaseController
{
    public function postBandejatramite()
    {
        $r=Input::all();
        if ( $r->ajax() ) {
            $renturnModel = Bandeja::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }
}
/*
$retorno=array(
'rst'=>1
);

if( !Input::has('totaldatos') ){
$array['w']=" AND rd.dtiempo_final IS NULL ";
}

if( Input::has('id_union') AND Input::get('id_union')!='' ){
$id_union=explode(" ",trim(Input::get('id_union')));
for($i=0; $i<count($id_union); $i++){
$array['w'].=" AND tr.id_union LIKE '%".$id_union[$i]."%' ";
}
}

if( Input::has('id_ant') AND Input::get('id_ant')!='' ){
$id_ant=explode(" ",trim(Input::get('id_ant')));
for($i=0; $i<count($id_ant); $i++){
$array['w'].=" AND re.referido LIKE '%".$id_ant[$i]."%' ";
}
$array['referido']=' INNER ';
}

if( Input::has('solicitante') AND Input::get('solicitante')!='' ){
$solicitante=explode(" ",trim(Input::get('solicitante')));
$dsol=array();$dsol[0]=array();$dsol[1]=array();$dsol[2]=array();
$array['w'].=" AND ( ";
for($i=0; $i<count($solicitante); $i++){
array_push($dsol[0]," CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre) like '%".$solicitante[$i]."%' ");
array_push($dsol[1]," CONCAT(tr.razon_social,' | RUC:',tr.ruc) like '%".$solicitante[$i]."%' ");
array_push($dsol[2]," tr.area_id IN (SELECT nombre FROM areas WHERE nombre like '%".$solicitante[$i]."%') ");
}
$array['w'].=" (".implode(" AND ",$dsol[0]).") ";
$array['w'].=" OR (".implode(" AND ",$dsol[1]).") ";
$array['w'].=" OR (".implode(" AND ",$dsol[2]).") ";
$array['w'].=" )";
}

if( Input::has('proceso') AND Input::get('proceso')!='' ){
$proceso=trim(Input::get('proceso'));
$array['w'].=" AND f.nombre LIKE '%".$proceso."%' ";
}

if( Input::has('tiempo_final') AND Input::get('tiempo_final')!='' ){
$estadofinal=">=CURRENT_TIMESTAMP()";
if( Input::get('tiempo_final')=='0' ){
$estadofinal="<CURRENT_TIMESTAMP()";
}
$array['w'].="  AND CalcularFechaFinal(
rd.fecha_inicio, 
(rd.dtiempo*t.totalminutos),
rd.area_id 
)$estadofinal ";
}

if(Input::has('fecha_inicio_b') AND Input::get('fecha_inicio_b')!=''){
$fecha_inicio=explode(" - ",Input::get('fecha_inicio_b'));
$array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
}

if(Input::has('fechaRange') AND Input::get('fechaRange')!=''){
$fecha_inicio=explode(" - ",Input::get('fechaRange'));
$array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
}
*/
