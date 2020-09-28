<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdRequest;
use App\Http\Resources\AdCollection;
use App\Http\Services\AdService;
use Illuminate\Http\Request;

class AdController extends Controller
{
    private $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    public function index(Request $request)
    {
        $ads = $this->adService->getAds($request->all())->paginate(10);
        return response()->json(AdCollection::collection($ads), 200);
    }

    public function getById($id)
    {
        try {
            $ad = $this->adService->getAd($id);
            return response()->json(new AdCollection($ad), 200);
        }catch (\DomainException $e){
            return response()->json(['message' => $e->getMessage()], 404);
        }

    }

    public function store(CreateAdRequest $createAdRequest)
    {
        $ad = $this->adService->createAd($createAdRequest);
        return response()->json(['data' => new AdCollection($ad)], 201);
    }
}
