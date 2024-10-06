<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Register;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\SurgeryController;
use App\Models\City;
use App\Models\Surgery;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('dashboard');
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard',  function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/surgeries', SurgeryController::class)
    ->only(['index', 'store', 'edit', 'create', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('professionals', ProfessionalController::class)
    ->only(['index', 'store', 'edit', 'create', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('/get-cities/{state_id}', [SurgeryController::class, 'getCities'])->name('get.cities');


Route::get('surgeries/{id}/report', [SurgeryController::class, 'report'])->name('surgeries.report');
Route::get('/surgeries/relatorio', [RelatorioController::class, 'index'])->name('relatorio.index');
Route::get('/relatorio/cirurgias/pdf', [RelatorioController::class, 'gerarPdf'])->name('relatorio.pdf');
Route::get('/relatorio/cirurgia/{id}/pdf', [RelatorioController::class, 'gerarPdfCirurgia'])->name('relatorio.cirurgia.pdf');


Route::post('/add-surgery', [SurgeryController::class, 'storeSurgery']);
Route::post('/add-indication', [SurgeryController::class, 'storeIndication']);

// Para atualizar a cirurgia (PUT)
Route::get('/register-cad', [RegisterController::class, 'index'])->name('register-cad.index');
Route::post('/register-cad', [RegisterController::class, 'store'])->name('register-cad.index');
Route::get('/surgeries/pdf', [SurgeryController::class, 'exportPdf'])->name('surgeries.pdf');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [ChartController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
