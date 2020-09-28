<?php


namespace App\Http\Repositories\Api\V1;


interface AdRepositoryInterface
{
    public function getById(int $id);

    public function create($data);

    public function getAll($sortParams);

}
