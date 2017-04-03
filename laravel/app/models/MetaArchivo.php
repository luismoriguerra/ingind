<?php

class MetaArchivo extends Base
{
    public $table = "metas_archivo";
    public static $where =['id' , 'avance_id' , 'ruta' , 'tipo_avance', 'estado'];
    public static $selec =['id' , 'avance_id' , 'ruta' , 'tipo_avance', 'estado'];

}
