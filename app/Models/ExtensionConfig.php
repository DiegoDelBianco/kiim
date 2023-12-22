<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ExtensionConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenancy_id',
        'extension',
        'key',
        'value',
        'bol_value',
    ];

    public static function setValue($extension, $key, $value)
    {
        $config = ExtensionConfig::updateOrCreate(
            ['extension' => $extension, 'key' => $key, 'tenancy_id' => Auth::user()->tenancy_id],
            ['value' => $value, 'bol_value' => is_bool($value) ? $value : null]
        );
    }

    public static function getValue($extension, $key, $tenancy_id = null)
    {
        $config = ExtensionConfig::where('extension', $extension)->where('key', $key)->where('tenancy_id', $tenancy_id ?? Auth::user()->tenancy_id)->first();
        if ($config) {
            if ($config->bol_value !== null) {
                return $config->bol_value;
            } else {
                return $config->value;
            }
        } else {
            return null;
        }
    }
}
