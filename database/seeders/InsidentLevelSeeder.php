<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InsidentLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insident_levels')->insert([
            [
                'name' => 'RR 1',
                'description' => 'Pasien Meninggal'
            ],
            [
                'name' => 'RR 2',
                'description' => 'Pasien Mengalami Kecacatan Fisik/Penurunan Kondisi yang Fatal'
            ],
            [
                'name' => 'RR 3',
                'description' => 'Pasien Mengalami Penurunan Kondisi yang tidak Signifikan'
            ],
            [
                'name' => 'RR 4',
                'description' => 'Pasien tidak mengalami kondisi buruk'
            ],
            [
                'name' => 'Never Event',
                'description' => 'Pasien Mengalami beberapa Kondisi (Terlampir)'
            ],
        ]);
    }
}
