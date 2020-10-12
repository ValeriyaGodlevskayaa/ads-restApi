<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\AdPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdPhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdPhoto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ad_id' => Ad::factory(),
            'link' => $this->faker->imageUrl(),
            'main' => $this->faker->numberBetween(0,1)
        ];
    }
}
