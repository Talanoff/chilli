<?php

namespace App\Services;


use App\Models\Product\Product;

class Parse1CImport
{
	protected $file;

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
		$xml = simplexml_load_file($this->file);
		list($props, $tag_id) = $this->handleProps($xml);

		$brands = $this->handleBrands($xml);
		$characteristics = $this->handleCharacteristics($props);

		foreach ($xml->Каталог->Товары as $product) {
			$product = json_decode(json_encode($product), true)['Товар'];
			$attrs = collect([]);
			$tags = null;

			foreach ($product['ЗначенияСвойств']['ЗначенияСвойства'] as $attr) {
				if ($attr['Ид'] !== $tag_id) {
					$attrs->push([
						'characteristic_type_1c_id' => $attr['Ид'],
						'characteristic_1c_id' => $attr['Значение'],
					]);
				} else {
					$tags = $attr['Значение'];
				}
			}

			Product::updateOrCreate([
				'1c_id' => $product['Ид'],
			], [
				'1c_id' => $product['Ид'],
				'1c_sku' => $product['Артикул'],
				'title' => $product['Наименование'],
				'description' => $product['Описание'],
				'brand' => $product['Группы']['Ид'],
				'image' => $product['Картинка'],
				'attrs' => $attrs->all(),
				'tags' => $tags,
			]);
		}
	}

	/**
	 * @param \SimpleXMLElement $xml
	 * @return array
	 */
	private function handleBrands(\SimpleXMLElement $xml): array
	{
		$brands = collect([]);
		foreach ($xml->Классификатор->Группы as $g) {
			$group = json_decode(json_encode($g), true)['Группа'];
			$brands->push([
				'1c_id' => $group['Ид'],
				'title' => $group['Наименование'],
			]);
		}
		return $brands->all();
	}

	/**
	 * @param \SimpleXMLElement $xml
	 * @return array
	 */
	private function handleProps(\SimpleXMLElement $xml): array
	{
		$props = collect([]);
		$tag_id = null;
		foreach ($xml->Классификатор->Свойства as $p) {
			$attrs = json_decode(json_encode($p), true)['Свойство'];

			foreach ($attrs as $attr) {
				$values = collect([]);

				if ($attr['Наименование'] !== 'seo_tags'
					&& !empty($attr['ТипЗначений'])
					&& $attr['ТипЗначений'] === 'Справочник') {
					foreach ($attr['ВариантыЗначений'] as $item) {
						$values->push([
							'1c_id' => $item['ИдЗначения'],
							'value' => $item['Значение'],
						]);
					}
				} else {
					$tag_id = $attr['Ид'];
				}

				$props->push([
					'1c_id' => $attr['Ид'],
					'title' => $attr['Наименование'],
					'values' => $values->all(),
				]);
			}
		}
		return [$props->all(), $tag_id];
	}

	public function handleCharacteristics($props)
	{
		return [];
	}
}