<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Parse1CImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	private $file;

	/**
	 * Create a new job instance.
	 *
	 * @param $file
	 */
    public function __construct($file)
    {
		$this->file = $file;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
