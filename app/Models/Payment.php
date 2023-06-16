<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Log;
use File;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_card_number',
        'credit_card_brand',
        'credit_card_token',
        'status',
        'limit_date',
        'cupom',
        'discount_type',
        'discount_value',
        'discount_percentage',
        'value',
        'totals',
        'sys_product_tenancy_id',
    ];

    public static function getUserByDoc($doc)
    {
        // Get assas user api by CPF/CNPJ

        $log =  PHP_EOL . PHP_EOL . '[' . date('Y-m-d H:i:s') . '] - Call: getUserByDoc ' . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        $log =  'Data: \n '. print_r($doc, true) . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        $ch = curl_init();

        // Transform array in query string
        // Sanetize doc to include only numbers
        $doc = preg_replace('/[^0-9]/', '', $doc);
        $query = http_build_query([
            'cpfCnpj' => $doc,
        ]);

        curl_setopt($ch, CURLOPT_URL, "https://www.".(config('assas.sandbox')?'sandbox.':NULL)."asaas.com/api/v3/customers?$query");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "access_token: ".config('assas.token'),
        ));

        $response = curl_exec($ch);
        curl_close($ch);


        $log =  'RESPONSE: \n ' . $response . PHP_EOL . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        return (array) json_decode($response);
    }

    public static function createAssasUser($user){

        $log =  PHP_EOL . PHP_EOL . '[' . date('Y-m-d H:i:s') . '] - Call: createAssasUser ' . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        $log =  'Data: \n '. print_r($user, true) . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.".(config('assas.sandbox')?'sandbox.':NULL)."asaas.com/api/v3/customers");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"name\": \"".$user->name."\",
            \"email\": \"".$user->email."\",
            \"phone\": \"".preg_replace('/[^0-9]/', '', $user->phone)."\",
            \"cpfCnpj\": \"".preg_replace('/[^0-9]/', '', $user->doc)."\",
            \"postalCode\": \"".preg_replace('/[^0-9]/', '', $user->cep)."\",
            \"addressNumber\": \"".preg_replace('/[^0-9]/', '', $user->address_number)."\",
            \"complement\": \"".$user->complement."\",
            }"
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config('assas.token'),
        ));

        $response = curl_exec($ch);
        curl_close($ch);



        $log =  'RESPONSE: \n ' . $response . PHP_EOL . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );


        return (array) json_decode($response);
    }

    // Create a new subscription in assas api
    public static function newSub($sysProductTenancy, $data){

        $log =  PHP_EOL . PHP_EOL . '[' . date('Y-m-d H:i:s') . '] - Call: newSub ' . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        $log =  'Data (sysProductTenancy): \n '. print_r($sysProductTenancy, true) . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        $log =  'Data (data): \n '. print_r($data, true) . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.".(config('assas.sandbox')?'sandbox.':NULL)."asaas.com/api/v3/subscriptions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        $price = NULL;

        if($sysProductTenancy->cycle == 'monthly')
            $price = $sysProductTenancy->sysProduct->monthly_price;

        if($sysProductTenancy->cycle == 'quarterly')
            $price = $sysProductTenancy->sysProduct->quarterly_price;

        if($sysProductTenancy->cycle == 'semiannually')
            $price = $sysProductTenancy->sysProduct->semiannually_price;

        if($sysProductTenancy->cycle == 'yearly')
            $price = $sysProductTenancy->sysProduct->yearly_price;

        // get client ip
        $ip = $_SERVER['REMOTE_ADDR'];

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"customer\": \"".$sysProductTenancy->tenancy->assas_id."\",
            \"billingType\": \"CREDIT_CARD\",
            \"nextDueDate\": \"".date('Y-m-d')."\",
            \"value\": \"".$price."\",
            \"remoteIp\": \"".$ip."\",
            \"cycle\": \"".strtoupper($sysProductTenancy->cycle)."\",
            \"description\": \"Assinatura: ".$sysProductTenancy->sysProduct->description."\",
            \"creditCard\": {
                \"holderName\": \"".$data['credit_card_name']."\",
                \"number\": \"".preg_replace('/[^0-9]/', '', $data['credit_card'])."\",
                \"expiryMonth\": \"".$data['credit_card_expiry_m']."\",
                \"expiryYear\": \"".$data['credit_card_expiry_y']."\",
                \"ccv\": \"".$data['credit_card_ccv']."\"
            },
            \"creditCardHolderInfo\": {
                \"name\": \"".$data['card_holder_name']."\",
                \"email\": \"".$data['card_holder_email']."\",
                \"cpfCnpj\": \"".preg_replace('/[^0-9]/', '', $data['card_holder_cpf_cnpj'])."\",
                \"postalCode\": \"".$data['card_holder_cep']."\",
                \"addressNumber\": \"".$data['card_holder_address_number']."\",
                \"addressComplement\": ".($data['card_holder_address_complement']?$data['card_holder_address_complement']:'null').",
                \"phone\": \"".preg_replace('/[^0-9]/', '', $data['card_holder_phone'])."\",
            },
            }");

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config('assas.token'),
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $log =  'RESPONSE: \n ' . $response . PHP_EOL . PHP_EOL;
        File::append(
            storage_path('logs/saas_api.log'),
            $log
        );

        return (array) json_decode($response);
    }
}
