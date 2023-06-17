<?php

namespace App\Http\Controllers;

use Log;
use File;
use Illuminate\Http\Request;

class WhatsappNotificationController extends Controller
{
    //webhookGet
    public function webhookGet(Request $request){


        $log =  PHP_EOL . PHP_EOL . '[' . date('Y-m-d H:i:s') . '] - GET '. print_r($request->all(), true) . PHP_EOL;
        File::append(
            storage_path('logs/wpp_webhook_api.log'),
            $log
        );
        if(isset($request->hub_challenge)){
            return $request->hub_challenge;
        }
        return NULL;
    }
    public function webhookPost(Request $request){

        $log =  PHP_EOL . PHP_EOL . '[' . date('Y-m-d H:i:s') . '] - POST '. print_r($request->all(), true) . PHP_EOL;
        File::append(
            storage_path('logs/wpp_webhook_api.log'),
            $log
        );

        return NULL;

    }
}
