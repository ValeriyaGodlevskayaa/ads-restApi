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

    public function create($data, $links)
    {
        $ad = Ad::create($data);
        $ad->photos()->createMany($links);

        if (!$ad || !$ad->id){
            throw new \DomainException('Error, not saved ad.');
        }
        return $ad;

    }


}
