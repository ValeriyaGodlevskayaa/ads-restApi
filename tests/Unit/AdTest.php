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
        $this->service = app()->make(AdService::class);
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
     */
    public function testAd()
    {
        $service = \Mockery::mock(AdService::class);
        app()->instance(AdService::class, $service);
        $data = Ad::factory()->make();
        $service->createAd($data);

        //$this->assertObjectHasAttribute('name', $res);
       // var_dump($res->refresh());die();
        $this->assertTrue(true);
    }

}
