<?php

class Area extends Base
{
    public $table = "areas";
    public static $where =['id', 'nombre', 'nemonico', 'id_int', 'id_ext', 'imagen', 'imagenc','imagenp', 'estado'];
    public static $selec =['id', 'nombre', 'nemonico', 'id_int', 'id_ext', 'imagen', 'imagenc','imagenp', 'estado'];
    /**
     * Cargos relationship
     */
    /*public function cargos()
    {
        return $this->belongsToMany('Cargo');
    }*/

    public static function getPersonasByArea($area_id){
        $sql = "SELECT acp.area_id FROM area_cargo_persona acp WHERE acp.estado=1 AND acp.area_id=".$area_id;
        $r= DB::select($sql);
        return $r[0];
    }
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(a.id) cant
                FROM areas a
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT a.id, a.nombre,a.nemonico,a.imagen,a.imagenc,a.imagenp, a.estado
                FROM areas a
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

  



    public function personas() {
        return $this->hasMany('Persona');
    }
    /**
     * Rutas relationship
     */
    public function rutas()
    {
        return $this->hasMany('Ruta');
    }

    public function getArea(){
        $area=DB::table('areas')
                ->select('id','nombre','nemonico','estado','imagen as evento')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                        if ( Input::has('areapersona') ){
                            $query->whereRaw('  FIND_IN_SET( id, 
                                                    (
                                                    SELECT GROUP_CONCAT(acp.area_id)
                                                    FROM area_cargo_persona acp
                                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                    WHERE acp.estado=1
                                                    AND cp.persona_id='.Auth::user()->id.'
                                                    )       )>0 ');
                        }
                        if ( Input::has('areagestion') ){
                            $query->where('area_gestion','>','0')
                            ->whereRaw('id!='.Auth::user()->area_id);
                        }
                        if ( Input::has('areagestionf') ){
                            $query->where('area_gestion_f','>','0')
                            ->whereRaw('id!='.Auth::user()->area_id);
                        }
                        if ( Input::has('omitir') ){
                            $query->where('id','!=','44');
                            $query->where('id','!=','54');
                        }
                        $rst=$this->getRol();
                        foreach ($rst as $value) {
                        $array[] = $value->cargo_id;}           
                        if ( Input::has('personal') && Auth::user()->area_id!=53 && Auth::user()->area_id!=31 && Auth::user()->id!=75 ){
                            if (!in_array(12, $array)) {
                            $query->where('id','=',Auth::user()->area_id);
                            
                        }
                        }
                        
                        if ( Input::has('responsable') ){
                            if (in_array(12, $array)){}else {
                            $query->where('id','=',Auth::user()->area_id);}
                        }

                        if ( Input::has('areagestionall') ){
                            $query->where('area_gestion','>','0');
                        }

                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $area;
    }
    
