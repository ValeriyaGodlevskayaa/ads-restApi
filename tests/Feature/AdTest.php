<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdTest extends TestCase
{

    public function testGetAds()
    {
        $response = $this->json('GET', 'api/v1/ads');
        $response->assertStatus(200);
    }

    public function testGetListAdWithSort()
    {
        $response = $this->json('GET', 'api/v1/ads', ['sort_price' => 'asc', 'sort_date' => 'desc']);
        $response->assertStatus(200);
    }

    public function testRequiresFieldFromAd()
    {
        $response = $this->json('POST', 'api/v1/ads/create');
        $response->assertStatus(200);

    }
}
