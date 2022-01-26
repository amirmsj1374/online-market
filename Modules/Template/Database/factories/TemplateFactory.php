<?php

namespace Modules\Template\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Template\Entities\Template;

class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'wolmart',
            'selected' => 1,
        ];
    }
}
