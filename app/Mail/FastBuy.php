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
     * @param User $user
     */
    public function __construct(Product $product, User $user)
    {
        $this->user = $user;
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
            ->to('info@chilli.com.ua')
            ->from('noreply@chilli.com.ua')
            ->subject('Быстрый заказ')
            ->view('mail.fast-buy');
    }
}
