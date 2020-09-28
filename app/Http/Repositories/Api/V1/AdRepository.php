<?php


namespace App\Http\Repositories\Api\V1;


use App\Models\Ad;

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

    public function getAll($sort_price = null, $sort_date = null)
    {
        return Ad::orderBy('price', $sort_price ?? 'asc')
            ->orderBy('created_at', $sort_date ?? 'asc');
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
                $img[$index]['main'] = 1;
            }
            $ad->photos()->createMany($img);
        }
        return $ad;
    }

}
