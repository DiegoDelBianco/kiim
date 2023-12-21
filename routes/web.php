<?php

use Illuminate\Support\Facades\Route;


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
use App\Http\Controllers\TenancyController;
use App\Http\Controllers\SysProductController;
use App\Http\Controllers\SysProductTenancyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\WhatsappNotificationController;
use App\Http\Controllers\CustomerCsvImportController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ExtensionController;

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

/*Route::get('/', function () {
    return view('public');
});*/
Route::get('/politica-de-privacidade', function () {
    return view('public.politica-de-privacidade');
});

Route::get('/wpp-test', function () {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v17.0/116377101484860/messages");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        //curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"messaging_product\": \"whatsapp\", \"to\": \"5511981825304\", \"type\": \"template\", \"template\": { \"name\": \"inicio\", \"language\": { \"code\": \"pt_BR\" } } }");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"messaging_product\": \"whatsapp\", \"to\": \"5511981825304\", \"type\": \"template\", \"template\": { \"name\": \"inicio\", \"language\": { \"code\": \"pt_BR\" } } }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "Authorization: Bearer EAAJvbmt10I8BAPcpjsHxM7kz5MwUx6AbCZCSWMdL0Vi9W58zkOCrFojX0eWtEQzQWSXyQlusT2R6cfEi1Mk2xjpZBZAZCcblfJE3eQROfyOdSgBZBW0ezoESJpNeSdGv4HMqUJm2gEolyZCknga8VqZCK7RkwWLY3eWMc4fpFFEIHsmJlAn0STCJMHq0Fo4bbyOPv5UydnW4QZDZD' ",
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        print_r($response);
    return null;
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Função do perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Atualização automatica de notificações
    Route::get('notifications/get',[App\Http\Controllers\NotifyUserController::class, 'getNotificationsData'])->name('notifications.get');
    Route::get('get-label-menu', [App\Http\Controllers\NotifyUserController::class, 'getLabelMenu'])->name('get-label-menu');

    // Usuários
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/link', [UserController::class, 'link'])->name('users.link');
    Route::post('/users/unlink/{tenancy}/{user}', [UserController::class, 'unlink'])->name('users.unlink');
    Route::get('/users/edit/{tenancy}/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/edit/{tenancy}/{user}', [UserController::class, 'update'])->name('users.update');
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
    Route::post('/customers/redirect/{customer}', [CustomerController::class, 'redirect'])->name('customers.redirect');

    // CSV import to leads
    Route::get('/users/csv-import', [CustomerCsvImportController::class, 'index'])->name('customers.importCsv');
    Route::post('/users/csv-import', [CustomerCsvImportController::class, 'store'])->name('customers.importCsv.store');
    Route::get('/users/csv-import/select-head/{customerCsvImport}', [CustomerCsvImportController::class, 'selectHead'])->name('customers.importCsv.selectHead');
    Route::post('/users/csv-import/finalize/{customerCsvImport}', [CustomerCsvImportController::class, 'finalize'])->name('customers.importCsv.finalize');

    // Atendimentos
    Route::get('/customers/customer-service/', [CustomerServiceController::class, 'index'])->name('customers.customer-services');
    Route::get('/customers/customer-service/remarketing', [CustomerServiceController::class, 'indexRemarketing'])->name('customers.customer-services.remarketing');
    Route::post('/customers/customer-service/', [CustomerServiceController::class, 'store'])->name('customers.customer-services.store');
    Route::delete('/customers/customer-service/{customer_service}', [CustomerServiceController::class, 'destroy'])->name('customers.customer-services.destroy');

    // Agendamentos
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::post('/schedules/{customer_service}', [ScheduleController::class, 'storeWithCS'])->name('schedules.store.customer-service');
    Route::patch('/schedules/{schedule}', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::post('/schedules/up-done/{schedule}', [ScheduleController::class, 'editDone'])->name('schedules.update.done');
    Route::post('/schedules/up-cancel/{schedule}', [ScheduleController::class, 'editCancel'])->name('schedules.update.cancel');

    // Equipes
    Route::get('/teams', [TeamController::class, 'index'])->name('teams');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::patch('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

    // Imóveis
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // tipo de produto
    Route::post('/customers/product-type/{customer}', [CustomerController::class, 'updateProductType'])->name('customers.update.product-type');

    // Leadages
    Route::get('/websites', [WebsiteController::class, 'index'])->name('websites');
    Route::get('/websites/{product}', [WebsiteController::class, 'create'])->name('websites.create');
    Route::post('/websites/{product}', [WebsiteController::class, 'store'])->name('websites.store');
    Route::get('/websites/edit/{website}', [WebsiteController::class, 'edit'])->name('websites.edit');
    Route::patch('/websites/edit/{website}', [WebsiteController::class, 'update'])->name('websites.update');
    Route::delete('/websites/{website}', [WebsiteController::class, 'destroy'])->name('websites.destroy');

    // Tenancies
    Route::get('/tenancy', [TenancyController::class, 'index'])->name('tenancies');
    Route::patch('/tenancy', [TenancyController::class, 'update'])->name('tenancies.update');

    // SysProducts, SysProductsTenancy e Payment
    Route::get('/sys-product/{sysProduct}', [SysProductController::class, 'show'])->name('sysProduct');
    Route::post('/sys-product-tenancy/{sysProduct}', [SysProductTenancyController::class, 'store'])->name('sysProductTenancy.store');
    Route::post('/payment/{sysProductTenancy}', [PaymentController::class, 'store'])->name('payment.store');

    // Métricas
    Route::get('/metrics', [MetricsController::class, 'index'])->name('metrics');
    Route::get('/metrics/team/{team}', [MetricsController::class, 'index'])->name('metrics.team');

    // Configurações de API
    Route::get('/facebook-config', [ApiController::class, 'facebookConfig'])->name('configApi.facebook');
});

Route::get('/pub/leadpage/{website}', [WebsiteController::class, 'show'])->name('public.websites');


require __DIR__.'/auth.php';
require __DIR__.'/extensions/all.php';
