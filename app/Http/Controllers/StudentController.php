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
<<<<<<< HEAD

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

=======
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        //vai separar os links por mêses do "created_at"



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        Excel::import(new StudentImport(), $request->file(key: 'import_file'));

        return redirect()->route('import')->with('success', 'Arquivo importado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
>>>>>>> ded43ed4e5d488e515c847964e4cc167872c9269
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

<<<<<<< HEAD
    public function restore($id) {
        $student = Student::where('id', $id)->withTrashed()->restore();
=======
    public function sendEmail($id) {
>>>>>>> ded43ed4e5d488e515c847964e4cc167872c9269

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
}
