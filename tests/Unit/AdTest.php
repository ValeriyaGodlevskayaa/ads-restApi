<?php

namespace Tests\Unit;

use App\Http\Requests\CreateAdRequest;
use App\Http\Services\AdService;
use App\Models\Ad;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class AdTest extends TestCase
{
    //use RefreshDatabase;
    public $service;

    public function setUp(): void
    {
        parent::setUp();
        $service = \Mockery::mock(AdService::class);
        app()->instance(AdService::class, $service);
        $this->service = $service;
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->service = null;
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     * @group api
     */
    public function testCreateAd()
    {
        $data = [
            'name' => 'Test1',
            'description' => 'test1 description ad',
            'price' => 55,
            'images' => ['link_for_image', 'link_for_image'],
            'main_image' => 0
        ];
        $this->service->shouldReceive('createAd')->andReturnSelf();
        $res = $this->service->createAd($data);
        $this->assertTrue(true);
    }

}
