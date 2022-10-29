<?php

//se importa el App\Http\Controllers\EmpleadoController para acceder a ese archivo
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

/*
Route::get('/empleado', function () {
    return view('empleado.index');
});

Route::get("/empleado/create", [EmpleadoController::class, "create"]);
*/
Route::resource("empleado", EmpleadoController::class)->middleware("auth");     //con middleware hace que respete la autentificacion(logiado)
//Auth::routes(["register" => false, "reset" => false]);        //elimina la funcionalidad de agregar o recuperar cuenta
Auth::routes(["reset" => false]);

Route::get("/home", [EmpleadoController::class, "index"])->name("home");

Route::group(["middleware" => "auth"], function(){

    Route::get("/", [EmpleadoController::class, "index"])->name("home");
});