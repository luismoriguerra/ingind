<?php 
/**
* 
*/
class Base extends Eloquent
{
    /**
    * Obtiene los registros de la tabla que hereda la clase, segun filtros
    */
    public static function get(array $data = array() )
    {
        $data = array_only($data, static::$where);//devuelve solo los filtros
        $data = array_filter($data, 'strlen');//remueve null
        $q = self::select(static::$selec);

        foreach ($data as $field => $value) {
            if (isset($data[$field])) {
                $q->where($field, $value)->orderBy('nombre');
            }
        }
        return $q->get();
    }
}