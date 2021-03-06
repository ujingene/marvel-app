<?php

use App\Http\Controllers\BulkInvoiceUploadController;
use App\Http\Controllers\CharacterController;
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

Route::get('/', [CharacterController::class, 'index'])->name('list_characters');
Route::get('/invoice', [BulkInvoiceUploadController::class, 'index'])->name('csv_page');
Route::post('/invoice/import/custom', [BulkInvoiceUploadController::class, 'import_custom'])->name('import_csv_custom');
Route::post('/invoice/import/maatwebsite', [BulkInvoiceUploadController::class, 'import_maatwebsite'])->name('import_csv_maatwebsite');
