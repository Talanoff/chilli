<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $fillable = [
        'email',
        'status',
    ];

    public static $STATUSES = [
        'new',
        'sent',
    ];
}
