<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use File;

use App\Models\UserFacebookApiFont;

use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\Lead;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;

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


        // $access_token = config("apis.fb.fb_cli_token");
        $app_secret = config("apis.fb.app_secrect");
        $app_id = config("apis.fb.app_id");

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


                $face_lead_id = $change['value']['leadgen_id'];

                $page_id = $change['value']['page_id'];
                $adgroup_id = $change['value']['adgroup_id'];
                $form_id = $change['value']['form_id'];
                $ad_id = $change['value']['ad_id'];

                $font = UserFacebookApiFont::where([['type', '=', 'page_id'], ['info_id', '=', $page_id]])
                    ->orWhere([['type', '=', 'adgroup_id'], ['info_id', '=', $adgroup_id]])
                    ->orWhere([['type', '=', 'form_id'], ['info_id', '=', $form_id]])
                    ->orWhere([['type', '=', 'ad_id'], ['info_id', '=', $ad_id]])
                    ->first();

                if(!$font){
                    $log = ' [' . date('Y-m-d H:i:s') . "] FONTE NAO ENCONTRADA " . PHP_EOL . PHP_EOL;
                    File::append(
                        storage_path('logs/fb_webhook.log'),
                        $log
                    );
                    return false;
                }

                $token = $font->user->facebook_api_token;

                if(!$token){

                    $log = ' [' . date('Y-m-d H:i:s') . "] TOKEN DO USUARIO NAO ENCONTRADO" . PHP_EOL . PHP_EOL;
                    File::append(
                        storage_path('logs/fb_webhook.log'),
                        $log
                    );
                    return false;
                }

                $api = Api::init($app_id, $app_secret, $token);
                $api->setLogger(new CurlLogger());

                $fields = array();
                $params = array();

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
