<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Extension extends Model
{
    use HasFactory;

    protected $fillable = [
        'extension',
        'tenancy_id',
        'active',
        'tigger_view_home_all',
        'tigger_view_home_basic',
        'tigger_view_home_magener',
        'tigger_view_home_team_manager',
        'tigger_view_home_admin',
        'tigger_view_menu_all',
        'tigger_view_menu_basic',
        'tigger_view_menu_magener',
        'tigger_view_menu_team_manager',
        'tigger_view_menu_admin',
        'tigger_monthend_close',

    ];

    public $extensions = [
        'thermometer' => [
            'icon' => 'fas fa-thermometer-quarter',
            'title' => 'Termômetro',
            'subtitle' => 'Termômetro',
            'description' => 'Motive sua equipe com premiações e desafios',
            'index-route' => 'extensions.thermometer',
            'tiggers' => [
                'view_home_all'      => true,
                'view_menu_admin'    => true,
                'monthend_close'     => true,
            ],
            'model' => 'App\Models\Extensions\Thermometer',
        ]
    ];

    public static function getExtensions()
    {
        $extensions = new Extension();
        return $extensions->extensions;
    }

    public static function getExtension($extension)
    {
        $extensions = new Extension();
        return isset($extensions->extensions[$extension]) ? $extensions->extensions[$extension] : false;
    }

    public static function checkActive($extension, $tenancy_id){
        $extension = Extension::where('extension', $extension)->where('tenancy_id', $tenancy_id)->first();
        if($extension){
            return $extension->active;
        }
        return false;
    }

    public static function getHomeAvaliable(){
        $tenancies = [];
        foreach(Auth::user()->roles as $tenancy){
            $tenancies[] = $tenancy->tenancy_id;
        }
        $response = [];
        $extensions = Extension::whereIn('tenancy_id', $tenancies)->where('active', true)->where('tigger_view_home_all', true)->get();
        foreach($extensions as $extension){
            $response[$extension->extension] = [
                'include'       => 'extensions.'.$extension->extension.'.include.home',
                'tenancy_id'    => $extension->tenancy_id,
            ];
        }

        return $response;
    }

    public static function tiggerMonthendClose(){

        $extensions = new Extension();
        $list_extensions = $extensions->extensions;
        foreach($list_extensions as $extension){
            if(isset($extension['tiggers']['monthend_close'])? $extension['tiggers']['monthend_close'] : false){
                call_user_func([$extension['model'], 'tiggerMonthendClose']);
            }
        }
    }
}
