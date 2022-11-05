<?php

namespace App\Imports;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
//use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
//use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class StudentImport implements ToModel, WithHeadingRow, WithMultipleSheets {

    private $students;

    public function __construct() {
        $this->students = Student::with('course')->get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function sheets(): array {
        return [
            'PresençaPACEII-41' => new StudentImport(),
        ];
    }

    public function model(array $row) {
        //dd($row);
        $months = ["jan", "fev", "mar", "abr", "mai", "jun", "jul", "ago", "set", "out", "nov", "dez"];

        foreach ($months as $month) {
            if (isset($row[$month])) {
                $frequence = str_replace('[!@#$%?^&*()_+=-]', '', $row[$month]);
            }
        }

        // }
        $course = Course::where('slug', $this->slug($row['curso']))->first();
        //dd($this->slug($row['curso']));
        //dd($course->id);
        if ($course) {
            if (isset($row[2])) {
                return null;
            }
            return new Student([
                "name" => $row['nome'],
                "email" => $row['email'],
                "frequence" => $frequence,
                "occurrence" => $row['ocorrencia'],
                "course_id" => $course->id,

            ]);
        }
    }

    // This function returns a slug of a text
    private function slug(string $text) {
        $text = strtolower($text);

        $text = str_replace('[!@#$%?^&*()_+=]', '', $text);
        $text = str_replace('[ÁÀÂÃ]', 'a', $text);
        $text = str_replace('[ÉÈÊ]', 'e', $text);
        $text = str_replace('[ÍÌÎ]', 'i', $text);
        $text = str_replace('[ÓÒÔÕ]', 'o', $text);
        $text = str_replace('[ÚÙÛ]', 'u', $text);
        $text = str_replace('[Ç]', 'c', $text);

        return Str::slug($text, '-');
    }
}
