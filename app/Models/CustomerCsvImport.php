<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCsvImport extends Model
{
    use HasFactory;

    public static $fields_to_save = [
        'name' => ['title' => 'Nome', 'func' => 'string'],
        'last_name' => ['title' => 'Sobre nome', 'func' => 'string'],
        'email' => ['title' => 'Email', 'func' => 'string'],
        'ddi' => ['title' => 'DDI', 'func' => 'pre_phone'],
        'ddd' => ['title' => 'DDD', 'func' => 'pre_phone'],
        'phone' => ['title' => 'Telefone', 'func' => 'phone'],
        'ddi_2' => ['title' => 'DDI 2', 'func' => 'pre_phone'],
        'ddd_2' => ['title' => 'DDD 2', 'func' => 'pre_phone'],
        'phone_2' => ['title' => 'Telefone 2', 'func' => 'phone'],
        'whatsapp' => ['title' => 'Whatsapp', 'func' => 'full_phone'],
        'birth' => ['title' => 'Nascimento', 'func' => 'date'],
        'rent' => ['title' => 'Alguel?', 'func' => 'bollean'],
        'acquisition_date' => ['title' => 'Data de aquisição', 'func' => 'date'],
        'first_contact_date' => ['title' => 'Data do primeiro contato', 'func' => 'date'],
        'last_contact_date' => ['title' => 'Data do ultimo contato', 'func' => 'date'],
        'source_campaign' => ['title' => 'Campanha (Nome)', 'func' => 'string'],
        'marital_status' => ['title' => 'Estado civil', 'func' => 'string'],
        'cpf' => ['title' => 'CPF', 'func' => 'numeric'],
        'familiar_income' => ['title' => 'Renda Familiar', 'func' => 'string'],
        'income' => ['title' => 'Renda', 'func' => 'string'],
        'job' => ['title' => 'Cargo', 'func' => 'string'],
        'restriction' => ['title' => 'Nome restrito?', 'func' => 'bollean'],
        'entry' => ['title' => 'Entrada', 'func' => 'money'],
        'installments' => ['title' => 'Qtd Parcelas', 'numeric' => 'numeric'],
        'installment_value' => ['title' => 'Valor Parcelas', 'func' => 'money'],
        'region' => ['title' => 'Região', 'func' => 'string'],
        'fgts' => ['title' => 'FGTS', 'func' => 'money'],
        'best_time' => ['title' => 'Melhor horario para contato', 'func' => 'string'],
    ];

    public static function getFieldsToSave()
    {
        // return filds_to_save
        return self::$fields_to_save;
    }

    public static function prepare_($value, $key, $instance){
        $instance->$key = $value;
        return $instance;
    }

    public static function prepare_string($value, $key, $instance){
        $instance->$key = $value;
        return $instance;
    }
    public static function prepare_pre_phone($value, $key, $instance){
        // sanetize $value to only numbers, and get only two first numbers
        $instance->$key = substr(preg_replace('/[^0-9]/', '', $value), 0, 2);
        return $instance;
    }
    public static function prepare_phone($value, $key, $instance){
        // sanetize $value to only numbers
        $value = preg_replace('/[^0-9]/', '', $value);
        $instance->$key = $value;

        return $instance;
    }
    public static function prepare_full_phone($value, $key, $instance){
        $value = preg_replace('/[^0-9]/', '', $value);
        $instance->$key = $value;

        return $instance;
    }
    public static function prepare_date($value, $key, $instance){
        // identify date format
        $date = strtotime($value);
        if($date){
            $instance->$key = date("Y-m-d H:i:s", $date);
        }
        return $instance;
    }
    public static function prepare_bollean($value, $key, $instance){
        if($value == 0 OR $value == "no" OR $value == "n" OR $value == 'false' OR $value == "falso"){
            $instance->$key = false;
        }else{
            $instance->$key = true;
        }

        return $instance;
    }
    public static function prepare_numeric($value, $key, $instance){
        // sanetize $value to only numbers
        $value = preg_replace('/[^0-9]/', '', $value);
        $instance->$key = $value;

        return $instance;
    }
    public static function prepare_money($value, $key, $instance){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $instance->$key = $value;

        return $instance;
    }
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
}
