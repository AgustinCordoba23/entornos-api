<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'nombre' => 'Admin'
            ],
            [
                'id' => 2,
                'nombre' => 'Responsable'
            ],
            [
                'id' => 3,
                'nombre' => 'Usuario'
            ]
        ]);
    }
}
