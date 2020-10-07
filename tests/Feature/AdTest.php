<?php

namespace Tests\Feature;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class AdTest extends TestCase
{
    use HasFactory;

    public function testGetAdsAndSort()
    {
        $response = $this->json('GET', 'api/v1/ads', ['sort_price' => 'asc', 'sort_date' => 'desc']);
        $response->assertStatus(200);
    }

    public function testRequiresFieldFromAd()
    {
        $response = $this->json('POST', 'api/v1/ads/create', [
            'name' => null,
            'description' => null,
            'price' => '33',
            'images' => ['','','',''],
            'main_image' => 1
        ]);

        $response->assertStatus(422);

    }

    public function testSuccessCreateAdRequestValidate()
    {
        $ad = [
            'name' => 'New Ad with car',
            'description' => 'This car very good. She very good, and accelerates to 300 km per hour.',
            'price' => 10000,
            'images' => ['https://unsplash.com/photos/llRPgs-bF88'],
            'main_image' => 0
        ];
        $response = $this->json('POST', 'api/v1/ads/create', $ad);

        $response->assertStatus(200);
        $response->assertJson($ad);
        var_dump($response->getContent());die();
    }

}
