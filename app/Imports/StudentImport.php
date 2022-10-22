<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{

    private $students;

    public function __construct()
    {
        $this->students = Student::with('course')->get();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $student = $this->students->where('name', $row['name'])->where('email', $row['email'])->first();
        return new Student([
            "name"=> $row['name'],
            "email"=> $row['email'],
            "frequence"=> $row['frequence'],
            "occurrence"=> $row['occurrence'],
            "course_id"=> $row['course_id'],

        ]);
    }
}
