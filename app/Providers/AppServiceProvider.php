<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Log;
use File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }else{

            if(!app()->runningInConsole())
                DB::listen(function($query) {

                    $log = '[' . date('Y-m-d H:i:s') . '] - ['. \Request::route()->getName() .'] - [' . $query->time . '] ' . $query->sql . ' | INPUTS - [' . implode(', ', $query->bindings) . ']' . PHP_EOL;
                    //$log .= 'User ID: ' . $userId  . PHP_EOL . PHP_EOL;
                    //error_log('QUERY: '.$log);
                    File::append(
                        storage_path('logs/query.log'),
                        $log
                    );
                });
        }
    }

}
