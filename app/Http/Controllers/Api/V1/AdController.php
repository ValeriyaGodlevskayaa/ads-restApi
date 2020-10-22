<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdRequest;
use App\Http\Services\AdService;
use Illuminate\Http\Request;

/**
 * Class AdController
 * @package App\Http\Controllers\Api\V1
 */
class AdController extends Controller
{
    /**
     * @var AdService
     */
    private $adService;

    /**
     * AdController constructor.
     * @param AdService $adService
     */
    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $ads = $this->adService->getAds($request->all());

        return response()->json(['data' => $ads], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById($id)
    {
        try {
            $ad = $this->adService->getAd($id);

            return response()->json(['data' => $ad], 200);
        }catch (\DomainException $domainException){

            return response()->json(['message' => $domainException->getMessage()], 404);
        }

    }

    /**
     * @param CreateAdRequest $createAdRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAdRequest $createAdRequest)
    {
        try {
            $ad = $this->adService->createAd($createAdRequest->all());

            return response()->json(['data' => $ad], 201);
        }catch (\DomainException $domainException){

            return response()->json(['message' => $domainException->getMessage()]);
        }

    }
}
