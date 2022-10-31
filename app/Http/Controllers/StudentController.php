<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Models\Student;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\newLaravelTips;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //vai separar os links por mêses do "created_at"
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Excel::import(new StudentImport(), $request->file(key: 'import_file'));

        return redirect()->route('import')->with('success', 'Arquivo importado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $student->update([
            "deleted_at" => now("America/Sao_Paulo")
        ]);

        return back()->with('success', 'Usuário deletado!');
    }

    public function sendEmail($id)
    {

        $student = Student::findOrFail($id);

        Mail::send(new \App\Mail\newLaravelTips($student));
        return new newLaravelTips($student);
    }
}
