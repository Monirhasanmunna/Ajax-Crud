<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[StudentController::class,'index']);
Route::get('/all/student',[StudentController::class,'dataShow'])->name('data.show');
Route::post('/store',[StudentController::class,'store'])->name('data.store');
Route::get('/edit/{id}',[StudentController::class,'edit'])->name('data.edit');
Route::post('/update/{id}',[StudentController::class,'update'])->name('data.update');
Route::delete('/delete/{id}',[StudentController::class,'destroy'])->name('data.delete');
