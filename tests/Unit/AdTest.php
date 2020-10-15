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

    private $faker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = Factory::create( Factory::DEFAULT_LOCALE);
    }


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
        return [
            [[
                'name' => $this->faker->sentence,
                'description' => $this->faker->text(300),
                'price' => $this->faker->randomFloat(2, 10, 10000),
                'images' => [
                    $this->faker->imageUrl(),
                    $this->faker->imageUrl()
                ],
                'main_image' => 1
            ]],
            [[
                'name' => $this->faker->sentence,
                'description' => $this->faker->text(300),
                'price' => $this->faker->randomFloat(2, 10, 10000),
                'images' => [
                    $this->faker->imageUrl(),
                    $this->faker->imageUrl()
                ],
                'main_image' => 1
            ]]
        ];
    }

    /**
     * @param $data
     * @dataProvider generateDataWithoutImagesProvider
     */
    public function testExceptionCreateAd($data)
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Images can't empty!");
        $adService = new AdService();
        $adService->createAd($data);
    }

    public function generateDataWithoutImagesProvider()
    {
        return [
            [[
                'name' => $this->faker->sentence,
                'description' => $this->faker->text(300),
                'price' => $this->faker->randomFloat(2, 10, 10000),
                'images' => [],
                'main_image' => 1
            ]]
        ];
    }


}
