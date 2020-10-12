<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AdPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AdTest
 * @package Tests\Feature
 * @group api-ads
 */
class AdTest extends TestCase
{
    use HasFactory;
    use RefreshDatabase;

    public function testShowAllAds()
    {
        $amount = 10;
        Ad::factory()->has(AdPhoto::factory()->count(2), 'photos')->count($amount)->create();
        $response = $this->json('GET', '/api/v1/ads');

        $response->assertStatus(200)->assertJsonCount($amount)->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'description',
                'price',
                'photos'
            ]
        ]);
    }


    public function testCreateAd()
    {
        $ad = Ad::factory()->make()->toArray();
        $photos = AdPhoto::factory()->count(3)->make()->toArray();
        $ad['images'] = array_column($photos, 'link');
        $ad['main_image'] = rand(0,2);
        $response = $this->json('POST', '/api/v1/ads/create', $ad);
        $response->assertStatus(201)->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'description',
                'price',
                'photos'
            ]
        ]);
    }

    public function testErrorValidate()
    {
        $ad = Ad::factory()->make()->toArray();
        $response = $this->json('POST', '/api/v1/ads/create', $ad);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['images'], 'error')
                ->assertJsonMissingValidationErrors(['name', 'description', 'price']);

    }


}
