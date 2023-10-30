<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('divisi')->insert([
            'id' => 1,
            'divisi' => 'sales',
        ]);
        DB::table('divisi')->insert([
            'id' => 2,
            'divisi' => 'admin',
        ]);
    }
}
