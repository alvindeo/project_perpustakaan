<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryInfo extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        $info = self::where('key', $key)->first();
        return $info ? $info->value : $default;
    }

    public static function set($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
