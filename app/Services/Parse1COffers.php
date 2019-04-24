<?php

namespace App\Services;


class Parse1COffers
{
	protected $file;
	protected $xml;

	/**
	 * Create a new job instance.
	 *
	 * @param $file
	 */
	public function __construct($file)
	{
		$this->file = $file;
	}

	public function handle()
	{
		$this->xml = simplexml_load_file($this->file);
	}
}