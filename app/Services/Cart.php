<?php

namespace App\Services;


use App\Models\Order\Checkout;
use App\Models\Order\Order;
use App\Models\User\User;
use Illuminate\Support\Collection;

class Cart
{
    private $user;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->user = User::define();
    }

    /**
     * @return Collection
     */
    public function items(): Collection
    {
        return Checkout::where('user_id', $this->user)
                       ->where('status', 'in_progress')
                       ->latest('id')->get();
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->items()->reduce(function ($total, $item) {
            return $total + ($item->price * $item->quantity);
        });
    }

    /**
     * Update users cart
     *
     * @param User $user
     * @param Order $order
     */
    public function complete(User $user, Order $order)
    {
        $this->items()->map(function ($item) use ($user, $order) {
            $item->update([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'status' => 'finished',
            ]);
        });
    }
}
