<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Course::create([
            "name"=>"Tecnologia em análise e desenvolvimento de sistemas",
            "sigla"=>"TADS"
        ]);
        Course::create([
            "name"=>"Tecnologia em Gestão Ambiental",
            "sigla"=>"TGA"
        ]);
        Course::create([
            "name"=>"Tecnologia em Manutenção industrial",
            "sigla"=>"TMI"
        ]);
        Course::create([
            "name"=>"Licenciatura em Física",
            "sigla"=>"LI"
        ]);
    }
}
