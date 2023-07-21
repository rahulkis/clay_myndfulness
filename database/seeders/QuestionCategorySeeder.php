<?php

namespace Database\Seeders;

use App\Models\QuestionCategory;
use Illuminate\Database\Seeder;

class QuestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [
                'name' => 'Self Assesment',
            ],
            [
                'name' => 'Journal'
            ]
        ];
        foreach($array as $arr){
            QuestionCategory::firstOrCreate(['name' => $arr['name']],$arr);
        }
    }
}
