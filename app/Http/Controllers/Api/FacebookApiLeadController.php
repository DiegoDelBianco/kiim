<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use File;

class FacebookApiLeadController extends Controller
{
    public function facebookLeadGet(){
        $token = 'Adc75-ffJk';

        $log = ' [' . date('Y-m-d H:i:s') . "] GET - ". print_r($_GET, true) . PHP_EOL . PHP_EOL;
        File::append(
            storage_path('logs/fb_webhook.log'),
            $log
        );

        if($_GET['hub_verify_token'] == $token) return $_GET["hub_challenge"];
        return true;
    }

    public function facebookLeadPost(Request $request){
        $token = 'Adc75-ffJk';

        if(!$request->has('entry')) return true;


        $access_token = config("facebook_api.fb_cli_token");
        $app_secret = config("facebook_api.fb_app_secret");
        $app_id = config("facebook_api.fb_app_id");

        foreach($request->entry as $entry){
            $log = ' [' . date('Y-m-d H:i:s') . "] POST (ENTRY) - ". print_r($entry, true) . PHP_EOL . PHP_EOL;
            File::append(
                storage_path('logs/fb_webhook.log'),
                $log
            );
            foreach($entry['changes'] as $change){
                $log = ' [' . date('Y-m-d H:i:s') . "] POST (CHANGE) [". $change['value']['leadgen_id']."] - ". print_r($change, true) . PHP_EOL . PHP_EOL;
                File::append(
                    storage_path('logs/fb_webhook.log'),
                    $log
                );


                $id = $change['value']['leadgen_id'];

                $api = Api::init($app_id, $app_secret, $access_token);
                $api->setLogger(new CurlLogger());

                $fields = array(
                );
                $params = array(
                );
                $response =  json_encode((new Lead($id))->getSelf(
                  $fields,
                  $params
                )->exportAllData(), JSON_PRETTY_PRINT);

                $log = ' [' . date('Y-m-d H:i:s') . "] RESPONSE LEAD - ". print_r($response, true) . PHP_EOL . PHP_EOL;
                File::append(
                    storage_path('logs/fb_webhook.log'),
                    $log
                );
            }
        }

        return true;
        if($_POST['hub_verify_token'] == $token) return $_POST["hub_challenge"];
        return true;
    }
}
