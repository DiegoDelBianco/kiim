<?php

namespace App\Models\Extensions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Log;
use File;

use App\Models\Customer;
use App\Models\Extension;
use App\Models\Extensions\ThermometerAwards;
use App\Models\RoleUser;

class Thermometer extends Model
{
    use HasFactory;

    protected $table = 'extension_thermometers';

    protected $fillable = [
        'tenancy_id',
        'title',
        'award_value',
        'set_limit_lead',
        'goal',
        'goal_type',
        'trophy_svg',
    ];

    public $adwards_images = [
        'award-7.jpg' => 'Troféu 7',
        'award-6.jpg' => 'Troféu 6',
        'award-5.jpg' => 'Troféu 5',
        'award-4.jpg' => 'Troféu 4',
        'award-3.jpg' => 'Troféu 3',
        'award-2.jpg' => 'Troféu 2',
        'award-1.jpg' => 'Troféu 1',
    ];

    public $adwards_image_folder = '/images/extensions/thermometer/awards/';

    public static function getImagePath($image){
        $instance = new Thermometer();
        return $instance->adwards_image_folder.$image;
    }

    public static function getImages()
    {
        $images = [];
        $instance = new Thermometer();

        $folder = $instance->adwards_image_folder;
        $image_list = $instance->adwards_images;

        foreach ($image_list as $image => $title) {
            $images[] = ["image" => $image, "file" => $folder.$image, 'title' => $title];
        }

        return $images;
    }

    public static function tiggerMonthendClose()
    {
        File::append(storage_path('logs/teste_t.log'),'teste 1 ' . PHP_EOL);
        $avaliables = Extension::where('extension', 'thermometer')->get();
        foreach ($avaliables as $avaliable) {
            $goals = self::where('tenancy_id', $avaliable->tenancy_id)->orderBy('goal', 'desc')->get();
            File::append(storage_path('logs/teste_t.log'),'teste 2 ' . PHP_EOL);
            $count_sell = DB::table('customers')
                ->select('user_id', DB::raw('count(*) as total'))
                ->where('tenancy_id', $avaliable->tenancy_id)
                ->where([['buy_date', '>=',  date('Y-m-01 00:00:00', strtotime('-1 month'))], ['buy_date', '<',  date('Y-m-01 00:00:00')]])
                ->groupBy('user_id')
                ->get();

            File::append(storage_path('logs/teste_t.log'), "query result (". date('Y-m-01 00:00:00', strtotime('-1 month')).") (".date('Y-m-01 00:00:00').") : ".print_r($count_sell, true) . PHP_EOL);


            foreach ($count_sell as $count) {
                File::append(storage_path('logs/teste_t.log'),'teste 3 ' . PHP_EOL);
                $set_goal = false;
                foreach ($goals as $goal) {
                    File::append(storage_path('logs/teste_t.log'),'teste 4 ' . PHP_EOL);
                    if($set_goal)
                        continue;

                    if ($count->total >= $goal->goal) {
                        $set_goal = true;

                        ThermometerAwards::create([
                            'tenancy_id' => $avaliable->tenancy_id,
                            'user_id' => $count->user_id,
                            'award_value' => $goal->award_value,
                            'set_limit_lead' => $goal->set_limit_lead,
                            'goal' => $goal->goal,
                            'goal_type' => $goal->goal_type,
                            'trophy_svg' => $goal->trophy_svg,
                            'title' => $goal->title,
                        ]);

                        if($goal->set_limit_lead > 0){
                            RoleUser::where('user_id', $count->user_id)
                                ->where('tenancy_id', $avaliable->tenancy_id)
                                ->update(['limit_cs_by_day' => $goal->set_limit_lead]);
                        }

                    }
                }
            }
        }
    }

}
