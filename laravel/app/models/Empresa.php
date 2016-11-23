<?php

class Empresa extends Base
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = "empresas";
    protected $fillable = [
            'tipo_id',
            'ruc',
            'razon_social',
            'nombre_comercial',
            'direccion_fiscal',
            'persona_id',
            'cargo',
            'telefono',
            'fecha_vigencia',
            'estado',
    ];

    public static $rules = [
        'tipo_id'                   => 'required|Integer',
        'ruc'                       => 'required|size:11|unique:empresas,ruc',
        'razon_social'              => 'required|Max:200',
        'nombre_comercial'          => 'required|Max:150',
        'direccion_fiscal'          => 'required|Max:250',
        'cargo'                     => 'required|Max:50',
        'telefono'                  => 'required|digits_between:9,12',
        'fecha_vigencia'            => 'required|date_format:"Y-m-d H:i:s"',
        'estado'                    => 'required|Integer|Max:1',
        //'persona_id'                => 'required|Integer',
    ];
    public static $messajes = [
        'required'      => ':attribute Es requerido',
        'Alpha'         => ':attribute Solo debe ser Texto',
        'AlphaNum'      => ':attribute Solo debe ser alfanumerico',
        'Integer'       => ':attribute Solo debe ser entero',
        'numeric'       => ':attribute Solo debe ser numero',
        'date_format'   => ':attribute Solo debe ser fecha con formato "Y-m-d H:i"',
    ];

    public static function boot() 
    {
        parent::boot();

        static::updating(
            function($table) {
                $table->usuario_updated_at = Auth::user()->id;
            }
        );
        static::creating(
            function($table) {
                $table->usuario_created_at = Auth::user()->id;
                $table->estado = 1;
            }
        );
    }

    /**
     * Persona relationship
     */
    public function personas()
    {
        return $this->belongsToMany('Persona')->withTimestamps();
    }
    public function scopeMisEmpresas($query)
   {
        return $query->where('persona_id','=',Auth::id());
   }
}


