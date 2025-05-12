<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\LeaveRequestForm;

use App\Http\Controllers\LeaveReportController;

Route::get('/leave-report', [LeaveReportController::class, 'generatePDF'])->name('leave.report.pdf');


Route::get('/leave-request', LeaveRequestForm::class)->name('leave.request');

Route::get('/', function () {
    return view('welcome');
});
