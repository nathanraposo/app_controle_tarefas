<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bem-vindo');
});

Auth::routes();

Route::get('tarefa/exportacao/{extensao}',[TarefaController::class, 'exportacao'])->name('tarefa.exportacao');
Route::get('tarefa/exportar',[TarefaController::class, 'exportar'])->name('tarefa.exportar');
Route::resource('tarefa', TarefaController::class);
