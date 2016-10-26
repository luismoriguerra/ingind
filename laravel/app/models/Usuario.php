<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Usuario extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'personas';
    public static $rules = array(
        'paterno'=>'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
        'materno'=>'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
        'nombre' =>'required|regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i',
        'usuario'  =>'required|min:8|unique:personas,dni',//dni
        'email'  =>'required|email|unique:personas',
        'password'=>'required|alpha_num|between:6,12|confirmed',
        'password_confirmation'=>'required|alpha_num|between:6,12'
    );
    public function getReminderEmail()
    {
        return $this->email;
    }
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public $hidden = array('password', 'remember_token');
    /**
     * Cargos relationship
     */
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
    public static function ListarUsuarios()
    {
        $areaId=implode("','",Input::get('area_id'));

          $sql="SELECT paterno,materno,p.nombre,dni,email,dni,fecha_nacimiento,
                CASE sexo
                WHEN 'F' THEN 'Femenino'
                WHEN 'M' THEN 'Masculino'
                END sexo,
                CASE p.estado
                WHEN '1' THEN 'Activo'
                WHEN '0' THEN 'Inactivo'
                END estado,
                a.nombre area,c.nombre cargo
                FROM personas p
                INNER JOIN cargo_persona cp ON cp.persona_id=p.id AND cp.estado=1
                INNER JOIN area_cargo_persona acp ON acp.cargo_persona_id=cp.id AND acp.estado=1
                INNER JOIN cargos c ON c.id=cp.cargo_id AND c.estado=1
                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                WHERE a.id IN ('$areaId')
                GROUP BY acp.area_id,acp.cargo_persona_id";

        $r= DB::select($sql);

        return $r;
    }
}
