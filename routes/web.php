<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\NetworkController;
use App\Http\Controllers\ObjectsController;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\MeterAllController;
use App\Http\Controllers\ReadingsController;
use App\Http\Controllers\PowerProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CurrentValueController;
use App\Http\Controllers\CurrentValueTableController;
use App\Http\Controllers\ConsumptionController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['check.session'])->group(function () {
    Route::get('/networks/{networkId?}', [NetworkController::class, 'index'])->name('networks');
    Route::get('/{networkId?}/objects', [ObjectsController::class, 'index'])->name('objects');
    Route::get('/{networkId?}/meters/{object_id?}', [MeterController::class, 'index'])->name('meters');
    Route::get('/{networkId?}/metersall', [MeterAllController::class, 'index'])->name('metersall');
    Route::get('/readings/{meter_id}', [ReadingsController::class, 'index'])->name('readings');
    Route::get('/powerprofile/{meter_id}', [PowerProfileController::class, 'index'])->name('powerprofile');
    Route::get('/currentvalue/{meter_id}/{dataType?}', [CurrentValueController::class, 'index'])->name('currentvalue');
    Route::get('/currentvaluetable/{meter_id}/{dataType?}', [CurrentValueTableController::class, 'index'])->name('currentvaluetable');
    Route::get('/consumption/{object_id}', [ConsumptionController::class, 'index'])->name('consumption');
    Route::get('/support', [SupportController::class, 'index'])->name('support');
});
