<?php

namespace App\Services;


use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Characteristic;
use App\Models\Product\CharacteristicType;
use App\Models\Product\Product;
use App\Models\Product\Series;
use Illuminate\Http\File;

class Parse1CImport
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
		$this->handleBrands();
		$this->handleCharacteristicsTypes();
		$this->handleProducts();
	}

	/**
	 * Handle brands
	 */
	private function handleBrands(): void
	{
		foreach ($this->xml->Классификатор->Группы->Группа as $group) {
			$brand = Brand::updateOrCreate([
				'title' => $group->Наименование,
			], [
				'1c_id' => $group->Ид,
			]);

			$this->handleSeries($group, $brand);
		}
	}

	/**
	 * Handle types of characteristics
	 */
	private function handleCharacteristicsTypes(): void
	{
		foreach ($this->xml->Классификатор->Свойства->СвойствоНоменклатуры as $type) {
			if ($type->Наименование != 'Совместимость') {
				CharacteristicType::updateOrCreate([
					'1c_id' => $type->Ид,
				], [
					'title' => $type->Наименование,
				]);
			}
		}
	}

	/**
	 * @param $group
	 * @param Brand $brand
	 */
	private function handleSeries($group, Brand $brand): void
	{
		foreach ($group->Группы->Группа as $series) {
			Series::updateOrCreate([
				'1c_id' => $series->Ид,
			], [
				'brand_id' => $brand->id,
				'title' => $series->Наименование,
			]);
		}
	}

	/**
	 * @return array
	 */
	private function prependProducts(): array
	{
		$products = collect([]);

		foreach ($this->xml->Каталог->Товары->Товар as $product) {
			$external_id = explode('#', $product->Ид);
			$series = Series::where('1c_id', $product->Группы->Ид)->first();
			$props = null;
			$color = null;
			$image = null;

			if (isset($product->ЗначенияСвойств)) {
				$props = [];
				foreach (json_decode(json_encode($product->ЗначенияСвойств)) as $propList) {
					foreach ($propList as $prop) {
						$props[$prop->Ид] = $prop->Значение;
					}
				}
			}

			if (isset($external_id[1])) {
				$color = [$external_id[1] => $product->ХарактеристикиТовара->ХарактеристикаТовара->Значение];
			}

			if (isset($product->Картинка)) {
				$path = str_replace('import.xml', '', $this->file) . $product->Картинка;

				if (file_exists($path)) {
					$image = new File($path);
				}
			}

			$products->push([
				'1c_id' => $external_id[0],
				'title' => $product->Наименование,
				'description' => $product->Описание ?? null,
				'brand_id' => $series->brand_id,
				'series_id' => $series->id,
				'props' => $props,
				'color' => $color,
				'image' => $image,
			]);
		}

		return $products->all();
	}

	/**
	 * Handle products
	 */
	private function handleProducts(): void
	{
		$products = $this->prependProducts();

		foreach ($products as $item) {
			/** @var Product $product */
			$product = Product::updateOrCreate([
				'1c_id' => $item['1c_id'],
			], [
				'title' => $item['title'],
				'description' => $item['description'],
				'brand_id' => $item['brand_id'],
				'is_published' => 1,
				'rating' => rand(4, 5), // @TODO change this
			]);

			if ($item['series_id']) {
				$product->series()->sync([$item['series_id']]);
			}

			if ($item['image']) {
				$product->clearMediaCollection('product');
				$product->addMedia($item['image'])->toMediaCollection('product');
			}

			$characteristics = [];

			if ($item['props']) {
				foreach ($item['props'] as $id => $prop) {
					$type = CharacteristicType::where('1c_id', $id)->first();

					if ($type) {
						$characteristic = Characteristic::firstOrCreate([
							'type_id' => $type->id,
							'value' => $prop,
						], [
							'type' => 'text',
						]);

						array_push($characteristics, $characteristic->id);
					}
				}
			}

			if ($item['color']) {
				foreach ($item['color'] as $external_id => $color) {
					$type = CharacteristicType::where('slug', 'color')->first();

					$characteristic = Characteristic::firstOrCreate([
						'type_id' => $type->id,
						'value' => $this->detectColor($color),
					], [
						'type' => 'color',
					]);

					$characteristics[$characteristic->id] = [
						'1c_id' => $external_id,
					];
				}
			}

			$product->characteristics()->sync($characteristics);
		}
	}

	/**
	 * @param $color
	 * @return string
	 */
	private function detectColor($color): string
	{
		switch ($color) {
			case 'Красный':
				$hash = '#ec1111';
				break;
			case 'Синий':
				$hash = '#1138df';
				break;
			default:
				$hash = '#f4f4f4';
		}

		return $hash;
	}
}