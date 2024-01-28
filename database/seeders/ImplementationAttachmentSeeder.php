<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImplementationAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('implementation_attachments')->insert([
            [
                'name' => 'Undangan Rapat'
            ],
            [
                'name' => 'Daftar Hadir Rapat'
            ],
            [
                'name' => 'Notulensi Rapat'
            ],
            [
                'name' => 'Dokumen Tambahan ...'
            ]
        ]);
    }
}
