<?php

namespace App\Services;


use App\Models\Product\Product;
use function foo\func;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

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

	/**
	 * Handle offers
	 */
	public function handle(): void
	{
		$this->xml = simplexml_load_file($this->file);

		$offers = collect([]);
		$products = collect([]);

		foreach ($this->xml->ПакетПредложений->Предложения->Предложение as $offer) {
			$offers->push([
				'1c_id' => explode('#', $offer->Ид)[0],
				'quantity' => (int)$offer->Количество,
				'price' => collect(json_decode(json_encode($offer->Цены))->Цена)
					->filter(function ($price) {
						return $price->ИдТипаЦены == $this->getPriceTypeId();
					})->first()->ЦенаЗаЕдиницу,
			]);
		}

		$offers->groupBy('1c_id')->each(function ($group, $key) use ($products) {
			$products->push([
				'1c_id' => $key,
				'quantity' => $group->reduce(function ($t, $item) {
					return $t + $item['quantity'];
				}, 0),
				'price' => (float)$group->first()['price'],
			]);
		});

		$this->handleProducts($products);
	}

	/**
	 * @param Collection $products
	 */
	private function handleProducts(Collection $products): void
	{
		$products->each(function ($p) {
			/** @var Product $product */
			$product = Product::where('1c_id', $p['1c_id'])->first();

			$product->update([
				'quantity' => $product['quantity'],
				'price' => $product['price'],
			]);
		});
	}

	/**
	 * @return string
	 */
	protected function getPriceTypeId(): string
	{
		$priceType = collect(json_decode(json_encode($this->xml->ПакетПредложений->ТипыЦен))->ТипЦены)
			->filter(function ($price) {
				return $price->Наименование == 'Розница';
			})->first()->Ид;
		return $priceType;
	}
}