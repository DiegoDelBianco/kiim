<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappNotification extends Model
{
    use HasFactory;

    public function send_api($to, $template, $args = []){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v17.0/116377101484860/messages");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"messaging_product\": \"whatsapp\", \"to\": \"".$to."\", \"type\": \"template\", \"template\": { \"name\": \"".$template."\", \"language\": { \"code\": \"".pt_BR."\" } } }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "Authorization: Bearer ".config('whatsapp_notify.token')."' ",
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        print_r($response);
    }

    public function ini_message($to){
        send_api($to, "inicio");
    }
}
