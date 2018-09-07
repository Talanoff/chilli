<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static $STATUSES = [
        'processing' => 'В обработке',
        'finished' => 'Завершен',
        'declined' => 'Отклонен',
    ];

    public static $DELIVERY = [
        'self' => 'Самовывоз',
        'np' => 'Новая почта',
        'courier' => 'Курьер',
    ];
}
