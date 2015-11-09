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

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public $hidden = array('password', 'remember_token');

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
                INNER JOIN cargo_persona cp ON cp.persona_id=p.id 
                INNER JOIN area_cargo_persona acp ON acp.cargo_persona_id=cp.id 
                INNER JOIN cargos c ON c.id=cp.cargo_id
                INNER JOIN areas a ON a.id=acp.area_id
                WHERE a.id IN ('$areaId')";

        $r= DB::select($sql);

        return $r;
    }
}
