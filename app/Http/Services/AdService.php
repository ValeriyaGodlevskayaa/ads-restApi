<?php

namespace App\Http\Services;

use App\Models\Ad;
use App\Models\AdPhoto;

class AdService
{

    public function getAds($sortParams = [])
    {
        return Ad::orderBy('price', $sortParams['sort_price'] ?? 'asc')
            ->orderBy('created_at', $sortParams['sort_date'] ?? 'asc');
    }

    public function getAd(int $id)
    {
        return Ad::find($id)->first();
    }

    public function createAd($requestData)
    {
        if (!empty($requestData)){
            $newData = $this->markToMainImage($requestData);
            $ad = new Ad($newData);
            $ad->save();
            $ad->photos()->createMany($newData['links']);
            return $ad;
        }
    }

    private function markToMainImage($requestData)
    {
        if (!empty($images = $requestData['images'])){
            foreach ($images as $key => $image){
                $requestData['links'][$key] = ['link' => $image, 'main' => AdPhoto::NOT_MAiN_IMAGE];
            }
            if (!empty($index = $requestData['main_image'])){
                $requestData['links'][$index]['main'] = AdPhoto::MAIN_IMAGE;
            }
            return $requestData;
        }
    }



}
