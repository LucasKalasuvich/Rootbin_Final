<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CaseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('case_statuses')->insert([
            [
                'name' => 'Open',
                'description' => 'Insiden yang belum dilakukan
nvestigasi oleh OMR (admin)'
            ],
            [
                'name' => 'On Progress',
                'description' => 'Insiden yang sedang dalam
proses perbaikan (corrective action)'
            ],
            [
                'name' => 'On Hold',
                'description' => 'Insiden yang sedang di lakukan
investigasi ulang / sedang menunggu
keputusan medis'
            ],
            [
                'name' => 'Closed',
                'description' => 'Insiden yang sudah selesai
dilakukan perbaikan dan unit sudah
menginput bukti implementasi corrective
action.'
            ],
        ]);
    }
}
