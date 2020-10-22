<?php

namespace App\Http\Services;

use App\Http\Resources\AdCollection;
use App\Models\{Ad, AdPhoto};
use Illuminate\Support\Facades\DB;

/**
 * Class AdService
 * @package App\Http\Services
 */
class AdService
{
    const COUNT_ITEM = 10;
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

    /**
     * @param array $sortParams
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAds(array $sortParams)
    {
        $ads = Ad::orderBy('price', $sortParams['sort_price'] ?? self::SORT_ASC)
            ->orderBy('created_at', $sortParams['sort_date'] ?? self::SORT_DESC)
            ->limit(self::COUNT_ITEM)
            ->paginate(self::COUNT_ITEM);

        return AdCollection::collection($ads);
    }

    /**
     * @param int $id
     * @throw Illuminate\Database\Eloquent\ModelNotFoundException
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAd(int $id)
    {
        $ad = Ad::find($id);

        return AdCollection::collection($ad);
    }

    /**
     * @param $requestData
     * @throw DomainException
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function createAd(array $requestData)
    {
        if (empty($requestData)){
            throw new \DomainException('Error! Params is required.');
        }
        $newData = $this->markToMainImage($requestData);
        $ad = $this->save($newData);

        return AdCollection::collection([$ad]);
    }

    /**
     * @param array $dataImages
     * @return array
     */
    private function markToMainImage(array $dataImages): array
    {
        if (!isset($dataImages['images']) || !isset($dataImages['main_image'])){
            throw new \DomainException('Params images and main_image is required.');
        }
        $images = $dataImages['images'];

        if (count($images) == 0){
            throw new \DomainException('Images can\'t empty!');
        }
        foreach ($images as $key => $image){
            $dataImages['links'][$key] = ['link' => $image, 'main' => AdPhoto::NOT_MAiN_IMAGE];
        }

        $index = $dataImages['main_image'];
        $dataImages['links'][$index]['main'] = AdPhoto::MAIN_IMAGE;

        return $dataImages;
    }

    /**
     * @param array $data
     * @return Ad
     */
    private function save(array $data): Ad
    {
        return DB::transaction(function () use ($data) {
            $newAd = new Ad($data);
            $newAd->save();
            $newAd->photos()->createMany($data['links']);

            return $newAd;
        });

    }

}
