<?php

namespace Modules\Template\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Modules\Template\Entities\Element;

class ElementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Element::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => 'بنر نوع اول',
            'name' => 'first-banner',
            'order' => 1,
            'page_id' => 1,
            'status' => 1,
            'type' => 'banner',
        ];
    }
}
