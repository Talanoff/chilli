<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BrandsProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	private $brands;

	/**
	 * Create a new job instance.
	 *
	 * @param $brands
	 */
    public function __construct($brands)
    {
		$this->brands = $brands;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::debug($this->brands);
    }
}