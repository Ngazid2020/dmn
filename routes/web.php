<?php

use App\Http\Controllers\MedicalFilePdfController;
use App\Http\Controllers\PrescriptionPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prescriptions/{prescription}/pdf',[PrescriptionPdfController::class, 'download'])->name('prescriptions.pdf');

Route::get(
    '/medical-files/{medicalFile}/pdf',
    [MedicalFilePdfController::class, 'show']
)->name('medical-files.pdf');
