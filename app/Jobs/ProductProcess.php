<?php

namespace App\Jobs;

use App\Models\Product\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProductProcess
{
    use Dispatchable, SerializesModels;
	private $product;

	/**
	 * Create a new job instance.
	 *
	 * @param $product
	 */
    public function __construct($product)
    {
		$this->product = $product;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	\Log::debug($this->product);


//    	dd($this->product);
//        Product::updateOrCreate([
//        	'1c_id' => $this->product->Артикул
//		]);
    }
}
