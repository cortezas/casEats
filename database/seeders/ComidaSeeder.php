<?php

namespace Database\Seeders;

use App\Models\Comida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Comida::factory()->count(10)->create();
    }
}
