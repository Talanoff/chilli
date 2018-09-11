<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socials = [
            'facebook' => 'https://facebook.com',
            'instagram' => 'https://instagram.com',
            'youtube' => 'https://youtube.com',
        ];

        foreach (['099 111 22 33', '098 111 22 33', '063 111 22 33', '044 111 22 33'] as $phone) {
            App\Models\Setting\Setting::create([
                'type' => 'phone',
                'value' => $phone,
            ]);
        }

        foreach ($socials as $key => $social) {
            App\Models\Setting\Setting::create([
                'type' => 'social',
                'name' => $key,
                'value' => $social,
            ]);
        }

        App\Models\Setting\Setting::create([
            'type' => 'email',
            'value' => 'chilli_mobile@gmail.com',
        ]);

        App\Models\Setting\Setting::create([
            'type' => 'about',
            'name' => 'О нас',
            'value' => 'Вас интересует мобильные устройства или товары для активного отдыха? Все это вы можете купить прямо сейчас, сэкономив уйму времени! Интернет- магазин с радостью поможет вам избежать необходимости посещать десятки магазинов. Вы можете заказать любой товар, не вставая со своего кресла, а наш курьер вовремя доставит покупку по указанному адресу. Интернет магазин действует на территории всей страны.',
        ]);

        App\Models\Setting\Setting::create([
            'type' => 'mission',
            'name' => 'Наша миссия',
            'value' => 'Вас интересует бытовая техника, компьютеры, софт или товары для активного отдыха? Все это вы можете купить прямо сейчас, сэкономив уйму времени!',
        ]);
    }
}
