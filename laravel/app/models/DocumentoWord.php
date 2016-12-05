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

    public static function getEncargadoArea($area_id){
        $sql = "SELECT p.nombre,p.id id,p.email_mdi,a.id area_id, "
            . " p.paterno,p.materno,a.nombre area, r.nombre rol "
            . " FROM personas p "
            . " INNER JOIN areas a ON a.id=p.area_id AND a.estado=1 "
            . " INNER JOIN roles r ON r.id=p.rol_id AND r.estado=1 "
            . " WHERE p.estado=1 "
            . " AND p.rol_id IN (8,9) "
            . " and a.id = ? "
            . " ORDER BY p.id";

        $r= DB::select(DB::raw($sql), array($area_id));

        return (count($r) > 0)? $r[0]: [];
    }


}