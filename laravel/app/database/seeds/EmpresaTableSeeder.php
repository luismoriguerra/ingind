<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EmpresaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->empresarSeeder();
        $this->empresarPersonaSeeder();
    }


    private function empresarSeeder(){

        DB::table('empresa_persona')->delete();
        DB::table('empresas')->delete();
        DB::table('empresas')->insert(array(
            'tipo_id' => 1,
            'ruc' => 36281236748,
            'razon_social' => 'PAPITA   E.I.R.L',
            'nombre_comercial' => 'PAPITA',
            'direccion_fiscal' => 'URB. SIEMPRE VIVA 123',
            'persona_id' => 1,
            'cargo' => 'Gerente',
            'telefono' => '017934619',
            'fecha_vigencia' => Carbon::now(),
            'estado' => 1
        ));

        DB::table('empresas')->insert(array(
            'tipo_id' => 2,
            'ruc' => 12281236749,
            'razon_social' => 'YUQUITA  S.A.',
            'nombre_comercial' => 'YUQUITA',
            'direccion_fiscal' => 'PROG. VIV.  LAURELES MZ A LT 2- CALLAO',
            'persona_id' => 1,
            'cargo' => 'Gerente',
            'telefono' => '987654321',
            'fecha_vigencia' => Carbon::now(),
            'estado' => 1
        ));
        DB::table('empresas')->insert(array(
            'tipo_id' => 3,
            'ruc' => 32281236750,
            'razon_social' => 'PRODUCTOS S.A.C.',
            'nombre_comercial' => 'PRODUCTOS SABROSIN',
            'direccion_fiscal' => 'JR  PAEZ VALLEJO 234 - OFI. 309',
            'persona_id' => 1,
            'cargo' => 'Gerente',
            'telefono' => '017934621',
            'fecha_vigencia' => Carbon::now(),
            'estado' => 1
        ));
        DB::table('empresas')->insert(array(
            'tipo_id' => 4,
            'ruc' => 45281236751,
            'razon_social' => 'SABOR Y SAZON  E.I.R.L',
            'nombre_comercial' => 'SABOR Y SAZON DEL NORTE',
            'direccion_fiscal' => 'CALLE LAS PIZZA 536',
            'persona_id' => 1,
            'cargo' => 'Gerente',
            'telefono' => '017933232',
            'fecha_vigencia' => Carbon::now(),
            'estado' => 1
        ));
        //factory(Restaurant\User::class, 4)->create();

        //Persona::create(array('email' => 'foo@bar.com'));
    }

    private function empresarPersonaSeeder(){

        DB::table('empresa_persona')->insert(array(
            'empresa_id' => 1,
            'persona_id' => 1,
            'representante_legal' => 1,
            'cargo' => 'gerente',
            'fecha_vigencia' => Carbon::now(),
            'fecha_cese' => Carbon::now(),
            'estado' => 1
        ));
        DB::table('empresa_persona')->insert(array(
            'empresa_id' => 2,
            'persona_id' => 1,
            'representante_legal' => 1,
            'cargo' => 'gerente',
            'fecha_vigencia' => Carbon::now(),
            'fecha_cese' => Carbon::now(),
            'estado' => 1
        ));
        DB::table('empresa_persona')->insert(array(
            'empresa_id' => 3,
            'persona_id' => 1,
            'representante_legal' => 1,
            'cargo' => 'gerente',
            'fecha_vigencia' => Carbon::now(),
            'fecha_cese' => Carbon::now(),
            'estado' => 1
        ));
        DB::table('empresa_persona')->insert(array(
            'empresa_id' => 4,
            'persona_id' => 1,
            'representante_legal' => 1,
            'cargo' => 'gerente',
            'fecha_vigencia' => Carbon::now(),
            'fecha_cese' => Carbon::now(),
            'estado' => 1
        ));
    }

}