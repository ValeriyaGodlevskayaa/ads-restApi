<?php

namespace App\Http\Services;

use App\Models\Ad;
use App\Models\AdPhoto;


/**
 * Class AdService
 * @package App\Http\Services
 */
class AdService
{

    /**
     * @param array $sortParams
     * @return mixed
     */
    public function getAds($sortParams = [])
    {
        return Ad::orderBy('price', $sortParams['sort_price'] ?? 'asc')
            ->orderBy('created_at', $sortParams['sort_date'] ?? 'asc');
    }

    /**
     * @param int $id
     * @return mixed
     * @throw Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getAd(int $id): Ad
    {
        return Ad::findOrFail($id);

    }

    /**
     * @param $requestData
     * @return Ad
     * @throw DomainException
     */
    public function createAd($requestData): Ad
    {
        if (empty($requestData)){
            throw new \DomainException('Error! Params is required.');
        }
        $newData = $this->markToMainImage($requestData);
        $ad = new Ad($newData);
        if (!$ad->save()){
            throw new \DomainException('Not save ad');
        }
        $ad->photos()->createMany($newData['links']);
        return $ad;

    }

    /**
     * @param $requestData
     * @return mixed
     */
    private static function markToMainImage($requestData): array
    {
        if (!isset($requestData['images']) || !isset($requestData['main_image']) || empty($images = $requestData['images'])){
            throw new \DomainException('Params images and main_image is required.');
        }
        foreach ($images as $key => $image){
            $requestData['links'][$key] = ['link' => $image, 'main' => AdPhoto::NOT_MAiN_IMAGE];
        }
        if (!empty($index = $requestData['main_image'])){
            $requestData['links'][$index]['main'] = AdPhoto::MAIN_IMAGE;
        }
        return $requestData;

    }

}
