<?php

namespace App\Mail;

use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FastBuy extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var array
     */
    public $user;
    /**
     * @var Product
     */
    public $product;

    /**
     * Create a new message instance.
     *
     * @param Product $product
     * @param array $user
     */
    public function __construct(Product $product, $user)
    {
        $this->user = new User($user);
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
//            ->to(config('app.email'))
            ->to('talanov.o@gmail.com')
            ->subject('Быстрый заказ')
            ->view('mail.fast-buy');
    }
}
