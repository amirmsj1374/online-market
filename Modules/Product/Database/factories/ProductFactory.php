<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Entities\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // return [
        //     'title'       => 'گوشی موبایل شیائومی مدل Redmi Note 9 Pro M2003J6B2G دو سیم‌ کارت ظرفیت 128 گیگابایت',
        //     'description' => 'گوشی موبایل شیائومی مدل Redmi Note 9 Pro M2003J6B2G دو سیم‌ کارت ظرفیت 128 گیگابایت با فناوری NFC وارد بازار شده است. شیائومی در آوریل 2020، نسل نهم از گوشی‌های Redmi Note خود را معرفی کرده است. ',
        //     'body'        => 'گوشی موبایل شیائومی مدل Redmi Note 9 Pro M2003J6B2G دو سیم‌ کارت ظرفیت 128 گیگابایت با فناوری NFC وارد بازار شده است. شیائومی در آوریل 2020، نسل نهم از گوشی‌های Redmi Note خود را معرفی کرده است. ',
        // ];
        return [
            'title'       => $this->faker->title(),
            'description' => $this->faker->sentence(),
            'body'        => $this->faker->paragraph(),
        ];
    }
}
