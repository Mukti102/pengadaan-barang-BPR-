<?php

use App\Models\Setting;

function setActive($route)
{
    return request()->routeIs($route) ? 'active' : '';
}


function rupiah($value)
{
    return 'Rp ' . number_format($value ?? 0, 0, ',', '.');
}

if (!function_exists('setting')) {

    function setting($key, $default = null)
    {
        $item = Setting::where('key', $key)->first();

        return $item ? $item->value : $default;
    }
}
