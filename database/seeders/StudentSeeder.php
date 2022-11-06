<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder {
    public function run() {
        $courses = Course::all();

        foreach ($courses as $course) {
            Student::factory()->count(5)->create(["course_id" => $course->id]);
        }
    }
}
