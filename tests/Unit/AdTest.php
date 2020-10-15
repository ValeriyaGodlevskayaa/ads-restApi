<?php

namespace Tests\Unit;

use App\Http\Services\AdService;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AdTest
 * @package Tests\Unit
 * @group api
 */
class AdTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider dataTestProvider
     * @param $data
     */
    public function testCreateAd($data)
    {
        $dataFake = $data;
        $adService = new AdService();
        $result = $adService->createAd($data)->load('photos')->toArray();
        $this->assertNotEmpty($result);
        $this->assertEquals($dataFake['name'], $result['name']);
        $this->assertEquals($dataFake['description'], $result['description']);
        $this->assertEquals($dataFake['price'], $result['price']);
        $this->assertEquals($dataFake['images'], array_column($result['photos'], 'link'));
    }

    public function dataTestProvider()
    {
        $faker = Factory::create( Factory::DEFAULT_LOCALE);
        return [
            [[
                'name' => $faker->sentence,
                'description' => $faker->text(300),
                'price' => $faker->randomFloat(2, 10, 10000),
                'images' => [
                    $faker->imageUrl(),
                    $faker->imageUrl()
                ],
                'main_image' => 1
            ]],
            [[
                'name' => $faker->sentence,
                'description' => $faker->text(300),
                'price' => $faker->randomFloat(2, 10, 10000),
                'images' => [
                    $faker->imageUrl(),
                    $faker->imageUrl()
                ],
                'main_image' => 1
            ]]
        ];
    }


}
