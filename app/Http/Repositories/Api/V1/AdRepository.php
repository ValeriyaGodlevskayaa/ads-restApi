<?php


namespace App\Http\Repositories\Api\V1;


use App\Models\Ad;
use App\Models\AdPhoto;

class AdRepository implements AdRepositoryInterface
{

    public function getById(int $id)
    {
        $ad = Ad::find($id);
        if (is_null($ad)){
            throw new \DomainException('Ad not found.');
        }
        return $ad;
    }

    public function getAll($sortParams)
    {
        return Ad::orderBy('price', $sortParams['sort_price'] ?? 'asc')
            ->orderBy('created_at', $sortParams['sort_date'] ?? 'asc');
    }

    public function create($data)
    {
        $ad = Ad::create($data);
        if ($images = $data['images']){
            $img = [];
            foreach ($images as $key => $image){
                $img[$key] = ['link' => $image, 'main' => 0];
            }
            if ($index = $data['main_image']){
                $img[$index]['main'] = AdPhoto::MAIN_IMAGE;
            }
            $ad->photos()->createMany($img);
        }

        if (!$ad || !$ad->id){
            throw new \DomainException('Error, not saved ad.');
        }
        return $ad;

    }

}
