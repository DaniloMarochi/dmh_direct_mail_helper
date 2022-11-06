<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('students.index');
});

Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('students.index');
    Route::get('/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/store', [StudentController::class, 'store'])->name('students.store');
    Route::get('/filter', [StudentController::class, 'filter'])->name('students.filter');
    Route::get('/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('{month}/{year}/show', [StudentController::class, 'show'])->name('students.show');
    Route::get('{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::patch('{id}/destroy', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::patch('{id}/restore', [StudentController::class, 'restore'])->name('students.restore');
    Route::get('{id}/enviar-email', [StudentController::class, 'sendEmail'])->name('students.send.email');
    Route::get('{month}/{year}/mala-direta', [StudentController::class, 'directMail'])->name('students.direct.email');
});

// Route::get('envio-email', function () {

//     $student = Student::all('name');

//     return new \App\Mail\newLaravelTips($student);
    // $user = new User();
    // $user->name = 'Robson';
    // $user->email = 'danilo.marochi60@gmail.com';


    // return new \App\Mail\newLaravelTips($user);
    //Mail::send(new \App\Mail\newLaravelTips($user));
