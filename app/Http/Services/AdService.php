<?php

namespace App\Http\Services;

use App\Models\Ad;
use App\Models\AdPhoto;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;


/**
 * Class AdService
 * @package App\Http\Services
 */
class AdService
{
    const COUNT_ITEM = 10;

    /**
     * @param array $sortParams
     * @return LengthAwarePaginator
     */
    public function getAds(array $sortParams): LengthAwarePaginator
    {
        return Ad::orderBy('price', $sortParams['sort_price'] ?? 'asc')
            ->orderBy('created_at', $sortParams['sort_date'] ?? 'asc')
            ->paginate(self::COUNT_ITEM);
    }

    /**
     * @param int $id
     * @return Ad
     * @throw Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getAd(int $id): Ad
    {
        return Ad::findOrFail($id);
    }

    /**
     * @param $requestData
     * @throw DomainException
     * @return array
     */
    public function createAd(array $requestData): array
    {
        if (empty($requestData)){
            throw new \DomainException('Error! Params is required.');
        }
        $newData = $this->markToMainImage($requestData);
        return $this->save($newData);

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
        if (count($images)>0){
            foreach ($images as $key => $image){
                $dataImages['links'][$key] = ['link' => $image, 'main' => AdPhoto::NOT_MAiN_IMAGE];
            }
        }
        $index = $dataImages['main_image'];
        $dataImages['links'][$index]['main'] = AdPhoto::MAIN_IMAGE;
        return $dataImages;

    }

    /**
     * @param array $data
     * @return array
     */
    private function save(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $newAd = new Ad($data);
            $newAd->save();
            $newAd->photos()->createMany($data['links']);
            return [$newAd];
        });

    }

}
