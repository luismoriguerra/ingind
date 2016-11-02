<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Persona extends Base implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

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
            'direccion',
            'telefono',
            'celular',
            'password',
            'rol_id',
            'area_id',
            'estado',
            'fecha_nacimiento',
            'sexo'
    ];
    public $hidden = ['password', 'remember_token'];
    public static $rules = [
                'paterno'=>'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
                'materno'=>'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
                'nombre' =>'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
                'usuario'  =>'required|min:8|unique:personas,dni',//dni
                'email'  =>'required|email|unique:personas',
                'password'=>'required|alpha_num|between:6,12|confirmed',
                'password_confirmation'=>'required|alpha_num|between:6,12',
                'recaptcha'  => 'required',
                'captcha'               => 'required|min:1'
    ];
    public static $messajes = [
                'paterno.required'   => 'apellido paterno es requerido.',
                'materno.required'    => 'Apellido materno es requerido.',
                'nombre.required'    => 'Nombre es requerido.',
                'usuario.required'    => 'DNI es requerido.',
                'usuario.unique'    => ' DNI ya ha sido registrado.',
                'usuario.min'    => ' DNI necesita tener al menos 6 caracteres',
                'email.required'        => 'Email es requerido.',
                'email.email'           => 'Email no es valido',
                'email.unique'          => 'El email ya ha sido registrado.',
                'password.required'     => 'Password  es requerido.',
                'password.min'          => 'Password necesita tener al menos 6 caracteres',
                'password.alpha_num'    => 'Password solo puede contener letras y numeros',
                'password.confirmed'    => 'la confirmacion de Password no coincide.',
                'password_confirmation.alpha_num'    => 'la confirmacion de Password solo puede contener letras y numeros',
                //'password.max'          => 'Password maximum length is 20 characters',
                'recaptcha.required'             => 'Captcha es requerido',
                'captcha.min'           => 'mal captcha, por favor intente nuevamente.'
    ];

    /**
     * 
     */
    public function getReminderEmail()
    {
        return $this->email;
    }
    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
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
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
   
    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail()
    {
        $this->verified = true;
        $this->token = null;
        $this->save();
    }
    public function cargos()
    {
        return $this->belongsToMany('Cargo');
    }
    public function conversations() {
        return $this->belongsToMany('Conversation', 'conversations_users', 'user_id', 'conversation_id');
    }
    public function areas() {
        return $this->belongsTo('Area', 'area_id');
    }
    public function getFullNameAttribute(){
        return "$this->paterno $this->materno, $this->nombre";
    }
    public function getImgAttribute(){
        if (isset($this->imagen) ){
            return  'img/user/'.md5('u'.$this->id).'/'.$this->imagen;
        }
        return 'img/admin/M.jpg';
    }
    public static $where =[
                        'id', 'paterno','materno','nombre','email','dni','rol_id','area_id',
                        'password','fecha_nacimiento','sexo', 'estado'
                        ];
    public static $selec =[
                        'id', 'paterno','materno','nombre','email','dni','rol_id','area_id',
                        'password','fecha_nacimiento','sexo', 'estado'
                        ];

    public static function getCargar()
    {
        $sql="  SELECT p.id ,a.id area_id,r.id rol_id,p.dni,p.email,p.estado,
                    p.paterno,p.materno,p.nombre,a.nombre area,r.nombre rol
                FROM personas p
                LEFT JOIN areas a ON a.id=p.area_id 
                LEFT JOIN roles r ON r.id=p.rol_id ";
        $personas = DB::select($sql);

        return $personas;
    }

    public static function getCargarp()
    {
        $sql="  SELECT p.id ,a.id area_id,r.id rol_id,p.dni,
                    p.paterno,p.materno,p.nombre,a.nombre area,r.nombre rol
                FROM personas p
                INNER JOIN areas a ON a.id=p.area_id 
                INNER JOIN roles r ON r.id=p.rol_id 
                WHERE p.estado=1
                AND p.area_id='".Input::get('area_id')."'";
        $personas = DB::select($sql);

        return $personas;
    }

    public static function getPersonas()
    {
        $where="";
        $select=" CONCAT(p.id,'-',a.id) id,
                    p.paterno,p.materno,p.nombre nombres,p.dni,a.nombre area,
                    CONCAT(p.paterno,' ',substr(p.materno,1,4),'. ',substr(p.nombre,1,7),'. |',a.nombre) nombre ";
        if( Input::has('solo_area') ){
            $area=Auth::user()->area_id;
            $where=" AND FIND_IN_SET(p.area_id, $area )>0 ";
            $select=" p.id,CONCAT(p.paterno,' ',substr(p.materno,1,4),'. ',substr(p.nombre,1,7)) nombre ";
        }
        $sql="  SELECT $select
                FROM personas p
                INNER JOIN areas a ON a.id=p.area_id 
                WHERE p.estado=1
                $where
                GROUP BY p.id,a.id
                ORDER BY p.paterno,p.materno,p.nombre";

        $personas= DB::select($sql);
        return $personas;
    }

    public static function getApellidoNombre()
    {
        $sql="  SELECT p.id id,
                    CONCAT_WS(' ',p.paterno,p.materno,p.nombre) nombre,p.dni
                FROM personas p
                WHERE p.estado=1
                ORDER BY p.paterno,p.materno,p.nombre";

        $personas= DB::select($sql);
        return $personas;
    }

    public static function get(array $data =array()){

        //recorrer la consulta
        $personas = parent::get( $data);

        foreach ($personas as $key => $value) {
            if ($key=='password') {
                $personas[$key]['password']='';
            }
        }

        return $personas;
    }

    public static function getAreas($personaId)
    {
        //subconsulta
        $sql = DB::table('cargo_persona as cp')
        ->join(
            'cargos as c', 
            'cp.cargo_id', '=', 'c.id'
        )
        ->join(
            'area_cargo_persona as acp', 
            'cp.id', '=', 'acp.cargo_persona_id'
        )
        ->join(
            'areas as a', 
            'acp.area_id', '=', 'a.id'
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
        $areas = DB::table(DB::raw("(".$sql->toSql().") as a"))
                ->select(
                    DB::raw("GROUP_CONCAT( info SEPARATOR '|'  ) as DATA ")
                )
               ->get();

        return $areas;
    }
    /*public static function getCargoArea()
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
    }*/

}


