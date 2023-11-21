<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use File;

use App\Models\User;

use FacebookAds\Object\Ad;
use FacebookAds\Object\Lead;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

class FaceGetLeadsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FaceApi:GetLeads {user_id} {form_id} {limit_days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa leads do facebook, especifique o id do usuario para obtermos o token, o id do formulario, e a quantidade de dias limite';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user_id        = $this->argument('user_id');
        $form_id        = $this->argument('form_id');
        $limit_days     = $this->argument('limit_days');
        $time_limit     = strtotime("-$limit_days days");

        $user = User::find($user_id);

        if(!$user ? true : !$user->facebook_api_token){
            echo "usuário ou token não encontrado";
            return 0;
        }

        $app_secret     = config("apis.fb.app_secrect");
        $app_id         = config("apis.fb.app_id");
        $access_token   = $user->facebook_api_token;

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());


        $fields = array(
            'created_time', 'id', 'ad_id', 'form_id', 'field_data', 'page_id', 'adgroup_id'
        );
        $params = array(
            'limit' => $limit
        );


        $response = json_decode(json_encode((new Ad($form_id))->getLeads(
            $fields,
            $params
          )->getResponse()->getContent(), JSON_PRETTY_PRINT));

        foreach($response->data as $lead){
            if(!$lead->id) continue;
            if(strtotime($lead->created_time) < $time_limit) continue;
            if(Customer::where([['source', '=', 'facebook form'], ['source_id', '=', $lead->id]])->first()) continue;

            $customer = new Customer;


            $customer->source = 'facebook form';
            $customer->source_id = $lead->id;
            $customer->source_form  = $lead->source_form;
            $customer->source_ad  = $lead->ad_id;
            $customer->tenancy_id = $user->tenancy_id;

            foreach($lead->field_data as $data){
                switch ($data->name) {
                    case 'email':
                        $customer->email = $data->values[0];
                        break;
                    case 'full_name':
                        $customer->name = $data->values[0];
                        break;
                    case 'nome_completo':
                        $customer->name = $data->values[0];
                        break;
                    case 'phone_number':

                        $cellphone          = preg_replace("/[^0-9]/", "", $data->values[0]);
                        $ddi                = substr($cellphone, 0, 2);
                        $ddd                = substr($cellphone, 2, 2);
                        $cellphone          = substr($cellphone, 4);

                        $customer->ddi      = $ddi;
                        $customer->ddd      = $ddd;
                        $customer->phone    = $cellphone;
                        $customer->whatsapp = $ddi.$ddd.$cellphone;

                        //$log .=  "ddi: $ddi ddd: $ddd phone: $cellphone \n";
                        break;
                    case 'telefone':

                        $cellphone          = preg_replace("/[^0-9]/", "", $data->values[0]);
                        $ddi                = substr($cellphone, 0, 2);
                        $ddd                = substr($cellphone, 2, 2);
                        $cellphone          = substr($cellphone, 4);

                        $customer->ddi      = $ddi;
                        $customer->ddd      = $ddd;
                        $customer->phone    = $cellphone;
                        $customer->whatsapp = $ddi.$ddd.$cellphone;

                        //$log .=  "ddi: $ddi ddd: $ddd phone: $cellphone \n";
                        break;
                    case 'cep':

                        $customer->cep = $data->values[0];

                        break;

                    default:

                        break;
                }
            }

            $customer->save();

            $log .=  "Cadatrado: #".$customer->customer_id." \n";
        }

        File::append(
            storage_path('logs/fb_webhook.log'),
            $log
        );

        return 0;
    }
}
