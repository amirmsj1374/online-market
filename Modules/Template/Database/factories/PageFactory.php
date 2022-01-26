<?php

namespace Modules\Template\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Template\Entities\Template;

use Modules\Template\Entities\Page;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => 'خانه',
            'name' => 'home',
            'template_id' => Template::where('selected', 1)->first()->id,
        ];
    }
}
