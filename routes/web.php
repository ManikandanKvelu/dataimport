<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/upload',[UploadController::class,'index']);

Route::get('/progress',[UploadController::class,'progress']);

Route::post('/upload/file',[UploadController::class,'uploadFileAndStoreInDatabase'])->name('processFile');

Route::get('/progress/data',[UploadController::class,'progressForCsvStoreProcess'])->name('csvStoreProgress');