    public function getAreaUser(){
        $area=DB::table('areas')
                ->select('id','nombre','nemonico','estado','imagen as evento')
                ->where( 
                    function($query){
                        $query->where('area_gestion_f','=','1');

                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                        if ( Input::has('areapersona') ){
                            $query->whereRaw('  FIND_IN_SET( id, 
                                                    (
                                                    SELECT GROUP_CONCAT(acp.area_id)
                                                    FROM area_cargo_persona acp
                                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                    WHERE acp.estado=1
                                                    AND cp.persona_id='.Auth::user()->id.'
                                                    )       )>0 ');
                        }

                        if ( Input::has('areagestion') ){
                            $query->where('area_gestion','>','0')
                            ->whereRaw('id!='.Auth::user()->area_id);
                        }
                        if ( Input::has('areagestionf') ){
                            $query->where('area_gestion_f','>','0')
                            ->whereRaw('id!='.Auth::user()->area_id);
                        }
                        if ( Input::has('omitir') ){
                            $query->where('id','!=','44');
                            $query->where('id','!=','54');
                        }
                        $rst=$this->getRol();
                        foreach ($rst as $value) {
                        $array[] = $value->cargo_id;}           
                        if ( Input::has('personal') && Auth::user()->area_id!=53 && Auth::user()->area_id!=31 && Auth::user()->id!=75 ){
                            if (!in_array(12, $array)) {
                            $query->where('id','=',Auth::user()->area_id);
                            
                        }
                        }
                        
                        if ( Input::has('responsable') ){
                            if (in_array(12, $array)){}else {
                            $query->where('id','=',Auth::user()->area_id);}
                        }

                        if ( Input::has('areagestionall') ){
                            $query->where('area_gestion','>','0');
                        }

                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $area;
    }

    public static function getRol(){
        $sql = "SELECT cp.cargo_id
                FROM personas p
                INNER JOIN cargo_persona cp on p.id=cp.persona_id and cp.estado=1

                WHERE p.id=".Auth::user()->id;
        $result = DB::select($sql);
        
        return $result;
    }

    public function getListar(){
        $area=DB::table('areas')
                ->select('id','nombre','nemonico','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                        if ( Input::has('areagestionall') ){
                            $query->where('area_gestion','>','0');
                        }
                        if ( Input::has('areapersona') ){

                            if ( Input::has('areagerencia') ){
                                $sql = "SELECT acp.area_id
                                    FROM area_cargo_persona acp
                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1 and cp.cargo_id IN (5,12)
                                    WHERE acp.estado=1
                                    AND cp.persona_id=".Auth::user()->id;
                            }else{
                                $sql = "SELECT acp.area_id
                                    FROM area_cargo_persona acp
                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                    WHERE acp.estado=1
                                    AND cp.persona_id=".Auth::user()->id;
                            }

                            $areas= DB::select($sql);
                            $areas_id = '';
                            foreach($areas as $key => $value){
                                $areas_id.= ($key == 0) ? $value->area_id : ','.$value->area_id; 
                            }
                            $query->whereRaw('FIND_IN_SET( id,"'.$areas_id.'")>0 ');
                        }
                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $area;
    }

    public static function getAreasGerencia(){
        $sql = "SELECT a.id,a.nombre,p.id relation,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) concat 
                FROM areas a 
                INNER JOIN area_cargo_persona acp ON acp.area_id=a.id AND acp.estado=1
                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1 AND cp.cargo_id=5
                INNER JOIN personas p ON p.id=cp.persona_id AND p.estado = 1 AND p.rol_id IN (8,9) 
                WHERE a.estado=1 AND a.area_gestion=1";
        $result = DB::select($sql);
        return ($result) ? $result : false;
    }
    
    public static function getAreasGerenciaPersona(){
        $sql = "SELECT CONCAT_WS('|',a.id,p.id) as id,a.nombre,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) concat 
                FROM areas a 
                INNER JOIN personas p ON (p.area_id=a.id OR FIND_IN_SET(a.id,p.area_responsable)) AND p.estado = 1 AND p.rol_id IN (8,9,6) 
                WHERE a.estado=1 AND a.area_gestion=1
                ORDER BY a.nombre asc";
        $result = DB::select($sql);
        return ($result) ? $result : false;
    }

    public static function getPersonasFromArea(){
        if(Input::get('area_id')){
            $sql = "";
            $sql.= "SELECT acp.area_id areaid,p.id,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) nombre FROM personas p 
                    INNER JOIN cargo_persona cp ON cp.persona_id=p.id AND p.estado=1 
                    INNER JOIN area_cargo_persona acp ON acp.cargo_persona_id=cp.id AND acp.estado=1 AND acp.area_id=".Input::get('area_id');

            if(Input::get('persona')){
                $sql.=" WHERE p.id <>".Input::get('persona');
            }

            $sql.=" GROUP BY cp.persona_id";
            $result = DB::select($sql);
            return ($result) ? $result : false;
        }else{
            return false;
        }
    }

    public static function getAllPersonsFromArea(){
         if(Input::get('area_id')){
            $sql = "";
            $sql.= "SELECT p.area_id areaid,p.id,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) nombre FROM personas p 
                    WHERE p.estado=1 AND p.area_id=".Input::get('area_id')." OR p.area_responsable=".Input::get('area_id');

            if(Input::get('persona')){
                $sql.=" AND p.id <>".Input::get('persona');
            }

            $sql.=" GROUP BY p.id";
            $result = DB::select($sql);
            return ($result) ? $result : false;
        }else{
            return false;
        }
    }


    public static function OrdenTrabjbyArea()
    {     

//        $area_id=Input::get('area_id');
/*        if(is_array(Input::get('area_id'))){
            $area_id = Input::get('area_id')[0];
        }else{
            $area_id = Input::get('area_id');
        }*/

        //3199
        $sSql = '';

        $sSql.= "SELECT CONCAT_WS(' ',p1.nombre,p1.paterno,p1.materno) as asignador,ap.id norden,a.nombre area,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) persona,COUNT(ap.id) as cantidad,ABS(SUM(ap.ot_tiempo_transcurrido)) as total,SEC_TO_TIME(ABS(SUM(ap.ot_tiempo_transcurrido)) * 60) formato 

                FROM  actividad_personal ap 
                INNER JOIN areas a ON a.id=ap.area_id AND a.estado=1
                INNER JOIN personas p ON p.id=ap.persona_id AND p.estado=1
                INNER JOIN personas p1 on ap.usuario_created_at=p1.id AND p1.estado=1
                WHERE ap.estado=1";

        if(Input::has('fecha') && Input::get('fecha')){
            $fecha = Input::get('fecha');
            list($fechaIni,$fechaFin) = explode(" - ", $fecha);
            $sSql.= " AND DATE(ap.fecha_inicio) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
        }
         if(Input::has('area_id') && Input::get('area_id')){
            $area_id=Input::get('area_id');
            $sSql.= " AND ap.area_id IN ($area_id) ";
        }
        
        if(Input::has('distinto') && Input::get('distinto')){
           
            $sSql.= " AND ap.tipo=2 ";
        }
        
        $sSql.="  GROUP BY ap.area_id,ap.persona_id";

        $oData= DB::select($sSql);
        return $oData;
    }
    
        public static function getAreaNotificacion( )
    {
        $sSql=" SELECT a.id, a.nombre
                FROM areas a 
		INNER JOIN personas p on p.area_id=a.id and rol_id in (9,8) and p.estado=1
                WHERE a.area_gestion=1 and a.estado=1 ";
        $oData = DB::select($sSql);
        return $oData;
    }
}
