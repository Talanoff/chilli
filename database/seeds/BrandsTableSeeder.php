<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    public function run()
    {
        $brands = [
            'Apple' => 'https://worldvectorlogo.com/download/apple-black.svg',
            'Samsung' => asset('/images/brands/samsung.svg'),
            'Xiaomi' => 'https://worldvectorlogo.com/download/xiaomi.svg',
            'Meizu' => 'https://worldvectorlogo.com/download/meizu-3.svg',
            'Sony' => asset('/images/brands/sony.svg'),
            'Asus' => asset('images/brands/asus.svg'),
            'Huawei' => asset('images/brands/huawei.svg'),
            'LG' => asset('/images/brands/lg.svg'),
            'Lenovo' => 'https://worldvectorlogo.com/download/lenovo-1.svg',
            'Motorola' => asset('/images/brands/motorola.svg'),
            'OnePlus' => asset('/images/brands/oneplus.svg'),
            'HTC' => 'https://worldvectorlogo.com/download/htc.svg',
            'Nokia' => 'https://worldvectorlogo.com/download/nokia-3.svg',
        ];

        foreach ($brands as $name => $link) {
            /** @var \App\Models\Product\Brand $brand */
            $brand = \App\Models\Product\Brand::create([
                'title' => $name,
                'slug' => str_slug($name),
            ]);

            $brand->clearMediaCollection('brand');
            $brand->addMediaFromUrl($link)
                  ->usingFileName($brand->slug . '.svg')
                  ->toMediaCollection('brand');
        }
    }
}
