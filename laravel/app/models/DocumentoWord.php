<?php
/**
*
*/
class DocumentoWord extends Base
{

    public $table = "documentosword";

    public static $where = [
        'id',
        'titulo',
        'estado',
        'cabecera',
        'remitente',
        'destinatario',
        'asunto',
        'fecha',
        'cuerpo',
        'correlativo',
        'plantillaId',
        'areaIdRemitente',
        'areaIdDestinatario',
        'personaIdRemitente',
        'personaIdDestinatario'
    ];
    public static $selec = [
        'id',
        'titulo',
        'estado',
        'cabecera',
        'remitente',
        'destinatario',
        'asunto',
        'fecha',
        'cuerpo',
        'correlativo',
        'plantillaId',
        'areaIdRemitente',
        'areaIdDestinatario',
        'personaIdRemitente',
        'personaIdDestinatario'
    ];

}