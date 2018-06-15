<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Persona extends Base implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = "personas";
    protected $fillable = [
        'paterno',
        'materno',
        'nombre',
        'dni',
        'email',
        'email_mdi',
        'direccion',
        'telefono',
        'celular',
        'password',
        'rol_id',
        'area_id',
        'estado',
        'fecha_nacimiento',
        'imagen',
        'imagen_dni',
        'sexo',
        'modalidad',
        'vista_doc'
    ];
    public $hidden = ['password', 'remember_token'];
    public static $rules = [
        'paterno' => 'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
        'materno' => 'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
        'nombre' => 'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
        'usuario' => 'required|min:8|unique:personas,dni', //dni
        'email' => 'required|email|unique:personas',
        'password' => 'required|alpha_num|between:6,12|confirmed',
        'password_confirmation' => 'required|alpha_num|between:6,12',
        'recaptcha' => 'required',
        'captcha' => 'required|min:1'
    ];
    public static $messajes = [
        'paterno.required' => 'apellido paterno es requerido.',
        'materno.required' => 'Apellido materno es requerido.',
        'nombre.required' => 'Nombre es requerido.',
        'usuario.required' => 'DNI es requerido.',
        'usuario.unique' => ' DNI ya ha sido registrado.',
        'usuario.min' => ' DNI necesita tener al menos 6 caracteres',
        'email.required' => 'Email es requerido.',
        'email.email' => 'Email no es valido',
        'email.unique' => 'El email ya ha sido registrado.',
        'password.required' => 'Password  es requerido.',
        'password.min' => 'Password necesita tener al menos 6 caracteres',
        'password.alpha_num' => 'Password solo puede contener letras y numeros',
        'password.confirmed' => 'la confirmacion de Password no coincide.',
        'password_confirmation.alpha_num' => 'la confirmacion de Password solo puede contener letras y numeros',
        //'password.max'          => 'Password maximum length is 20 characters',
        'recaptcha.required' => 'Captcha es requerido',
        'captcha.min' => 'mal captcha, por favor intente nuevamente.'
    ];

    /**
     * 
     */
    public function getReminderEmail() {
        return $this->email;
    }

    public static function getExoneraciones(){
        $sql = "SELECT *
                FROM persona_exoneracion pe
                WHERE pe.estado!=0 and pe.persona_id=".Input::get('persona_id');
        $rst = DB::select($sql);
        return $rst;
    }

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        static::creating(function ($user) {
            $user->token = str_random(30);
        });
    }

    /**
     * Set the password attribute.
     *
     * @param string $password
     */
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail() {
        $this->verified = true;
        $this->token = null;
        $this->save();
    }

    /**
     * 
     */
    public function cargos() {
        return $this->belongsToMany('Cargo');
    }

    /**
     * 
     */
    public function conversations() {
        return $this->belongsToMany('Conversation', 'conversations_users', 'user_id', 'conversation_id');
    }

    /**
     * 
     */
    public function areas() {
        return $this->belongsTo('Area', 'area_id');
    }

    /**
     * Empresa relationship
     */
    public function empresas() {
        return $this->belongsToMany('Empresa')->withTimestamps();
    }

    /**
     * 
     */
    public function getFullNameAttribute() {
        return "$this->paterno $this->materno, $this->nombre";
    }

    /**
     * 
     */
    public function getImgAttribute() {
        if (isset($this->imagen)) {
            return 'img/user/' . md5('u' . $this->id) . '/' . $this->imagen;
        }
        return 'img/admin/M.jpg';
    }


    public static $where = [
        'id', 'paterno', 'materno', 'nombre', 'dni', 'sexo', 'area_id', 'rol_id',
        'estado', 'envio_actividad', 'modalidad', 'vista_doc', 'email', 'email_mdi', 'fecha_nacimiento', 'password',
    ];
    public static $selec = [
        'id', 'paterno', 'materno', 'nombre', 'dni', 'sexo', 'area_id', 'rol_id',
        'estado', 'envio_actividad', 'email', 'email_mdi', 'fecha_nacimiento', 'password', 'modalidad', 'vista_doc'
    ];

    public static function getCargar($array) {

        $sSql = " SELECT p.id ,a.id area_id,r.id rol_id, p.paterno, p.materno, p.nombre,p.dni,p.sexo sexo_id,p.fecha_nacimiento,

                                a.nombre area,r.nombre rol, 
                                p.estado,p.email, p.email_mdi, p.password,
                                CASE p.sexo
                                WHEN 'M' THEN 'Masculino'
                                WHEN 'F' THEN 'Femenino'
                                END sexo,

                                p.modalidad modalidad_id,
                                CASE p.modalidad
                                WHEN 1 THEN 'Trabajador'
                                WHEN 2 THEN 'Tercero'
                                END modalidad,

                                p.vista_doc vista_doc_id,
                                CASE p.vista_doc
                                WHEN 1 THEN 'Si'
                                WHEN 0 THEN 'No'
                                END vista_doc
                FROM personas p
                LEFT JOIN roles r ON r.id=p.rol_id 
                LEFT JOIN areas a ON a.id=p.area_id 
                
                                WHERE 1=1";
        $sSql .= $array['where'] .
                $array['order'] .
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

    public static function getCargarp() {
        $sql = "  SELECT p.id ,a.id area_id,r.id rol_id,p.dni,
                    p.paterno,p.materno,p.nombre,a.nombre area,r.nombre rol
                FROM personas p
                INNER JOIN areas a ON a.id=p.area_id 
                INNER JOIN roles r ON r.id=p.rol_id 
                WHERE p.estado=1
                AND p.area_id='" . Input::get('area_id') . "'";
        $personas = DB::select($sql);

        return $personas;
    }

    public static function getCargarCount($array) {
        $sSql = " SELECT COUNT(p.id) cant
                FROM personas p
                INNER JOIN roles r ON r.id=p.rol_id
                INNER JOIN areas a ON a.id=p.area_id
                WHERE 1=1 ";
        $sSql .= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getPersonas() {
        $where = "";
        $select = " CONCAT(p.id,'-',a.id) id,
                    p.paterno,p.materno,p.nombre nombres,p.dni,a.nombre area,
                    CONCAT(p.paterno,' ',substr(p.materno,1,4),'. ',substr(p.nombre,1,7),'. |',a.nombre) nombre ";
        if (Input::has('solo_area')) {
            $area = Auth::user()->area_id;
            $where = " AND FIND_IN_SET(p.area_id, $area )>0 ";
            $select = " p.id,CONCAT(p.paterno,' ',substr(p.materno,1,4),'. ',substr(p.nombre,1,7)) nombre ";
        }
        else if (Input::has('area_documento')) {
            $id = Input::get('ruta_detalle_id');
            $rd = RutaDetalle::find($id);
            $where = " AND (p.area_id =".$rd->area_id." or FIND_IN_SET(p.area_id,"
                    . "(SELECT p2.area_responsable "
                    . "FROM personas p2 "
                    . "WHERE p2.area_id=".$rd->area_id." AND rol_id IN (8,6,9) AND p2.estado=1"
                    . ")))";
            $select = " p.id,CONCAT(p.paterno,' ',substr(p.materno,1,4),'. ',substr(p.nombre,1,7)) nombre ";
        }
        $sql = "  SELECT $select
                FROM personas p
                LEFT JOIN areas a ON a.id=p.area_id 
                WHERE p.estado=1
                $where
                GROUP BY p.id,a.id
                ORDER BY p.paterno,p.materno,p.nombre";

        $personas = DB::select($sql);
        return $personas;
    }

    public static function getApellidoNombre() {
        $sql = "  SELECT p.id id,
                    CONCAT_WS(' ',p.paterno,p.materno,p.nombre) nombre,p.nombre name,p.paterno,p.materno,p.email,p.dni,p.area_id,p.direccion,p.telefono
                FROM personas p
                WHERE p.estado=1
                ORDER BY p.paterno,p.materno,p.nombre";

        $personas = DB::select($sql);
        return $personas;
    }

    public static function get(array $data = array()) {

        //recorrer la consulta
        $personas = parent::get($data);

        foreach ($personas as $key => $value) {
            if ($key == 'password') {
                $personas[$key]['password'] = '';
            }
        }

        return $personas;
    }

    public static function getAreas($personaId) {
        //subconsulta
        $sql = DB::table('cargo_persona as cp')
                ->join(
                        'cargos as c', 'cp.cargo_id', '=', 'c.id'
                )
                ->join(
                        'area_cargo_persona as acp', 'cp.id', '=', 'acp.cargo_persona_id'
                )
                ->join(
                        'areas as a', 'acp.area_id', '=', 'a.id'
                )
                ->select(
                        DB::raw(
                                "
                CONCAT(c.id, '-',
                    GROUP_CONCAT(a.id)
                ) AS info"
                        )
                )
                ->whereRaw("cp.persona_id=$personaId AND cp.estado=1 AND c.estado=1 AND acp.estado=1")
                //->where("cp.persona_id",$personaId)
                //->where("cp.estado","1")
                //->where("c.estado","1")
                //->where("acp.estado","1")
                ->groupBy('c.id');
        //consulta
        $areas = DB::table(DB::raw("(" . $sql->toSql() . ") as a"))
                ->select(
                        DB::raw("GROUP_CONCAT( info SEPARATOR '|'  ) as DATA ")
                )
                ->get();

        return $areas;
    }

    public static function ListarUsuarios() {
        $areaId = '';
        if (Input::get('export')) {
            $areaId = Input::get('area_id');
        } else {
            if(is_array(Input::get('area_id'))){
                $areaId = implode("','", Input::get('area_id'));                
            }else{
                $areaId = Input::get('area_id');
            }
        }

        $sql = "SELECT p.id norden,p.paterno,p.materno,p.nombre,p.email, p.email_mdi, p.dni,p.fecha_nacimiento,
                CASE p.sexo
                WHEN 'F' THEN 'Femenino'
                WHEN 'M' THEN 'Masculino'
                END sexo,
                CASE p.modalidad
                WHEN 1 THEN 'Trabajador'
                WHEN 2 THEN 'Tercero'
                END modalidad,
                CASE p.estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                END estado,
                a.nombre area,r.nombre rol,p.envio_actividad,DATE_FORMAT(p.fecha_ini_exonera,'%Y-%m-%d') as fechaini ,DATE_FORMAT(p.fecha_fin_exonera,'%Y-%m-%d') as fechafin,p.responsable_asigt,p.responsable_dert,
                p.resolucion, p.cod_inspector, p.area_id, p.imagen_dni
                FROM personas p
                INNER JOIN areas a on p.area_id=a.id
                INNER JOIN roles r on p.rol_id=r.id
                -- WHERE a.id IN ('$areaId') 
                WHERE (a.id IN ('$areaId') 
                                OR FIND_IN_SET(a.id IN ('$areaId'), a.area_responsable))
                AND p.estado=1
                ORDER BY p.paterno";
        //echo $sql;
        $r = DB::select($sql);

        return $r;
    }

    public static function VerUsuarios($area_id, $dni) {
        $areaId = '';
        if(is_array($area_id)){
            $areaId = implode("','", $area_id);                
        }else{
            $areaId = $area_id;
        }

        $sql = "SELECT p.id norden,p.paterno,p.materno,p.nombre,p.email, p.email_mdi, p.dni,p.fecha_nacimiento,
                CASE p.sexo
                WHEN 'F' THEN 'Femenino'
                WHEN 'M' THEN 'Masculino'
                END sexo,
                CASE p.modalidad
                WHEN 1 THEN 'Trabajador'
                WHEN 2 THEN 'Tercero'
                END modalidad,
                CASE p.estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                END estado,
                a.nombre area,r.nombre rol,p.envio_actividad,DATE_FORMAT(p.fecha_ini_exonera,'%Y-%m-%d') as fechaini ,DATE_FORMAT(p.fecha_fin_exonera,'%Y-%m-%d') as fechafin,p.responsable_asigt,p.responsable_dert,
                p.resolucion, p.cod_inspector, p.imagen_dni
                FROM personas p
                INNER JOIN areas a on p.area_id=a.id
                INNER JOIN roles r on p.rol_id=r.id
                WHERE (a.id IN ('$areaId') 
                                OR FIND_IN_SET(a.id IN ('$areaId'), a.area_responsable))
                -- AND p.estado=1
                AND p.dni = '$dni'
                ORDER BY p.paterno";
        
        $r = DB::select($sql);

        return $r;
    }

    public static function VerTodosUsuarios($area_id) {
        $areaId = '';
        if(is_array($area_id)){
            $areaId = implode("','", $area_id);                
        }else{
            $areaId = $area_id;
        }

        $sql = "SELECT p.id norden,p.paterno,p.materno,p.nombre,p.email, p.email_mdi, p.dni,p.fecha_nacimiento,
                CASE p.sexo
                WHEN 'F' THEN 'Femenino'
                WHEN 'M' THEN 'Masculino'
                END sexo,
                CASE p.modalidad
                WHEN 1 THEN 'Trabajador'
                WHEN 2 THEN 'Tercero'
                END modalidad,
                CASE p.estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                END estado,
                a.nombre area,r.nombre rol,p.envio_actividad,DATE_FORMAT(p.fecha_ini_exonera,'%Y-%m-%d') as fechaini ,DATE_FORMAT(p.fecha_fin_exonera,'%Y-%m-%d') as fechafin,p.responsable_asigt,p.responsable_dert,
                p.resolucion, p.cod_inspector, p.imagen_dni
                FROM personas p
                INNER JOIN areas a on p.area_id=a.id
                INNER JOIN roles r on p.rol_id=r.id
                WHERE (a.id IN ('$areaId') 
                                OR FIND_IN_SET(a.id IN ('$areaId'), a.area_responsable))
                AND p.estado=1
                ORDER BY p.paterno";

        $r = DB::select($sql);

        return $r;
    }

    public static function ProduccionUsuario($fecha, $id_usuario) {
        $query = '';

        $query .= "select COUNT(rdv.id) as tareas
                from rutas_detalle_verbo rdv
                INNER JOIN rutas_detalle rd on rdv.ruta_detalle_id=rd.id AND rdv.estado=1 AND rd.estado=1                        
                INNER JOIN rutas r on rd.ruta_id=r.id   AND r.estado=1                                                   
                INNER JOIN flujos f on r.flujo_id=f.id 
                WHERE rdv.finalizo=1 
                AND rdv.usuario_updated_at=$id_usuario";

        if ($fecha != '') {
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $query .= ' AND date(rdv.updated_at) BETWEEN "' . $fechaIni . '" AND "' . $fechaFin . '" ';
        }
        $r = DB::select($query);

        return $r;
    }

    public static function ProduccionUsuarioxArea($fecha, $id_usuario) {
        $query = '';

        $query .= "select f.id,f.nombre ,COUNT(rdv.id) AS tareas
            from rutas_detalle_verbo rdv 
            INNER JOIN rutas_detalle rd on rdv.ruta_detalle_id=rd.id AND rdv.estado=1 AND rd.estado=1                        
            INNER JOIN rutas r on rd.ruta_id=r.id   AND r.estado=1                                                   
            INNER JOIN flujos f on r.flujo_id=f.id
            WHERE rdv.finalizo=1 
            AND rdv.usuario_updated_at=$id_usuario";

        if ($fecha != '') {
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $query .= ' AND date(rdv.updated_at) BETWEEN "' . $fechaIni . '" AND "' . $fechaFin . '" ';
        }
        $query .= 'GROUP BY f.id';
        $r = DB::select($query);

        return $r;
    }

    public static function ProduccionTramiteAsignadoTotal($fecha, $id_usuario) {
        $query = '';

        $query .= "SELECT COUNT(tr.id) as tareas
                    FROM tablas_relacion tr 
                    INNER JOIN rutas r on tr.id=r.tabla_relacion_id AND r.estado=1
                    INNER JOIN flujos f on r.flujo_id=f.id
                    WHERE tr.estado=1
                    AND tr.usuario_created_at=$id_usuario";

        if ($fecha != '') {
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $query .= ' AND date(tr.created_at) BETWEEN "' . $fechaIni . '" AND "' . $fechaFin . '" ';
        }
        $r = DB::select($query);

        return $r;
    }

    public static function ProduccionTramiteAsignado($fecha, $id_usuario) {
        $query = '';

        $query .= "SELECT f.id,f.nombre,COUNT(tr.id) as tareas
                    FROM tablas_relacion tr 
                    INNER JOIN rutas r on tr.id=r.tabla_relacion_id AND r.estado=1
                    INNER JOIN flujos f on r.flujo_id=f.id
                    WHERE tr.estado=1 
                    AND tr.usuario_created_at=$id_usuario";

        if ($fecha != '') {
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $query .= ' AND date(tr.created_at) BETWEEN "' . $fechaIni . '" AND "' . $fechaFin . '" ';
        }
        $query .= 'GROUP BY f.id';
        $r = DB::select($query);

        return $r;
    }

    public static function getProduccionTramiteAsignadoDetalle($array) {

        $sSql = "SELECT f.nombre as proceso,a.nombre as area,tr.id_union,tr.sumilla,tr.created_at as fecha
                FROM tablas_relacion tr 
                INNER JOIN rutas r on tr.id=r.tabla_relacion_id AND r.estado=1
                INNER JOIN flujos f on r.flujo_id=f.id
                INNER JOIN areas a on r.area_id=a.id
                WHERE tr.estado=1";
        $sSql .= $array['where'] .
                $array['order'] .
                $array['limit'];

        $oData = DB::select($sSql);

        return $oData;
    }

    public static function getPTADCount($array) {

        $sSql = "SELECT COUNT(tr.id) cant
                    FROM tablas_relacion tr 
                    INNER JOIN rutas r on tr.id=r.tabla_relacion_id AND r.estado=1
                    INNER JOIN flujos f on r.flujo_id=f.id
                    INNER JOIN areas a on r.area_id=a.id
                    WHERE tr.estado=1";
        $sSql .= $array['where'];

        $oData = DB::select($sSql);

        return $oData[0]->cant;
    }

    public static function getDetalleProduccion($array) {

        $sSql = "select f.nombre as proceso,a.nombre as area,rdv.nombre  as tarea,
                    v.nombre as verbo,rdv.documento,rdv.observacion,rd.norden as nroacti,rdv.updated_at
                    from rutas_detalle_verbo rdv 
                    INNER JOIN verbos v on rdv.verbo_id=v.id
                    INNER JOIN rutas_detalle rd on rdv.ruta_detalle_id=rd.id AND rdv.estado=1 AND rd.estado=1
                    INNER JOIN areas a on rd.area_id=a.id                        
                    INNER JOIN rutas r on rd.ruta_id=r.id   AND r.estado=1                                                   
                    INNER JOIN flujos f on r.flujo_id=f.id
                    WHERE rdv.finalizo=1";
        $sSql .= $array['where'] .
                $array['order'] .
                $array['limit'];

        $oData = DB::select($sSql);

        return $oData;
    }

    public static function getDPCount($array) {

        $sSql = "select COUNT(rdv.id) cant
                    from rutas_detalle_verbo rdv 
                    INNER JOIN verbos v on rdv.verbo_id=v.id
                    INNER JOIN rutas_detalle rd on rdv.ruta_detalle_id=rd.id AND rdv.estado=1 AND rd.estado=1
                    INNER JOIN areas a on rd.area_id=a.id                        
                    INNER JOIN rutas r on rd.ruta_id=r.id   AND r.estado=1                                                   
                    INNER JOIN flujos f on r.flujo_id=f.id
                    WHERE rdv.finalizo=1";
        $sSql .= $array['where'];

        $oData = DB::select($sSql);

        return $oData[0]->cant;
    }

    /* public static function getCargoArea()
      {
      $query = DB::table('tipos_respuesta_detalle as trd')
      ->join(
      'tipos_respuesta as tr',
      'trd.tipo_respuesta_id', '=', 'tr.id'
      )
      ->select(
      'trd.id',
      'trd.nombre',
      'trd.estado',
      'tr.nombre as tiporespuesta',
      'tr.id as tiporespuesta_id'
      )
      ->where('tr.estado', '=', 1)
      ->get();
      $personas =  DB::table('personas as p')
      ->join(
      'empresas as e',
      'u.empresa_id', '=', 'e.id'
      )
      ->join(
      'perfiles as p',
      'u.perfil_id', '=', 'p.id'
      )
      ->select(
      'p.id',
      'p.paterno',
      'p.materno',
      'p.nombre',
      'p.email',
      'p.dni',
      'p.password',
      'p.fecha_nacimiento',
      'p.estado',
      'p.imagen',
      'a.nombre as empresa',
      'c.nombre as perfil'
      )
      ->get();
      return $query;
      } */

    public static function ProduccionTRPersonalxArea($fecha, $id_area) {
        $query = '';

        $query .= "select a.nombre as area,rdv.usuario_updated_at,rd.area_id,f.id,f.nombre ,COUNT(rdv.id) AS tareas
                   from rutas_detalle_verbo rdv 
                   INNER JOIN rutas_detalle rd on rdv.ruta_detalle_id=rd.id AND rdv.estado=1 AND rd.estado=1
                   INNER JOIN areas a on rd.area_id=a.id
                   INNER JOIN rutas r on rd.ruta_id=r.id    AND r.estado=1                                                   
                   INNER JOIN flujos f on r.flujo_id=f.id
                   WHERE rdv.estado=1 
                   AND rdv.finalizo=1 
                   AND rd.area_id IN ($id_area)
                   ";
        if ($fecha != '') {
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $query .= ' AND date(rdv.updated_at) BETWEEN "' . $fechaIni . '" AND "' . $fechaFin . '" ';
        }
        $query .= 'GROUP BY rd.area_id,f.id WITH ROLLUP ';

        $r = DB::select($query);

        return $r;
    }

    public static function getProduccionTRPersonalxAreaDetalle($array) {

        $sSql = "select f.nombre as proceso,a.nombre as area,CONCAT(p.paterno,' ', p.materno,' ',p.nombre) as persona,rdv.nombre  as tarea,
                v.nombre as verbo,rdv.documento,rdv.observacion,rd.norden,rdv.updated_at
                from rutas_detalle_verbo rdv 
                INNER JOIN verbos v on rdv.verbo_id=v.id
                INNER JOIN personas p on rdv.usuario_updated_at=p.id
                INNER JOIN rutas_detalle rd on rdv.ruta_detalle_id=rd.id AND rdv.estado=1 AND rd.estado=1
                INNER JOIN areas a on rd.area_id=a.id                        
                INNER JOIN rutas r on rd.ruta_id=r.id   AND r.estado=1                                                   
                INNER JOIN flujos f on r.flujo_id=f.id
                WHERE rdv.estado=1 
                AND rdv.finalizo=1";
        $sSql .= $array['where'] .
                $array['order'] .
                $array['limit'];
        $oData = DB::select($sSql);

        return $oData;
    }

    public static function getPTRPxACount($array) {

        $sSql = "select COUNT(rdv.id) cant
                from rutas_detalle_verbo rdv 
                INNER JOIN verbos v on rdv.verbo_id=v.id
                INNER JOIN rutas_detalle rd on rdv.ruta_detalle_id=rd.id AND rdv.estado=1 AND rd.estado=1
                INNER JOIN areas a on rd.area_id=a.id                        
                INNER JOIN rutas r on rd.ruta_id=r.id   AND r.estado=1                                                   
                INNER JOIN flujos f on r.flujo_id=f.id
                WHERE rdv.estado=1 
                AND rdv.finalizo=1";
        $sSql .= $array['where'];

        $oData = DB::select($sSql);

        return $oData[0]->cant;
    }

    public static function ProduccionTAPersonalxArea($fecha, $id_area) {
        $query = '';

        $query .= "SELECT a.nombre as area,tr.area_id,f.id,f.nombre,COUNT(tr.id) as tareas
                    FROM tablas_relacion tr 
                    INNER JOIN areas a on tr.area_id=a.id
                    INNER JOIN rutas r on tr.id=r.tabla_relacion_id AND r.estado=1
                    INNER JOIN flujos f on r.flujo_id=f.id
                    WHERE tr.estado=1 
                   AND tr.area_id IN ($id_area)
                   ";
        if ($fecha != '') {
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $query .= ' AND date(tr.created_at) BETWEEN "' . $fechaIni . '" AND "' . $fechaFin . '" ';
        }
        $query .= 'GROUP BY tr.area_id,f.id WITH ROLLUP ';

        $r = DB::select($query);

        return $r;
    }

    public static function getProduccionTAPersonalxAreaDetalle($array) {

        $sSql = "SELECT a.nombre as area,CONCAT(p.paterno,' ',p.materno,' ',p.nombre) as persona,f.nombre as proceso,tr.id_union,tr.sumilla,tr.created_at as fecha
                FROM tablas_relacion tr 
                INNER JOIN personas p on tr.usuario_created_at=p.id
                INNER JOIN rutas r on tr.id=r.tabla_relacion_id AND r.estado=1
                INNER JOIN flujos f on r.flujo_id=f.id
                INNER JOIN areas a on tr.area_id=a.id
                WHERE tr.estado=1";
        $sSql .= $array['where'] .
                $array['order'] .
                $array['limit'];
        $oData = DB::select($sSql);

        return $oData;
    }

    public static function getPTAPxACount($array) {

        $sSql = "SELECT COUNT(tr.id) cant
                FROM tablas_relacion tr 
                INNER JOIN personas p on tr.usuario_created_at=p.id
                INNER JOIN rutas r on tr.id=r.tabla_relacion_id AND r.estado=1
                INNER JOIN flujos f on r.flujo_id=f.id
                INNER JOIN areas a on tr.area_id=a.id
                WHERE tr.estado=1";
        $sSql .= $array['where'];

        $oData = DB::select($sSql);

        return $oData[0]->cant;
    }

    public static function getEnviosSGCFaltas($array) {

        $sSql = "SELECT acs.persona,acs.nro_faltas,acs.nro_inasistencias,acs.fecha_notificacion,
                CASE acs.ultimo_registro WHEN 1 THEN 'X' WHEN 0 THEN '' ELSE acs.ultimo_registro END AS ultimo
                FROM alertas_seguridad_ciudadana acs
                WHERE 1=1";
        $sSql .= $array['where'];

        $oData = DB::select($sSql);

        return $oData;
    }

    public static function OrdenTrabjbyPersona() {
        $sSql = '';
        $left='';
        $variable='';
        if (Input::has('distinto') && Input::get('distinto')) {
            $left=" LEFT JOIN actividad_personal ap1 ON ap.id=ap1.actividad_asignada_id and ap1.estado=1 ";
            $variable=" COUNT(ap1.id)  as resultado,IFNULL(GROUP_CONCAT(ap1.actividad),'') as descripcion_resultado, ";
        }
        
        $sSql .= "SELECT ".$variable." a.nombre area,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) persona,CONCAT_WS(' ',p1.nombre,p1.paterno,p1.materno) as asignador,ap.id norden,ap.actividad,ap.fecha_inicio,ap.dtiempo_final,ABS(ap.ot_tiempo_transcurrido) ot_tiempo_transcurrido ,SEC_TO_TIME(ABS(ap.ot_tiempo_transcurrido) * 60) formato 
                ,GROUP_CONCAT(ddt.titulo) AS doc_digital,GROUP_CONCAT(ddt.id) AS doc_digital_id
                ,GROUP_CONCAT(ddt1.titulo) AS doc_digital1,GROUP_CONCAT(ddt1.id) AS doc_digital_id1,f.nombre as flujo, ap.cargo_dir
                FROM  actividad_personal ap 
                INNER JOIN areas a ON a.id=ap.area_id AND a.estado=1
                INNER JOIN personas p ON p.id=ap.persona_id AND p.estado=1
                INNER JOIN personas p1 on ap.usuario_created_at=p1.id AND p1.estado=1 ". $left;
        $sSql .=" LEFT JOIN actividad_personal_docdigital apd ON apd.actividad_personal_id=ap.id
                LEFT JOIN doc_digital_temporal ddt ON ddt.id=apd.doc_digital_id
                LEFT JOIN actividad_personal_docdigital apd1 ON apd1.actividad_personal_id=ap1.id
                LEFT JOIN doc_digital_temporal ddt1 ON ddt1.id=apd1.doc_digital_id
                INNER JOIN rutas r ON r.id=ap.ruta_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                WHERE ap.estado=1";

        if (Input::has('fecha') && Input::get('fecha')) {
            $fecha = Input::get('fecha');
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $sSql .= " AND DATE(ap.fecha_inicio) BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "' ";
        }

        if (Input::has('usuario_id') && Input::get('usuario_id')) {
            $sSql .= " AND ap.persona_id='" . Input::get('usuario_id') . "'  AND ap.tipo=1 ";
        }

        if (Input::has('distinto') && Input::get('distinto')) {

            $sSql .= " AND ap.tipo=2 ";

            if (Input::has('area_id') && Input::get('area_id')) {
                $area_id = Input::get('area_id');
                $sSql .= " AND ap.area_id IN ($area_id) ";
            }
        }
        $sSql .= "GROUP BY ap.id";
        $oData = DB::select($sSql);
        return $oData;
    }

    public static function getPersonById() {
        $sSql = '';
        $sSql .= "SELECT * FROM personas WHERE id='" . Input::get('persona_id') . "'";

        $oData = DB::select($sSql);
        return $oData;
    }

    public static function CuadroProductividadActividad() {
        $sSql = '';
        $cl = '';
        $left = '';
        $f_fecha = '';
        $cabecera = [];
        $validar = [];

        if (Input::has('fecha') && Input::get('fecha')) {
            $fecha = Input::get('fecha');
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $f_fecha .= " AND DATE(ap.fecha_inicio) BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "' ";
        }

        $fechaIni_ = strtotime($fechaIni);
        $fechaFin_ = strtotime($fechaFin);
        $fecha = date_create($fechaIni);
        $n = 1;
        for ($i = $fechaIni_; $i <= $fechaFin_; $i += 86400) {
            $cl .= ",COUNT(ap$n.id) AS f$n,IFNULL(SEC_TO_TIME(ABS(SUM(ap$n.ot_tiempo_transcurrido)) * 60),'00:00')  h$n,IFNULL(GROUP_CONCAT(ap$n.id),'0') id$n,IFNULL(SUM(ap$n.ot_tiempo_transcurrido),0) v$n,ExoneraFecha(STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y'),p.id) as e$n";
            $left .= "LEFT JOIN actividad_personal ap$n on ap$n.id=ap.id AND  DATE(ap.fecha_inicio) = STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y')";
            $n++;
            array_push($validar,date('w', strtotime(date_format($fecha, 'Y-m-d'))));
            array_push($cabecera, date_format($fecha, 'Y-m-d'));
            date_add($fecha, date_interval_create_from_date_string('1 days'));
        }

        $sSql .= "SELECT a.nombre as area,CONCAT_WS(' ',p.paterno,p.materno,p.nombre) as persona, p.envio_actividad";
        $sSql .= $cl;
        $sSql .= ",COUNT(ap.id) AS f_total,IFNULL(SEC_TO_TIME(ABS(SUM(ap.ot_tiempo_transcurrido)) * 60),'00:00')  h_total,IFNULL(GROUP_CONCAT(ap.id),'0') id_total";
        $sSql .= " FROM personas p
                 INNER JOIN areas a on p.area_id=a.id
                 LEFT JOIN actividad_personal ap on ap.persona_id=p.id AND ap.estado=1 AND ap.tipo=1 " . $f_fecha;
        $sSql .= $left;
        $sSql .= " WHERE p.estado=1  AND p.rol_id NOT IN (8,9)";

        if (Input::has('area_id') && Input::get('area_id')) {
            $id_area = Input::get('area_id');
            $sSql .= " AND p.area_id IN ($id_area)";
        }

        $sSql .= " GROUP BY p.id ";

        
        $oData['cabecera'] = $cabecera;
        $oData['validar'] = $validar;
        $oData['data'] = DB::select($sSql);
        return $oData;
    }

    public static function CargarActividad() {
        $id_actividad = Input::get('id');
        $sSql = '';
        $sSql .= "SELECT GROUP_CONCAT( DISTINCT dd.titulo) as n_documento,GROUP_CONCAT( DISTINCT apa.ruta) as archivo,GROUP_CONCAT(DISTINCT apd.doc_digital_id) as documento,IFNULL(ap.cantidad,'') as cantidad,ap.id norden,ap.actividad,ap.fecha_inicio,ap.dtiempo_final,ABS(ap.ot_tiempo_transcurrido) ot_tiempo_transcurrido ,SEC_TO_TIME(ABS(ap.ot_tiempo_transcurrido) * 60) formato "
                . " FROM actividad_personal ap"
                . " LEFT JOIN actividad_personal_archivo apa ON apa.actividad_personal_id=ap.id"
                . " LEFT JOIN actividad_personal_docdigital apd ON apd.actividad_personal_id=ap.id "
                . " LEFT JOIN doc_digital dd ON dd.id=apd.doc_digital_id  "
                . "WHERE ap.id IN ($id_actividad) GROUP BY ap.id";

        $oData = DB::select($sSql);
        return $oData;
    }
    
        public static function MostrarTextoFecha() {
        $id_fecha = Input::get('id');
        $sSql = '';
        $sSql .= "SELECT pe.observacion"
                . " FROM persona_exoneracion pe WHERE pe.id = ".$id_fecha;

        $oData = DB::select($sSql);
        return $oData[0]->observacion;
    }

    public static function ExportCuadroProductividadActividad() {
        $sSql = '';
        $cl = '';
        $left = '';
        ;
        $f_fecha = '';
        $cabecera = [];
        $cabecera1 = [];
        $validar=[];

        if (Input::has('fecha') && Input::get('fecha')) {
            $fecha = Input::get('fecha');
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $f_fecha .= " AND DATE(ap.fecha_inicio) BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "' ";
        }

        $fechaIni_ = strtotime($fechaIni);
        $fechaFin_ = strtotime($fechaFin);
        $fecha = date_create($fechaIni);
        $n = 1;
        for ($i = $fechaIni_; $i <= $fechaFin_; $i += 86400) {
            $cl .= ",WEEKDAY(STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y')) as v$n,ExoneraFecha(STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y'),p.id) as e$n ,COUNT(ap$n.id) AS f$n,IFNULL(SEC_TO_TIME(ABS(SUM(ap$n.ot_tiempo_transcurrido)) * 60),'00:00')  h$n";
            $left .= "LEFT JOIN actividad_personal ap$n on ap$n.id=ap.id AND  DATE(ap.fecha_inicio) = STR_TO_DATE('" . date("d-m-Y", $i) . "','%d-%m-%Y')";
            $n++;
            array_push($validar,date('w', strtotime(date_format($fecha, 'Y-m-d'))));
            array_push($cabecera, date_format($fecha, 'Y-m-d'));
            array_push($cabecera, date_format($fecha, 'Y-m-d'));
            array_push($cabecera1, 'N° de Acti');
            array_push($cabecera1, 'T. Horas');
            date_add($fecha, date_interval_create_from_date_string('1 days'));
        }

        $sSql .= "SELECT 1 as norden,a.nombre as area,CONCAT_WS(' ',p.paterno,p.materno,p.nombre) as persona";
        $sSql .= $cl;
        $sSql .= ",COUNT(ap.id) AS f_total,IFNULL(SEC_TO_TIME(ABS(SUM(ap.ot_tiempo_transcurrido)) * 60),'00:00')  h_total";
        $sSql .= ",p.envio_actividad";
        $sSql .= " FROM personas p
                 INNER JOIN areas a on p.area_id=a.id
                 LEFT JOIN actividad_personal ap on ap.persona_id=p.id AND ap.estado=1 AND ap.tipo=1 " . $f_fecha;
        $sSql .= $left;
        $sSql .= " WHERE p.estado=1 AND p.rol_id NOT IN (8,9)";

        if (Input::has('area_id') && Input::get('area_id')) {
            $id_area = Input::get('area_id');
            $sSql .= " AND p.area_id IN ($id_area)";
        }

        $sSql .= " GROUP BY p.id ";


        $oData['cabecera'] = $cabecera;
        $oData['cabecera1'] = $cabecera1;
        $oData['validar'] = $validar;
        $oData['data'] = DB::select($sSql);
        return $oData;
    }

    public static function AlertasActividadArea() {

        $areaId = implode("','", Input::get('area_id'));

        $sql = "UPDATE personas 
                SET envio_actividad=" . Input::get('estado');
        $sql .= " WHERE area_id IN ('$areaId')";

        $r = DB::Update($sql);

        return $r;
    }
    
        public static function BuscarJefe($area_id,$persona_id) {
            
        $sSql = '';
        $sSql .= "SELECT COUNT(p.id) as cantidad
                    FROM personas p
                    WHERE  p.area_id=".$area_id." 
                    AND p.rol_id IN (8,9) AND p.estado=1
                    AND p.id!=".$persona_id;

        $oData = DB::select($sSql);
        return $oData[0]->cantidad;
    }
    
    public static function BuscarJefe1($area_id) {
            
        $sSql = '';
        $sSql .= "SELECT COUNT(p.id) as cantidad
                    FROM personas p
                    WHERE  p.area_id=".$area_id." 
                    AND p.rol_id IN (8,9) AND p.estado=1";

        $oData = DB::select($sSql);
        return $oData[0]->cantidad;
    }
    
    public static function ActualizarResponsable($area_id) {
            
            $sSql = 'UPDATE personas
                     SET responsable_asigt=0,
             responsable_dert=0
                     WHERE area_id= '.$area_id;
            
                DB::update($sSql);
    }
            
    public static function RequestActividades() {

        $sSql = "SELECT p.dni,p.area_id,ap.fecha_inicio,ap.dtiempo_final,ap.actividad
                 FROM actividad_personal ap
                 INNER JOIN personas p on ap.persona_id=p.id and p.estado=1
                 WHERE ap.area_id=".Input::get('area_id'). 
                 " AND DATE(ap.fecha_inicio) BETWEEN '".Input::get('inicio')."' AND '".Input::get('fin')."'";

        $oData = DB::select($sSql);
        return $oData;
    }

}
