<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotifyUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CustomerTimelineController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Função do perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Atualização automatica de notificações no sininho
    Route::get('notifications/get',[App\Http\Controllers\NotifyUserController::class, 'getNotificationsData'])->name('notifications.get');

    // Usuários
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/edit/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/edit-pass/{user}', [UserController::class, 'updatePassword'])->name('users.update.password');
    Route::get('/users/list/ajax/by-team', [UserController::class, 'listByTeam'])->name('users.list.ajax.by-team');

    // Leads
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/list/ajax', [CustomerController::class, 'listAjax'])->name('customers.list.ajax');
    Route::delete('/customers/destroy/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/show/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::patch('/customers/edit/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::post('/customers/{customer}/timeline/', [CustomerTimelineController::class, 'store'])->name('customers.timelines.store');
    Route::get('/customers/sales', [CustomerController::class, 'listSales'])->name('customers.sales');
    
    // Atendimentos
    Route::get('/customers/customer-service/', [CustomerServiceController::class, 'index'])->name('customers.customer-services');
    Route::get('/customers/customer-service/remarketing', [CustomerServiceController::class, 'indexRemarketing'])->name('customers.customer-services.remarketing');
    Route::post('/customers/customer-service/', [CustomerServiceController::class, 'store'])->name('customers.customer-services.store');
    Route::delete('/customers/customer-service/{customer_service}', [CustomerServiceController::class, 'destroy'])->name('customers.customer-services.destroy');

    // Agendamentos
    Route::post('/schedules/{customer_service}', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::patch('/schedules/{schedule}', [ScheduleController::class, 'edit'])->name('schedules.edit');

    // Equipes
    Route::get('/teams', [TeamController::class, 'index'])->name('teams');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::patch('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');

    // Imóveis
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Leadages
    Route::get('/websites', [WebsiteController::class, 'index'])->name('websites');
    Route::get('/websites/{product}', [WebsiteController::class, 'create'])->name('websites.create');
    Route::post('/websites/{product}', [WebsiteController::class, 'store'])->name('websites.store');
    Route::get('/websites/edit/{website}', [WebsiteController::class, 'edit'])->name('websites.edit');
    Route::patch('/websites/edit/{website}', [WebsiteController::class, 'update'])->name('websites.update');
    Route::delete('/websites/{website}', [WebsiteController::class, 'destroy'])->name('websites.destroy');
});

Route::get('/pub/leadpage/{website}', [WebsiteController::class, 'show'])->name('public.websites');

require __DIR__.'/auth.php';
