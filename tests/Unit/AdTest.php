<?php

namespace Tests\Unit;

use App\Http\Requests\CreateAdRequest;
use App\Http\Services\AdService;
use App\Models\Ad;
use App\Models\AdPhoto;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
//use PHPUnit\Framework\TestCase;
use Mockery\Mock;
use Tests\TestCase;

/**
 * Class AdTest
 * @package Tests\Unit
 * @group api
 */
class AdTest extends TestCase
{
    use RefreshDatabase;


//    public function testCreateAd()
//    {
//        $data = Ad::factory()->make()->toArray();
//        $photoLinks = array_column(AdPhoto::factory()->count(2)->make()->toArray(), 'link');
//        $data['images'] = $photoLinks;
//        $data['main_image'] = rand(0,1);
//        $r = new AdService();
//        $r->createAd($data);
//
//    }

    public function testCreateAd()
    {
        $data = Ad::factory()->make()->toArray();
        $photoLinks = array_column(AdPhoto::factory()->count(2)->make()->toArray(), 'link');
        $data['images'] = $photoLinks;
        $data['main_image'] = rand(0,1);
        $mock = $this->createMock(AdService::class);
        $result = $mock->createAd($data);
        $this->assertInstanceOf(Ad::class, $result);

    }

}
