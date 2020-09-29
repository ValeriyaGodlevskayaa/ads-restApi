<?php


namespace App\Http\Services;


use App\Http\Repositories\Api\V1\AdRepository;
use App\Http\Requests\CreateAdRequest;
use App\Models\AdPhoto;
use Illuminate\Http\Request;

class AdService
{
    private $adRepository;

    public function __construct(AdRepository $adRepository)
    {
        $this->adRepository = $adRepository;
    }

    public function getAds($requestSort)
    {
        return $this->adRepository->getAll($requestSort);
    }

    public function getAd($id)
    {
        return $this->adRepository->getById($id);
    }

    public function createAd(CreateAdRequest $createAdRequest)
    {
        if (!empty($createAdRequest->get('error'))){
            return response()->json($createAdRequest->get('error'));
        }

        $requestData = $createAdRequest->all();
        if ($requestData){
            $data['name'] = $requestData['name'];
            $data['description'] = $requestData['description'];
            $data['price'] = $requestData['price'];
            $data['images'] = $requestData['images'];
            $data['main_image'] = $requestData['main_image'];

            if ($images = $data['images']){
                $links = [];
                foreach ($images as $key => $image){
                    $links[$key] = ['link' => $image, 'main' => 0];
                }
                if ($index = $data['main_image']){
                    $links[$index]['main'] = AdPhoto::MAIN_IMAGE;
                }
            }
            return $this->adRepository->create($data, $links);

        }

    }

}
