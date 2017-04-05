<?php

class MetaDocdigital extends Base
{
    public $table = "metas_docdigital";
    public static $where =['id' , 'avance_id' , 'doc_digital_id' , 'tipo_avance', 'estado'];
    public static $selec =['id' , 'avance_id' , 'doc_digital_id' , 'tipo_avance', 'estado'];

}
