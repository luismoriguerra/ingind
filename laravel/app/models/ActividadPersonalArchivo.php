<?php

class ActividadPersonalArchivo extends Base
{
    public $table = "actividad_personal_archivo";
    public static $where =['id' , 'actividad_personal_id', 'ruta' , 'estado'];
    public static $selec =['id' , 'actividad_personal_id', 'ruta' , 'estado'];

}
