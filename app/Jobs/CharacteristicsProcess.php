<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CharacteristicsProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	private $props;

	/**
	 * Create a new job instance.
	 *
	 * @param $props
	 */
    public function __construct($props)
    {
		$this->props = $props;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::debug(json_decode($this->props));
    }
}
