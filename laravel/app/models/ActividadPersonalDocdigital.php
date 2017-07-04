<?php

class ActividadPersonalDocdigital extends Base
{
    public $table = "actividad_personal_docdigital";
    public static $where =['id' , 'actividad_personal_id' , 'doc_digital_id' , 'estado'];
    public static $selec =['id' , 'actividad_personal_id' , 'doc_digital_id' , 'estado'];

}
