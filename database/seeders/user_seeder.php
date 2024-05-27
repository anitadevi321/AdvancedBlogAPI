<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\role;
class user_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        role::create([
            'name'=>'Admin'
        ]);

        role::create([
            'name'=>'Author'
        ]);

        role::create([
            'name'=>'Reader'
        ]);
    }
}
