<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return view('auth.login');
});

/*Route::get('/Empleado', function () {
    return view('CRUD-Empleado.Index');
});

//Route::get('/Empleado/Create',[EmpleadoController::class,'create']);*/

Route::resource('Empleado', EmpleadoController::class)->middleware('auth');

Auth::routes(['register'=>false, 'reset'=>false]);

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/',[EmpleadoController::class, 'index'])->name('home');
});