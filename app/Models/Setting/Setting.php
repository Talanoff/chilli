<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public static $TYPES = [
        'social' => 'Соцальные сети',
        'phone' => 'Телефоны',
        'email' => 'E-mail',
        'about' => 'О нас',
        'mission' => 'Наша миссия',
        'advantages' => 'Преимущества',
        'schedule' => 'График работы'
    ];

    protected $guarded = [];
}
