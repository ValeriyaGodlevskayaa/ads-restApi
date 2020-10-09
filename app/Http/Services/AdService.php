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

    public function getAds($requestSort=[])
    {
        return $this->adRepository->getAll($requestSort);
    }

    public function getAd(int $id)
    {
        return $this->adRepository->getById($id);
    }

    public function createAd($requestData)
    {
        $links = [];
        if (!empty($requestData)){
            if (!empty($images = $requestData['images'])){
                $links = [];
                foreach ($images as $key => $image){
                    $links[$key] = ['link' => $image, 'main' => 0];
                }
                if (!empty($index = $requestData['main_image'])){
                    $links[$index]['main'] = AdPhoto::MAIN_IMAGE;
                }
            }
            return $this->adRepository->create($requestData, $links);

        }

    }



}
