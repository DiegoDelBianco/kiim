<?php

namespace App\Models\Extensions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThermometerAwards extends Model
{
    use HasFactory;

    protected $table = 'extension_thermometer_awards';

    protected $fillable = [
        'tenancy_id',
        'user_id',
        'award_value',
        'set_limit_lead',
        'goal',
        'goal_type',
        'trophy_svg',
        'title',
    ];
}
