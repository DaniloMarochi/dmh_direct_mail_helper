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
    return redirect()->route("home");
});

Route::view("/home", "home")->name("home");

Route::prefix('students')->group(function () {
    Route::get('/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/store', [StudentController::class, 'store'])->name('students.store');
    Route::get('{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::patch('{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('{id}/enviar-email', [StudentController::class, 'sendEmail'])->name('students.send.email');

});

// Route::get('envio-email', function () {

//     $student = Student::all('name');

//     return new \App\Mail\newLaravelTips($student);
    // $user = new User();
    // $user->name = 'Robson';
    // $user->email = 'danilo.marochi60@gmail.com';


    // return new \App\Mail\newLaravelTips($user);
    //Mail::send(new \App\Mail\newLaravelTips($user));

