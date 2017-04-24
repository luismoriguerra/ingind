<?php

class DocumentoFechaH extends Base
{
    public $table = "documento_fecha_h";
    public static $where = ['id', 'documento_id', 'fecha_documento','comentario','estado'];
    public static $selec = ['id', 'documento_id', 'fecha_documento','comentario','estado'];


}
