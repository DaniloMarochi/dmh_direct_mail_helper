<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Course::create([
            "name" => "Tecnologia em análise e desenvolvimento de sistemas",
            "slug" => "tecnologia-em-analise-e-desenvolvimento-de-sistemas",
            "sigla" => "TADS"
        ]);
        Course::create([
            "name" => "Tecnologia em Gestão Ambiental",
            "slug" => "tecnologia-em-gestao-ambiental",
            "sigla" => "TGA"
        ]);
        Course::create([
            "name" => "Tecnologia em Manutenção industrial",
            "slug" => "tecnologia-em-manutencao-industrial",
            "sigla" => "TMI"
        ]);
        Course::create([
            "name" => "Licenciatura em Física",
            "slug" => "licenciatura-em-fisica",
            "sigla" => "LF"
        ]);
        Course::create([
            "name" => "Licenciatura em ciências sociais",
            "slug" => "licenciatura-em-ciencias-sociais",
            "sigla" => "LCS"
        ]);
        Course::create([
            "name" => "Técnico em Informática",
            "slug" => "tecnico-em-informatica",
            "sigla" => "TI"
        ]);
        Course::create([
            "name" => "Técnico em Meio Ambiente",
            "slug" => "tecnico-em-meio-ambiente",
            "sigla" => "TMA"
        ]);
        Course::create([
            "name" => "Técnico em Mecânica",
            "slug" => "tecnico-em-mecanica",
            "sigla" => "TM"
        ]);
    }
}
