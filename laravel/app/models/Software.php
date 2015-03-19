<?php

class Software extends Base
{
    public $table = "softwares";
    public static $where =['id', 'nombre', 'tabla', 'campo', 'estado'];
    public static $selec =['id', 'nombre', 'tabla', 'campo', 'estado'];

}
