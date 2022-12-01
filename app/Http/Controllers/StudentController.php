<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;

class StudentController extends Controller {

    public function index() {
        return view('students.index');
    }

    public function filter() {
        $query = request()->query('month');

        if ($query) {
            $month = Carbon::parse($query)->format('m');
            $year = Carbon::parse($query)->format('Y');

            return redirect()->route('students.show', ['month' => $month, 'year' => $year]);
        }

        $sheets = Student::all()->groupBy('created_at')->toArray();

        return view('students.filter', compact('sheets'));
    }

    public function import() {
        return view('students.import');
    }

    public function store(Request $request) {
        Excel::import(new StudentImport(Carbon::parse($request->month)->startOfMonth()), $request->file(key: 'import_file'));

        $month = Carbon::parse($request->month)->format('m');
        $year = Carbon::parse($request->month)->format('Y');

        return redirect()->route('students.show', ['month' => $month, 'year' => $year])->with('success', 'Planilha importada!');
    }

    public function show($month, $year) {
        Carbon::setLocale('pt_BR');

        $date = Carbon::createFromDate($year, $month, 1, 'America/Sao_Paulo');

        $start = $date->startOfMonth()->toDateTimeString();
        $end = $date->endOfMonth()->toDateTimeString();

        $month_formatted = $date->monthName;

        $students = Student::whereBetween('created_at', [$start, $end])->where([
            ['frequence', '<=', 75],
            ['mailed', false]
        ])->get(['id', 'name', 'email', 'frequence'])->count();

        if ($students != 0) {
            $disable_direct_mail_button = false;
        } else {
            $disable_direct_mail_button = true;
        }

        return view('students.show', compact('year', 'month', 'month_formatted', 'disable_direct_mail_button'));
    }

    public function destroy($id) {
        $student = Student::findOrFail($id);

        $student->update([
            'mailed' => false,
            "deleted_at" => now("America/Sao_Paulo")
        ]);

        $month = $student->created_at->format('m');
        $year = $student->created_at->format('Y');

        return redirect()->route('students.show', ['month' => $month, 'year' => $year])->with('success', 'Usuário deletado!');
    }

    public function restore($id) {
        $student = Student::where('id', $id)->withTrashed()->restore();

        if ($student) {
            $aux_student = Student::findOrFail($id);
        }

        $month = $aux_student->created_at->format('m');
        $year = $aux_student->created_at->format('Y');

        return redirect()->route('students.show', ['month' => $month, 'year' => $year])->with('success', 'Usuário restaurado!');
    }

    public function sendEmail($id) {
        $student = Student::findOrFail($id);

        $student->update([
            'mailed' => true,
        ]);

        Mail::to($student->email)->queue(new \App\Mail\newLaravelTips($student));

        return back()->with('success', 'Email enviado!');
    }

    public function directMail($month, $year) {
        try {
            Carbon::setLocale('pt_BR');

            $date = Carbon::createFromDate($year, $month, 1, 'America/Sao_Paulo');

            $start = $date->startOfMonth()->toDateTimeString();
            $end = $date->endOfMonth()->toDateTimeString();

            $students = Student::whereBetween('created_at', [$start, $end])->where([
                ['frequence', '<=', 75],
                ['mailed', false]
            ])->get(['id', 'name', 'email', 'frequence']);

            if (count($students) > 0) {
                set_time_limit(0);
                $flag = 0;

                foreach ($students as $student) {
                    Mail::to($student->email)->queue(new \App\Mail\newLaravelTips($student));

                    $student->update([
                        'mailed' => true,
                    ]);

                    if ($flag == 4) {
                        $flag = 0;
                        sleep(10);
                    }

                    $flag++;
                }

                return back()->with('success', 'Emails de mala direta enviados!');
            } else {
                $disable_direct_mail_button = true;
            }

            return redirect()->route('students.show', ['month' => $month, 'year' => $year, 'disable_direct_mail_button' => $disable_direct_mail_button])->with('warning', 'Você já enviou mala direta para estes alunos');
        } catch (Exception $ex) {
            return back()->with('error', 'Mala direta não foi enviada!');
        }
    }

    public function historic($email){
        //pelo id do estudante que eu acabei de clicar no ícone, quero trazer na tabela todas
        // as vezes que o email daquele estudante é repetido no banco de dados
        try {
            $media = Student::where('email', $email)->avg('frequence');

            return view('students.historic', compact('email', 'media'));
        } catch (Exception $ex) {
            return back()->with('error', 'Estudante não encontrado');
        }
    }
}
