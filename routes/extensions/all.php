<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\Extensions\ThermometerController;



Route::middleware('auth')->group(function () {

    // Extensões
    Route::get('/estencoes', [ExtensionController::class, 'index'])->name('extensions');
    Route::post('/estencoes/ativar', [ExtensionController::class, 'active'])->name('extensions.active');
    Route::post('/estencoes/desativar', [ExtensionController::class, 'disable'])->name('extensions.disable');

    // Termômetro
    Route::get('/thermometer', [ThermometerController::class, 'index'])->name('extensions.thermometer');
    Route::post('/thermometer', [ThermometerController::class, 'newGoal'])->name('extensions.thermometer.new-goal');
    Route::patch('/thermometer/{goal}', [ThermometerController::class, 'upGoal'])->name('extensions.thermometer.up-goal');
    Route::delete('/thermometer/{goal}', [ThermometerController::class, 'delGoal'])->name('extensions.thermometer.del-goal');
    Route::post('/thermometer/config', [ThermometerController::class, 'config'])->name('extensions.thermometer.config');

});

