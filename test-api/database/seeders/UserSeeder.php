<?php

namespace Database\Seeders;

use App\Models\Questionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i=0;$i<5;$i++){
        Questionnaire::create([
            'title'=>fake()->text(),
            'type'=>fake()->text(), 
            'user_id'=>fake()->randomDigitNotNull(),
            'templatejson'=>fake()->text(),
            
        ]);
    }
    }
}
